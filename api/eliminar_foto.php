<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

include("../conexion.php");

if (!isset($_SESSION["id"])) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "mensaje" => "Debe iniciar sesión."
    ]);

    exit;
}

$idFoto = intval($_POST["id_foto"] ?? 0);
$idPropiedad = intval($_POST["id_propiedad"] ?? 0);
$idUsuario = intval($_SESSION["id"]);
$rol = $_SESSION["rol"] ?? "";

if ($idFoto <= 0 || $idPropiedad <= 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La fotografía seleccionada no es válida."
    ]);

    exit;
}

if ($rol !== "Administrador" && $rol !== "Gestor") {
    $sqlPermiso = "SELECT id
                   FROM propiedades
                   WHERE id = ?
                   AND id_usuario = ?";

    $stmtPermiso = $conexion->prepare($sqlPermiso);
    $stmtPermiso->bind_param("ii", $idPropiedad, $idUsuario);
    $stmtPermiso->execute();

    $resultadoPermiso = $stmtPermiso->get_result();

    if ($resultadoPermiso->num_rows === 0) {
        http_response_code(403);

        echo json_encode([
            "success" => false,
            "mensaje" => "No tiene permisos para eliminar esta fotografía."
        ]);

        $stmtPermiso->close();
        $conexion->close();
        exit;
    }

    $stmtPermiso->close();
}

$sqlFoto = "SELECT id, ruta, principal
            FROM fotos_propiedades
            WHERE id = ?
            AND id_propiedad = ?";

$stmtFoto = $conexion->prepare($sqlFoto);
$stmtFoto->bind_param("ii", $idFoto, $idPropiedad);
$stmtFoto->execute();

$resultadoFoto = $stmtFoto->get_result();

if ($resultadoFoto->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La fotografía no pertenece a esta propiedad."
    ]);

    $stmtFoto->close();
    $conexion->close();
    exit;
}

$foto = $resultadoFoto->fetch_assoc();
$stmtFoto->close();

$conexion->begin_transaction();

try {
    $sqlEliminar = "DELETE FROM fotos_propiedades
                    WHERE id = ?
                    AND id_propiedad = ?";

    $stmtEliminar = $conexion->prepare($sqlEliminar);
    $stmtEliminar->bind_param("ii", $idFoto, $idPropiedad);

    if (!$stmtEliminar->execute()) {
        throw new Exception("No se pudo eliminar la fotografía.");
    }

    $stmtEliminar->close();

    $rutaFisica = __DIR__ . "/../" . $foto["ruta"];

    if (is_file($rutaFisica) && !unlink($rutaFisica)) {
        throw new Exception("No se pudo eliminar el archivo de imagen.");
    }

    if (intval($foto["principal"]) === 1) {
        $sqlNuevaPrincipal = "UPDATE fotos_propiedades
                              SET principal = 1
                              WHERE id_propiedad = ?
                              ORDER BY id ASC
                              LIMIT 1";

        $stmtNuevaPrincipal = $conexion->prepare($sqlNuevaPrincipal);
        $stmtNuevaPrincipal->bind_param("i", $idPropiedad);
        $stmtNuevaPrincipal->execute();
        $stmtNuevaPrincipal->close();
    }

    $conexion->commit();

    echo json_encode([
        "success" => true,
        "mensaje" => "Fotografía eliminada correctamente."
    ]);
} catch (Throwable $error) {
    $conexion->rollback();

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => $error->getMessage()
    ]);
}

$conexion->close();
?>
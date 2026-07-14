<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
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
        "mensaje" => "Debe iniciar sesión para ver las fotografías."
    ]);

    exit;
}

$idPropiedad = intval($_GET["id_propiedad"] ?? 0);
$idUsuario = intval($_SESSION["id"]);
$rol = $_SESSION["rol"] ?? "";

if ($idPropiedad <= 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La propiedad seleccionada no es válida."
    ]);

    exit;
}

if ($rol !== "Administrador" && $rol !== "Gestor") {
    $sqlValidar = "SELECT id
                   FROM propiedades
                   WHERE id = ?
                   AND id_usuario = ?";

    $stmtValidar = $conexion->prepare($sqlValidar);
    $stmtValidar->bind_param("ii", $idPropiedad, $idUsuario);
    $stmtValidar->execute();

    $resultadoValidar = $stmtValidar->get_result();

    if ($resultadoValidar->num_rows === 0) {
        http_response_code(403);

        echo json_encode([
            "success" => false,
            "mensaje" => "No tiene permisos para ver estas fotografías."
        ]);

        $stmtValidar->close();
        $conexion->close();
        exit;
    }

    $stmtValidar->close();
}

$sql = "SELECT id, id_propiedad, ruta, principal
        FROM fotos_propiedades
        WHERE id_propiedad = ?
        ORDER BY principal DESC, id ASC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idPropiedad);
$stmt->execute();

$resultado = $stmt->get_result();
$fotos = [];

while ($fila = $resultado->fetch_assoc()) {
    $fotos[] = $fila;
}

echo json_encode([
    "success" => true,
    "fotos" => $fotos
], JSON_UNESCAPED_UNICODE);

$stmt->close();
$conexion->close();
?>
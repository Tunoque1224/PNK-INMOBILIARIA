<?php
session_start();

header("Access-Control-Allow-Origin: http://98.90.238.74");
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
        "mensaje" => "Debe iniciar sesión para eliminar una propiedad."
    ]);

    exit;
}

$id = intval($_POST["id"] ?? 0);
$idUsuario = intval($_SESSION["id"]);
$rol = $_SESSION["rol"] ?? "";

if ($id <= 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La propiedad seleccionada no es válida."
    ]);

    exit;
}

if ($rol === "Administrador") {
    $sql = "DELETE FROM propiedades WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
} else {
    $sql = "DELETE FROM propiedades
            WHERE id = ?
            AND id_usuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $id, $idUsuario);
}

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "mensaje" => "Propiedad eliminada correctamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "No se encontró la propiedad o no tiene permisos para eliminarla."
        ]);
    }
} else {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo eliminar la propiedad."
    ]);
}

$stmt->close();
$conexion->close();
?>
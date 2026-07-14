<?php
header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

include("../conexion.php");

$id = $_POST["id"] ?? 0;

if ($id == 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "ID no válido"
    ]);
    exit;
}

$sql = "DELETE FROM usuarios WHERE id = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "mensaje" => "Usuario eliminado correctamente"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo eliminar el usuario"
    ]);
}

$stmt->close();
$conexion->close();
?>
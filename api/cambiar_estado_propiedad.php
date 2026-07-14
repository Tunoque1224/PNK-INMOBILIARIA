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
        "mensaje" => "Debe iniciar sesión."
    ]);
    exit;
}

$rol = $_SESSION["rol"] ?? "";

if ($rol !== "Administrador") {
    http_response_code(403);

    echo json_encode([
        "success" => false,
        "mensaje" => "Solo el administrador puede cambiar el estado."
    ]);
    exit;
}

$id = intval($_POST["id"] ?? 0);
$estado = trim($_POST["estado"] ?? "");

$estadosPermitidos = [
    "Publicada",
    "Desactivada",
    "Vendida"
];

if ($id <= 0 || !in_array($estado, $estadosPermitidos, true)) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "Los datos enviados no son válidos."
    ]);
    exit;
}

$sql = "UPDATE propiedades
        SET estado = ?
        WHERE id = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("si", $estado, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "mensaje" => "Estado actualizado correctamente."
    ]);
} else {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo actualizar el estado."
    ]);
}

$stmt->close();
$conexion->close();
?>
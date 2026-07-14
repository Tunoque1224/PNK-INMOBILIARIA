<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

include("../conexion.php");

if (!isset($_SESSION["id"])) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "mensaje" => "Debe iniciar sesión para ver los usuarios."
    ]);

    exit();
}

$rol = $_SESSION["rol"] ?? "";

if ($rol !== "Administrador") {
    http_response_code(403);

    echo json_encode([
        "success" => false,
        "mensaje" => "No tiene permisos para ver los usuarios."
    ]);

    exit();
}

$sql = "SELECT id, rut, nombre, correo, rol, estado
        FROM usuarios
        ORDER BY id DESC";

$resultado = $conexion->query($sql);

$usuarios = [];

while ($fila = $resultado->fetch_assoc()) {
    $usuarios[] = $fila;
}

echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);

$conexion->close();
?>
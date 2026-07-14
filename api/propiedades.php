<?php

session_start();

header("Access-Control-Allow-Origin: http://98.90.238.74");
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
        "mensaje" => "Debe iniciar sesión para ver las propiedades."
    ]);

    exit();
}

$idUsuario = intval($_SESSION["id"]);
$rol = $_SESSION["rol"] ?? "";

if ($rol === "Administrador" || $rol === "Gestor") {

    $sql = "SELECT
            propiedades.*,
            fotos_propiedades.ruta AS imagen_principal,
            usuarios.nombre AS propietario_nombre,
            usuarios.correo AS propietario_correo
        FROM propiedades
        LEFT JOIN fotos_propiedades
            ON propiedades.id = fotos_propiedades.id_propiedad
            AND fotos_propiedades.principal = 1
        LEFT JOIN usuarios
            ON propiedades.id_usuario = usuarios.id
        ORDER BY propiedades.id DESC";

    $stmt = $conexion->prepare($sql);

} else {

    $sql = "SELECT
            propiedades.*,
            fotos_propiedades.ruta AS imagen_principal,
            usuarios.nombre AS propietario_nombre,
            usuarios.correo AS propietario_correo
        FROM propiedades
        LEFT JOIN fotos_propiedades
            ON propiedades.id = fotos_propiedades.id_propiedad
            AND fotos_propiedades.principal = 1
        LEFT JOIN usuarios
            ON propiedades.id_usuario = usuarios.id
        WHERE propiedades.id_usuario = ?
        ORDER BY propiedades.id DESC";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
}

if (!$stmt) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "No fue posible preparar la consulta."
    ]);

    exit();
}

$stmt->execute();
$resultado = $stmt->get_result();

$propiedades = [];

while ($fila = $resultado->fetch_assoc()) {
    $propiedades[] = $fila;
}

echo json_encode($propiedades, JSON_UNESCAPED_UNICODE);

$stmt->close();
$conexion->close();
?>
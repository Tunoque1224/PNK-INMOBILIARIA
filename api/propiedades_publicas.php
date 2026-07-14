<?php

header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

include("../conexion.php");

$sql = "SELECT
            propiedades.*,
            fotos_propiedades.ruta AS imagen_principal
        FROM propiedades
        LEFT JOIN fotos_propiedades
            ON propiedades.id = fotos_propiedades.id_propiedad
            AND fotos_propiedades.principal = 1
        WHERE propiedades.estado = 'Publicada'
        ORDER BY propiedades.id DESC";

$resultado = $conexion->query($sql);

$propiedades = [];

while ($fila = $resultado->fetch_assoc()) {
    $propiedades[] = $fila;
}

echo json_encode($propiedades, JSON_UNESCAPED_UNICODE);

$conexion->close();
?>
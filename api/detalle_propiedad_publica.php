<?php

header("Access-Control-Allow-Origin: http://pnk-react-cesar-20260714.s3-website-us-east-1.amazonaws.com");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

include("../conexion.php");

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "La propiedad seleccionada no es válida."
    ]);

    exit();
}

$sql = "SELECT *
        FROM propiedades
        WHERE id = ?
        AND estado = 'Publicada'
        LIMIT 1";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    http_response_code(404);

    echo json_encode([
        "success" => false,
        "mensaje" => "La propiedad no existe o no está publicada."
    ]);

    exit();
}

$propiedad = $resultado->fetch_assoc();
$stmt->close();

$sqlFotos = "SELECT id, ruta, principal
             FROM fotos_propiedades
             WHERE id_propiedad = ?
             ORDER BY principal DESC, id ASC";

$stmtFotos = $conexion->prepare($sqlFotos);
$stmtFotos->bind_param("i", $id);
$stmtFotos->execute();

$resultadoFotos = $stmtFotos->get_result();

$fotos = [];

while ($fila = $resultadoFotos->fetch_assoc()) {
    $fotos[] = $fila;
}

echo json_encode([
    "success" => true,
    "propiedad" => $propiedad,
    "fotos" => $fotos
], JSON_UNESCAPED_UNICODE);

$stmtFotos->close();
$conexion->close();
?>
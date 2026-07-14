<?php
header("Access-Control-Allow-Origin: http://pnk-react-cesar-20260714.s3-website-us-east-1.amazonaws.com");
header("Content-Type: application/json; charset=UTF-8");

include("../conexion.php");

$id = $_POST["id"] ?? "";
$nombre = $_POST["nombre"] ?? "";
$correo = $_POST["correo"] ?? "";
$rol = $_POST["rol"] ?? "";
$estado = $_POST["estado"] ?? "";

$sql = "UPDATE usuarios
        SET nombre='$nombre',
            correo='$correo',
            rol='$rol',
            estado='$estado'
        WHERE id='$id'";

if ($conexion->query($sql)) {
    echo json_encode([
        "success" => true,
        "mensaje" => "Usuario actualizado correctamente"
    ]);
} else {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => $conexion->error
    ]);
}
?>
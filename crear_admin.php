<?php
include("conexion.php");

$rut = "11.111.111-1";
$nombre = "Cesar Administrador";
$correo = "admin@pnk.cl";
$tipo = "Administrador";
$password = password_hash("Admin123!", PASSWORD_DEFAULT);
$estado = "Activo";
$rol = "Administrador";

$sql = "INSERT INTO usuarios (rut, nombre, correo, tipo, password, estado, rol)
VALUES ('$rut', '$nombre', '$correo', '$tipo', '$password', '$estado', '$rol')";

if ($conexion->query($sql)) {
    echo "Administrador creado correctamente";
} else {
    echo "Error: " . $conexion->error;
}
?>
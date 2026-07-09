<?php
include("conexion.php");

$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$rol = $_POST["rol"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$estado = "Activo";

$sql = "INSERT INTO usuarios (rut, nombre, correo, tipo, password, estado, rol)
VALUES ('$rut', '$nombre', '$correo', '$rol', '$password', '$estado', '$rol')";

if ($conexion->query($sql) === TRUE) {
    header("Location: usuarios.php?mensaje=guardado");
    exit();
} else {
    echo "Error al guardar: " . $conexion->error;
}

$conexion->close();
?>
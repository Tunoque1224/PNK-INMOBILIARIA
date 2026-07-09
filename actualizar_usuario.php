<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["rol"] != "Administrador") {
    header("Location: dashboard.php");
    exit();
}

$id = $_POST["id"];
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$estado = $_POST["estado"];
$rol = $_POST["rol"];

$sql = "UPDATE usuarios
        SET rut='$rut',
            nombre='$nombre',
            correo='$correo',
            estado='$estado',
            rol='$rol'
        WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    header("Location: usuarios.php?mensaje=actualizado");
    exit();
} else {
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
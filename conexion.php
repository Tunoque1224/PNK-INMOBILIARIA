<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "pnk_inmobiliaria";
$puerto = 3306;

$conexion = new mysqli($servidor, $usuario, $password, $baseDatos, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>
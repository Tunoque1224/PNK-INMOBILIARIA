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

$id = $_GET["id"];

$sql = "DELETE FROM usuarios WHERE id=$id";

if ($conexion->query($sql)) {
    header("Location: usuarios.php?mensaje=eliminado");
    exit();
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>
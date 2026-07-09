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

/* Primero buscamos el usuario */
$buscarUsuario = $conexion->query("SELECT rut, rol FROM usuarios WHERE id=$id");
$usuario = $buscarUsuario->fetch_assoc();

if ($usuario) {

    $rut = $usuario["rut"];
    $rol = $usuario["rol"];

    /* Si es Gestor, también se elimina de la tabla gestores */
    if ($rol == "Gestor") {
        $conexion->query("DELETE FROM gestores WHERE rut='$rut'");
    }

    /* Luego eliminamos la cuenta de usuarios */
    $sql = "DELETE FROM usuarios WHERE id=$id";

    if ($conexion->query($sql)) {
        header("Location: usuarios.php?mensaje=eliminado");
        exit();
    } else {
        echo "Error: " . $conexion->error;
    }

} else {
    header("Location: usuarios.php");
    exit();
}

$conexion->close();
?>
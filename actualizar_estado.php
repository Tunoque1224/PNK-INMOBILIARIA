<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"]) || ($_SESSION["rol"] != "Administrador" && $_SESSION["rol"] != "Gestor")) {
    header("Location: dashboard.php");
    exit();
}

$id = $_POST["id"];
$estado = $_POST["estado"];

$estadosPermitidos = [
    "Publicada",
    "Desactivada",
    "Vendida",
    "Arrendada"
];

if (!in_array($estado, $estadosPermitidos)) {
    header("Location: propiedades.php?mensaje=estado_error");
    exit();
}

$sql = "UPDATE propiedades
        SET estado = '$estado'
        WHERE id = '$id'";

if ($conexion->query($sql) === TRUE) {

    header("Location: propiedades.php?mensaje=estado_actualizado");
    exit();

} else {

    echo "Error al actualizar estado: " . $conexion->error;
}
?>
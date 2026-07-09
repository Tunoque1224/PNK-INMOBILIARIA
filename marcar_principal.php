<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_foto = $_GET["id_foto"];
$id_propiedad = $_GET["id_propiedad"];

$conexion->query("UPDATE fotos_propiedades SET principal = 0 WHERE id_propiedad = '$id_propiedad'");
$conexion->query("UPDATE fotos_propiedades SET principal = 1 WHERE id = '$id_foto'");

header("Location: administrar_fotos.php?id=$id_propiedad&mensaje=principal");
exit();
?>
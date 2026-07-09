<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_foto = $_GET["id_foto"];
$id_propiedad = $_GET["id_propiedad"];

$sql = "SELECT * FROM fotos_propiedades WHERE id = '$id_foto'";
$resultado = $conexion->query($sql);
$foto = $resultado->fetch_assoc();

if ($foto) {
    if (file_exists($foto["ruta"])) {
        unlink($foto["ruta"]);
    }

    $conexion->query("DELETE FROM fotos_propiedades WHERE id = '$id_foto'");
}

header("Location: administrar_fotos.php?id=$id_propiedad");
exit();
?>
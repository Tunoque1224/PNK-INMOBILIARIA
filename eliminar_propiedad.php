<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];
$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"];

if ($rol == "Administrador") {

    $sql = "DELETE FROM propiedades WHERE id = $id";

} else {

    $sql = "DELETE FROM propiedades
            WHERE id = $id
            AND id_usuario = '$id_usuario'";

}

if ($conexion->query($sql)) {
    header("Location: propiedades.php?mensaje=eliminado");
    exit();
} else {
    echo "Error al eliminar: " . $conexion->error;
}

$conexion->close();
?>
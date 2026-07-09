<?php
include("conexion.php");

$id = $_GET["id"];

$sql = "DELETE FROM propietarios WHERE id = $id";

if($conexion->query($sql)){
    header("Location: propietario.php?mensaje=eliminado");
    exit();
}else{
    echo "Error al eliminar: " . $conexion->error;
}

$conexion->close();
?>
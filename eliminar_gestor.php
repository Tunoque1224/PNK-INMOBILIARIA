<?php
include("conexion.php");

$id = $_GET["id"];

$sql = "DELETE FROM gestores WHERE id = $id";

if($conexion->query($sql)){
    header("Location: gestor.php?mensaje=eliminado");
    exit();
}else{
    echo "Error al eliminar: " . $conexion->error;
}

$conexion->close();
?>
<?php
include("conexion.php");

$id = $_POST["id"];
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$correo = $_POST["correo"];
$sexo = $_POST["sexo"];
$telefono = $_POST["telefono"];
$propiedad = $_POST["propiedad"];

$sql = "UPDATE propietarios SET
rut='$rut',
nombre='$nombre',
fecha='$fecha',
correo='$correo',
sexo='$sexo',
telefono='$telefono',
propiedad='$propiedad'
WHERE id=$id";

if($conexion->query($sql)){
    header("Location: propietario.php?mensaje=actualizado");
    exit();
}else{
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
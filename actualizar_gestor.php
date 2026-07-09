<?php
include("conexion.php");

$id = $_POST["id"];
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$fechaNacimiento = $_POST["fechaNacimiento"];
$correo = $_POST["correo"];
$sexo = $_POST["sexo"];
$telefono = $_POST["telefono"];

$sql = "UPDATE gestores SET
rut='$rut',
nombre='$nombre',
fechaNacimiento='$fechaNacimiento',
correo='$correo',
sexo='$sexo',
telefono='$telefono'
WHERE id=$id";

if($conexion->query($sql)){
    header("Location: gestor.php?mensaje=actualizado");
    exit();
}else{
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
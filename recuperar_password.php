<?php
include("conexion.php");

$correo = $_POST["correo"];

$sql = "SELECT * FROM usuarios WHERE correo='$correo'";
$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){
    header("Location: recuperar.php?mensaje=encontrado");
}else{
    header("Location: recuperar.php?mensaje=noexiste");
}

$conexion->close();
?>
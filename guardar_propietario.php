<?php
include("conexion.php");
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$correo = $_POST["correo"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$sexo = $_POST["sexo"];
$telefono = $_POST["telefono"];
$propiedad = $_POST["propiedad"];

$sql = "INSERT INTO propietarios
(rut, nombre, fecha, correo, password, sexo, telefono, propiedad)
VALUES

('$rut','$nombre','$fecha','$correo','$password','$sexo','$telefono','$propiedad')";
$sqlUsuario = "INSERT INTO usuarios
(rut, nombre, correo, tipo, password, estado, rol)
VALUES
('$rut','$nombre','$correo','Propietario','$password','Pendiente','Propietario')";

if($conexion->query($sql) && $conexion->query($sqlUsuario)){
    header("Location: propietario.php?mensaje=guardado");
    exit();
}else{

    echo "<h2>Error al guardar</h2>";

    echo "<br><b>Propietarios:</b> ";
    if(!$conexion->query($sql)){
        echo $conexion->error;
    }else{
        echo "OK";
    }

    echo "<br><br><b>Usuarios:</b> ";
    if(!$conexion->query($sqlUsuario)){
        echo $conexion->error;
    }else{
        echo "OK";
    }

}

$conexion->close();
?>
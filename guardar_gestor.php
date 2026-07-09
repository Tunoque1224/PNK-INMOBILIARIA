<?php
include("conexion.php");

$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$fechaNacimiento = $_POST["fechaNacimiento"];
$correo = $_POST["correo"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$sexo = $_POST["sexo"];
$telefono = $_POST["telefono"];

$certificado = "";

if (isset($_FILES["certificado"]) && $_FILES["certificado"]["error"] == 0) {

    $carpeta = "certificados/";

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $certificado = time() . "_" . basename($_FILES["certificado"]["name"]);

    move_uploaded_file(
        $_FILES["certificado"]["tmp_name"],
        $carpeta . $certificado
    );
}

$sql = "INSERT INTO gestores
(rut, nombre, fechaNacimiento, correo, password, sexo, telefono, certificado)
VALUES
('$rut','$nombre','$fechaNacimiento','$correo','$password','$sexo','$telefono','$certificado')";
$sqlUsuario = "INSERT INTO usuarios
(rut, nombre, correo, tipo, password, estado, rol)
VALUES
('$rut','$nombre','$correo','Gestor','$password','Pendiente','Gestor')";

if ($conexion->query($sql) && $conexion->query($sqlUsuario)) {
    header("Location: gestor.php?mensaje=guardado");
    exit();
} else {
    echo "Error: " . $conexion->error;
}
$conexion->close();
?>
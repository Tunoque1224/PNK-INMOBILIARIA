<?php
session_start();
include("conexion.php");

$correo = $_POST["correo"];
$password = $_POST["password"];

$sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $usuario = $resultado->fetch_assoc();

    if (password_verify($password, $usuario["password"])) {

    if ($usuario["estado"] != "Activo") {

        header("Location: login.php?error=pendiente");
        exit();

    }

    $_SESSION["id"] = $usuario["id"];
    $_SESSION["nombre"] = $usuario["nombre"];
    $_SESSION["tipo"] = $usuario["tipo"];
    $_SESSION["rol"] = $usuario["rol"];
    $_SESSION["estado"] = $usuario["estado"];

    header("Location: dashboard.php?login=ok");
    exit();

} else {
        header("Location: login.php?error=1");
        exit();
    }

} else {
    header("Location: login.php?error=1");
    exit();
}

$conexion->close();
?>
<?php
include("conexion.php");

$rut = trim($_POST["rut"]);
$nombre = trim($_POST["nombre"]);
$correo = trim($_POST["correo"]);
$rol = trim($_POST["rol"]);
$passwordPlano = $_POST["password"];

if ($rut == "" || $nombre == "" || $correo == "" || $rol == "" || $passwordPlano == "") {
    die("Error: Debe completar todos los campos.");
}

if (!preg_match("/^[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9kK]$/", $rut)) {
    die("Error: RUT inválido.");
}

if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/", $nombre)) {
    die("Error: Nombre inválido.");
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    die("Error: Correo inválido.");
}

if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_-]).{8,}$/", $passwordPlano)) {
    die("Error: Contraseña insegura.");
}

if ($rol != "Administrador" && $rol != "Propietario" && $rol != "Gestor") {
    die("Error: Rol inválido.");
}

$password = password_hash($passwordPlano, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (rut, nombre, correo, rol, password)
        VALUES ('$rut', '$nombre', '$correo', '$rol', '$password')";

if ($conexion->query($sql) === TRUE) {
    header("Location: usuarios.php?mensaje=guardado");
    exit();
} else {
    echo "Error al guardar: " . $conexion->error;
}

$conexion->close();
?>
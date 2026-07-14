<?php
header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

include("../conexion.php");

$rut = trim($_POST["rut"] ?? "");
$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$password = $_POST["password"] ?? "";
$rol = trim($_POST["rol"] ?? "");

$estado = "Activo";
$tipo = $rol;

if (
    empty($rut) ||
    empty($nombre) ||
    empty($correo) ||
    empty($password) ||
    empty($rol)
) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Debe completar todos los campos."
    ]);
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "mensaje" => "El correo ingresado no es válido."
    ]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La contraseña debe tener al menos 8 caracteres."
    ]);
    exit;
}

$sqlVerificar = "SELECT id FROM usuarios WHERE rut = ? OR correo = ?";
$stmtVerificar = $conexion->prepare($sqlVerificar);
$stmtVerificar->bind_param("ss", $rut, $correo);
$stmtVerificar->execute();
$resultadoVerificar = $stmtVerificar->get_result();

if ($resultadoVerificar->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "El RUT o el correo ya están registrados."
    ]);

    $stmtVerificar->close();
    $conexion->close();
    exit;
}

$stmtVerificar->close();

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios
        (rut, nombre, correo, tipo, password, estado, rol)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "sssssss",
    $rut,
    $nombre,
    $correo,
    $tipo,
    $passwordHash,
    $estado,
    $rol
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "mensaje" => "Usuario creado correctamente."
    ]);
} else {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "Error al crear el usuario."
    ]);
}

$stmt->close();
$conexion->close();
?>
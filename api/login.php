<?php

session_start();

header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

require_once __DIR__ . "/../conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "ok" => false,
        "message" => "Método no permitido."
    ]);

    exit();
}

$contenido = file_get_contents("php://input");
$datos = json_decode($contenido, true);

$correo = trim($datos["correo"] ?? "");
$password = $datos["password"] ?? "";

if ($correo === "" || $password === "") {
    http_response_code(400);

    echo json_encode([
        "ok" => false,
        "message" => "Debe ingresar correo y contraseña."
    ]);

    exit();
}

$sql = "SELECT id, nombre, correo, password, tipo, rol, estado
        FROM usuarios
        WHERE correo = ?
        LIMIT 1";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    http_response_code(500);

    echo json_encode([
        "ok" => false,
        "message" => "No fue posible preparar la consulta."
    ]);

    exit();
}

$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    http_response_code(401);

    echo json_encode([
        "ok" => false,
        "message" => "Correo o contraseña incorrectos."
    ]);

    exit();
}

$usuario = $resultado->fetch_assoc();

if (!password_verify($password, $usuario["password"])) {
    http_response_code(401);

    echo json_encode([
        "ok" => false,
        "message" => "Correo o contraseña incorrectos."
    ]);

    exit();
}

if ($usuario["estado"] !== "Activo") {
    http_response_code(403);

    echo json_encode([
        "ok" => false,
        "message" => "Su cuenta todavía no se encuentra activa."
    ]);

    exit();
}

$_SESSION["id"] = $usuario["id"];
$_SESSION["nombre"] = $usuario["nombre"];
$_SESSION["tipo"] = $usuario["tipo"];
$_SESSION["rol"] = $usuario["rol"];
$_SESSION["estado"] = $usuario["estado"];

echo json_encode([
    "ok" => true,
    "message" => "Inicio de sesión correcto.",
    "data" => [
        "user" => [
            "id" => (int) $usuario["id"],
            "nombre" => $usuario["nombre"],
            "correo" => $usuario["correo"],
            "tipo" => $usuario["tipo"],
            "rol" => $usuario["rol"],
            "estado" => $usuario["estado"]
        ]
    ]
]);

$stmt->close();
$conexion->close();
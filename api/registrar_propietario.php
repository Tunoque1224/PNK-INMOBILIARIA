<?php

header("Access-Control-Allow-Origin: http://pnk-react-cesar-20260714.s3-website-us-east-1.amazonaws.com");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

include("../conexion.php");

$rut = trim($_POST["rut"] ?? "");
$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$password = $_POST["password"] ?? "";
$confirmarPassword = $_POST["confirmar_password"] ?? "";

function limpiarRut($rut)
{
    return strtoupper(
        str_replace([".", "-"], "", trim($rut))
    );
}

function validarRutChileno($rutCompleto)
{
    $rutLimpio = limpiarRut($rutCompleto);

    if (!preg_match('/^\d{7,8}[0-9K]$/', $rutLimpio)) {
        return false;
    }

    $cuerpo = substr($rutLimpio, 0, -1);
    $digitoIngresado = substr($rutLimpio, -1);

    $suma = 0;
    $multiplicador = 2;

    for ($i = strlen($cuerpo) - 1; $i >= 0; $i--) {
        $suma += intval($cuerpo[$i]) * $multiplicador;

        $multiplicador =
            $multiplicador === 7
                ? 2
                : $multiplicador + 1;
    }

    $resultado = 11 - ($suma % 11);

    if ($resultado === 11) {
        $digitoCalculado = "0";
    } elseif ($resultado === 10) {
        $digitoCalculado = "K";
    } else {
        $digitoCalculado = strval($resultado);
    }

    return $digitoIngresado === $digitoCalculado;
}

if (
    $rut === "" ||
    $nombre === "" ||
    $correo === "" ||
    $password === "" ||
    $confirmarPassword === ""
) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "Debe completar todos los campos."
    ]);

    exit();
}

if (!validarRutChileno($rut)) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "El RUT ingresado no es válido."
    ]);

    exit();
}

$soloLetras = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u";

if (!preg_match($soloLetras, $nombre)) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "El nombre solo puede contener letras y espacios."
    ]);

    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "El correo electrónico no es válido."
    ]);

    exit();
}

if (
    strlen($password) < 8 ||
    !preg_match("/[A-Z]/", $password) ||
    !preg_match("/[a-z]/", $password) ||
    !preg_match("/[0-9]/", $password) ||
    !preg_match("/[^A-Za-z0-9]/", $password)
) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un símbolo."
    ]);

    exit();
}

if ($password !== $confirmarPassword) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "mensaje" => "Las contraseñas no coinciden."
    ]);

    exit();
}

$rutLimpio = limpiarRut($rut);

$sqlVerificar = "SELECT id
                 FROM usuarios
                 WHERE REPLACE(
                     REPLACE(UPPER(rut), '.', ''),
                     '-',
                     ''
                 ) = ?
                 OR correo = ?
                 LIMIT 1";

$stmtVerificar = $conexion->prepare($sqlVerificar);

if (!$stmtVerificar) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo validar la información."
    ]);

    exit();
}

$stmtVerificar->bind_param(
    "ss",
    $rutLimpio,
    $correo
);

$stmtVerificar->execute();
$resultadoVerificar = $stmtVerificar->get_result();

if ($resultadoVerificar->num_rows > 0) {
    http_response_code(409);

    echo json_encode([
        "success" => false,
        "mensaje" => "El RUT o el correo ya están registrados."
    ]);

    $stmtVerificar->close();
    $conexion->close();
    exit();
}

$stmtVerificar->close();

$rol = "Propietario";
$tipo = "Propietario";
$estado = "Pendiente";
$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$sql = "INSERT INTO usuarios
        (
            rut,
            nombre,
            correo,
            tipo,
            password,
            estado,
            rol
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo preparar el registro."
    ]);

    $conexion->close();
    exit();
}

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
        "mensaje" => "Registro realizado correctamente. Su cuenta quedó pendiente de aprobación."
    ]);
} else {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo registrar al propietario."
    ]);
}

$stmt->close();
$conexion->close();
?>
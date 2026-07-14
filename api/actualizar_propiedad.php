<?php
session_start();

header("Access-Control-Allow-Origin: http://pnk-react-cesar-20260714.s3-website-us-east-1.amazonaws.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

include("../conexion.php");

if (!isset($_SESSION["id"])) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "mensaje" => "Debe iniciar sesión para actualizar una propiedad."
    ]);

    exit;
}

$id = intval($_POST["id"] ?? 0);
$idUsuario = intval($_SESSION["id"]);
$rol = $_SESSION["rol"] ?? "";

$tipo = trim($_POST["tipo"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$comuna = trim($_POST["comuna"] ?? "");
$sector = trim($_POST["sector"] ?? "");
$dormitorios = $_POST["dormitorios"] ?? "";
$banos = $_POST["banos"] ?? "";
$precio = $_POST["precio"] ?? "";
$precioUF = $_POST["precioUF"] ?? "";
$areaConstruida = $_POST["areaConstruida"] ?? "";
$areaTerreno = $_POST["areaTerreno"] ?? "";
$fecha = $_POST["fecha"] ?? "";
$visita = $_POST["visita"] ?? "";

$caracteristicas = isset($_POST["caracteristicas"])
    ? implode(", ", $_POST["caracteristicas"])
    : "";

if (
    $id <= 0 ||
    $tipo === "" ||
    $descripcion === "" ||
    $comuna === "" ||
    $sector === "" ||
    $precio === "" ||
    $precioUF === "" ||
    $fecha === "" ||
    $visita === ""
) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Debe completar todos los campos obligatorios."
    ]);

    exit;
}

$soloLetras = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u";

if (
    !preg_match($soloLetras, $descripcion) ||
    !preg_match($soloLetras, $comuna) ||
    !preg_match($soloLetras, $sector)
) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Descripción, comuna y sector solo permiten letras y espacios."
    ]);

    exit;
}

if (!in_array($tipo, ["Casa", "Departamento", "Terreno"])) {
    echo json_encode([
        "success" => false,
        "mensaje" => "El tipo de propiedad no es válido."
    ]);

    exit;
}

if (!in_array($visita, ["Sí", "No"])) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La opción de visita no es válida."
    ]);

    exit;
}

if (!is_numeric($precio) || number_format($precio, 0, ".", "") <= 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "El precio debe ser mayor que cero."
    ]);

    exit;
}

if ($fecha > date("Y-m-d")) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La fecha de publicación no puede ser futura."
    ]);

    exit;
}

if ($tipo === "Casa") {
    if (
        $dormitorios === "" ||
        $banos === "" ||
        $areaConstruida === "" ||
        $areaTerreno === ""
    ) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Complete todos los datos de la casa."
        ]);

        exit;
    }
}

if ($tipo === "Departamento") {
    if (
        $dormitorios === "" ||
        $banos === "" ||
        $areaConstruida === ""
    ) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Complete todos los datos del departamento."
        ]);

        exit;
    }

    $areaTerreno = 0;
}

if ($tipo === "Terreno") {
    if ($areaTerreno === "") {
        echo json_encode([
            "success" => false,
            "mensaje" => "Debe completar el área del terreno."
        ]);

        exit;
    }

    $dormitorios = 0;
    $banos = 0;
    $areaConstruida = 0;
}

if (
    !is_numeric($dormitorios) ||
    !is_numeric($banos) ||
    !is_numeric($areaConstruida) ||
    !is_numeric($areaTerreno) ||
    $dormitorios < 0 ||
    $banos < 0 ||
    $areaConstruida < 0 ||
    $areaTerreno < 0
) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Los valores numéricos no pueden ser negativos."
    ]);

    exit;
}

if ($rol === "Administrador" || $rol === "Gestor") {
    $sql = "UPDATE propiedades
            SET tipo = ?,
                descripcion = ?,
                comuna = ?,
                sector = ?,
                dormitorios = ?,
                banos = ?,
                precio = ?,
                precioUF = ?,
                areaConstruida = ?,
                areaTerreno = ?,
                fecha = ?,
                visita = ?,
                caracteristicas = ?
            WHERE id = ?";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "ssssiiddddsssi",
        $tipo,
        $descripcion,
        $comuna,
        $sector,
        $dormitorios,
        $banos,
        $precio,
        $precioUF,
        $areaConstruida,
        $areaTerreno,
        $fecha,
        $visita,
        $caracteristicas,
        $id
    );
} else {
    $sql = "UPDATE propiedades
            SET tipo = ?,
                descripcion = ?,
                comuna = ?,
                sector = ?,
                dormitorios = ?,
                banos = ?,
                precio = ?,
                precioUF = ?,
                areaConstruida = ?,
                areaTerreno = ?,
                fecha = ?,
                visita = ?,
                caracteristicas = ?
            WHERE id = ?
            AND id_usuario = ?";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "ssssiiddddsssii",
        $tipo,
        $descripcion,
        $comuna,
        $sector,
        $dormitorios,
        $banos,
        $precio,
        $precioUF,
        $areaConstruida,
        $areaTerreno,
        $fecha,
        $visita,
        $caracteristicas,
        $id,
        $idUsuario
    );
}

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "mensaje" => "Propiedad actualizada correctamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "No se encontró la propiedad o no tiene permisos para editarla."
        ]);
    }
} else {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo actualizar la propiedad."
    ]);
}

$stmt->close();
$conexion->close();
?>
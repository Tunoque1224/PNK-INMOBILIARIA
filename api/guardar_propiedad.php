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
        "mensaje" => "Debe iniciar sesión para guardar una propiedad."
    ]);

    exit;
}

$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"] ?? "";

if (
    $rol === "Administrador" &&
    !empty($_POST["id_propietario_admin"])
) {
    $id_usuario = $_POST["id_propietario_admin"];
}

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

if (!is_numeric($precio) || $precio <= 0) {
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

$conexion->begin_transaction();

try {
    $sql = "INSERT INTO propiedades
            (
                id_usuario,
                tipo,
                descripcion,
                comuna,
                sector,
                dormitorios,
                banos,
                precio,
                precioUF,
                areaConstruida,
                areaTerreno,
                fecha,
                visita,
                caracteristicas
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception("No se pudo preparar el registro.");
    }

    $stmt->bind_param(
        "issssiiddddsss",
        $id_usuario,
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
        $caracteristicas
    );

    if (!$stmt->execute()) {
        throw new Exception("No se pudo guardar la propiedad.");
    }

    $id_propiedad = $conexion->insert_id;
    $stmt->close();

    if (
        isset($_FILES["fotos"]) &&
        !empty($_FILES["fotos"]["name"][0])
    ) {
        $cantidadFotos = count($_FILES["fotos"]["name"]);

        if ($cantidadFotos > 10) {
            throw new Exception("Solo puede subir hasta 10 fotografías.");
        }

        $formatosPermitidos = ["jpg", "jpeg", "png", "webp"];

        $carpetaFisica = __DIR__ . "/../uploads/propiedades/";
        $carpetaBaseDatos = "uploads/propiedades/";

        if (!is_dir($carpetaFisica)) {
            mkdir($carpetaFisica, 0777, true);
        }

        for ($i = 0; $i < $cantidadFotos; $i++) {
            if ($_FILES["fotos"]["error"][$i] !== UPLOAD_ERR_OK) {
                throw new Exception("Una fotografía no pudo ser procesada.");
            }

            $nombreOriginal = $_FILES["fotos"]["name"][$i];
            $archivoTemporal = $_FILES["fotos"]["tmp_name"][$i];

            $extension = strtolower(
                pathinfo($nombreOriginal, PATHINFO_EXTENSION)
            );

            if (!in_array($extension, $formatosPermitidos)) {
                throw new Exception(
                    "Solo se permiten imágenes JPG, JPEG, PNG o WEBP."
                );
            }

            $nombreNuevo =
                time() .
                "_" .
                $i .
                "_" .
                random_int(1000, 9999) .
                "." .
                $extension;

            $rutaFisica = $carpetaFisica . $nombreNuevo;
            $rutaBaseDatos = $carpetaBaseDatos . $nombreNuevo;

            if (!move_uploaded_file($archivoTemporal, $rutaFisica)) {
                throw new Exception("No se pudo guardar una fotografía.");
            }

            $principal = $i === 0 ? 1 : 0;

            $sqlFoto = "INSERT INTO fotos_propiedades
                        (id_propiedad, ruta, principal)
                        VALUES (?, ?, ?)";

            $stmtFoto = $conexion->prepare($sqlFoto);

            if (!$stmtFoto) {
                throw new Exception(
                    "No se pudo preparar el registro de fotografías."
                );
            }

            $stmtFoto->bind_param(
                "isi",
                $id_propiedad,
                $rutaBaseDatos,
                $principal
            );

            if (!$stmtFoto->execute()) {
                throw new Exception("No se pudo registrar una fotografía.");
            }

            $stmtFoto->close();
        }
    }

    $conexion->commit();

    echo json_encode([
        "success" => true,
        "mensaje" => "Propiedad guardada correctamente."
    ]);
} catch (Exception $error) {
    $conexion->rollback();

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "mensaje" => $error->getMessage()
    ]);
}

$conexion->close();
?>
<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["rol"] == "Administrador" && isset($_POST["id_propietario_admin"])) {
    $id_usuario = $_POST["id_propietario_admin"];
} else {
    $id_usuario = $_SESSION["id"];
}

$tipo = $_POST["tipo"];
$descripcion = $_POST["descripcion"];
$comuna = $_POST["comuna"];
$sector = $_POST["sector"];
$dormitorios = $_POST["dormitorios"];
$banos = $_POST["banos"];
$precio = $_POST["precio"];
$precioUF = $_POST["precioUF"];
$areaConstruida = $_POST["areaConstruida"];
$areaTerreno = $_POST["areaTerreno"];
$fecha = $_POST["fecha"];
$visita = $_POST["visita"];

$caracteristicas = isset($_POST["caracteristicas"])
    ? implode(", ", $_POST["caracteristicas"])
    : "";

$sql = "INSERT INTO propiedades
(id_usuario, tipo, descripcion, comuna, sector, dormitorios, banos, precio, precioUF, areaConstruida, areaTerreno, fecha, visita, caracteristicas)
VALUES
('$id_usuario', '$tipo', '$descripcion', '$comuna', '$sector', '$dormitorios', '$banos', '$precio', '$precioUF', '$areaConstruida', '$areaTerreno', '$fecha', '$visita', '$caracteristicas')";

if ($conexion->query($sql) === TRUE) {

    $id_propiedad = $conexion->insert_id;

    if (isset($_FILES["fotos"]) && count($_FILES["fotos"]["name"]) > 0) {

        $cantidadFotos = count($_FILES["fotos"]["name"]);

        if ($cantidadFotos < 1 || $cantidadFotos > 10) {
            header("Location: propiedades.php?mensaje=error_fotos");
            exit();
        }

        $formatosPermitidos = ["jpg", "jpeg", "png", "webp"];
        $carpetaDestino = "uploads/propiedades/";

        for ($i = 0; $i < $cantidadFotos; $i++) {

            if ($_FILES["fotos"]["error"][$i] === 0) {

                $nombreOriginal = $_FILES["fotos"]["name"][$i];
                $tmp = $_FILES["fotos"]["tmp_name"][$i];
                $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

                if (!in_array($extension, $formatosPermitidos)) {
                    header("Location: propiedades.php?mensaje=formato_invalido");
                    exit();
                }

                $nombreNuevo = time() . "_" . $i . "_" . rand(1000, 9999) . "." . $extension;
                $ruta = $carpetaDestino . $nombreNuevo;

                if (move_uploaded_file($tmp, $ruta)) {

                    $principal = ($i == 0) ? 1 : 0;

                    $sqlFoto = "INSERT INTO fotos_propiedades
                    (id_propiedad, ruta, principal)
                    VALUES
                    ('$id_propiedad', '$ruta', '$principal')";

                    $conexion->query($sqlFoto);
                }
            }
        }
    }

    header("Location: propiedades.php?mensaje=guardado");
    exit();

} else {
    echo "Error al guardar: " . $conexion->error;
}

$conexion->close();
?>
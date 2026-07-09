<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_POST["id"];
$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"];

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

if ($rol == "Administrador" || $rol == "Gestor") {

    $sql = "UPDATE propiedades
            SET tipo='$tipo',
                descripcion='$descripcion',
                comuna='$comuna',
                sector='$sector',
                dormitorios='$dormitorios',
                banos='$banos',
                precio='$precio',
                precioUF='$precioUF',
                areaConstruida='$areaConstruida',
                areaTerreno='$areaTerreno',
                fecha='$fecha',
                visita='$visita'
            WHERE id=$id";

} else {

    $sql = "UPDATE propiedades
            SET tipo='$tipo',
                descripcion='$descripcion',
                comuna='$comuna',
                sector='$sector',
                dormitorios='$dormitorios',
                banos='$banos',
                precio='$precio',
                precioUF='$precioUF',
                areaConstruida='$areaConstruida',
                areaTerreno='$areaTerreno',
                fecha='$fecha',
                visita='$visita'
            WHERE id=$id
            AND id_usuario='$id_usuario'";

}

if ($conexion->query($sql) === TRUE) {
    header("Location: propiedades.php?mensaje=actualizado");
    exit();
} else {
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"];
$id_propiedad = $_GET["id"];

if ($rol != "Administrador" && $rol != "Gestor") {
    $validar = $conexion->query("
        SELECT id 
        FROM propiedades 
        WHERE id = '$id_propiedad'
        AND id_usuario = '$id_usuario'
    ");

    if ($validar->num_rows == 0) {
        header("Location: propiedades.php");
        exit();
    }
}
$fotos = $conexion->query("SELECT * FROM fotos_propiedades WHERE id_propiedad = '$id_propiedad'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Fotos</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="contenedor-propiedades-crud">

    <h1>🖼️ Administrar Fotos</h1>

    <?php while($foto = $fotos->fetch_assoc()) { ?>

        <div style="display:inline-block; margin:15px; text-align:center;">

            <img src="<?php echo $foto["ruta"]; ?>"
                 width="220"
                 height="150"
                 style="object-fit:cover; border-radius:10px;">

            <br><br>

            <?php if ($foto["principal"] == 1) { ?>
                <strong>⭐ Imagen Principal</strong>
            <?php } else { ?>
                <a href="marcar_principal.php?id_foto=<?php echo $foto['id']; ?>&id_propiedad=<?php echo $id_propiedad; ?>"
                   class="btnEditar">
                    ⭐ Hacer Principal
                </a>
            <?php } ?>

            <br><br>

            <a href="eliminar_foto.php?id_foto=<?php echo $foto['id']; ?>&id_propiedad=<?php echo $id_propiedad; ?>"
               class="btnEliminar"
               onclick="return confirmarEliminarFoto(event, this.href)">
                🗑️ Eliminar
            </a>

        </div>

    <?php } ?>

    <br><br>

    <a href="detalle_propiedad.php?id=<?php echo $id_propiedad; ?>" class="volver">⬅️ Volver al detalle</a>

</div>

<script>
function confirmarEliminarFoto(evento, url) {
    evento.preventDefault();

    Swal.fire({
        title: "¿Eliminar foto?",
        text: "Esta imagen se eliminará de la propiedad.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            window.location.href = url;
        }
    });

    return false;
}
</script>
<script>
const params = new URLSearchParams(window.location.search);
const mensaje = params.get("mensaje");

if (mensaje === "principal") {
    Swal.fire({
        icon: "success",
        title: "Imagen principal actualizada",
        text: "Cambio guardado correctamente."
    });
}
</script>

</body>
</html>
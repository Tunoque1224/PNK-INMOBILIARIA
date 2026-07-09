

<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"]) || ($_SESSION["rol"] != "Administrador" && $_SESSION["rol"] != "Gestor")) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET["id"];

$resultado = $conexion->query(
    "SELECT id, tipo, descripcion, estado
     FROM propiedades
     WHERE id = '$id'"
);

$propiedad = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cambiar Estado</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="contenedor-propiedades-crud">

    <h1>🔄 Estado de Propiedad</h1>

    <p>
        <strong>Tipo:</strong>
        <?php echo $propiedad["tipo"]; ?>
    </p>

    <p>
        <strong>Descripción:</strong>
        <?php echo $propiedad["descripcion"]; ?>
    </p>

    <form action="actualizar_estado.php" method="POST">

        <input type="hidden"
               name="id"
               value="<?php echo $propiedad["id"]; ?>">

        <label>Estado:</label>

        <select name="estado" required>

            <option value="Publicada"
                <?php if ($propiedad["estado"] == "Publicada") echo "selected"; ?>>
                Publicada
            </option>

            <option value="Desactivada"
                <?php if ($propiedad["estado"] == "Desactivada") echo "selected"; ?>>
                Desactivada
            </option>

            <option value="Vendida"
                <?php if ($propiedad["estado"] == "Vendida") echo "selected"; ?>>
                Vendida
            </option>

            <option value="Arrendada"
                <?php if ($propiedad["estado"] == "Arrendada") echo "selected"; ?>>
                Arrendada
            </option>

        </select>

        <br><br>

        <button type="submit">
            Guardar Estado
        </button>

    </form>

    <br>

    <a href="propiedades.php" class="volver">
        ⬅️ Volver
    </a>

</div>

</body>
</html>
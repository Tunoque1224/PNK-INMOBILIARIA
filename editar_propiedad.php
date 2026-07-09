<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];
$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"];

if ($rol == "Administrador" || $rol == "Gestor") {
    $sql = "SELECT * FROM propiedades WHERE id = $id";
} else {
    $sql = "SELECT * FROM propiedades 
            WHERE id = $id 
            AND id_usuario = '$id_usuario'";
}

$resultado = $conexion->query($sql);

if ($resultado->num_rows == 0) {
    header("Location: propiedades.php");
    exit();
}

$propiedad = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propiedad</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

<div class="contenedor-propiedades-crud">

    <h1>✏️ Editar Propiedad</h1>

    <form action="actualizar_propiedad.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">

        <label>Tipo Propiedad:</label>
        <select name="tipo">
            <option value="Casa" <?php if($propiedad['tipo'] == 'Casa') echo 'selected'; ?>>Casa</option>
            <option value="Departamento" <?php if($propiedad['tipo'] == 'Departamento') echo 'selected'; ?>>Departamento</option>
            <option value="Terreno" <?php if($propiedad['tipo'] == 'Terreno') echo 'selected'; ?>>Terreno</option>
        </select>

        <br><br>

        <label>Descripción:</label>
        <input type="text" name="descripcion" value="<?php echo $propiedad['descripcion']; ?>">

        <br><br>

        <label>Comuna:</label>
        <input type="text"
        name="comuna"
        value="<?php echo $propiedad['comuna']; ?>"
        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">

        <br><br>

        <label>Sector:</label>
        <input type="text"
        name="sector"
        value="<?php echo $propiedad['sector']; ?>"
        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">

        <br><br>

        <label>Dormitorios:</label>
        <input type="number" name="dormitorios" value="<?php echo $propiedad['dormitorios']; ?>">

        <br><br>

        <label>Baños:</label>
        <input type="number" name="banos" value="<?php echo $propiedad['banos']; ?>">

        <br><br>

        <label>Precio ($):</label>
        <input type="number" name="precio" value="<?php echo $propiedad['precio']; ?>">

        <br><br>

        <label>Precio UF:</label>
        <input type="number" name="precioUF" value="<?php echo $propiedad['precioUF']; ?>">

        <br><br>

        <label>Área Construida:</label>
        <input type="number" name="areaConstruida" value="<?php echo $propiedad['areaConstruida']; ?>">

        <br><br>

        <label>Área Terreno:</label>
        <input type="number" name="areaTerreno" value="<?php echo $propiedad['areaTerreno']; ?>">

        <br><br>

        <label>Fecha Publicación:</label>
        <input type="date" name="fecha" value="<?php echo $propiedad['fecha']; ?>">

        <br><br>

        <label>Solicitar visita:</label>
        <select name="visita">
            <option value="Sí" <?php if($propiedad['visita'] == 'Sí') echo 'selected'; ?>>Sí</option>
            <option value="No" <?php if($propiedad['visita'] == 'No') echo 'selected'; ?>>No</option>
        </select>

        <br><br>

        <button type="submit">Actualizar Propiedad</button>

    </form>

    <br><br>

    <a href="propiedades.php" class="volver">← Volver a Propiedades</a>
    <a href="dashboard.php" class="volver">🏠 Dashboard</a>

</div>

</body>
</html>
<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM propiedades WHERE id = '$id'";
$resultado = $conexion->query($sql);
$propiedad = $resultado->fetch_assoc();

$fotos = $conexion->query("SELECT * FROM fotos_propiedades WHERE id_propiedad = '$id'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle Propiedad</title>

    <link rel="stylesheet" href="css/estilos.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="contenedor-propiedades-crud">

    <h1>🏠 Detalle de Propiedad</h1>

    <h2><?php echo $propiedad["tipo"]; ?></h2>

    <p><strong>Descripción:</strong> <?php echo $propiedad["descripcion"]; ?></p>
    <p><strong>Comuna:</strong> 📍 <?php echo $propiedad["comuna"]; ?></p>
    <p><strong>Sector:</strong> 🗺️ <?php echo $propiedad["sector"]; ?></p>
    <p><strong>Dormitorios:</strong> 🛏️ <?php echo $propiedad["dormitorios"]; ?></p>
    <p><strong>Baños:</strong> 🚿 <?php echo $propiedad["banos"]; ?></p>
    <p><strong>Área terreno:</strong> 📐 <?php echo $propiedad["areaTerreno"]; ?> m²</p>
    <p><strong>Área construida:</strong> 🏗️ <?php echo $propiedad["areaConstruida"]; ?> m²</p>
    <p><strong>Precio:</strong> $<?php echo $propiedad["precio"]; ?></p>
    <p><strong>UF:</strong> <?php echo $propiedad["precioUF"]; ?> UF</p>
    <p><strong>Características:</strong> <?php echo $propiedad["caracteristicas"]; ?></p>

    <h2>📸 Fotografías</h2>

    <div id="carouselPropiedad" class="carousel slide" data-bs-ride="carousel" style="max-width: 800px;">

        <div class="carousel-inner">

            <?php
            $activo = "active";
            while($foto = $fotos->fetch_assoc()) {
            ?>

                <div class="carousel-item <?php echo $activo; ?>">
                    <img src="<?php echo $foto["ruta"]; ?>"
                         class="d-block w-100"
                         style="height: 450px; object-fit: cover; border-radius: 12px;"
                         alt="Foto propiedad">
                </div>

            <?php
                $activo = "";
            }
            ?>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPropiedad" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselPropiedad" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

<br><br>

<hr>

<h2>📍 Ubicación de la Propiedad</h2>

<iframe
    src="https://www.google.com/maps?q=<?php echo urlencode($propiedad['comuna'] . ' ' . $propiedad['sector'] . ' Chile'); ?>&output=embed"
    width="100%"
    height="350"
    style="border:0; border-radius:12px;"
    allowfullscreen=""
    loading="lazy">
</iframe>

<br><br>
    <a href="propiedades.php" class="volver">⬅️ Volver</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
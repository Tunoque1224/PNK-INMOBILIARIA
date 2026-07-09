<?php
include("conexion.php");

if (!isset($_GET["id"])) {
    header("Location: catalogo.php");
    exit();
}

$id = intval($_GET["id"]);

$resultado = $conexion->query("
    SELECT *
    FROM propiedades
    WHERE id = $id
    AND estado = 'Publicada'
");

if (!$resultado || $resultado->num_rows == 0) {
    header("Location: catalogo.php");
    exit();
}

$propiedad = $resultado->fetch_assoc();

$fotos = $conexion->query("
    SELECT *
    FROM fotos_propiedades
    WHERE id_propiedad = $id
    ORDER BY principal DESC, id ASC
");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detalle de Propiedad - PNK Inmobiliaria</title>

    <link rel="stylesheet"
          href="css/estilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="mb-4">

        <a href="catalogo.php"
           class="btn btn-outline-primary">
            ← Volver a Propiedades
        </a>

    </div>


    <div class="row g-4">


        <!-- CARRUSEL -->

        <div class="col-lg-7">

            <?php if ($fotos && $fotos->num_rows > 0) { ?>

                <div id="carouselPublico"
                     class="carousel slide shadow"
                     data-bs-ride="carousel">

                    <div class="carousel-inner rounded">

                        <?php
                        $activo = "active";

                        while ($foto = $fotos->fetch_assoc()) {
                        ?>

                            <div class="carousel-item <?php echo $activo; ?>">

                                <img src="<?php echo $foto["ruta"]; ?>"
                                     class="d-block w-100"
                                     alt="Fotografía de propiedad"
                                     style="height: 500px; object-fit: cover;">

                            </div>

                        <?php
                            $activo = "";
                        }
                        ?>

                    </div>


                    <button class="carousel-control-prev"
                            type="button"
                            data-bs-target="#carouselPublico"
                            data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>

                    </button>


                    <button class="carousel-control-next"
                            type="button"
                            data-bs-target="#carouselPublico"
                            data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>

                    </button>

                </div>

            <?php } else { ?>

                <div class="bg-white shadow-sm rounded p-5 text-center">

                    <h4>Sin fotografías disponibles</h4>

                </div>

            <?php } ?>

        </div>


        <!-- INFORMACIÓN -->

        <div class="col-lg-5">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <span class="badge bg-primary mb-3">

                        <?php echo htmlspecialchars($propiedad["tipo"]); ?>

                    </span>


                    <h1 class="h3 mb-3">

                        <?php echo htmlspecialchars($propiedad["descripcion"]); ?>

                    </h1>


                    <p class="text-muted">

                        📍
                        <?php echo htmlspecialchars($propiedad["comuna"]); ?>,
                        <?php echo htmlspecialchars($propiedad["sector"]); ?>

                    </p>


                    <hr>


                    <div class="row text-center mb-4">

                        <div class="col-6">

                            <strong>🛏️ Dormitorios</strong>

                            <p class="mb-0">

                                <?php echo $propiedad["dormitorios"]; ?>

                            </p>

                        </div>


                        <div class="col-6">

                            <strong>🚿 Baños</strong>

                            <p class="mb-0">

                                <?php echo $propiedad["banos"]; ?>

                            </p>

                        </div>

                    </div>


                    <div class="row text-center mb-4">

                        <div class="col-6">

                            <strong>📐 Terreno</strong>

                            <p class="mb-0">

                                <?php echo $propiedad["areaTerreno"]; ?> m²

                            </p>

                        </div>


                        <div class="col-6">

                            <strong>🏗️ Construido</strong>

                            <p class="mb-0">

                                <?php echo $propiedad["areaConstruida"]; ?> m²

                            </p>

                        </div>

                    </div>


                    <hr>


                    <p class="mb-1 text-muted">
                        Precio
                    </p>

                    <h3 class="text-primary">

                        $<?php echo number_format($propiedad["precio"], 0, ",", "."); ?>

                    </h3>

                    <p>

                        <?php echo $propiedad["precioUF"]; ?> UF

                    </p>


                    <hr>


                    <h5>Características</h5>

                    <p>

                        <?php echo htmlspecialchars($propiedad["caracteristicas"]); ?>

                    </p>


                    <h5>Visitas</h5>

                    <p>

                        <?php echo htmlspecialchars($propiedad["visita"]); ?>

                    </p>
                    <hr>

<h5>📍 Ubicación</h5>

<iframe
    src="https://www.google.com/maps?q=<?php echo urlencode($propiedad['comuna'] . ' ' . $propiedad['sector'] . ' Chile'); ?>&output=embed"
    width="100%"
    height="260"
    style="border:0; border-radius:12px;"
    allowfullscreen=""
    loading="lazy">
</iframe>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>
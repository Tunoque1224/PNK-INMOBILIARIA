<?php
include("conexion.php");

$sql = "
    SELECT propiedades.*, fotos_propiedades.ruta AS imagen_principal
    FROM propiedades
    LEFT JOIN fotos_propiedades
        ON propiedades.id = fotos_propiedades.id_propiedad
        AND fotos_propiedades.principal = 1
    WHERE propiedades.estado = 'Publicada'
    ORDER BY propiedades.id DESC
";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Propiedades Disponibles - PNK Inmobiliaria</title>

    <link rel="stylesheet" href="css/estilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="mb-4">
    <a href="index.html" class="btn btn-outline-primary">
        ← Volver al Inicio
    </a>
</div>

    <div class="text-center mb-5">
        <h1>Propiedades Disponibles</h1>
        <p>Encuentra la propiedad que estás buscando.</p>
    </div>

    <div class="row g-4">

        <?php while ($propiedad = $resultado->fetch_assoc()) { ?>

            <div class="col-lg-4 col-md-6">

                <div class="card h-100 shadow-sm">

                    <?php if (!empty($propiedad["imagen_principal"])) { ?>

                        <img src="<?php echo $propiedad["imagen_principal"]; ?>"
                             class="card-img-top"
                             alt="Imagen propiedad"
                             style="height: 240px; object-fit: cover;">

                    <?php } else { ?>

                        <div class="d-flex align-items-center justify-content-center bg-light"
                             style="height: 240px;">
                            Sin imagen disponible
                        </div>

                    <?php } ?>

                    <div class="card-body">

                        <h4 class="card-title">
                            <?php echo $propiedad["tipo"]; ?>
                        </h4>

                        <p class="card-text">
                            <?php echo $propiedad["descripcion"]; ?>
                        </p>

                        <p>
                            📍
                            <?php echo $propiedad["comuna"]; ?>,
                            <?php echo $propiedad["sector"]; ?>
                        </p>

                        <p>
                            🛏️ <?php echo $propiedad["dormitorios"]; ?> dormitorios
                            &nbsp;
                            🚿 <?php echo $propiedad["banos"]; ?> baños
                        </p>

                        <h5>
                            $<?php echo number_format($propiedad["precio"], 0, ",", "."); ?>
                        </h5>

                        <p>
                            <?php echo $propiedad["precioUF"]; ?> UF
                        </p>

                    </div>

                    <div class="card-footer bg-white border-0 pb-4">

                        <a href="detalle_publico.php?id=<?php echo $propiedad['id']; ?>"
                           class="btn btn-primary w-100">
                            Ver Detalle
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
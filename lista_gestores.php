<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "Administrador") {
    header("Location: dashboard.php");
    exit();
}

$resultado = $conexion->query("SELECT * FROM gestores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Gestores</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

<div class="contenedor-propiedades-crud">

    <h1>🤝 Gestores Registrados</h1>

    <div class="tabla-responsive">
        <table border="1">
            <thead>
                <tr>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Certificado</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($gestor = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $gestor["rut"]; ?></td>
                        <td><?php echo $gestor["nombre"]; ?></td>
                        <td><?php echo $gestor["correo"]; ?></td>
                        <td><?php echo $gestor["telefono"]; ?></td>
                        <td>
                            <?php if (!empty($gestor["certificado"])) { ?>
    <a href="certificados/<?php echo $gestor["certificado"]; ?>"
       target="_blank"
       class="btnEditar">
        📄 Ver PDF
    </a>
<?php } else { ?>
    Sin PDF
<?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <br><br>

    <a href="dashboard.php" class="volver">🏠 Volver al Dashboard</a>

</div>

</body>
</html>
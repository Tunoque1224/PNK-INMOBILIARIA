<?php
include("conexion.php");
$resultado = $conexion->query("SELECT * FROM gestores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Gestor Inmobiliario Freelance</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="contenedor-propiedades-crud">

    <h1>🤝 Registro Gestor Inmobiliario</h1>

    <form id="formGestor" action="guardar_gestor.php" method="POST" enctype="multipart/form-data">

        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut" placeholder="12.345.678-9">

        <br><br>

        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre">

        <br><br>

        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date"
       id="fechaNacimiento"
       name="fechaNacimiento"
       max="<?php echo date('Y-m-d'); ?>">

        <br><br>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo">

        <br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">

        <br><br>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo">
            <option value="">Seleccione...</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>

        <br><br>

        <label for="telefono">Teléfono Móvil:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="912345678">

        <br><br>

        <label for="certificado">Certificado de Antecedentes:</label>
        <input type="file" id="certificado" name="certificado" accept=".pdf">

        <br><br>

        <button type="submit">Registrar Gestor</button>

</form>

<br><br>

<a href="dashboard.php" class="volver">🏠 Dashboard</a>
<a href="index.html" class="volver">← Volver al Inicio</a>

</div>

    <?php if(isset($_GET["mensaje"])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    <?php if($_GET["mensaje"] == "guardado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Gestor registrado",
        text: "Tu registro fue exitoso. Debes esperar la aprobación del administrador para acceder al sistema.."
    });
    <?php } ?>

    <?php if($_GET["mensaje"] == "actualizado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Gestor actualizado",
        text: "Los datos fueron modificados correctamente."
    });
    <?php } ?>

    <?php if($_GET["mensaje"] == "eliminado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Gestor eliminado",
        text: "El gestor fue eliminado correctamente."
    });
    <?php } ?>

});
</script>
<?php } ?>
       <script src="js/gestor.js?v=2"></script>

</body>
</html>
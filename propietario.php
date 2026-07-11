
<?php
include("conexion.php");
$resultado = $conexion->query("SELECT * FROM propietarios");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro Propietario</title>

    <link rel="stylesheet" href="css/estilos.css?v=2">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="contenedor-propiedades-crud">

    <h1>🏡 Administración de Propietarios</h1>
    <form id="formPropietario" action="guardar_propietario.php" method="POST">
    <label for="rut">RUT:</label>
    <input type="text" id="rut" name="rut">

    <br><br>

    <label for="nombre">Nombre Completo:</label>
    <input type="text" id="nombre" name="nombre">

    <br><br>

    <label for="fecha">Fecha de Nacimiento:</label>
    <input type="date"
       id="fecha"
       name="fecha"
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
    <option>Masculino</option>
    <option>Femenino</option>
    <option>Otro</option>
    </select>

    <br><br>

    <label for="telefono">Teléfono Móvil:</label>
    <input type="text" id="telefono" name="telefono">

    <br><br>

    <label for="propiedad">N° Propiedad:</label>
    <input type="number"
       id="propiedad"
       name="propiedad"
       min="1"
       step="1"
       required>

    <br><br>

    <button type="submit">Registrar Propietario</button>

<a href="dashboard.php" class="volver">
    🏠 Dashboard
</a>

</form>

<br><br>

<a href="index.html" class="volver">
    ← Volver
</a>

</div>
       <?php if(isset($_GET["mensaje"])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    <?php if($_GET["mensaje"] == "guardado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Propietario registrado",
        text: "Tu registro fue exitoso. Debes esperar la aprobación del administrador para acceder al sistema"
    });
    <?php } ?>

    <?php if($_GET["mensaje"] == "actualizado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Propietario actualizado",
        text: "Los datos fueron modificados correctamente."
    });
    <?php } ?>

    <?php if($_GET["mensaje"] == "eliminado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Propietario eliminado",
        text: "El propietario fue eliminado correctamente."
    });
    <?php } ?>

});
</script>
<?php } ?>
       <script src="js/propietario.js?v=3"></script>

</body>
</html>
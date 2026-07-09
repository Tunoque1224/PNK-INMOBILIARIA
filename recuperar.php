<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - PNK Inmobiliaria</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="login-contenedor">

    <div class="login-card">

        <img src="img/logo.png" alt="Logo PNK">

        <h1>Recuperar Contraseña</h1>

        <form action="recuperar_password.php" method="POST">

            <label>Correo Electrónico:</label>
            <input type="email" name="correo" id="correo" required>

            <br><br>

            <button type="submit">Recuperar contraseña</button>

        </form>

        <br>

        <a href="login.php">← Volver al Login</a>

    </div>

</div>

<?php
if(isset($_GET["mensaje"])){

    if($_GET["mensaje"]=="encontrado"){
?>

<script>
Swal.fire({
    icon:"success",
    title:"Correo encontrado",
    text:"El correo existe en el sistema."
});
</script>

<?php
    }

    if($_GET["mensaje"]=="noexiste"){
?>

<script>
Swal.fire({
    icon:"error",
    title:"Correo no encontrado",
    text:"No existe una cuenta con ese correo."
});
</script>

<?php
    }
}
?>

</body>
</html>
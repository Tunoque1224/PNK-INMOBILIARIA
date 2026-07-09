<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - PNK Inmobiliaria</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="login-contenedor">

    <div class="login-card">

        <img src="img/logo.png" alt="Logo PNK Inmobiliaria">

        <h1>Iniciar Sesión</h1>

        <form id="formLogin" action="validar_login.php" method="POST">

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" placeholder="Ingrese su correo">

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Ingrese su contraseña">

            <button type="submit">Ingresar</button>

        </form>

        <a href="recuperar.php">¿Olvidó su contraseña?</a>
        <a href="index.html">← Volver al Inicio</a>

    </div>

</div>

<script src="./js/login.js"></script>

</body>
</html>
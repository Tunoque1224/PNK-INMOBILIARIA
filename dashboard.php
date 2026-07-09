<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - PNK Inmobiliaria</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="dashboard">

    <img src="img/logo.png" alt="Logo PNK" class="logo-dashboard">

    <h1>Panel PNK Inmobiliaria</h1>

<h2>Bienvenido, <?php echo $_SESSION["nombre"]; ?></h2>

<div class="info-usuario">
    <p><strong>Rol:</strong> <?php echo $_SESSION["rol"]; ?></p>
    <p><strong>Estado:</strong> <?php echo $_SESSION["estado"]; ?></p>
</div>

<p>Sistema de gestión inmobiliaria con control de usuarios y propiedades.</p>
<div class="dashboard-menu">

    <a href="propiedades.php" class="card-dashboard">
        🏠
        <h2>Propiedades</h2>
        <p>Administrar propiedades</p>
    </a>

    <?php if ($_SESSION["rol"] == "Administrador") { ?>

        <a href="usuarios.php" class="card-dashboard">
            👥
            <h2>Usuarios</h2>
            <p>Aprobar y gestionar usuarios</p>
        </a>
        <a href="lista_gestores.php" class="card-dashboard">
        🤝
        <h2>Gestores</h2>
        <p>Revisar gestores y certificados</p>
    </a>

    <?php } ?>

</div>

    <a href="logout.php" class="btnLogout">Cerrar Sesión</a>

</div>

<?php if(isset($_GET["login"]) && $_GET["login"]=="ok") { ?>
<script>
Swal.fire({
    icon: "success",
    title: "Bienvenido",
    text: "Inicio de sesión correcto."
});
</script>
<?php } ?>

</body>
</html>
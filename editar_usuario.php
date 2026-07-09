<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["rol"] != "Administrador") {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM usuarios WHERE id = $id";
$resultado = $conexion->query($sql);
$usuario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

<div class="contenedor-usuarios">

    <h1>✏️ Editar Usuario</h1>

    <form action="actualizar_usuario.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

        <label>RUT:</label>
        <input type="text" name="rut" value="<?php echo $usuario['rut']; ?>">

        <br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>">

        <br><br>

        <label>Correo:</label>
        <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>">

        <br><br>

<label>Estado de la Cuenta:</label>
<select name="estado">
    <option value="Pendiente" <?php if($usuario['estado'] == 'Pendiente') echo 'selected'; ?>>
        Pendiente
    </option>

    <option value="Activo" <?php if($usuario['estado'] == 'Activo') echo 'selected'; ?>>
        Activo
    </option>

    <option value="Bloqueado" <?php if($usuario['estado'] == 'Bloqueado') echo 'selected'; ?>>
        Bloqueado
    </option>
</select>

<br><br>

<label>Rol del Usuario:</label>
<select name="rol">
    <option value="Administrador" <?php if($usuario['rol'] == 'Administrador') echo 'selected'; ?>>
        Administrador
    </option>

    <option value="Propietario" <?php if($usuario['rol'] == 'Propietario') echo 'selected'; ?>>
        Propietario
    </option>

    <option value="Gestor" <?php if($usuario['rol'] == 'Gestor') echo 'selected'; ?>>
        Gestor
    </option>

        </select>

        <br><br>

        <button type="submit">Actualizar Usuario</button>

    </form>

    <br><br>

    <a href="usuarios.php" class="volver">← Volver a Usuarios</a>
    <a href="dashboard.php" class="volver">🏠 Dashboard</a>

</div>

</body>
</html>
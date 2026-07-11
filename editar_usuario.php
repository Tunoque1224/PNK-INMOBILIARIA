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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="contenedor-usuarios">

    <h1>✏️ Editar Usuario</h1>

    <form id="formEditarUsuario" action="actualizar_usuario.php" method="POST">

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
<script>
function validarRut(rutCompleto) {
    const rutLimpio = rutCompleto
        .replace(/\./g, "")
        .replace("-", "")
        .toUpperCase();

    if (rutLimpio.length < 2) {
        return false;
    }

    const cuerpo = rutLimpio.slice(0, -1);
    const dvIngresado = rutLimpio.slice(-1);

    if (!/^\d+$/.test(cuerpo)) {
        return false;
    }

    let suma = 0;
    let multiplicador = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += Number(cuerpo.charAt(i)) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }

    const resultado = 11 - (suma % 11);
    let dvCalculado;

    if (resultado === 11) {
        dvCalculado = "0";
    } else if (resultado === 10) {
        dvCalculado = "K";
    } else {
        dvCalculado = resultado.toString();
    }

    return dvIngresado === dvCalculado;
}

document.getElementById("formEditarUsuario").addEventListener("submit", function (e) {
    const rut = document.querySelector('input[name="rut"]').value.trim();
    const nombre = document.querySelector('input[name="nombre"]').value.trim();
    const correo = document.querySelector('input[name="correo"]').value.trim();
    const estado = document.querySelector('select[name="estado"]').value;
    const rol = document.querySelector('select[name="rol"]').value;

    const formatoRut = /^[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9kK]$/;
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]+$/;
    const formatoCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (
        rut === "" ||
        nombre === "" ||
        correo === "" ||
        estado === "" ||
        rol === ""
    ) {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Debe completar todos los campos."
        });

        return;
    }

    if (!formatoRut.test(rut)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "RUT inválido",
            text: "Use el formato 12.345.678-9."
        });

        return;
    }

    if (!validarRut(rut)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "RUT inválido",
            text: "El dígito verificador no corresponde."
        });

        return;
    }

    if (!soloLetras.test(nombre)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Nombre inválido",
            text: "El nombre solo debe contener letras y espacios."
        });

        return;
    }

    if (!formatoCorreo.test(correo)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Correo inválido",
            text: "Ingrese un correo electrónico válido."
        });

        return;
    }
});
</script>

</body>
</html>
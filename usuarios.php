<?php
session_start();
include("conexion.php");
$totalUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()["total"];

$totalPropietarios = $conexion->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'Propietario'")->fetch_assoc()["total"];

$totalGestores = $conexion->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'Gestor'")->fetch_assoc()["total"];

$totalPendientes = $conexion->query("SELECT COUNT(*) AS total FROM usuarios WHERE estado = 'Pendiente'")->fetch_assoc()["total"];

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["rol"] != "Administrador") {
    header("Location: dashboard.php");
    exit();
}

$resultado = $conexion->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CRUD Usuarios</title>
    <link rel="stylesheet" href="css/estilos.css?v=99">
</head>

<body>

<div class="contenedor-usuarios">

    <div class="cabeceraUsuarios">
        <h1>👤 Administración de Usuarios</h1>

        <button type="button" class="btnNuevoUsuario" onclick="mostrarFormulario()">
            ➕ Nuevo Usuario
        </button>
    </div>

    <br>

    <input type="text"
           id="buscadorUsuarios"
           class="buscadorUsuarios"
           placeholder="🔍 Buscar por nombre, correo, RUT o rol...">

    <br><br>

    <form id="formUsuario" action="guardar_usuario.php" method="POST" style="display:none;">

        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut">

        <br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre">

        <br><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo">
        
        <br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">

        <br><br>

        <label for="rol">Rol Usuario:</label>

        <select id="rol" name="rol">
            <option value="">Seleccione...</option>
            <option value="Administrador">Administrador</option>
            <option value="Propietario">Propietario</option>
            <option value="Gestor">Gestor</option>
        </select>

        <br><br>

        <button type="submit">Guardar</button>

    </form>
    <div class="resumenPropiedades">

    <div class="cardResumen">
        <h3>Total Usuarios</h3>
        <p><?php echo $totalUsuarios; ?></p>
    </div>

    <div class="cardResumen">
        <h3>Propietarios</h3>
        <p><?php echo $totalPropietarios; ?></p>
    </div>

    <div class="cardResumen">
        <h3>Gestores</h3>
        <p><?php echo $totalGestores; ?></p>
    </div>

    <div class="cardResumen">
        <h3>Pendientes</h3>
        <p><?php echo $totalPendientes; ?></p>
    </div>

</div>
    <h2>Listado de Usuarios</h2>

    <table border="1">

        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Rol</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>

        <tbody id="tablaUsuarios">

        <?php while($usuario = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $usuario["rut"]; ?></td>
                <td><?php echo $usuario["nombre"]; ?></td>
                <td><?php echo $usuario["correo"]; ?></td>
                <td>
    <?php
    $estado = $usuario["estado"];

    if ($estado == "Activo") {
        $claseEstado = "estado-activo";
    } elseif ($estado == "Pendiente") {
        $claseEstado = "estado-pendiente";
    } elseif ($estado == "Bloqueado") {
        $claseEstado = "estado-bloqueado";
    } else {
        $claseEstado = "";
    }
    ?>

    <span class="estado-usuario <?php echo $claseEstado; ?>">
        <?php echo $estado; ?>
    </span>
</td>
                <td><?php echo $usuario["rol"]; ?></td>

                <td>
                    <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btnEditarUsuario">
                        ✏️ Editar
                    </a>
                </td>

                <td>
                    <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btnEliminarUsuario">
                        🗑️ Eliminar
                    </a>
                </td>
            </tr>
        <?php } ?>

        </tbody>

    </table>

    <br><br>

    <a href="dashboard.php" class="volver">🏠 Volver al Dashboard</a>

</div>

<?php if(isset($_GET["mensaje"])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    <?php if($_GET["mensaje"] == "guardado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Usuario registrado",
        text: "El usuario fue guardado correctamente."
    });
    <?php } ?>

    <?php if($_GET["mensaje"] == "actualizado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Usuario actualizado",
        text: "Los datos fueron modificados correctamente."
    });
    <?php } ?>

    <?php if($_GET["mensaje"] == "eliminado"){ ?>
    Swal.fire({
        icon: "success",
        title: "Usuario eliminado",
        text: "El usuario fue eliminado correctamente."
    });
    <?php } ?>

});
</script>
<?php } ?>

<script>
function mostrarFormulario() {
    let formulario = document.getElementById("formUsuario");

    if (formulario.style.display === "none") {
        formulario.style.display = "block";
    } else {
        formulario.style.display = "none";
    }
}

document.getElementById("buscadorUsuarios").addEventListener("keyup", function() {
    let texto = this.value.toLowerCase();
    let filas = document.querySelectorAll("#tablaUsuarios tr");

    filas.forEach(function(fila) {
        let contenido = fila.textContent.toLowerCase();

        if (contenido.includes(texto)) {
            fila.style.display = "";
        } else {
            fila.style.display = "none";
        }
    });
});
</script>

<script src="js/usuarios.js?v=2"></script>

</body>
</html>
<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];
$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"];

if ($rol == "Administrador" || $rol == "Gestor") {
    $sql = "SELECT * FROM propiedades WHERE id = $id";
} else {
    $sql = "SELECT * FROM propiedades 
            WHERE id = $id 
            AND id_usuario = '$id_usuario'";
}

$resultado = $conexion->query($sql);

if ($resultado->num_rows == 0) {
    header("Location: propiedades.php");
    exit();
}

$propiedad = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propiedad</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="contenedor-propiedades-crud">

    <h1>✏️ Editar Propiedad</h1>

    <form id="formEditarPropiedad"
      action="actualizar_propiedad.php"
      method="POST">

        <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">

        <label>Tipo Propiedad:</label>
        <select id="tipo" name="tipo">
            <option value="Casa" <?php if($propiedad['tipo'] == 'Casa') echo 'selected'; ?>>Casa</option>
            <option value="Departamento" <?php if($propiedad['tipo'] == 'Departamento') echo 'selected'; ?>>Departamento</option>
            <option value="Terreno" <?php if($propiedad['tipo'] == 'Terreno') echo 'selected'; ?>>Terreno</option>
        </select>

        <br><br>

        <label>Descripción:</label>
        <input type="text"
       id="descripcion"
       name="descripcion"
       value="<?php echo $propiedad['descripcion']; ?>"
       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')"
       required>

        <br><br>

        <label>Comuna:</label>
        <input type="text"
       id="comuna"
       name="comuna"
       value="<?php echo $propiedad['comuna']; ?>"
       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')"
       required>

        <br><br>

        <label>Sector:</label>
        <input type="text"
       id="sector"
       name="sector"
       value="<?php echo $propiedad['sector']; ?>"
       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')"
       required>

        <br><br>
        <label>Dormitorios:</label>
        <input type="number"
       id="dormitorios"
       name="dormitorios"
       value="<?php echo $propiedad['dormitorios']; ?>"
       min="0"
       required>

        <br><br>
        <label>Baños:</label>
        <input type="number"
       id="banos"
       name="banos"
       value="<?php echo $propiedad['banos']; ?>"
       min="0"
       required>

        <br><br>

        <label>Precio ($):</label>
        <input type="number"
       id="precio"
       name="precio"
       value="<?php echo $propiedad['precio']; ?>"
       min="1"
       step="1"
       required>

        <br><br>

       <label>Precio UF:</label>
       <input type="number"
       id="precioUF"
       name="precioUF"
       value="<?php echo $propiedad['precioUF']; ?>"
       readonly>

        <br><br>

        <label>Área Construida:</label>
        <input type="number"
       id="areaConstruida"
       name="areaConstruida"
       value="<?php echo $propiedad['areaConstruida']; ?>"
       min="0"
       required>

        <br><br>

        <label>Área Terreno:</label>
        <input type="number"
       id="areaTerreno"
       name="areaTerreno"
       value="<?php echo $propiedad['areaTerreno']; ?>"
       min="0"
       required>

        <br><br>
        <label>Fecha</label>
        <input type="date"
       id="fecha"
       name="fecha"
       value="<?php echo $propiedad['fecha']; ?>"
       max="<?php echo date('Y-m-d'); ?>"
       required>

        <br><br>

        <label>Solicitar visita:</label>
        <select id="visita" name="visita">
            <option value="Sí" <?php if($propiedad['visita'] == 'Sí') echo 'selected'; ?>>Sí</option>
            <option value="No" <?php if($propiedad['visita'] == 'No') echo 'selected'; ?>>No</option>
        </select>

        <br><br>

        <button type="submit">Actualizar Propiedad</button>

    </form>

    <br><br>

    <a href="propiedades.php" class="volver">← Volver a Propiedades</a>
    <a href="dashboard.php" class="volver">🏠 Dashboard</a>

</div>
<script>
const valorUF = 78158;

const formEditarPropiedad = document.getElementById("formEditarPropiedad");
const precioInput = document.getElementById("precio");
const precioUFInput = document.getElementById("precioUF");

precioInput.addEventListener("input", function () {
    const precio = Number(precioInput.value);

    if (precio > 0) {
        precioUFInput.value = (precio / valorUF).toFixed(2);
    } else {
        precioUFInput.value = "";
    }
});

formEditarPropiedad.addEventListener("submit", function (e) {
    const tipo = document.getElementById("tipo").value;
    const descripcion = document.getElementById("descripcion").value.trim();
    const comuna = document.getElementById("comuna").value.trim();
    const sector = document.getElementById("sector").value.trim();
    const dormitorios = document.getElementById("dormitorios").value;
    const banos = document.getElementById("banos").value;
    const precio = document.getElementById("precio").value;
    const precioUF = document.getElementById("precioUF").value;
    const areaConstruida = document.getElementById("areaConstruida").value;
    const areaTerreno = document.getElementById("areaTerreno").value;
    const fecha = document.getElementById("fecha").value;
    const visita = document.getElementById("visita").value;

    if (
        tipo === "" ||
        descripcion === "" ||
        comuna === "" ||
        sector === "" ||
        precio === "" ||
        precioUF === "" ||
        fecha === "" ||
        visita === ""
    ) {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Debe completar todos los campos obligatorios."
        });

        return;
    }

    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]+$/;

    if (
        !soloLetras.test(descripcion) ||
        !soloLetras.test(comuna) ||
        !soloLetras.test(sector)
    ) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Texto inválido",
            text: "Descripción, comuna y sector solo permiten letras y espacios."
        });

        return;
    }

    if (tipo === "Casa") {
        if (
            dormitorios === "" ||
            banos === "" ||
            areaConstruida === "" ||
            areaTerreno === ""
        ) {
            e.preventDefault();

            Swal.fire({
                icon: "warning",
                title: "Campos incompletos",
                text: "Complete todos los datos de la casa."
            });

            return;
        }
    }

    if (tipo === "Departamento") {
        if (
            dormitorios === "" ||
            banos === "" ||
            areaConstruida === ""
        ) {
            e.preventDefault();

            Swal.fire({
                icon: "warning",
                title: "Campos incompletos",
                text: "Complete todos los datos del departamento."
            });

            return;
        }
    }

    if (tipo === "Terreno" && areaTerreno === "") {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Complete el área del terreno."
        });

        return;
    }

    if (
        Number(dormitorios) < 0 ||
        Number(banos) < 0 ||
        Number(areaConstruida) < 0 ||
        Number(areaTerreno) < 0
    ) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Valores inválidos",
            text: "Dormitorios, baños y áreas no pueden ser negativos."
        });

        return;
    }

    if (Number(precio) <= 0) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Precio inválido",
            text: "El precio debe ser mayor que cero."
        });

        return;
    }

    const fechaSeleccionada = new Date(fecha + "T00:00:00");
    const fechaActual = new Date();

    fechaActual.setHours(0, 0, 0, 0);

    if (fechaSeleccionada > fechaActual) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Fecha inválida",
            text: "La fecha de publicación no puede ser futura."
        });

        return;
    }
});
</script>

</body>
</html>
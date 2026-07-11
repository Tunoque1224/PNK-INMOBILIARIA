
<?php
session_start();
include("conexion.php");
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"];
$propietariosActivos = $conexion->query("
    SELECT id, nombre, correo
    FROM usuarios
    WHERE rol = 'Propietario'
    AND estado = 'Activo'
");

if ($rol == "Administrador" || $rol == "Gestor") {

    $resultado = $conexion->query("
    SELECT 
        propiedades.*,
        fotos_propiedades.ruta AS imagen_principal,
        usuarios.nombre AS nombre_usuario,
        usuarios.correo AS correo_usuario
    FROM propiedades
    LEFT JOIN fotos_propiedades
        ON propiedades.id = fotos_propiedades.id_propiedad
        AND fotos_propiedades.principal = 1
    LEFT JOIN usuarios
        ON propiedades.id_usuario = usuarios.id
");

} else {

    $resultado = $conexion->query("
        SELECT propiedades.*, fotos_propiedades.ruta AS imagen_principal
        FROM propiedades
        LEFT JOIN fotos_propiedades
        ON propiedades.id = fotos_propiedades.id_propiedad
        AND fotos_propiedades.principal = 1
        WHERE propiedades.id_usuario = '$id_usuario'
    ");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Propiedades</title>
    <link rel="stylesheet" href="css/estilos.css?v=50">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="contenedor-propiedades-crud">

    <div class="cabeceraUsuarios">
        <h1>🏠 Administración de Propiedades</h1>

        <?php if ($rol != "Gestor") { ?>
        <button type="button" class="btnNuevaPropiedad" onclick="mostrarFormularioPropiedad()">
            ➕ Nueva Propiedad
        </button>
        <?php } ?>
    </div>

    <br>

    <div class="barraFiltros">

    <select id="filtroTipo" class="inputFiltro">
        <option value="">Todos los tipos</option>
        <option value="casa">Casa</option>
        <option value="departamento">Departamento</option>
        <option value="terreno">Terreno</option>
    </select>

    <input type="text"
           id="filtroComuna"
           class="inputFiltro"
           placeholder="Comuna">

    <input type="text"
           id="filtroSector"
           class="inputFiltro"
           placeholder="Sector">

    <button type="button"
            id="btnLimpiarBusqueda"
            class="btnLimpiarFiltros">
        Limpiar filtros
    </button>

</div>

    <br><br>

    <?php if ($rol != "Gestor") { ?>
    <form id="formPropiedad" action="guardar_propiedad.php" method="POST" enctype="multipart/form-data" style="display:none;">
        <?php if ($rol == "Administrador") { ?>

    <label>Seleccionar Propietario:</label>

    <select name="id_propietario_admin" id="id_propietario_admin" required>
        <option value="">Seleccione propietario...</option>

        <?php while ($propietario = $propietariosActivos->fetch_assoc()) { ?>

            <option value="<?php echo $propietario["id"]; ?>">
                <?php echo $propietario["nombre"]; ?>
                - <?php echo $propietario["correo"]; ?>
            </option>

        <?php } ?>

    </select>

    <br><br>

<?php } ?>

        <label>Tipo Propiedad:</label>
        <select id="tipo" name="tipo">
            <option value="">Seleccione...</option>
            <option value="Casa">Casa</option>
            <option value="Departamento">Departamento</option>
            <option value="Terreno">Terreno</option>
        </select>

        <br><br>

        <label>Descripción:</label>
        <input type="text" id="descripcion" name="descripcion">
        <label>Comuna:</label>
        <input type="text"
        id="comuna"
        name="comuna"
        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">

        <br><br>

       <label>Sector:</label>
       <input type="text"
       id="sector"
       name="sector"
       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">

       <br><br>

        <div id="campoDormitorios">
        <label>Dormitorios:</label>
        <input type="number" id="dormitorios" name="dormitorios" min="0">
        <br><br>
        </div>

        <div id="campoBanos">
        <label>Baños:</label>
        <input type="number" id="banos" name="banos" min="0">
        <br><br>
        </div>
        

        <label>Precio ($):</label>
        <input type="text" id="precio" name="precio">

        <br><br>

        <label>Precio (UF):</label>
        <input type="text" id="precioUF" name="precioUF" readonly>

        <br><br>

        <div id="campoAreaConstruida">
        <label>Área Construida (m²):</label>
        <input type="number" id="areaConstruida" name="areaConstruida" min="0">
        <br><br>
        </div>

        

        <div id="campoAreaTerreno">
        <label>Área Terreno (m²):</label>
        <input type="number" id="areaTerreno" name="areaTerreno" min="0">
        <br><br>
        </div>

        <label>Fecha Publicación:</label>
        <input type="date"
       id="fecha"
       name="fecha"
       max="<?php echo date('Y-m-d'); ?>">

        <br><br>

        <label>Fotografías:</label>
        <input type="file" id="fotos" name="fotos[]" accept=".jpg,.jpeg,.png,.webp" multiple>

        <br><br>

        <div id="galeriaFotos"></div>

        <label>Solicitar visita:</label>
        <select id="visita" name="visita">
            <option value="">Seleccione...</option>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
        </select>

        <br><br>

        <strong>Características:</strong>

        <br><br>

        <label><input type="checkbox" name="caracteristicas[]" value="Bodega"> Bodega</label>
        <label><input type="checkbox" name="caracteristicas[]" value="Estacionamiento"> Estacionamiento</label>
        <label><input type="checkbox" name="caracteristicas[]" value="Logia"> Logia</label>

        <br><br>

        <label><input type="checkbox" name="caracteristicas[]" value="Cocina Amoblada"> Cocina Amoblada</label>
        <label><input type="checkbox" name="caracteristicas[]" value="Antejardín"> Antejardín</label>
        <label><input type="checkbox" name="caracteristicas[]" value="Patio Trasero"> Patio Trasero</label>
        <label><input type="checkbox" name="caracteristicas[]" value="Piscina"> Piscina</label>

        <br><br>

        <button type="submit">Guardar Propiedad</button>

    </form>
   <?php } ?>

<div class="resumenPropiedades">

    <div class="cardResumen">
        <h3>Total Propiedades</h3>
        <p><?php echo $resultado->num_rows; ?></p>
    </div>

    <div class="cardResumen">
        <h3>Publicadas</h3>
        <p>🏠</p>
    </div>

    <div class="cardResumen">
        <h3>Gestión</h3>
        <p>📊</p>
    </div>

</div>
    <h2>Listado de Propiedades</h2>

    <div class="tabla-responsive">
        <table border="1">
            <thead>
    <tr>
        <th>Tipo</th>
        <th>Foto</th>
        <th>Descripción</th>

<?php if ($rol == "Administrador" || $rol == "Gestor") { ?>
    <th>Propietario</th>
<?php } ?>

<th>Comuna</th>
        <th>Sector</th>
        <th>Dormitorios</th>
        <th>Baños</th>
        <th>Área Terreno</th>
        <th>Área Construida</th>
        <th>Precio</th>
        <th>UF</th>
        <th>Características</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody id="tablaPropiedades">

<?php while($propiedad = $resultado->fetch_assoc()) { ?>

    <tr>

        <td><?php echo $propiedad["tipo"]; ?></td>

        <td>
            <?php if (!empty($propiedad["imagen_principal"])) { ?>

                <img src="<?php echo $propiedad["imagen_principal"]; ?>"
                     alt="Imagen principal"
                     width="120"
                     height="90"
                     style="object-fit: cover; border-radius: 8px;">

            <?php } else { ?>

                Sin imagen

            <?php } ?>
        </td>

        <td><?php echo $propiedad["descripcion"]; ?></td>
        <?php if ($rol == "Administrador" || $rol == "Gestor") { ?>

    <td>
        <?php if (!empty($propiedad["nombre_usuario"])) { ?>

            <strong>
                <?php echo $propiedad["nombre_usuario"]; ?>
            </strong>

            <br>

            <?php echo $propiedad["correo_usuario"]; ?>

        <?php } else { ?>

            Sin propietario asignado

        <?php } ?>
    </td>

<?php } ?>
</td>

        <td><?php echo $propiedad["comuna"]; ?></td>

        <td><?php echo $propiedad["sector"]; ?></td>

        <td><?php echo $propiedad["dormitorios"]; ?></td>

        <td><?php echo $propiedad["banos"]; ?></td>

        <td><?php echo $propiedad["areaTerreno"]; ?> m²</td>

        <td><?php echo $propiedad["areaConstruida"]; ?> m²</td>

        <td>$<?php echo $propiedad["precio"]; ?></td>

        <td><?php echo $propiedad["precioUF"]; ?> UF</td>

        <td><?php echo $propiedad["caracteristicas"]; ?></td>

        <td>
            <span class="badgeEstado">
                <?php echo $propiedad["estado"]; ?>
            </span>
        </td>

        <td>
            <a href="detalle_propiedad.php?id=<?php echo $propiedad['id']; ?>"
               class="btnEditar">
               👁️ Ver Detalle
            </a>

            <?php if ($rol == "Administrador") { ?>

                <a href="administrar_fotos.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                   🖼️ Administrar Fotos
                </a>

                <a href="cambiar_estado.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                   🔄 Estado
                </a>

                <a href="editar_propiedad.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                    ✏️ Editar
                </a>

                <a href="eliminar_propiedad.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEliminar"
                   onclick="return confirmarEliminar(event, this.href)">
                    🗑️ Eliminar
                </a>

            <?php } elseif ($rol == "Gestor") { ?>

                <a href="administrar_fotos.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                    🖼️ Administrar Fotos
                </a>

                <a href="cambiar_estado.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                    🔄 Estado
                </a>

                <a href="editar_propiedad.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                    ✏️ Editar
                </a>

            <?php } else { ?>

                <a href="administrar_fotos.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                   🖼️ Administrar Fotos
                </a>

                <a href="editar_propiedad.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEditar">
                   ✏️ Editar
                </a>

                <a href="eliminar_propiedad.php?id=<?php echo $propiedad['id']; ?>"
                   class="btnEliminar"
                   onclick="return confirmarEliminar(event, this.href)">
                   🗑️ Eliminar
                </a>

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
<script>
function mostrarFormularioPropiedad() {
    let formulario = document.getElementById("formPropiedad");

    if (formulario.style.display === "none") {
        formulario.style.display = "block";
    } else {
        formulario.style.display = "none";
    }
}

function aplicarFiltros() {
    let tipo = document.getElementById("filtroTipo").value.toLowerCase();
    let comuna = document.getElementById("filtroComuna").value.toLowerCase();
    let sector = document.getElementById("filtroSector").value.toLowerCase();

    let filas = document.querySelectorAll("#tablaPropiedades tr");

    filas.forEach(function(fila) {
        let celdas = fila.querySelectorAll("td");

        if (celdas.length > 0) {
            let tipoTabla = celdas[0].textContent.toLowerCase();
            let comunaTabla;
let sectorTabla;

if ("<?php echo $rol; ?>" === "Administrador" ||
    "<?php echo $rol; ?>" === "Gestor") {

    comunaTabla = celdas[4].textContent.toLowerCase();
    sectorTabla = celdas[5].textContent.toLowerCase();

} else {

    comunaTabla = celdas[3].textContent.toLowerCase();
    sectorTabla = celdas[4].textContent.toLowerCase();
}

            let coincideTipo = tipo === "" || tipoTabla.includes(tipo);
            let coincideComuna = comuna === "" || comunaTabla.includes(comuna);
            let coincideSector = sector === "" || sectorTabla.includes(sector);

            fila.style.display = (coincideTipo && coincideComuna && coincideSector) ? "" : "none";
        }
    });
}

document.getElementById("filtroTipo").addEventListener("change", aplicarFiltros);
document.getElementById("filtroComuna").addEventListener("keyup", aplicarFiltros);
document.getElementById("filtroSector").addEventListener("keyup", aplicarFiltros);

document.getElementById("btnLimpiarBusqueda").addEventListener("click", function() {
    document.getElementById("filtroTipo").value = "";
    document.getElementById("filtroComuna").value = "";
    document.getElementById("filtroSector").value = "";

    document.querySelectorAll("#tablaPropiedades tr").forEach(function(fila) {
        fila.style.display = "";
    });
});

function confirmarEliminar(evento, url) {
    evento.preventDefault();

    Swal.fire({
        title: "¿Eliminar propiedad?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            window.location.href = url;
        }
    });

    return false;
}

const params = new URLSearchParams(window.location.search);
const mensaje = params.get("mensaje");

if (mensaje === "guardado") {
    Swal.fire({
        icon: "success",
        title: "Propiedad registrada",
        text: "La propiedad fue guardada correctamente."
    });
}

if (mensaje === "actualizado") {
    Swal.fire({
        icon: "success",
        title: "Propiedad actualizada",
        text: "Los datos fueron modificados correctamente."
    });
}

if (mensaje === "eliminado") {
    Swal.fire({
        icon: "success",
        title: "Propiedad eliminada",
        text: "La propiedad fue eliminada correctamente."
    });
}
</script>

<script src="js/propiedades.js?v=5"></script>

</body>
</html>
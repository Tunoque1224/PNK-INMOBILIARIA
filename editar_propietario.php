<?php
include("conexion.php");

$id = $_GET["id"];

$resultado = $conexion->query("SELECT * FROM propietarios WHERE id=$id");
$propietario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Propietario</title>
    <link rel="stylesheet" href="css/estilos.css?v=20">
</head>

<body>

<div class="contenedor-editar">

<h1>✏️ Editar Propietario</h1>

<form action="actualizar_propietario.php" method="POST">

<input type="hidden" name="id" value="<?php echo $propietario['id']; ?>">

<label>RUT:</label>
<input type="text" name="rut" value="<?php echo $propietario['rut']; ?>">

<br><br>

<label>Nombre:</label>
<input type="text" name="nombre" value="<?php echo $propietario['nombre']; ?>">

<br><br>

<label>Fecha:</label>
<input type="date" name="fecha" value="<?php echo $propietario['fecha']; ?>">

<br><br>

<label>Correo:</label>
<input type="email" name="correo" value="<?php echo $propietario['correo']; ?>">

<br><br>

<label>Sexo:</label>
<select name="sexo">

<option <?php if($propietario['sexo']=="Masculino") echo "selected"; ?>>Masculino</option>

<option <?php if($propietario['sexo']=="Femenino") echo "selected"; ?>>Femenino</option>

<option <?php if($propietario['sexo']=="Otro") echo "selected"; ?>>Otro</option>

</select>

<br><br>

<label>Teléfono:</label>
<input type="text" name="telefono" value="<?php echo $propietario['telefono']; ?>">

<br><br>

<label>N° Propiedad:</label>
<input type="text" name="propiedad" value="<?php echo $propietario['propiedad']; ?>">

<br><br>

<button type="submit">Actualizar</button>

<a href="propietario.php">Cancelar</a>

</form>

</div>

</body>
</html>
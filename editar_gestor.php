<?php
include("conexion.php");

$id = $_GET["id"];

$resultado = $conexion->query("SELECT * FROM gestores WHERE id=$id");
$gestor = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Gestor</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

<div class="contenedor-editar">

<h1>✏️ Editar Gestor</h1>

<form action="actualizar_gestor.php" method="POST">

<input type="hidden" name="id" value="<?php echo $gestor['id']; ?>">

<label>RUT:</label>
<input type="text" name="rut" value="<?php echo $gestor['rut']; ?>">

<br><br>

<label>Nombre:</label>
<input type="text" name="nombre" value="<?php echo $gestor['nombre']; ?>">

<br><br>

<label>Fecha de Nacimiento:</label>
<input type="date" name="fechaNacimiento" value="<?php echo $gestor['fechaNacimiento']; ?>">

<br><br>

<label>Correo:</label>
<input type="email" name="correo" value="<?php echo $gestor['correo']; ?>">

<br><br>

<label>Sexo:</label>
<select name="sexo">
    <option <?php if($gestor['sexo']=="Masculino") echo "selected"; ?>>Masculino</option>
    <option <?php if($gestor['sexo']=="Femenino") echo "selected"; ?>>Femenino</option>
    <option <?php if($gestor['sexo']=="Otro") echo "selected"; ?>>Otro</option>
</select>

<br><br>

<label>Teléfono:</label>
<input type="text" name="telefono" value="<?php echo $gestor['telefono']; ?>">

<br><br>

<button type="submit">Actualizar Gestor</button>

<a href="gestor.php">Cancelar</a>

</form>

</div>

</body>
</html>
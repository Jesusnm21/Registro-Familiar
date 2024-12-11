<?php
// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "listado")
    or die("Problemas con la conexión: " . mysqli_connect_error());

// Inicializar variables para manejar los datos del registro
$id = $nombre = $parentesco = $foto_actual = ""; // Variables para almacenar los datos del registro
$mensaje = ""; // Variable para mostrar mensajes al usuario

// Bloque para buscar el registro
if (isset($_POST['buscar'])) { // Verifica si se envió el formulario de búsqueda
    $id_buscar = $_POST['id_buscar']; // Captura el ID ingresado
    $query = "SELECT * FROM familia WHERE id = $id_buscar"; // Consulta para buscar el registro por ID
    $resultado = mysqli_query($conexion, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) { // Si encuentra un registro, almacena sus datos
        $id = $fila['id'];
        $nombre = $fila['nombre'];
        $parentesco = $fila['parentesco'];
        $foto_actual = $fila['foto'];
    } else { // Si no encuentra un registro, muestra un mensaje de error
        $mensaje = "<p style='color: red;'>Registro no encontrado.</p>";
    }
}

// Bloque para eliminar el registro
if (isset($_POST['eliminar'])) { // Verifica si se confirmó la eliminación
    $id = $_POST['id']; // Captura el ID del registro a eliminar
    $query = "DELETE FROM familia WHERE id=$id"; // Consulta para eliminar el registro

    if (mysqli_query($conexion, $query)) { // Si la eliminación es exitosa, muestra un mensaje
        $mensaje = "<p style='color: green;'>Registro eliminado correctamente.</p>";
    } else { // Si ocurre un error durante la eliminación, muestra un mensaje de error
        $mensaje = "<p style='color: red;'>Error al eliminar: " . mysqli_error($conexion) . "</p>";
    }

    // Limpia las variables después de la eliminación
    $id = $nombre = $parentesco = $foto_actual = "";
}

// Cierra la conexión con la base de datos
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Registro</title>
    <!-- Enlace a una hoja de estilos CSS externa -->
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <h1>Eliminar Registro</h1>

    <!-- Muestra mensajes al usuario -->
    <?php echo $mensaje; ?>

    <!-- Formulario para buscar un registro por ID -->
    <form method="POST">
        <label for="id_buscar">ID del registro a eliminar:</label>
        <input type="number" name="id_buscar" id="id_buscar" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <!-- Si se encontró un registro, muestra el formulario de confirmación -->
    <?php if ($id) { ?>
        <form method="POST">
            <!-- Campo oculto para enviar el ID del registro a eliminar -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <!-- Muestra los datos del registro encontrado -->
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
            <p><strong>Parentesco:</strong> <?php echo $parentesco; ?></p>
            <?php if ($foto_actual) { ?>
                <p><strong>Foto:</strong></p>
                <img src="<?php echo $foto_actual; ?>" alt="Foto del registro">
            <?php } ?>
            <br>

            <!-- Botón para confirmar la eliminación -->
            <button type="submit" name="eliminar">Confirmar Eliminación</button>
        </form>
    <?php } ?>
</body>
</html>

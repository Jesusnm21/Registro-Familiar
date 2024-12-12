<!DOCTYPE html>
<html>
<head>
    <title>Modificar Registro</title>
    <!-- Hoja de estilos externa -->
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <h1>Modificar Registro</h1>

    <?php
    // Establecer la conexión con la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "listado")
        or die("Error de conexión: " . mysqli_connect_error());

    // Declaración de variables
    $id = $nombre = $parentesco = $foto_actual = ""; // Para manejar los datos del registro

    // **Búsqueda del registro por ID**
    if (isset($_POST['buscar'])) { // Si el usuario envió el formulario de búsqueda
        $id_buscar = $_POST['id_buscar']; // Captura el ID del registro a buscar
        $query = "SELECT * FROM familia WHERE id = $id_buscar"; // Consulta para buscar por ID
        $resultado = mysqli_query($conexion, $query);

        if ($fila = mysqli_fetch_assoc($resultado)) { // Si se encuentra el registro
            $id = $fila['id'];
            $nombre = $fila['nombre'];
            $parentesco = $fila['parentesco'];
            $foto_actual = $fila['foto']; // Almacena los datos del registro en variables
        } else { // Si no se encuentra el registro
            echo "<p style='color: red;'>Registro no encontrado.</p>";
        }
    }

    // **Modificación del registro**
    if (isset($_POST['modificar'])) { // Si el usuario envió el formulario de modificación
        $id = $_POST['id']; // Captura el ID del registro a modificar
        $nombre = $_POST['nombre']; // Captura el nuevo nombre
        $parentesco = $_POST['parentesco']; // Captura el nuevo parentesco
        $foto = $_FILES['foto']; // Captura el archivo de foto cargado (si existe)

        if ($foto['name']) { // Si se subió una nueva foto
            $rutaFoto = "imagenes/" . basename($foto['name']); // Define la ruta donde se guardará la foto
            move_uploaded_file($foto['tmp_name'], $rutaFoto); // Mueve la foto a la ruta especificada
            $query = "UPDATE familia SET nombre='$nombre', parentesco='$parentesco', foto='$rutaFoto' WHERE id=$id"; // Actualiza con la nueva foto
        } else { // Si no se subió una nueva foto
            $query = "UPDATE familia SET nombre='$nombre', parentesco='$parentesco' WHERE id=$id"; // Actualiza solo los campos de texto
        }

        // Ejecuta la consulta y muestra mensajes según el resultado
        if (mysqli_query($conexion, $query)) {
            echo "<p style='color: green;'>Registro modificado correctamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al modificar: " . mysqli_error($conexion) . "</p>";
        }
    }
    ?>

    <!-- Formulario para buscar un registro -->
    <form method="POST" enctype="multipart/form-data">
        <label for="id_buscar">ID del registro a modificar:</label>
        <input type="number" name="id_buscar" id="id_buscar" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if ($id) { ?>
        <!-- Formulario para modificar los datos -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">

            <label for="parentesco">Parentesco:</label>
            <input type="text" name="parentesco" id="parentesco" value="<?php echo $parentesco; ?>">

            <label for="foto">Nueva Foto:</label>
            <input type="file" name="foto" id="foto">
            <?php if ($foto_actual) { ?>
                <p>Foto actual:</p>
                <img src="<?php echo $foto_actual; ?>" alt="Foto Actual">
            <?php } ?>
            <br>
            <button type="submit" name="modificar">Guardar Cambios</button>
        </form>
    <?php } ?>

    <?php mysqli_close($conexion); // Cierra la conexión con la base de datos ?>
</body>
</html>

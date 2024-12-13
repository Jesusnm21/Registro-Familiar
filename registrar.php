<?php
// Establece la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "listado")
    or die("Problemas con la conexión");

// Validación de la subida de imagen
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    // Obtener información del archivo subido
    $nombreImagen = $_FILES['foto']['name']; // Nombre original de la imagen
    $rutaTemporal = $_FILES['foto']['tmp_name']; // Ruta temporal donde se almacena el archivo en el servidor
    $rutaDestino = "imagenes/" . $nombreImagen; // Ruta donde se guardará permanentemente la imagen

    // Mueve el archivo desde la ruta temporal a la carpeta destino
    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
        // Si la imagen se movió con éxito, se procede a insertar los datos en la base de datos
        $nombre = $_POST['nombre']; // Nombre del familiar, enviado desde el formulario
        $parentesco = $_POST['parentesco']; // Parentesco, enviado desde el formulario

        // Inserta los datos del registro en la tabla 'familia'
        mysqli_query($conexion, "INSERT INTO familia (nombre, parentesco, foto) VALUES ('$nombre', '$parentesco', '$rutaDestino')")
            or die("Problemas en el insert: " . mysqli_error($conexion));
        
        // Mensaje de éxito si la operación fue exitosa
        echo "El registro fue exitoso.";
    } else {
        // Error al mover el archivo a la carpeta destino
        echo "Error al subir la imagen.";
    }
} else {
    // Si no se seleccionó una imagen o ocurrió un error
    echo "Debe seleccionar una imagen.";
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>

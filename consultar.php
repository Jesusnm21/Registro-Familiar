<!DOCTYPE html>
<html>
<head>
    <title>Consultar Registros</title>
    <!-- Enlace a una hoja de estilos CSS externa -->
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <!-- Contenedor principal de la página -->
    <div class="container">
        <h1>Listado Familiar</h1>

        <!-- Formulario para consultar registros por ID -->
        <form method="GET">
            <!-- Campo para ingresar el ID a consultar -->
            <label for="id">Consultar por ID:</label>
            <input type="number" name="id" id="id" placeholder="Ingrese el ID">
            <!-- Botón para enviar la consulta -->
            <button type="submit" name="consulta">Consultar</button>
        </form>

        <!-- Tabla para mostrar los registros consultados -->
        <table>
            <thead>
                <!-- Encabezados de las columnas -->
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Parentesco</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexión a la base de datos
                // Se conecta al servidor de base de datos MySQL utilizando los parámetros: servidor, usuario, contraseña y nombre de la base de datos
                $conexion = mysqli_connect("localhost", "root", "", "listado")
                    or die("Error de conexión: " . mysqli_connect_error());

                // Verifica si se ha enviado una solicitud de consulta y si el campo ID no está vacío
                if (isset($_GET['consulta']) && !empty($_GET['id'])) {
                    // Convierte el valor ingresado de ID en un número entero para evitar inyección SQL
                    $id = intval($_GET['id']);
                    // Consulta SQL para obtener el registro correspondiente al ID ingresado
                    $query = "SELECT * FROM familia WHERE id = $id";
                } else {
                    // Si no se proporciona un ID, se realiza una consulta para obtener todos los registros
                    $query = "SELECT * FROM familia";
                }

                // Ejecuta la consulta SQL y almacena el resultado
                $resultado = mysqli_query($conexion, $query);

                // Verifica si hay registros en el resultado de la consulta
                if (mysqli_num_rows($resultado) > 0) {
                    // Recorre cada registro obtenido y lo muestra en la tabla
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>"; // Inicia una nueva fila
                        echo "<td>" . $fila['id'] . "</td>"; // Muestra el ID
                        echo "<td>" . $fila['nombre'] . "</td>"; // Muestra el nombre
                        echo "<td>" . $fila['parentesco'] . "</td>"; // Muestra el parentesco
                        // Muestra la foto como una imagen utilizando la ruta almacenada en la base de datos
                        echo "<td><img src='" . $fila['foto'] . "' alt='Foto' class='foto'></td>";
                        echo "</tr>"; // Cierra la fila
                    }
                } else {
                    // Si no se encuentran registros, muestra un mensaje en una fila de la tabla
                    echo "<tr><td colspan='4'>No hay registros disponibles</td></tr>";
                }

                // Cierra la conexión a la base de datos
                mysqli_close($conexion);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

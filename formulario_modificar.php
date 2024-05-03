<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Modificar Producto</h1>
        <form id="formModificar" enctype="multipart/form-data" action="modificar_producto.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto a Modificar:</label>
                <select class="form-select" id="nombre" name="nombre">
                    <?php
                    // Conexión a la base de datos
                    $host = "localhost";
                    $usuario = "id21955227_usuario1";
                    $contrasena = "Jdrs0987.";
                    $baseDeDatos = "id21955227_sistemalocatario";

                    // Crear conexión
                    $tabla = "frutasyverduras";

                    $link = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);

                    if (!$link) {
                        die("Error de conexión: " . mysqli_connect_error());
                    }
                    $query = "SELECT Nombre FROM $tabla WHERE IdCategoria = 1"; // Frutas
                    $result = mysqli_query($link, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row["Nombre"] . '">' . $row["Nombre"] . '</option>';
                        }
                    }

                    mysqli_close($link);
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="precio_mayoreo" class="form-label">Nuevo Precio Mayoreo:</label>
                <input type="number" class="form-control" id="precio_mayoreo" name="precio_mayoreo" required>
            </div>
            <div class="mb-3">
                <label for="precio_menudeo" class="form-label">Nuevo Precio Menudeo:</label>
                <input type="number" class="form-control" id="precio_menudeo" name="precio_menudeo" required>
            </div>
            <div class="mb-3">
                <label for="existencias" class="form-label">Nuevas Existencias (KG):</label>
                <input type="number" class="form-control" id="existencias" name="existencias" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="cambiar_imagen" name="cambiar_imagen">
                <label class="form-check-label" for="cambiar_imagen">Cambiar Imagen</label>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Nueva Imagen:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                <input type="hidden" id="nombre_imagen" name="nombre_imagen">
            </div>
            <button type="submit" class="btn btn-primary">Modificar Producto</button>
            <a href="index.html" class="btn btn-danger">Salir</a>
        </form>
        <div id="mensaje-exito" class="alert alert-success d-none mt-3" role="alert">
            ¡El producto se ha modificado exitosamente!
        </div>
    </div>

    <script>
        document.getElementById('imagen').addEventListener('change', function() {
            var nombreArchivo = this.files[0].name;
            document.getElementById('nombre_imagen').value = nombreArchivo;
        });

        document.getElementById('formModificar').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    var respuesta = xhr.responseText;
                    if (respuesta.includes('correctamente')) {
                        alert('Producto modificado correctamente.');
                        document.getElementById('mensaje-exito').classList.remove('d-none');
                        document.getElementById('formModificar').reset();
                    } else {
                        alert('Error al modificar el producto. Inténtalo de nuevo.');
                    }
                }
            };

            xhr.open('POST', 'modificar_producto.php', true);
            xhr.send(formData);
        });
    </script>
</body>
</html>
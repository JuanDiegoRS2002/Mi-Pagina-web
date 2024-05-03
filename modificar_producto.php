<?php
// Conexión a la base de datos
$host = "localhost"; //ruta de la base de datos ó link de la pagina
$usuario = "id21955227_usuario1"; //cambiar
$contrasena = "Jdrs0987."; 
$baseDeDatos = "id21955227_sistemalocatario";
$tabla = "frutasyverduras";

$link = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener los valores del formulario
$nombre = $_POST['nombre'];
$precioMayoreo = $_POST['precio_mayoreo'];
$precioMenudeo = $_POST['precio_menudeo'];
$existencias = $_POST['existencias'];

// Actualizar datos en la base de datos
$sql = "UPDATE $tabla SET `Precio Mayoreo` = ?, `Precio Menudeo` = ?, `ExistenciasKG` = ? WHERE Nombre = ?";
$stmt = mysqli_stmt_init($link);

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "ddds", $precioMayoreo, $precioMenudeo, $existencias, $nombre);

    if (mysqli_stmt_execute($stmt)) {
        echo "Producto modificado correctamente.";

        // Actualizar la URL de la imagen si se subió una nueva imagen
        if (!empty($_FILES['imagen']['name'])) {
            $nombreArchivo = $_POST['nombre_imagen']; // Nombre del archivo de imagen
            $carpetaImagenes = "archivos/";
            $rutaArchivo = $carpetaImagenes . $nombreArchivo;

            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
                $urlImagen = $rutaArchivo;
                $sqlUpdateImagen = "UPDATE $tabla SET `Imagen Url` = ? WHERE Nombre = ?";
                $stmtUpdateImagen = mysqli_stmt_init($link);

                if (mysqli_stmt_prepare($stmtUpdateImagen, $sqlUpdateImagen)) {
                    mysqli_stmt_bind_param($stmtUpdateImagen, "ss", $urlImagen, $nombre);
                    if (mysqli_stmt_execute($stmtUpdateImagen)) {
                        echo " La imagen se ha actualizado correctamente.";
                    } else {
                        echo " Error al actualizar la imagen.";
                    }
                    mysqli_stmt_close($stmtUpdateImagen);
                } else {
                    echo " Error de preparación de la consulta para actualizar la imagen.";
                }
            } else {
                echo " Error al subir la nueva imagen.";
            }
        }
    } else {
        echo " Error al modificar el producto: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo " Error de preparación de la consulta: " . mysqli_error($link);
}

mysqli_close($link);
echo '<button onclick="window.location.href=\'index.html\'" class="btn btn-primary">Regresar al Inicio</button>';
?>


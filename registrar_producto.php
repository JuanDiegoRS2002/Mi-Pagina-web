<?php
// Conexión a la base de datos
$host = "localhost"; //ruta de la base de datos ó link de la pagina
$usuario = "id21955227_usuario1"; //cambiar
$contrasena = "Jdrs0987."; 
$baseDeDatos = "id21955227_sistemalocatario";

// Crear conexión
$tabla = "frutasyverduras";

$link = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener los valores del formulario
$idCategoria = $_POST['categoria'] === 'Frutas' ? 1 : 2; // 1 para Frutas, 2 para Verduras
$nombre = $_POST['nombre'];
$precioMayoreo = $_POST['precio_mayoreo'];
$precioMenudeo = $_POST['precio_menudeo'];
$existencias = $_POST['existencias'];
$nombreArchivo = $_POST['nombre_imagen']; // Nombre del archivo de imagen

// Guardar la imagen en una carpeta
$carpetaImagenes = "archivos/";
$rutaArchivo = $carpetaImagenes . $nombreArchivo;

if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
    echo "La imagen se ha subido correctamente.";
} else {
    echo "Error al subir la imagen: ";
    switch ($_FILES["imagen"]["error"]) {
        case UPLOAD_ERR_INI_SIZE:
            echo "El archivo subido excede la directiva upload_max_filesize en php.ini.";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            echo "El archivo subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML.";
            break;
        case UPLOAD_ERR_PARTIAL:
            echo "El archivo subido solo se ha subido parcialmente.";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "No se ha subido ningún archivo.";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo "Falta la carpeta temporal.";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo "Error al escribir el archivo en el disco.";
            break;
        case UPLOAD_ERR_EXTENSION:
            echo "Una extensión PHP detuvo la subida de archivos.";
            break;
        default:
            echo "Error desconocido al subir el archivo.";
            break;
    }
}

// Insertar datos en la base de datos
$urlImagen = $carpetaImagenes . $nombreArchivo; // URL de la imagen para guardar en la base de datos
$sql = "INSERT INTO $tabla (IdCategoria, Nombre, `Precio Mayoreo`, `Precio Menudeo`, `ExistenciasKG`, `Imagen Url`) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($link);

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "isddds", $idCategoria, $nombre, $precioMayoreo, $precioMenudeo, $existencias, $urlImagen);

    if (mysqli_stmt_execute($stmt)) {
        echo "Producto registrado correctamente.";
    } else {
        echo "Error al registrar el producto: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error de preparación de la consulta: " . mysqli_error($link);
}

mysqli_close($link);
?>

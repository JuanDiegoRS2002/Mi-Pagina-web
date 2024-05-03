<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "id21955227_usuario1";
$contrasena = "Jdrs0987.";
$baseDeDatos = "id21955227_sistemalocatario";
$tabla = "frutasyverduras";
// Crear conexión
$link = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener el nombre de la fruta seleccionada
$nombreFruta = $_GET['nombre'];

// Consulta para obtener los datos de la fruta seleccionada
$query = "SELECT 'Precio Mayoreo', 'Precio Menudeo', ExistenciasKG FROM frutasyverduras WHERE Nombre = '$nombreFruta'";
$result = mysqli_query($link, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $fruta = mysqli_fetch_assoc($result);
    // Devolver los datos en formato JSON
    echo json_encode($fruta);
} else {
    echo json_encode(array('error' => 'No se encontraron datos para la fruta seleccionada.'));
}

mysqli_close($link);
?>

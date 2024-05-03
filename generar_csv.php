<?php
// Dirección o IP del servidor MySQL
$host = "localhost"; // Nombre del servidor MySQL
$usuario = "id21955227_usuario1"; // Nombre de usuario de la base de datos
$contrasena = "Jdrs0987."; // Contraseña de la base de datos
$baseDeDatos = "id21955227_sistemalocatario"; // Nombre de la base de datos

// Nombre de la tabla a trabajar
$tabla = "frutasyverduras";

function Conectarse()
{
    global $host, $usuario, $contrasena, $baseDeDatos, $tabla;
    $link = mysqli_connect($host, $usuario, $contrasena, $baseDeDatos);
    if (!$link) {
        echo "Error conectando a la base de datos.<br>";
        exit();
    }

    return $link;
}

$link = Conectarse();
$query = "SELECT Nombre, `Precio Mayoreo`, `Precio Menudeo`, ExistenciasKG, `Imagen Url` FROM $tabla";

$result = mysqli_query($link, $query);

// Abrir un archivo CSV para escribir
$csvFile = fopen('archivos/catalogo.csv', 'w');

// Escribir la línea de encabezados en el archivo CSV
fputcsv($csvFile, array('Nombre', 'Precio Mayoreo', 'Precio Menudeo', 'ExistenciasKG', 'Imagen Url'));

// Escribir los datos de la consulta en el archivo CSV
while ($row = mysqli_fetch_array($result)) {
    // Limpiar los datos para asegurar la coherencia en el archivo CSV
    $nombre = str_replace(array("\r", "\n", "\t"), ' ', $row['Nombre']);
    $precioMayoreo = str_replace(array("\r", "\n", "\t"), ' ', $row['Precio Mayoreo']);
    $precioMenudeo = str_replace(array("\r", "\n", "\t"), ' ', $row['Precio Menudeo']);
    $existenciasKG = str_replace(array("\r", "\n", "\t"), ' ', $row['ExistenciasKG']);
    $imagenUrl = str_replace(array("\r", "\n", "\t"), ' ', $row['Imagen Url']);
    
    // Escribir los datos limpios en el archivo CSV
    fputcsv($csvFile, array($nombre, $precioMayoreo, $precioMenudeo, $existenciasKG, $imagenUrl));
}

// Cerrar el archivo CSV
fclose($csvFile);

mysqli_free_result($result);
mysqli_close($link);

echo "Tabla en formato CSV generada correctamente.";
?>

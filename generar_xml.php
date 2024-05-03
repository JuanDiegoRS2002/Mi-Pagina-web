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

// Crear un nuevo documento XML
$xml = new DOMDocument('1.0', 'UTF-8');

// Crear el elemento raíz del XML
$root = $xml->createElement('frutas_y_verduras');
$xml->appendChild($root);

// Iterar sobre los resultados de la consulta y agregar elementos al XML
while ($row = mysqli_fetch_array($result)) {
    // Limpiar los datos para asegurar la coherencia en el archivo XML
    $nombre = htmlspecialchars($row['Nombre']);
    $precioMayoreo = htmlspecialchars($row['Precio Mayoreo']);
    $precioMenudeo = htmlspecialchars($row['Precio Menudeo']);
    $existenciasKG = htmlspecialchars($row['ExistenciasKG']);
    $imagenUrl = htmlspecialchars($row['Imagen Url']);
    
    // Crear un nuevo elemento para cada registro y agregarlo al XML
    $item = $xml->createElement('producto');
    $item->appendChild($xml->createElement('nombre', $nombre));
    $item->appendChild($xml->createElement('precio_mayoreo', $precioMayoreo));
    $item->appendChild($xml->createElement('precio_menudeo', $precioMenudeo));
    $item->appendChild($xml->createElement('existencias_kg', $existenciasKG));
    $item->appendChild($xml->createElement('imagen_url', $imagenUrl));
    $root->appendChild($item);
}

// Guardar el XML en un archivo
$xml->formatOutput = true;
$xml->save('archivos/catalogo.xml');

mysqli_free_result($result);
mysqli_close($link);

echo "Archivo XML generado correctamente.";
?>

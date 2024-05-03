<?php
// Definir la ruta del archivo XML a descargar
$archivo = 'archivos/catalogo.xml';

// Verificar si el archivo existe
if (file_exists($archivo)) {
    // Configurar las cabeceras para la descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($archivo));
    readfile($archivo);
    exit;
} else {
    echo "El archivo no existe.";
}
?>

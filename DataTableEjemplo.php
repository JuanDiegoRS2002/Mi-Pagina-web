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
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Estilos personalizados -->
    <style>
        /* Estilo para el título de la tabla */
        th {
            background-color: #343a40; /* Fondo gris oscuro */
            color: #ffffff; /* Texto blanco */
        }

        /* Estilo para las celdas de datos */
        td {
            background-color: #f8f9fa; /* Fondo gris claro */
            color: #212529; /* Texto negro */
        }

        /* Estilo para la imagen en la última columna */
        .img-container img {
            max-width: 100px; /* Ancho máximo de la imagen */
            height: auto; /* Altura automática */
        }

        /* Estilo para los botones */
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .btn-group button {
            margin-right: 10px;
        }

        /* Estilo para el mensaje de confirmación */
        .alert {
            display: none;
            margin-top: 10px;
        }
    </style>

    <title>Data Table</title>
</head>
<body>

<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio Mayoreo</th>
            <th>Precio Menudeo</th>
            <th>ExistenciasKG</th>
            <th>Imagen</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["Precio Mayoreo"] . "</td>";
            echo "<td>" . $row["Precio Menudeo"] . "</td>";
            echo "<td>" . $row["ExistenciasKG"] . "</td>";
            echo '<td class="text-center"><img src="' . $row['Imagen Url'] . '" alt="Imagen" style="width:200px;height:auto;"></td>';
            echo "</tr>";
        }
        mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </tbody>
</table>

<!-- Botones -->
<!-- Botón para generar la tabla en XML -->
<div class="btn-group">
    <form id="generateXmlForm" action="generar_xml.php" method="post">
        <button type="submit" name="generate_xml" class="btn btn-primary" onclick="generateXml()">Generar XML</button>
    </form>

    <!-- Botón para descargar el archivo XML -->
    <a href="descargar_xml.php" class="btn btn-success" onclick="downloadXml()">Descargar XML</a>
</div>

<!-- Botón para generar la tabla en CSV -->
<div class="btn-group">
    <form id="generateCsvForm" action="generar_csv.php" method="post">
        <button type="submit" name="generate_csv" class="btn btn-primary" onclick="generateCsv()">Generar CSV</button>
    </form>

    <!-- Botón para descargar el archivo CSV -->
    <a href="descargar_csv.php" class="btn btn-success" onclick="downloadCsv()">Descargar CSV</a>
</div>

<!-- Script para SweetAlert -->
<script>
    function generateXml() {
        swal("Generado el XML");
    }

    function downloadXml() {
        swal("Descarga hecha del XML");
    }

    function generateCsv() {
        swal("Generado el CSV");
    }

    function downloadCsv() {
        swal("Descargado el csv");
    }
</script>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();

        // Mostrar el mensaje de confirmación al generar el archivo XML
        $('#generateXmlForm').submit(function(event) {
            event.preventDefault(); // Evitar que se envíe el formulario
            $('#confirmationMessage').fadeIn().delay(2000).fadeOut(); // Mostrar y ocultar el mensaje
        });

        // Mostrar el mensaje de confirmación al generar el archivo CSV
        $('#generateCsvForm').submit(function(event) {
            event.preventDefault(); // Evitar que se envíe el formulario
            $('#confirmationMessage').fadeIn().delay(2000).fadeOut(); // Mostrar y ocultar el mensaje
        });
    });
</script>

</body>
</html>

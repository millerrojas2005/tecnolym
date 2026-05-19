<?php

require 'vendor/autoload.php';

include("conexion.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['excel']) && $_FILES['excel']['error'] == 0) {

    $file_name = $_FILES['excel']['name'];
    $file_tmp  = $_FILES['excel']['tmp_name'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, ['xls', 'xlsx'])) {

        echo "<script>
                alert('Solo archivos Excel');
                window.location='index.php';
              </script>";
        exit;
    }

    $temp_dir = 'temp_excel/';

    if (!is_dir($temp_dir)) {
        mkdir($temp_dir, 0777, true);
    }

    $destino = $temp_dir . time() . "_" . $file_name;

    if (!move_uploaded_file($file_tmp, $destino)) {

        echo "<script>
                alert('Error al subir archivo');
                window.location='index.php';
              </script>";
        exit;
    }

    try {

        $documento = IOFactory::load($destino);

        $hoja = $documento->getActiveSheet();

        $filas = $hoja->toArray();

        $agregados = 0;

        foreach ($filas as $i => $data) {

            // Saltar encabezado
            if ($i == 0) {
                continue;
            }

            // Saltar filas vacías
            if (
                empty($data[1]) &&
                empty($data[2])
            ) {
                continue;
            }

            // EXCEL:
            // A = stock
            // B = nombre
            // C = precio

            $stock  = intval($data[0]);

            $nombre = mysqli_real_escape_string(
                $conn,
                trim($data[1])
            );

            $precio_excel = trim($data[2]);

/* LIMPIAR PRECIO */

$precio_excel = str_replace(".", "", $precio_excel);
$precio_excel = str_replace(",", "", $precio_excel);
$precio_excel = preg_replace('/[^0-9]/', '', $precio_excel);

$precio = intval($precio_excel);

            // Categoría por defecto
            $categoria = "General";

            // Imagen vacía
            $imagen = "";

            $sql = "INSERT INTO productos
                    (nombre, categoria, precio, stock, imagen)

                    VALUES
                    ('$nombre', '$categoria', '$precio', '$stock', '$imagen')";

            if (mysqli_query($conn, $sql)) {
                $agregados++;
            }
        }

        unlink($destino);

        echo "<script>
                alert('Importación completa. Productos agregados: $agregados');
                window.location='index.php';
              </script>";

    } catch (Exception $e) {

        echo "<script>
                alert('Error al leer Excel');
                window.location='index.php';
              </script>";
    }

} else {

    echo "<script>
            alert('No se seleccionó archivo');
            window.location='index.php';
          </script>";
}
?>
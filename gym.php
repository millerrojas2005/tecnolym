<?php

$host = "localhost";
$usuario = "root";
$password = "";
$bd = "inventario_local";

$conn = mysqli_connect($host, $usuario, $password, $bd);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Inventario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <h1>Sistema de Inventario</h1>

    <a href="productos/listar.php">
        Ver productos
    </a>

</body>
</html>
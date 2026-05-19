<?php

include("conexion.php");

if(isset($_GET['buscar'])) {

    $buscar = mysqli_real_escape_string($conn, $_GET['buscar']);

    $sql = "SELECT * FROM productos
            WHERE nombre LIKE '%$buscar%'
            LIMIT 5";

    $resultado = mysqli_query($conn, $sql);

    if(mysqli_num_rows($resultado) > 0) {

        while($fila = mysqli_fetch_assoc($resultado)) {

            echo '
            <a href="?buscar='.urlencode($fila['nombre']).'"
               class="list-group-item list-group-item-action">

                '.$fila['nombre'].'

            </a>';
        }

    } else {

        echo '
        <div class="list-group-item text-muted">

            No se encontraron productos

        </div>';
    }

}
?>
<?php
include("conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$total = 0;

foreach($data as $p){

$total += $p['precio'] * $p['cantidad'];

}

/* GUARDAR VENTA */

mysqli_query($conn,
"INSERT INTO ventas(total)
VALUES('$total')");

$venta_id = mysqli_insert_id($conn);

/* DETALLE */

foreach($data as $p){

$id = $p['id'];
$cantidad = $p['cantidad'];
$precio = $p['precio'];

mysqli_query($conn,
"INSERT INTO detalle_ventas
(venta_id,producto_id,cantidad,precio)

VALUES
('$venta_id','$id','$cantidad','$precio')");

/* DESCONTAR STOCK */

mysqli_query($conn,
"UPDATE productos
SET stock = stock - $cantidad
WHERE id = $id");

}

echo "ok";
?>
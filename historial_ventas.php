<?php
include("conexion.php");

$sql = "SELECT * FROM ventas ORDER BY id DESC";

$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Historial Ventas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#0f172a,#1e293b);
font-family:'Segoe UI',sans-serif;
color:white;
min-height:100vh;
}

.container{
padding-top:40px;
}

.card-venta{
background:rgba(255,255,255,0.08);
border-radius:20px;
padding:20px;
margin-bottom:25px;
backdrop-filter:blur(10px);
box-shadow:0 8px 25px rgba(0,0,0,0.3);
}

.table{
border-radius:15px;
overflow:hidden;
}

</style>

</head>

<body>

<div class="container">

<div class="d-flex justify-content-between align-items-center mb-4">

<h1>🧾 Historial de Ventas</h1>

<a href="ventas.php" class="btn btn-primary">
⬅ Volver a Ventas
</a>

</div>

<?php while($venta=mysqli_fetch_assoc($res)){ ?>

<div class="card-venta">

<div class="d-flex justify-content-between mb-3">

<div>

<h4>
Venta #<?php echo $venta['id']; ?>
</h4>

<p>
Fecha:
<?php echo $venta['fecha']; ?>
</p>

</div>

<div>

<h3 class="text-success">

$ <?php echo number_format($venta['total'],0,',','.'); ?>

</h3>

</div>

</div>

<div class="table-responsive">

<table class="table table-dark table-hover">

<thead>

<tr>

<th>Producto</th>
<th>Cantidad</th>
<th>Precio</th>
<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php

$idVenta = $venta['id'];

$sqlDetalle = "

SELECT dv.*, p.nombre

FROM detalle_ventas dv

INNER JOIN productos p
ON p.id = dv.producto_id

WHERE dv.venta_id = $idVenta

";

$resDetalle = mysqli_query($conn,$sqlDetalle);

while($d=mysqli_fetch_assoc($resDetalle)){

?>

<tr>

<td>
<?php echo $d['nombre']; ?>
</td>

<td>
<?php echo $d['cantidad']; ?>
</td>

<td>

$ <?php echo number_format($d['precio'],0,',','.'); ?>

</td>

<td>

$

<?php
echo number_format(
$d['precio'] * $d['cantidad'],
0,
',',
'.'
);
?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<?php } ?>

</div>

</body>
</html>
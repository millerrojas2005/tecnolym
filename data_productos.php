<?php
include("conexion.php");

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$buscar = isset($_GET['buscar']) ? mysqli_real_escape_string($conn,$_GET['buscar']) : "";
$categoria = isset($_GET['categoria']) ? mysqli_real_escape_string($conn,$_GET['categoria']) : "";

$limite = 10;
$inicio = ($pagina - 1) * $limite;

/* =========================
   FILTROS
========================= */

$where = "WHERE 1=1";

if($buscar != ""){
    $where .= " AND nombre LIKE '%$buscar%'";
}

if($categoria != ""){
    $where .= " AND categoria='$categoria'";
}

/* =========================
   CONSULTA
========================= */

$sql = "SELECT * FROM productos
        $where
        ORDER BY id DESC
        LIMIT $inicio,$limite";

$res = mysqli_query($conn, $sql);

$tabla = "";

$n = $inicio + 1;

while($f = mysqli_fetch_assoc($res)){

/* STOCK BAJO */

$stockColor = ($f['stock'] <= 5)
? "style='color:red;font-weight:bold;'"
: "";

/* IMAGEN */

$imagen = !empty($f['imagen'])
? "imagenes/".$f['imagen']
: "https://via.placeholder.com/50";

/* TABLA */

$tabla .= "

<tr>

<td>".$n++."</td>

<td>
<img src='".$imagen."'
width='55'
height='55'
style='object-fit:cover;border-radius:10px;'>
</td>

<td>".$f['nombre']."</td>

<td>
<span class='badge bg-primary'>
".$f['categoria']."
</span>
</td>

<td>
$ ".number_format($f['precio'],0,',','.')
."</td>

<td $stockColor>
".$f['stock']."
</td>

<td class='d-flex gap-2'>

<a href='editar.php?id=".$f['id']."'
class='btn btn-warning btn-sm'>
✏ Editar
</a>

<a href='eliminar.php?id=".$f['id']."'
class='btn btn-danger btn-sm'
onclick='return confirm(\"¿Eliminar producto?\")'>
🗑 Eliminar
</a>

</td>

</tr>";

}

/* =========================
   TOTAL
========================= */

$total_q = mysqli_query($conn,
"SELECT id FROM productos $where");

$total = mysqli_num_rows($total_q);

$total_paginas = ceil($total / $limite);

$paginacion = "";

/* =========================
   ANTERIOR
========================= */

if($pagina > 1){

$ant = $pagina - 1;

$paginacion .= "
<li class='page-item'>
<a href='#'
class='page-link'
data-page='$ant'>
&laquo;
</a>
</li>";

}

/* =========================
   NUMEROS
========================= */

$inicio_pag = max(1, $pagina - 2);
$fin_pag = min($total_paginas, $pagina + 2);

for($i=$inicio_pag;$i<=$fin_pag;$i++){

$active = ($i == $pagina) ? "active" : "";

$paginacion .= "
<li class='page-item $active'>
<a href='#'
class='page-link'
data-page='$i'>
$i
</a>
</li>";

}

/* =========================
   SIGUIENTE
========================= */

if($pagina < $total_paginas){

$sig = $pagina + 1;

$paginacion .= "
<li class='page-item'>
<a href='#'
class='page-link'
data-page='$sig'>
&raquo;
</a>
</li>";

}

/* =========================
   JSON
========================= */

echo json_encode([
"tabla"=>$tabla,
"paginacion"=>$paginacion,
"total"=>$total
]);

?>
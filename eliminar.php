<?php
include("conexion.php");

if(isset($_GET['id'])){

$id = (int)$_GET['id'];

/* OBTENER IMAGEN */

$sql_img = "SELECT imagen FROM productos WHERE id=$id";

$res_img = mysqli_query($conn, $sql_img);

$fila = mysqli_fetch_assoc($res_img);

/* ELIMINAR IMAGEN */

if($fila && $fila['imagen'] != ""){

$ruta = "imagenes/".$fila['imagen'];

if(file_exists($ruta)){
unlink($ruta);
}

}

/* ELIMINAR PRODUCTO */

$sql = "DELETE FROM productos WHERE id=$id";

if(mysqli_query($conn, $sql)){

header("Location: index.php");

}else{

echo "
<div style='padding:20px;font-family:sans-serif;'>
Error al eliminar producto
</div>";

}

}else{

header("Location: index.php");

}
?>
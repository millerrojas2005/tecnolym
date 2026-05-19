<?php
include("conexion.php");

$sql = "SELECT * FROM productos ORDER BY nombre ASC";
$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sistema de Ventas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#0f172a,#1e293b);
font-family:'Segoe UI',sans-serif;
color:white;
min-height:100vh;
}

/* PRODUCTOS */

.producto-card{
background:rgba(255,255,255,0.08);
border-radius:18px;
padding:15px;
transition:0.3s;
cursor:pointer;
height:100%;
box-shadow:0 5px 20px rgba(0,0,0,0.3);
}

.producto-card:hover{
transform:translateY(-5px);
background:rgba(59,130,246,0.2);
}

.producto-card img{
width:100%;
height:160px;
object-fit:cover;
border-radius:12px;
}

/* CARRITO */

.carrito{
background:rgba(255,255,255,0.08);
padding:20px;
border-radius:20px;
backdrop-filter:blur(10px);
box-shadow:0 8px 25px rgba(0,0,0,0.3);
position:sticky;
top:20px;
}

.item-carrito{
background:rgba(255,255,255,0.06);
padding:10px;
border-radius:12px;
margin-bottom:10px;
}

.btn{
border-radius:12px;
}

</style>

</head>

<body>

<div class="container-fluid p-4">

<div class="row">

<!-- PRODUCTOS -->

<div class="col-lg-8">

<h2 class="mb-4">🛒 Sistema de Ventas</h2>

<div class="row g-4">

<?php while($f=mysqli_fetch_assoc($res)){ ?>

<div class="col-md-4">

<div class="producto-card"
onclick="agregarCarrito(
<?php echo $f['id']; ?>,
'<?php echo $f['nombre']; ?>',
<?php echo $f['precio']; ?>
)">

<img src="imagenes/<?php echo $f['imagen']; ?>">

<h5 class="mt-3">
<?php echo $f['nombre']; ?>
</h5>

<p>
$ <?php echo number_format($f['precio'],0,',','.'); ?>
</p>

<p>
Stock:
<?php echo $f['stock']; ?>
</p>

<button class="btn btn-primary w-100">
Agregar
</button>

</div>

</div>

<?php } ?>

</div>

</div>

<!-- CARRITO -->

<div class="col-lg-4">

<div class="carrito">

<h3>🧾 Carrito</h3>

<hr>

<div id="listaCarrito"></div>

<hr>

<h4>
Total:
$ <span id="total">0</span>
</h4>

<button class="btn btn-success w-100 mt-3"
onclick="finalizarVenta()">

💰 Finalizar Venta



</button><br><br>


<a href="historial_ventas.php"
class="btn btn-warning mb-4">

📜 Historial Ventas

</a>
</div>

</div>

</div>

</div>

<script>

let carrito = [];

/* AGREGAR */

function agregarCarrito(id,nombre,precio){

let existe = carrito.find(p => p.id == id);

if(existe){

existe.cantidad++;

}else{

carrito.push({
id:id,
nombre:nombre,
precio:precio,
cantidad:1
});

}

renderCarrito();

}

/* RENDER */

function renderCarrito(){

let lista = document.getElementById("listaCarrito");

lista.innerHTML = "";

let total = 0;

carrito.forEach((p,index)=>{

total += p.precio * p.cantidad;

lista.innerHTML += `

<div class="item-carrito">

<h6>${p.nombre}</h6>

<p>
${p.cantidad} x $
${p.precio.toLocaleString()}
</p>

<button class="btn btn-danger btn-sm"
onclick="eliminarItem(${index})">

Eliminar

</button>

</div>

`;

});

document.getElementById("total")
.innerText = total.toLocaleString();

}

/* ELIMINAR */

function eliminarItem(index){

carrito.splice(index,1);

renderCarrito();

}

/* FINALIZAR */

function finalizarVenta(){

if(carrito.length == 0){

alert("Carrito vacío");

return;

}

fetch("guardar_venta.php",{

method:"POST",

headers:{
"Content-Type":"application/json"
},

body:JSON.stringify(carrito)

})

.then(res=>res.text())

.then(data=>{

alert("Venta realizada");

carrito = [];

renderCarrito();

location.reload();

});

}

</script>

</body>
</html>
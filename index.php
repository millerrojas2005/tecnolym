<?php
include("conexion.php");

$limite = 10;

/* =========================
   DATOS BASE
========================= */

$categorias = [
    "Celulares",
    "Cargadores",
    "Audífonos",
    "reflector",
    "Power Banks",
    "Fundas",
    "vidrio templado",
    "bocinas"
];
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tecno LyM Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#0f172a,#1e293b);
font-family:'Segoe UI',sans-serif;
min-height:100vh;
color:white;
overflow-x:hidden;
}

/* SIDEBAR */

.sidebar{
width:260px;
min-height:100vh;
background:rgba(15,23,42,0.98);
backdrop-filter:blur(10px);
box-shadow:4px 0 20px rgba(0,0,0,0.4);
position:fixed;
left:0;
top:0;
padding:25px;
z-index:1000;
}

.sidebar h3{
font-weight:bold;
margin-bottom:35px;
}

.menu-item{
display:block;
padding:14px 18px;
margin-bottom:12px;
border-radius:14px;
text-decoration:none;
color:#cbd5e1;
transition:0.3s;
font-weight:500;
}

.menu-item:hover{
background:rgba(59,130,246,0.2);
color:white;
transform:translateX(5px);
}

.menu-item.active{
background:linear-gradient(135deg,#3b82f6,#2563eb);
color:white;
}

/* CONTENIDO */

.content{
margin-left:260px;
width:calc(100% - 260px);
}

/* NAVBAR */

.navbar{
background:rgba(15,23,42,0.95)!important;
backdrop-filter:blur(10px);
box-shadow:0 4px 20px rgba(0,0,0,0.4);
}

.navbar-brand{
font-size:24px;
font-weight:bold;
letter-spacing:1px;
}

/* CONTAINER */

.container-fluid{
padding:30px;
}

/* CARDS */

.card-dashboard{
min-height:160px;
border-radius:20px;
background:rgba(255,255,255,0.08);
backdrop-filter:blur(10px);
border:1px solid rgba(255,255,255,0.1);
box-shadow:0 8px 30px rgba(0,0,0,0.3);
transition:0.3s;
padding:25px;
}

.card-dashboard:hover{
transform:translateY(-5px);
box-shadow:0 10px 35px rgba(0,0,0,0.5);
}

.card-dashboard h5{
font-size:18px;
color:#cbd5e1;
}

.card-dashboard h2{
font-size:40px;
font-weight:bold;
}

/* INPUTS */

.form-control,
.form-select{
border-radius:12px;
border:none;
padding:12px;
background:#f1f5f9;
}

.form-control:focus,
.form-select:focus{
box-shadow:0 0 0 3px rgba(59,130,246,0.4);
}

/* BOTONES */

.btn{
border-radius:12px;
padding:10px 18px;
font-weight:600;
transition:0.3s;
border:none;
}

.btn-success{
background:linear-gradient(135deg,#22c55e,#16a34a);
}

.btn-success:hover{
transform:translateY(-2px);
}

.btn-primary{
background:linear-gradient(135deg,#3b82f6,#2563eb);
}

.btn-primary:hover{
transform:translateY(-2px);
}

/* TABLA */

.table{
border-radius:18px;
overflow:hidden;
box-shadow:0 8px 25px rgba(0,0,0,0.3);
}

.table thead{
background:#111827;
}

.table tbody tr{
transition:0.2s;
}

.table tbody tr:hover{
background:rgba(59,130,246,0.2)!important;
}

/* PAGINACION */

.pagination .page-link{
border:none;
margin:0 4px;
border-radius:12px;
background:#1e293b;
color:white;
padding:10px 15px;
transition:0.3s;
}

.pagination .page-link:hover{
background:#2563eb;
transform:translateY(-2px);
}

.pagination .active .page-link{
background:#3b82f6;
font-weight:bold;
}

/* TITULOS */

h2{
font-weight:bold;
letter-spacing:1px;
}

/* RESPONSIVE */

@media(max-width:992px){

.sidebar{
width:100%;
height:auto;
position:relative;
min-height:auto;
}

.content{
margin-left:0;
width:100%;
}

}

</style>

</head>

<body>

<div class="d-flex">

<!-- SIDEBAR -->

<div class="sidebar">

<h3>📱 Tecno LyM</h3>

<a href="index.php" class="menu-item active">
📊 Dashboard
</a>

<a href="agregar.php" class="menu-item">
➕ Agregar Producto
</a>

<a href="ventas.php" class="menu-item">
🛒 Ventas
</a>


<a href="#" class="menu-item text-danger">
🚪 Cerrar sesión
</a>

</div>

<!-- CONTENIDO -->

<div class="content">

<!-- NAVBAR -->

<nav class="navbar navbar-dark px-4">

<span class="navbar-brand">
📦 Dashboard Inventario
</span>

</nav>

<div class="container-fluid">

<!-- CARDS -->

<div class="row g-4 mb-4">

<div class="col-md-4">

<div class="card-dashboard">

<h5>Total Productos</h5>

<h2 id="total">0</h2>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<h5>Categorías</h5>

<select id="filtroCategoria" class="form-select mt-3">

<option value="">Todas</option>

<?php foreach($categorias as $c){ ?>

<option value="<?php echo $c; ?>">
<?php echo $c; ?>
</option>

<?php } ?>

</select>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<h5>Estado Sistema</h5>

<h2 class="text-success">Activo</h2>

</div>

</div>

</div>

<!-- BUSCADOR -->

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

<h2>📦 Inventario</h2>

<div style="width:320px;">

<input type="text"
id="buscar"
class="form-control"
placeholder="Buscar producto...">

</div>

</div>

<!-- BOTONES -->

<!-- BOTONES -->

<div class="d-flex gap-2 mb-4 flex-wrap align-items-center">

<a href="agregar.php" class="btn btn-success">
➕ Agregar Producto
</a>

<a href="ventas.php" class="btn btn-primary">
🛒 Ir a Ventas
</a>

<form action="importar_excel.php"
method="POST"
enctype="multipart/form-data"
class="d-flex gap-2 flex-wrap">

<input type="file"
name="excel"
class="form-control"
accept=".xls,.xlsx"
required
style="max-width:260px;">

<button type="submit" class="btn btn-warning">
📥 Importar Excel
</button>

</form>

</div>

<!-- TABLA -->

<div class="table-responsive">

<table class="table table-dark table-hover align-middle">

<thead>

<tr>

<th>ID</th>
<th>Imagen</th>
<th>Nombre</th>
<th>Categoría</th>
<th>Precio</th>
<th>Stock</th>
<th>Acciones</th>

</tr>

</thead>

<tbody id="tabla">

</tbody>

</table>

</div>

<!-- PAGINACION -->

<div class="d-flex justify-content-center mt-4">

<ul class="pagination pagination-sm" id="paginacion"></ul>

</div>

</div>

</div>

</div>

<script>

/* VARIABLES */

let pagina = 1;
let buscar = "";
let categoria = "";

/* CARGAR DATOS */

function cargarDatos(){

fetch(
"data_productos.php?pagina="
+ pagina
+ "&buscar="
+ buscar
+ "&categoria="
+ categoria
)

.then(response => response.json())

.then(data => {

document.getElementById("tabla").innerHTML = data.tabla;

document.getElementById("paginacion").innerHTML = data.paginacion;

document.getElementById("total").innerText = data.total;

})

.catch(error => {

console.log(error);

});

}

/* BUSCADOR */

document.getElementById("buscar")
.addEventListener("keyup", function(){

buscar = this.value;

pagina = 1;

cargarDatos();

});

/* FILTRO */

document.getElementById("filtroCategoria")
.addEventListener("change", function(){

categoria = this.value;

pagina = 1;

cargarDatos();

});

/* PAGINACION */

document.addEventListener("click", function(e){

if(e.target.classList.contains("page-link")){

e.preventDefault();

let p = e.target.getAttribute("data-page");

if(p){

pagina = parseInt(p);

cargarDatos();

}

}

});

/* INICIAL */

cargarDatos();

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
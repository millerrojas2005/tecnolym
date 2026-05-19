<?php
include("conexion.php");

$id = $_GET['id'];

/* CONSULTAR PRODUCTO */

$sql = "SELECT * FROM productos WHERE id = $id";
$resultado = mysqli_query($conn, $sql);

$fila = mysqli_fetch_assoc($resultado);

/* ACTUALIZAR PRODUCTO */

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    /* IMAGEN ACTUAL */

    $imagen = $fila['imagen'];

    /* SI SUBE NUEVA IMAGEN */

    if($_FILES['imagen']['name'] != ""){

        $nuevaImagen = time() . "_" . $_FILES['imagen']['name'];

        $tmp = $_FILES['imagen']['tmp_name'];

        move_uploaded_file($tmp, "imagenes/" . $nuevaImagen);

        /* ELIMINAR IMAGEN ANTERIOR */

        if(file_exists("imagenes/" . $imagen)){
            unlink("imagenes/" . $imagen);
        }

        $imagen = $nuevaImagen;
    }

    /* UPDATE */

    $sql_update = "UPDATE productos 
                   SET nombre='$nombre',
                       categoria='$categoria',
                       precio='$precio',
                       stock='$stock',
                       imagen='$imagen'
                   WHERE id=$id";

    if(mysqli_query($conn, $sql_update)){
        header("Location: index.php");
    } else {
        echo "Error al actualizar";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#0f172a,#1e293b);
font-family:'Segoe UI',sans-serif;
min-height:100vh;
color:white;
}

.container{
max-width:700px;
}

.card-form{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(12px);
padding:35px;
border-radius:25px;
box-shadow:0 8px 30px rgba(0,0,0,0.4);
margin-top:40px;
}

.form-control{
border:none;
border-radius:12px;
padding:12px;
}

.form-control:focus{
box-shadow:0 0 0 3px rgba(59,130,246,0.4);
}

.btn{
border-radius:12px;
padding:10px 18px;
font-weight:bold;
}

img{
box-shadow:0 5px 15px rgba(0,0,0,0.4);
}

</style>

</head>
<body>

<div class="container">
<div class="card-form">

    <h1 class="mb-4">Editar Producto</h1>

    <form method="POST" enctype="multipart/form-data">

        <!-- IMAGEN ACTUAL -->

        <div class="mb-3">

            <label class="form-label">Imagen Actual</label>

            <br>

          <?php if($fila['imagen'] != ""){ ?>

        <img src="imagenes/<?php echo $fila['imagen']; ?>"
            width="150"
            height="150"
            style="object-fit: cover; border-radius: 10px;">

        <?php } ?>

        </div>

        <!-- NUEVA IMAGEN -->

        <div class="mb-3">

            <label class="form-label">Cambiar Imagen</label>

            <input type="file"
                   name="imagen"
                   class="form-control"
                   accept="image/*">

        </div>

        <!-- NOMBRE -->

        <div class="mb-3">

            <label class="form-label">Nombre</label>

            <input type="text"
                   name="nombre"
                   class="form-control"
                   value="<?php echo $fila['nombre']; ?>"
                   required>

        </div>

        <!-- CATEGORIA -->

        <div class="mb-3">

            <label class="form-label">Categoría</label>

            <input type="text"
                   name="categoria"
                   class="form-control"
                   value="<?php echo $fila['categoria']; ?>"
                   required>

        </div>

        <!-- PRECIO -->

        <div class="mb-3">

            <label class="form-label">Precio</label>

            <input type="number"
                   step="0.01"
                   name="precio"
                   class="form-control"
                   value="<?php echo $fila['precio']; ?>"
                   required>

        </div>

        <!-- STOCK -->

        <div class="mb-3">

            <label class="form-label">Stock</label>

            <input type="number"
                   name="stock"
                   class="form-control"
                   value="<?php echo $fila['stock']; ?>"
                   required>

        </div>

        <button type="submit" class="btn btn-warning">
            Actualizar
        </button>

        <a href="index.php" class="btn btn-secondary">
            Volver
        </a>

    </form>

</div>

</body>
</html>
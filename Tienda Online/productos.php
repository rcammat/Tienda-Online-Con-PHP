<?php
session_name('login');
session_start(); 
if(!isset($_SESSION['login']))
  	header("Location: index.php");
	require_once 'bd.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de productos por categoría</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body class="gradient-custom">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="principalTienda.php">Tienda Online</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="principalTienda.php">Seguir Comprando</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="carrito.php">Ver Carrito</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="cerrarSesion.php">Cerrar Sesion</a>
      </li>
      </ul>
    </div>
  </div>
</nav>
    <div class="container bg-dark mt-2">
    <div class="row justify-content-center  align-items-center text-center text-white pt-3">
    <?php 
    $conexion=mysqli_connect("localhost","root","","pedidos");
    mysqli_set_charset($conexion,"utf8");
    $cat = cargar_categoria($_GET['categoria']);
    $productos = cargar_productos_categoria($_GET['categoria']);    
    if($cat=== FALSE or $productos === FALSE){
      echo "<p class='error'>Error al conectar con la base datos</p>";
      exit;
    }
    echo "<h1>". $cat['nombre']. "</h1>";
    echo "<p>". $cat['descripcion']."</p>";   
    echo "<table class='table table-striped table-bordered table-dark'>"; //abrir la tabla
    echo "<tr><th></th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th><th>Comprar</th></tr>";
    foreach ($productos as $filaProducto){
      extract($filaProducto);
      $cod=obtenerFoto($CodProd);
      echo "<tr><td>";
      if ($cod)
        {
              
              echo "<img width='150px' class='img-fluid'src='mostrar.php?id=".$cod."' >";
        }
          else
        {echo "<img width='150px' class='img-fluid' src=img/nodisponible.png >";}
            
      echo "</td><td>$Nombre</td><td>$Descripcion</td><td>$Precio</td><td>$Stock</td>
      <td><form action = 'anadir.php' method = 'POST'>
      <input name = 'unidades' type='number' min = '1' value = '1' >
      <input type = 'submit' value='Comprar'><input name = 'cod' type='hidden' value = '$CodProd'>
      </form></td></tr>";
    }
    echo "</table>" 
    ?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
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
    <title>Tienda</title>
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
<div class="row justify-content-center text-center text-white pt-3">
<div class="col-sm-12">
<div id="typed-strings">
     <h1>Bienvenido a su tienda de confianza</h1>
     <h1>Lista de categorías:</h1>
</div>
<h1 id="typed"></h1>
</div>
</div>

<div class="row justify-content-center align-items-center text-center pt-5 pb-5">
<?php
		$conexion=mysqli_connect("localhost","root","","pedidos");
	    mysqli_set_charset($conexion,"utf8");
		$categorias = cargar_categorias();
		if($categorias===false){
			echo "<p class='error'>Error al conectar con la base datos</p>";
		}else{
			foreach ($categorias as  $codigo=>$nombre){				
					$url = "productos.php?categoria=".$codigo;
				    echo "<div class='col-sm-2'>
  							 <div class='card text-dark bg-white'>
  							   <div class='card-body'>
  							     <h5 class='card-title'>$nombre</h5>
  							     <a href='$url' class='btn btn-primary'>Ver Productos</a>
  							   </div>
  							 </div>
  							</div>";
			}
		}
		?>
<div>
</div>
<script>
var typed = new Typed('#typed',{
    stringsElement: '#typed-strings',         
});
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
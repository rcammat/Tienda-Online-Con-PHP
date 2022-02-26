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
    <title>Procesar Pedido</title>
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
<?php 
      function crear_correo($carrito, $pedido, $correo){
    $headers = array();
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset="utf-8"' ;
    $headers[] ='Content-Transfer-Encoding: 7bit' ;

    $texto = "Pedido:$pedido Cliente: $correo\n";
    $texto .= "Detalle del pedido:\n";
    $productos = cargar_productos(array_keys($carrito));  
  
  foreach($productos as $producto){
    $cod = $producto['CodProd'];
    $nom = $producto['Nombre'];
    $des = $producto['Descripcion'];
    $precio = $producto['Precio'];
    $unidades = $_SESSION['carrito'][$cod];                     
    $texto .= "$nom.......$des...$precio...$unidades\n";
  }
  

  $subject="Pedido Enviado\n";
  $success = mail($correo, $subject, $texto, 'From: Tienda online <admin@admin.com>');
  if (!$success) {
    
    echo '<p><strong>Se produjo un error al enviar su mensaje.</strong></p>';
}
return $texto;
}
  $conexion=mysqli_connect("localhost","root","","pedidos");
  mysqli_set_charset($conexion,"utf8");
  $resul = insertar_pedido($_SESSION['carrito'], $_SESSION['usuario']["num_cliente"]);
  if($resul === FALSE){
    $_SESSION["realizado"]= "No se ha podido realizar el pedido<br>";     
  }
  else{
  $_SESSION["realizado"]="Pedido nº".$resul." almacenado correctamente";}
  $cuerpo = crear_correo($_SESSION['carrito'], $resul, $_SESSION['usuario']["email"]);
  $_SESSION['carrito'] = [];

  header("Location:principalTienda.php");

        
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
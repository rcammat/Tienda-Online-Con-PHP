<?php
session_name('login');
session_start(); 
if(!isset($_SESSION['login']))
  header("Location: index.php");
else {
  $cod = $_POST['cod'];
$unidades = (int)$_POST['unidades'];
}
/*si existe el código sumamos las unidades*/
if(isset($_SESSION['carrito'][$cod])){
  $_SESSION['carrito'][$cod] += $unidades;
}else{
  $_SESSION['carrito'][$cod] = $unidades;  
}
header("Location: carrito.php");
?>

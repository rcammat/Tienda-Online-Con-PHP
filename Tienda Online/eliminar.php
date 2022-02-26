<?php
session_name('login');
session_start();  
if(!isset($_SESSION['login'])){
  header("Location: index.php");
}else {
	$cod = $_POST['cod'];
	echo $_SESSION['carrito'][$cod];
	unset($_SESSION['carrito'][$cod]);
	header("Location: carrito.php");
}
?>
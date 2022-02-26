<?php
session_name('login');
session_start();
if($_SESSION['login']!=true){
header("Location: index.php");
}else{  
$base="pedidos";
$tabla="fotos";
$numero=$_GET['id'];
$conexion=mysqli_connect ("localhost","root","",$base);
$sacar = "SELECT * FROM ".$tabla." WHERE (num_ident=$numero)" ;
$resultado = mysqli_query($conexion,$sacar);
if ($registro = mysqli_fetch_array($resultado))
       {  
	  $tipo_foto=$registro['formato'];
	  header("Content-type: $tipo_foto");  
	  echo $registro['imagen'];
	   }


mysqli_close($conexion);
}
?>
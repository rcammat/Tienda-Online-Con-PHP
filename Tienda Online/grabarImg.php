<?php
session_name('login');
session_start();
if($_SESSION['login']!=true){
header("Location: index.php");
}else{ 
include ("funciones.php");
cabecera('Tienda online');
echo "<div id=\"contenido\">\n";
$foto_name= $_FILES['foto']['name'];
$foto_size= $_FILES['foto']['size'];
$foto_type=  $_FILES['foto']['type'];
$foto_temporal= $_FILES['foto']['tmp_name'];
$lim_tamano= $_POST['lim_tamano'];
$foto_titulo= $_POST['titulo'];

if ($foto_type=="image/x-png" OR $foto_type=="image/png"){
 $extension="image/png";
 }
if ($foto_type=="image/jpeg" ){
 $extension="image/jpeg";
 }
if ($foto_type=="image/gif" ){
 $extension="image/gif";
 }

if ($foto_name != "" AND $foto_size != 0
                           AND $foto_titulo !='' AND
                        $foto_size<=$lim_tamano AND $extension !=''){

$f1= fopen($foto_temporal,"rb");
		
$foto_reconvertida = fread($f1, $foto_size);
	
$foto_reconvertida=addslashes($foto_reconvertida);

$base="pedidos";
$tabla="fotos";
$n=$_POST["clave"];
$conexion=mysqli_connect ("localhost","root","",$base);
$sacar = "SELECT num_ident FROM ".$tabla." WHERE (num_ident=$n)" ;
$resultado = mysqli_query($conexion,$sacar);
$fila=mysqli_fetch_row($resultado);
$num_registros=mysqli_num_rows($resultado);
if ($num_registros==0)
	{$meter="INSERT INTO ".$tabla;
	 $meter .=" (num_ident, imagen, nombre, tamano, formato) ";
	 $meter .=" VALUES(".$_POST["clave"].",'$foto_reconvertida','$foto_titulo',";
	 $meter .= "$foto_size, '$extension')";
	 $mensaje= "Foto guardada en la tabla";}
else
{
$meter="UPDATE $tabla SET imagen='".$foto_reconvertida."' WHERE num_ident=$n";
$mensaje="Se ha cambiado la imagen del mueble";
}

    if (mysqli_query($conexion,$meter)){
        print $mensaje;
        }else{
        
		
		print "mysqli_error" ;
    }
}else{
    echo "<h2>No ha podido transferirse el fichero</h2>";
 }
echo "</div>";
}
?>
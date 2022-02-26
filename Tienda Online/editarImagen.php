<?php
session_name('login');
session_start();
if($_SESSION['login']!=true){
header("Location: index.php");
}else{ 
include ("funciones.php");
cabecera();
echo "<div  class='container text-center pt-4' id=\"contenido\">\n";
echo "<h4>Asignar imágenes</h4>";
$clave=$_GET['id'];
echo "Seleccionar imagen para el artículo: ".$clave;
?>
<FORM ENCTYPE="multipart/form-data" ACTION="grabarImg.php" METHOD="post">
<INPUT type="hidden" name="lim_tamano" value="65000">
<INPUT type="hidden" name="clave" value=<?php echo $clave; ?>>
<p><b>Selecciona la imagen a transferir: <b><br>
<INPUT type="file" name="foto"><br>
<p><b>Título la imagen: <b><br>
<INPUT TYPE="text" NAME="titulo" value="<?php echo $clave?>" />
<p><INPUT type="submit" name="enviar" value="Aceptar"></p>
</FORM>
</div>
<?php
pie();
}
?>

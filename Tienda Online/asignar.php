<?php
session_name('login');
session_start();
if($_SESSION['login']!=true){
header("Location: index.php");
}else{ 
include('funciones.php');  
cabecera();
echo "<br>";
$TAMANO_PAGINA=5;
if (isset($_GET["pagina"]))
$pagina = $_GET["pagina"];
else
$pagina=false;
if (!$pagina) {
    $inicio = 0;
    $pagina=1;
}
else {
    $inicio = ($pagina - 1) * $TAMANO_PAGINA;
}
$conexion=mysqli_connect("localhost","root","","pedidos");
mysqli_set_charset($conexion,"utf8");
$res=mysqli_query($conexion,"SELECT COUNT(CodProd) FROM productos");
$res=mysqli_fetch_array($res);
$num_total_registros=$res[0];
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
$sql = "SELECT p.CodProd,p.Nombre,p.Descripcion,p.Precio,p.Stock,c.Nombre as categoria  \n"

    . " FROM productos as p\n"

    . " INNER JOIN categoria as c ON p.CodCat=c.CodCat\n"

    . " ORDER BY p.CodCat"

    . " limit " . $inicio . "," . $TAMANO_PAGINA;
echo "<div class='container'>";
echo "<center><table border='1px' class='table table-striped table-bordered table-dark'><thead align='center'><tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th><th>Categoria</th><th>Imagen</th></tr></thead>";
$res=mysqli_query($conexion,$sql);
echo "<tbody align='center' class='va'>";
while ($fila=mysqli_fetch_array($res)) {
	echo "<tr bgcolor='#ffffff'>";
	for($i=1;$i<6;$i++){
		echo "<td>".$fila[$i]."</td>";
	}
	echo "<td><a href='editarImagen.php?id=".$fila[0]."'><img src='img/editar.png' width='25px'></a></td></tr>";
}
mysqli_close($conexion);
echo "<tr><td colspan=6 bgcolor=blue></td></tr>";
echo "<tr bgcolor=grey>";
echo "<td colspan=2>Número de registros encontrados: " . $num_total_registros . "</td>";
echo "<td>Se muestran páginas de " . $TAMANO_PAGINA . " registros cada una. <br>";
echo "Mostrando la página " . $pagina . " de " . $total_paginas . "</td><td colspan=3 align='center' style='
padding-top: 1.25rem !important;'>";
if ($total_paginas > 1){
    for ($i=1;$i<=$total_paginas;$i++){
       if ($pagina == $i)
              echo " <span class='marca-paginas'>$pagina</span>";
       else
          
          echo "<a class='marca-paginas' href='asignar.php?pagina=" . $i ."'>" . $i . "</a>";
    }
	
}
echo "<tbody>";
echo "</table></center>";
echo "</div>";
pie();
}
?>
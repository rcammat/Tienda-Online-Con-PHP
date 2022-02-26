<?php
session_name('login');
session_start();
if($_SESSION['login']!=true){
header("Location: index.php");
}else{   
include('funciones.php');  
cabecera();
echo "<div class='container'>";
$conexion=mysqli_connect("localhost","root","","pedidos");
mysqli_set_charset($conexion,"utf8");
echo "<br>";
$TAMANO_PAGINA=2;
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
echo "<table  border='1px' class='table table-striped table-bordered table-dark'><thead class='text-center'><tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th><th>Categoria</th><th>Imagen</th></tr></thead>";
$res=mysqli_query($conexion,$sql);
echo "<tbody class='text-center va'>";
while ($fila=mysqli_fetch_array($res)) {
	echo "<tr>";
	for($i=1;$i<6;$i++){
		echo "<td>".$fila[$i]."</td>";
	}
	$tabla="fotos";
	$sacar = "SELECT count(*) FROM ".$tabla." WHERE (num_ident=$fila[0])";
	$resultado = mysqli_query($conexion,$sacar);
	$fila2=mysqli_fetch_row($resultado);
	$num_registros=$fila2[0];
	if ($num_registros<>0){
		echo "<td ><img width='150px' class='img-fluid' src='mostrar.php?id=".$fila[0]."'></td></tr>";
	}else{
		echo "<td><img width='150px' class='img-fluid' src='img/nodisponible.png'></td></tr>";
	}

}
mysqli_close($conexion);
echo "<tr><td colspan=6></td></tr>";
echo "<tr >";
echo "<td colspan=2>Número de registros encontrados: " . $num_total_registros . "</td>";
echo "<td>Se muestran páginas de " . $TAMANO_PAGINA . " registros cada una. <br>";
echo "Mostrando la página " . $pagina . " de " . $total_paginas . "</td><td colspan=3 style='
padding-top: 1.25rem !important;'>";
if ($total_paginas > 1){
    for ($i=1;$i<=$total_paginas;$i++){
       if ($pagina == $i)
              echo "<span class='marca-paginas'>$pagina</span>";
       else
          
          echo "<a class='marca-paginas' href='listado.php?pagina=" . $i ."'>" . $i . "</a>";
    }
	
}
echo "<tbody>";
echo "</table>";
echo "</div>";
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php  
}
?>
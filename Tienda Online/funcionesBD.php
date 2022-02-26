<?php 
function mostrarSelect($resultSet)
{
	$nfilas = mysqli_num_rows($resultSet);
	if ($nfilas==0)
		$devuelve="la consulta no ha devuelto ninguna fila";
	else
	{
	$devuelve="<table border='1'>";
	$fila=(mysqli_fetch_assoc($resultSet));
    $devuelve.= "<tr>";	
	foreach ($fila as $nombreColumna=>$contenido)
	{
				$devuelve.= "<th>".$nombreColumna."</th>";
	}
	$devuelve.= "</tr>";	
    	
	
	while ($fila)
	{
		  $devuelve.= "<tr>";
	      foreach ($fila as $contenido)
	      {
				$devuelve.= "<td>".$contenido."</td>";
          }
	      $devuelve.= "</tr>";	
	      $fila=(mysqli_fetch_assoc($resultSet));	
	}
	$devuelve.= "</table>";
	}
	return $devuelve;
}
function obtenerCombo($tabla,$guarda,$muestra) {  
        global $conexion;	
        $arrayCombo = array();
        $sql="SELECT $guarda,$muestra FROM $tabla order by $muestra";
		$resultado =mysqli_query($conexion,$sql);
        while ($row = mysqli_fetch_assoc($resultado)) {
			$indice=$row[$guarda];
			$arrayCombo[$indice] =$row[$muestra];
        }
		return $arrayCombo;
    }
function obtenerComboFiltrado($tabla,$guarda,$muestra,$condicion) {  
        global $conexion;	
        $arrayCombo = array();
        $sql="SELECT $guarda,$muestra FROM $tabla ";
		$sql.=" WHERE ".$condicion." order by $muestra";
	
		$resultado =mysqli_query($conexion,$sql);
        while ($row = mysqli_fetch_assoc($resultado)) {
			$indice=$row[$guarda];
			$arrayCombo[$indice] =$row[$muestra];
        }
		return $arrayCombo;
    }
function pintarComboMensaje($arrayOpciones,$nombreCombo,$textoPrimeraOpcion,$valorPrimeraOpcion)
	{
		echo "<select name='".$nombreCombo."'>";
		echo "<option value='".$valorPrimeraOpcion."'>".$textoPrimeraOpcion."</option>";
		foreach ($arrayOpciones as $indice=>$valor)
		{
			echo "<option value='".$indice."'>".$valor."</option>";
		}
		echo "</select>";
	}
function pintarCombo($arrayOpciones,$nombreCombo)
	{
		echo "<select name='".$nombreCombo."'>";
		foreach ($arrayOpciones as $indice=>$valor)
		{
			echo "<option value='".$indice."'>".$valor."</option>";
		}
		echo "</select>";
	}
function pintarComboSelected($arrayOpciones,$nombreCombo,$seleccionado)
	{
		echo "<select name='".$nombreCombo."'>";
		foreach ($arrayOpciones as $indice=>$valor)
		{
			$cadena= "<option ";
			if ($indice==$seleccionado)
				$cadena.=" selected ";
			$cadena.="value='".$indice."'>".$valor."</option>";
			echo $cadena;
		}
		echo "</select>";
	}
function pintarRadio($arrayOpciones,$nombreRadio)
	{
		echo "<p>";
		foreach ($arrayOpciones as $indice=>$valor)
		{
			echo "<input type='radio' name='" .$nombreRadio. "' value='".$indice."'>".$valor."<br>\n";
		}
		echo "</p>";
	}
function pintarRadioMensaje($arrayOpciones,$nombreRadio,$textoPrimeraOpcion,$valorPrimeraOpcion)
	{
		echo "<p>";
		echo "<input type='radio' name='" .$nombreRadio. "' value='".$valorPrimeraOpcion."'>".$textoPrimeraOpcion."<br>\n";
		foreach ($arrayOpciones as $indice=>$valor)
		{
			echo "<input type='radio' name='" .$nombreRadio. "' value='".$indice."'>".$valor."<br>\n";
		}
		echo "</p>";
	}
function pintarCheckBox($arrayOpciones,$nombreArray)
	{
		echo "<p>";
		foreach ($arrayOpciones as $indice=>$valor)
		{
			echo "<input type='checkbox' name='" .$nombreArray. "[]' value='".$indice."'>".$valor."<br>\n";
		}
		echo "</p>";
	}
function pintarComboMultiple($arrayOpciones,$nombreCombo)
	{
		echo "<p><select multiple name='".$nombreCombo."[]'>";
		foreach ($arrayOpciones as $indice=>$valor)
		{
			echo "<option value='".$indice."'>".$valor."</option>";
		}
		echo "</select></p>";
	}
/*
Devuelve:
0 Si el usuario y la contraseña son correctos
1 Si el usuario existe y la contraseña está mal
2 Si el usuario no existe
3 Si ha dejado algún campo vacio
4 otro error
*/
function comprobarUsuario($nombreTabla,$nombreColumna,$nombreClave,
$contenidoColumna,$contenidoClave){
global $conexion;
if (($contenidoColumna=="") || ($contenidoClave=="")) {
    $devuelve=3;
} 
else 
{
/* Evitar inyecciones SQL usando sentencias preparadas*/
$sentencia=$conexion->stmt_init();
$cadenaSql="SELECT COUNT(*) FROM ".$nombreTabla.
        " WHERE ".$nombreColumna."=? AND ".$nombreClave."=?";
$sentencia->prepare($cadenaSql);
$sentencia->bind_param("ss",$contenidoColumna,$contenidoClave);
$sentencia->execute();
/*usando el método bind_result*/
$sentencia->bind_result($num_filas);
$sentencia->fetch();
if (!$sentencia) {
    $devuelve= 4;
   } 
else
   { 
   if ($num_filas>0)
		{
            $devuelve=0;			
        }
		else
		{           
			$sentencia->close();
			unset($sentencia);
			$sentencia=$conexion->stmt_init();
			$consulta = "SELECT COUNT(*) AS cuenta FROM ". $nombreTabla ;
            $consulta.="   WHERE ".$nombreColumna."=?";
			$sentencia->prepare($consulta);
			$sentencia->bind_param("s",$contenidoColumna);
			$sentencia->execute();
			/*en vez de bind_result uso ahora el método get_result */
            $result = $sentencia->get_result();
		    $fila=$result->fetch_array();
	        $num_filas=$fila["cuenta"];
            if (!$result) {
                $devuelve= 4;
            } elseif ($num_filas>0) {
                $devuelve= 1;
            } else {
                $devuelve=2;
            }
        }
    }
}
return $devuelve;
}
?>
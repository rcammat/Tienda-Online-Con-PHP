<?php

function comprobar_usuario($nombre, $clave){
	global $conexion;
	
	$sql = "select num_cliente, email from clientes where email = '$nombre' 
			and password = '$clave'";
	$resul = mysqli_query($conexion,$sql);	
	if ($fila=mysqli_fetch_assoc($resul)){		
		return $fila;		
	}else{
		return FALSE;
	}
}
function cargar_categorias(){
	global $conexion;
	$sql = "select codCat, nombre from categoria";
	$resul = mysqli_query($conexion,$sql);		
	if (!$resul) {
		return FALSE;
	}
	if (mysqli_num_rows($resul) == 0) {    
		return FALSE;
    }
    while ($cat=mysqli_fetch_assoc($resul)){
    	extract ($cat);
        $datos[$codCat]=$nombre;
	}
	//si hay 1 o más
	return $datos;	
}
function cargar_categoria($codCat){
	global $conexion;
	$sql = "select nombre, descripcion from categoria where codcat = $codCat";
	$resul = mysqli_query($conexion,$sql);
	if (!$resul) {
		return FALSE;
	}
	if (mysqli_num_rows($resul) == 0) {    
		return FALSE;
    }	
	//si hay 1 
    return mysqli_fetch_assoc($resul);
	
}
function cargar_productos_categoria($codCat){
	global $conexion;
	$sql = "select * from productos where codCat  = $codCat";	
	$resul = mysqli_query($conexion,$sql);
	if (!$resul) {
		return FALSE;
	}
		if (mysqli_num_rows($resul) == 0) {    
		return FALSE;
    }	
	//si hay 1 o más
	while ($producto=mysqli_fetch_assoc($resul)){

		$arrayProductos[]=$producto;
	}
	return $arrayProductos;			
}
// recibe un array de códigos de productos
// devuelve un array en el que cada elemento contiene los datos de un productos
function cargar_productos($codigosProductos){
	global $conexion;
	$texto_in = implode(",", $codigosProductos);
	$sql = "select * from productos where codProd in($texto_in)";
	$resul = mysqli_query($conexion,$sql);	
	if (!$resul) {
		return FALSE;
	}
while ($filaProducto=mysqli_fetch_assoc ($resul)){
	$productosCesta[]=$filaProducto;;	
}
return $productosCesta;
}
function insertar_pedido($carrito, $NUM_CLIENTE){
	global $conexion;
	$hora = date("Y-m-d H:i:s", time());
	// insertar el pedido
	$sql = "insert into pedidos(CLIENTE, FECHA) 
			values($NUM_CLIENTE,'$hora')";
	$resul=mysqli_query($conexion,$sql);	
	if (!$resul) {
		return FALSE;
	}
	// coger el id del nuevo pedido para las filas detalle
	$pedido = mysqli_insert_id($conexion);

	// insertar las filas en pedidoproductos
	foreach($carrito as $codProd=>$unidades){
			$sql2="SELECT Precio FROM productos WHERE CodProd=$codProd";
			$resul2 = mysqli_query($conexion,$sql2);
			$precio = mysqli_fetch_assoc($resul2);
			extract($precio);

		$sql = "insert into lineas(NUM_PEDIDO, COD_PRODUCTO, PRECIO, CANTIDAD) 
		             values( $pedido, $codProd,$Precio,$unidades)";	
				 
		 $resul = mysqli_query($conexion,$sql);	
		
	}
	
	return $pedido;
} 
function cargar_foto($codProducto)
{
	global $conexion;
	$sacar = "SELECT count(*) FROM fotos WHERE (num_ident=$codProducto)" ;
	$resultado = mysqli_query($conexion,$sacar);
	$fila=mysqli_fetch_assoc($resultado);
	return $fila[0];
}
function obtenerFoto($cod)
{
	global $conexion;
	$sacar = "SELECT * FROM fotos WHERE (num_ident=$cod)" ;
	$resul = mysqli_query($conexion,$sacar);
	if (!$resul) {
		return FALSE;
	}
	if (mysqli_num_rows($resul) == 0) {    
		return FALSE;
    }	
	$registro=mysqli_fetch_row($resul);
   	return $registro[0];   	
}
 
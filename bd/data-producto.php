<?php
	/* R&G - Funciones de clentes */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function agregarProducto( $producto, $dbh ){
		$q = "insert into producto ( Codigo, Descripcion, Presentacion, Foto ) 
		values ( '$producto[codigo]', '$producto[descripcion]', '$producto[pres]', '$producto[foto]' )";
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();		
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function agregarCategoria( $categoria, $dbh ){
		$q = "insert into categoria ( nombre, descripcion ) values ( '$categoria[nombre]', '$categoria[descripcion]' )";
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();		
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function modificarProducto( $producto, $dbh ){
		
		$resp["cambio"] = "exito";
		$q = "update producto set Codigo = '$producto[codigo]', Descripcion = '$producto[descripcion]', Presentacion = '$producto[pres]', Foto = '$producto[foto]' where idProducto = $producto[id]";
		$data = mysql_query( $q, $dbh );
		
		$resp["id"] = $producto["id"];
		if( mysql_affected_rows() != 1 )
			$resp["cambio"] = "";
		
		return $resp;		
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerListaProductos( $link ){
		$lista_c = array();
		$q = "Select idProducto, Codigo, Descripcion from producto order by Descripcion asc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function actualizarCategoria( $dbh, $id, $campo, $valor ){
		$q = "update categoria set $campo = '$valor' where iDcategoria = $id";
		echo $q;
		$data = mysql_query( $q, $dbh );	
	}
	
	function obtenerCategoriasProductos( $dbh ){
		$lista_c = array();
		$q = "select * from categoria order by nombre asc";
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes al servidor para procesar información de Productos */
	/* ----------------------------------------------------------------------------------------------------- */
	//Registro de nuevo producto
	if( isset( $_POST["reg_producto"] ) || isset( $_POST["mod_producto"] ) ){
		$producto["nombre"] = $_POST["nombre"];
		$producto["rif"] = $_POST["rif"];
		$producto["email"] = $_POST["email"];
		$producto["direccion"] = $_POST["direccion"];
		$producto["tel1"] = $_POST["telefono1"];
		$producto["tel2"] = $_POST["telefono2"];
		
		if( isset( $_POST["reg_cliente"] )){
			$idr = agregarProducto( $producto, $dbh );
		}
		if( isset( $_POST["mod_producto"] )){
			$producto["id"] = $_POST["idProducto"];
			$res = modificarProducto( $producto, $dbh );
			$idr = $res["id"]."&res=$res[cambio]";
		}
		
		echo "<script>window.location.href='../ficha_producto.php?p=$idr'</script>";	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_POST["reg_categoria"] ) ){
		$categoria["nombre"] = $_POST["nombre"];
		$categoria["descripcion"] = $_POST["descripcion"];
		 
		echo agregarCategoria( $categoria, $dbh );
	}
	
	if( isset( $_POST["act_categ"] ) ){
		$categoria["id"] = $_POST["idreg"];
		$categoria["campo"] = $_POST["act_categ"];
		$categoria["valor"] = $_POST["valor_c"];
		
		actualizarCategoria( $dbh, $categoria["id"], $categoria["campo"], $categoria["valor"] );
		//return $categoria["id"];
	}
?>
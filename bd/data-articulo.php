<?php
	/* R&G - Funciones de articulos */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function agregarArticulo( $articulo, $dbh ){
		$q = "insert into articulo ( Codigo, Descripcion, Presentacion, Foto ) 
		values ( '$articulo[codigo]', '$articulo[descripcion]', '$articulo[pres]', '$articulo[foto]' )";
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();		
	}

	function obtenerArticuloPorId( $ida, $dbh ){
		$q = "Select a.idArticulo as idArticulo, a.Descripcion as descripcion, a.Codigo as codigo, 
		a.Presentacion as presentacion, c.nombre as categoria from articulo a, categoria c 
		where a.idArticulo = $ida and a.idCategoria = c.idCategoria";
		
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		return $data;
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function agregarCategoria( $categoria, $dbh ){
		$q = "insert into categoria ( nombre, descripcion ) values ( '$categoria[nombre]', '$categoria[descripcion]' )";
		$data = mysql_query( $q, $dbh );
		
		return $q;
		//return mysql_insert_id();		
	}

	function agregarUnidad( $nombre, $dbh ){
		$q = "insert into unidad ( nombre ) values ( '$nombre' )";
		$data = mysql_query( $q, $dbh );
		
		return $q;
		//return mysql_insert_id();		
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function modificarArticulo( $articulo, $dbh ){
		
		$resp["cambio"] = "exito";
		$q = "update articulo set Codigo = '$articulo[codigo]', Descripcion = '$articulo[descripcion]', Presentacion = '$articulo[pres]', Foto = '$articulo[foto]' where idArticulo = $articulo[id]";
		$data = mysql_query( $q, $dbh );
		
		$resp["id"] = $articulo["id"];
		if( mysql_affected_rows() != 1 )
			$resp["cambio"] = "";
		
		return $resp;		
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerListaArticulos( $link ){
		$lista_a = array();
		$q = "Select idArticulo, Codigo, Descripcion, Presentacion from articulo order by Descripcion asc";
		$data = mysql_query( $q, $link );
		while( $a = mysql_fetch_array( $data ) ){
			$lista_a[] = $a;	
		}
		return $lista_a;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function actualizarCategoria( $dbh, $id, $campo, $valor ){
		$q = "update categoria set $campo = '$valor' where iDcategoria = $id";
		//echo $q;
		$data = mysql_query( $q, $dbh );	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function actualizarUnidad( $dbh, $id, $nombre ){
		$q = "update unidad set nombre = '$nombre' where idUnidad = $id";
		//echo $q;
		$data = mysql_query( $q, $dbh );	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function eliminarUnidad( $dbh, $id ){
		$q = "delete from unidad where idUnidad = $id";
		//$data = mysql_query( $q, $dbh );
		return $id;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerCategoriasArticulos( $dbh ){
		$lista_c = array();
		$q = "select * from categoria order by nombre asc";
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerUnidadesVenta( $dbh ){
		$lista_u = array();
		$q = "select * from unidad order by nombre asc";
		$data = mysql_query( $q, $dbh );
		while( $u = mysql_fetch_array( $data ) ){
			$lista_u[] = $u;	
		}
		return $lista_u;	
	}	
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_articulo"] ) || isset( $_POST["mod_articulo"] ) ){
		$articulo["nombre"] = $_POST["nombre"];
		$articulo["rif"] = $_POST["rif"];
		$articulo["email"] = $_POST["email"];
		$articulo["direccion"] = $_POST["direccion"];
		$articulo["tel1"] = $_POST["telefono1"];
		$articulo["tel2"] = $_POST["telefono2"];
		
		if( isset( $_POST["reg_cliente"] )){
			$idr = agregarArticulo( $articulo, $dbh );
		}
		if( isset( $_POST["mod_articulo"] )){
			$articulo["id"] = $_POST["idArticulo"];
			$res = modificarArticulo( $articulo, $dbh );
			$idr = $res["id"]."&res=$res[cambio]";
		}
		
		echo "<script>window.location.href='../ficha_articulo.php?a=$idr'</script>";	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_POST["reg_categoria"] ) ){
		include( "bd.php" );
		$categoria["nombre"] = $_POST["nombre"];
		$categoria["descripcion"] = $_POST["descripcion"];
		 
		echo agregarCategoria( $categoria, $dbh );
	}

	if( isset( $_POST["reg_unidad"] ) ){
		include( "bd.php" );		 
		echo agregarUnidad( $_POST["nombre"], $dbh );
	}

	if( isset( $_POST["act_categ"] ) ){
		include( "bd.php" );
		$categoria["id"] = $_POST["idreg"];
		$categoria["campo"] = $_POST["act_categ"];
		$categoria["valor"] = $_POST["valor_c"];
		
		actualizarCategoria( $dbh, $categoria["id"], $categoria["campo"], $categoria["valor"] );
		//return $categoria["id"];
	}

	if( isset( $_POST["act_und"] ) ){
		include( "bd.php" );		
		actualizarUnidad( $dbh, $_POST["idreg"], $_POST["valor_u"] );
		//return $categoria["id"];
	}

	if( isset( $_POST["elim_und"] ) ){
		include( "bd.php" );		
		return eliminarUnidad( $dbh, $_POST["idreg"] );
	}
?>
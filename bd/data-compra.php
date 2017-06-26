<?php
	/* ----------------------------------------------------------------------------------- */
	/* R&G - Funciones de compras */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function agregarCompra( $dbh, $compra, $idu ){
		//Agrega un registro de compra
		$fecha_emision = cambiaf_a_mysql( $compra["fecha_emision"] );
		$q = "insert into compra ( idProveedor, fecha_registro, fecha_emision, monto, iva, 
		ncontrol, nfactura, idUsuario ) values ( $compra[idProveedor], NOW(), '$fecha_emision', 
		$compra[mbase], $compra[iva], '$compra[ncontrol]', '$compra[nfactura]', $idu )";
		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCompraPorId( $dbh, $id, $idu ){
		//Devuelve registro de artículo dado el ID
		$q = "Select c.idCompra as idcompra, c.monto as mbase, c.iva as iva, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, 
		date_format(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		c.ncontrol as ncontrol, c.nfactura as nfactura, p.idProveedor as idp, p.Nombre as proveedor 
		from proveedor p, compra c 
		where c.idProveedor = p.idProveedor and c.idCompra = $id and c.idUsuario = $idu";
		
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		return $data;
	}
	/* ----------------------------------------------------------------------------------- */
	function agregarCategoria( $categoria, $dbh ){
		$q = "insert into categoria ( nombre, descripcion ) values ( '$categoria[nombre]', '$categoria[descripcion]' )";
		$data = mysql_query( $q, $dbh );
		
		//return $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function agregarUnidad( $nombre, $dbh ){
		$q = "insert into unidad ( nombre ) values ( '$nombre' )";
		$data = mysql_query( $q, $dbh );
		
		//return $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function modificarArticulo( $articulo, $dbh ){
		//Modifica los datos de un artículo
		$resp["cambio"] = "exito";
		$q = "update articulo set Codigo = '$articulo[codigo]', Descripcion = '$articulo[descripcion]', 
		Presentacion = '$articulo[presentacion]', idCategoria = $articulo[categoria] where idArticulo = $articulo[id]";
		$data = mysql_query( $q, $dbh );
		
		$resp["id"] = $articulo["id"];
		if( mysql_affected_rows() != 1 )
			$resp["cambio"] = "";
		
		return $resp;		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaArticulos( $link ){
		$lista_a = array();
		$q = "Select idArticulo, Codigo, Descripcion, Presentacion from articulo order by Descripcion asc";
		$data = mysql_query( $q, $link );
		while( $a = mysql_fetch_array( $data ) ){
			$lista_a[] = $a;	
		}
		return $lista_a;	
	}
	/* ----------------------------------------------------------------------------------- */
	function actualizarCategoria( $dbh, $id, $campo, $valor ){
		$q = "update categoria set $campo = '$valor' where iDcategoria = $id";
		//echo $q;
		$data = mysql_query( $q, $dbh );	
	}
	/* ----------------------------------------------------------------------------------- */
	function actualizarUnidad( $dbh, $id, $nombre ){
		$q = "update unidad set nombre = '$nombre' where idUnidad = $id";
		//echo $q;
		$data = mysql_query( $q, $dbh );	
	}
	/* ----------------------------------------------------------------------------------- */
	function eliminarUnidad( $dbh, $id ){
		$q = "delete from unidad where idUnidad = $id";
		//$data = mysql_query( $q, $dbh );
		return $id;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCategoriasArticulos( $dbh ){
		$lista_c = array();
		$q = "select * from categoria order by nombre asc";
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerUnidadesVenta( $dbh ){
		$lista_u = array();
		$q = "select * from unidad order by nombre asc";
		$data = mysql_query( $q, $dbh );
		while( $u = mysql_fetch_array( $data ) ){
			$lista_u[] = $u;	
		}
		return $lista_u;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerOperacionesArticulo( $dbh, $ida ){
		//Retorna una lista de documentos (facturas cotizaciones) que incluyan un artículo dado por su id
		$lista = array();
		$q = "Select c.idCotizacion as id, 'Cotización' as documento, DATE_FORMAT(fecha_emision,'%d/%m/%Y') as femision, 
		Total as total, estado, numero FROM cotizacion c, detallecotizacion dc 
		where dc.idCotizacion = c.idCotizacion and dc.IdArticulo = $ida UNION ALL 
			Select f.idFactura as id, 'Factura' as documento, DATE_FORMAT(fecha_emision,'%d/%m/%Y') as femision, 
		Total as total, estado, numero FROM factura f, detallefactura df 
		where df.IdFactura = f.idFactura and df.IdArticulo = $ida order by femision DESC"; 
		
		$data = mysql_query( $q, $dbh );
		while( $reg = mysql_fetch_array( $data ) ){
			$lista[] = $reg;	
		}
		return $lista;
	}
	/* ----------------------------------------------------------------------------------- */
	function valorExistente( $dbh, $campo, $valor ){
		$existente = 0;
		$q = "select * from articulo where $campo = '$valor'"; 
		$data = mysql_query( $q, $dbh );
		if( mysql_num_rows( $data ) > 0 ) $existente = 1;
		
		return $existente;	
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["mod_articulo"] ) ){
		include( "bd.php" );
		$articulo["descripcion"] = $_POST["descripcion"];
		$articulo["codigo"] = $_POST["codigo"];
		$articulo["presentacion"] = $_POST["presentacion"];
		$articulo["categoria"] = $_POST["categoria"];
		$articulo["id"] = $_POST["idArticulo"];
		
		$res = modificarArticulo( $articulo, $dbh );
		$idr = $res["id"]."&res=$res[cambio]";
		
		echo "<script>window.location.href='../ficha_articulo.php?a=$idr'</script>";	
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["ncompra"] ) ){ //Registro de nueva compra
		include( "bd.php" );
		
		$compra = array();
		parse_str( $_POST["ncompra"], $compra );
		
		$idc = agregarCompra( $dbh, $compra, $_POST["id_u"] );
		if( ( $idc != 0 ) && ( $idc != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Compra registrada";
			$compra["id"] = $idc;
			$res["registro"] = $compra;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar compra";
		}
		echo json_encode( $res );
	}
	/* ----------------------------------------------------------------------------------- */
	/* Solicitudes al servidor para procesar información de artículos */
	/* ----------------------------------------------------------------------------------- */
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
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["act_categ"] ) ){
		include( "bd.php" );
		$categoria["id"] = $_POST["idreg"];
		$categoria["campo"] = $_POST["act_categ"];
		$categoria["valor"] = $_POST["valor_c"];
		
		actualizarCategoria( $dbh, $categoria["id"], $categoria["campo"], $categoria["valor"] );
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

	if( isset( $_POST["existe"] ) ){
		include( "bd.php" );		
		echo valorExistente( $dbh, $_POST["campo"], $_POST["valor"] );
	}
	/* ----------------------------------------------------------------------------------- */
?>
<?php
	/* ----------------------------------------------------------------------------------- */
	/* R&G - Funciones de compras */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function agregarCompra( $dbh, $compra, $idu ){
		//Agrega un registro de compra
		$fecha_emision = cambiaf_a_mysql( $compra["fecha_emision"] );
		$q = "insert into compra ( idProveedor, fecha_registro, fecha_emision, monto, iva, 
		ncontrol, nfactura, idUsuario, estado ) values ( $compra[idProveedor], NOW(), '$fecha_emision', 
		$compra[mbase], $compra[iva], '$compra[ncontrol]', '$compra[nfactura]', $idu, 'creada' )";
		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCompraPorId( $dbh, $id, $idu ){
		//Devuelve registro de artículo dado el ID
		$q = "Select c.idCompra as idcompra, c.monto as mbase, c.iva as iva, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, c.estado as estado,  
		date_format(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		c.ncontrol as ncontrol, c.nfactura as nfactura, p.idProveedor as idp, p.Nombre as proveedor 
		from proveedor p, compra c 
		where c.idProveedor = p.idProveedor and c.idCompra = $id and c.idUsuario = $idu";
		
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		return $data;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaCompras( $dbh, $idu ){
		//Devuelve registro de artículo dado el ID
		$lista_c = array();
		$q = "select c.idCompra as idcompra, c.monto as mbase, c.iva as iva, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, 
		date_format(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		c.ncontrol as ncontrol, c.nfactura as nfactura, p.idProveedor as idp, p.Nombre as proveedor 
		from proveedor p, compra c where c.idProveedor = p.idProveedor and c.idUsuario = $idu and estado = 'creada'";
		
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function modificarCompra( $dbh, $compra, $idu ){
		//Modifica los datos de una compra
		$q = "update compra set idProveedor = $compra[idProveedor], fecha_modificacion = NOW(), 
		monto = $compra[mbase], iva = $compra[iva], ncontrol = '$compra[ncontrol]', nfactura = '$compra[nfactura]'
		where idCompra = $compra[idCompra] and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return $compra["idCompra"];		
	}
	/* ----------------------------------------------------------------------------------- */
	function eliminarCompra( $dbh, $idc, $estado, $idu ){
		//Modifica el estado de una compra ('creada', 'eliminada')
		$q = "update compra set estado = '$estado' where idCompra = $idc and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();		
	}
	/* ----------------------------------------------------------------------------------- */
	function mjeRespuestaEstado( $estado ){
		$mje = array(
			"eliminada" 		=> "Compra eliminada",
			"creada"			=> "Compra recuperada"
		);
		return $mje[$estado];
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
	
	/* ----------------------------------------------------------------------------------- */
	/* Solicitudes al servidor para procesar información de compras */
	/* ----------------------------------------------------------------------------------- */
	
	if( isset( $_POST["ncompra"] ) ){ //Registro o modificación de una compra
		include( "bd.php" );
		
		$compra = array();
		parse_str( $_POST["ncompra"], $compra );
		if( $_POST["c_accion"] == "agregar" )
			$idc = agregarCompra( $dbh, $compra, $_POST["id_u"] );
		if( $_POST["c_accion"] == "editar" )
			$idc = modificarCompra( $dbh, $compra, $_POST["id_u"] );

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
	if( isset( $_POST["ecompra"] ) ){
		include( "bd.php" );
		$idu = $_POST["id_u"];
		$r = eliminarCompra( $dbh, $_POST["ecompra"], $_POST["edo"], $idu );
		
		if( ( $r != 0 ) ){
			$res["exito"] = 1;
			$res["mje"] = mjeRespuestaEstado( $_POST["edo"] );
			$compra["id"] = $_POST["ecompra"];
			$res["registro"] = $compra;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "No se realizaron cambios";
		}
		echo json_encode( $res );
	}
	/* ----------------------------------------------------------------------------------- */
?>
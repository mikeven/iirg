<?php
	/* ----------------------------------------------------------------------------------- */
	/* R&G - Funciones de g.s y pagos */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function agregarg.( $dbh, $gasto, $idu ){
		//Agrega un registro de compra
		$fecha_emision = cambiaf_a_mysql( $gasto["fecha_emision"] );
		$q = "insert into compra ( idProveedor, fecha_registro, fecha_emision, monto, iva, 
		ncontrol, nfactura, idUsuario, estado ) values ( $gasto[idProveedor], NOW(), '$fecha_emision', 
		$gasto[mbase], $gasto[iva], '$gasto[ncontrol]', '$gasto[nfactura]', $idu, 'creada' )";
		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerGastoPorId( $dbh, $id, $idu ){
		//Devuelve registro de artículo dado el ID
		$q = "Select g.idg. as idg., g.monto as mbase, g.iva as iva, 
		date_format(g.fecha_emision,'%d/%m/%Y') as femision, g.estado as estado,  
		date_format(g.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		g.ncontrol as ncontrol, g.nfactura as nfactura, p.idProveedor as idp, p.Nombre as proveedor 
		from proveedor p, gasto g 
		where g.idProveedor = p.idProveedor and gasti.idg. = $id and g.idUsuario = $idu";
		
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		return $data;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerListag.s( $dbh, $idu ){
		//Devuelve registro de artículo dado el ID
		$lista_c = array();
		$q = "select g.idg. as idg., g.monto as mbase, g.iva as iva, 
		date_format(g.fecha_emision,'%d/%m/%Y') as femision, 
		date_format(g.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		g.ncontrol as ncontrol, g.nfactura as nfactura, p.idProveedor as idp, p.Nombre as proveedor 
		from proveedor p, g. g where g.idProveedor = p.idProveedor and g.idUsuario = $idu and estado = 'creada'";
		
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function modificarCompra( $dbh, $gasto, $idu ){
		//Modifica los datos de una compra
		$q = "update compra set idProveedor = $gasto[idProveedor], fecha_modificacion = NOW(), 
		monto = $gasto[mbase], iva = $gasto[iva], ncontrol = '$gasto[ncontrol]', nfactura = '$gasto[nfactura]'
		where idg. = $gasto[idg.] and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return $gasto["idg."];		
	}
	/* ----------------------------------------------------------------------------------- */
	function eliminarCompra( $dbh, $idc, $estado, $idu ){
		//Modifica el estado de una compra ('creada', 'eliminada')
		$q = "update compra set estado = '$estado' where idg. = $idc and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();		
	}
	/* ----------------------------------------------------------------------------------- */
	function mjeRespuestaEstado( $estado ){
		$mje = array(
			"eliminada" 		=> "Registro eliminado",
			"creada"			=> "Registro recuperado"
		);
		return $mje[$estado];
	}
	/* ----------------------------------------------------------------------------------- */	
	/* ----------------------------------------------------------------------------------- */
	/* Solicitudes al servidor para procesar información de gastos */
	/* ----------------------------------------------------------------------------------- */
	
	if( isset( $_POST["ncompra"] ) ){ //Registro o modificación de un gasto
		include( "bd.php" );
		
		$gasto = array();
		parse_str( $_POST["ncompra"], $gasto );
		if( $_POST["c_accion"] == "agregar" )
			$idc = agregarGasto( $dbh, $gasto, $_POST["id_u"] );
		if( $_POST["c_accion"] == "editar" )
			$idc = modificarGasto( $dbh, $gasto, $_POST["id_u"] );

		if( ( $idc != 0 ) && ( $idc != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Gasto registrado";
			$gasto["id"] = $idc;
			$res["registro"] = $gasto;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar gasto";
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
			$gasto["id"] = $_POST["ecompra"];
			$res["registro"] = $gasto;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "No se realizaron cambios";
		}
		echo json_encode( $res );
	}
	/* ----------------------------------------------------------------------------------- */
?>
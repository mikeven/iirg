<?php
	/* ----------------------------------------------------------------------------------- */
	/* R&G - Funciones de compras */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	
	function obtenerProximoNumeroRetencion( $dbh, $idu ){
		//Retorna el número correspondiente al próximo registro de compra(control retención)
		$q = "select MAX(control_ret) as nret from compra where idUsuario = $idu 
		and estado <> 'eliminada'";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["nret"] + 1;
	}
	/* ----------------------------------------------------------------------------------- */
	function generarNumeroRetencion( $num ){
		//Devuelve los últimos 8 dígitos del núm de comprobante de retención
		$nr = "";
		$stn_l = strlen((string)$num);
		for( $i = 0; $i < 8-$stn_l; $i++ )
			$nr .= "0";

		return $nr.$num;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerNumeroComprobanteRetencion( $dbh, $idc, $idu ){
		//Retorna el número de comprobante de retención de acuerdo al número y fecha
		$nret = -1;
		$hoy = obtenerFechaActual();
		$fecha = $hoy["f1"]["fecha"];

		$nret = obtenerProximoNumeroRetencion( $dbh, $idu );
		$data_f = explode( '/', $fecha );
		$nr = generarNumeroRetencion( $nret );
		$nc = $data_f[2].$data_f[1].$nr; 
		
		actualizarRetencionCompra( $dbh, $fecha, $idc, $nret, $nc, $idu );

		return $nret; 
	}
	/* ----------------------------------------------------------------------------------- */
	function actualizarRetencionCompra( $dbh, $fecha, $idc, $c_ret, $n_ret, $idu ){
		// Actualiza el registro de compra para asignar valores de retención

		$fecha_emision_r = cambiaf_a_mysql( $fecha );
		
		$q = "update compra set control_ret = $c_ret, num_retencion = '$n_ret', 
		fecha_retencion = '$fecha_emision_r' where idCompra = $idc and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
	}
	/* ----------------------------------------------------------------------------------- */
	function agregarCompra( $dbh, $compra, $idu ){
		//Agrega un registro de compra

		$fecha_emision = cambiaf_a_mysql( $compra["fecha_emision"] );
		$q = "insert into compra ( idProveedor, fecha_registro, fecha_emision, monto, 
		iva, retencion, ncontrol, nfactura, nfactura_afec, nnota_credito, nnota_debito, idUsuario, estado ) 
		values ( $compra[idProveedor], NOW(), '$fecha_emision', $compra[mbase], $compra[iva], 
		$compra[retencion], '$compra[ncontrol]', '$compra[nfactura]', '$compra[nfactura_afec]', 
		'$compra[nncredito]', '$compra[nndebito]', $idu, 'creada' )";
		
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCompraPorId( $dbh, $id, $idu ){
		//Devuelve registro de compra dado el ID

		$q = "Select c.idCompra as idcompra, c.monto as mbase, c.iva as iva, c.retencion as vret, 
		((c.iva*c.monto/100)*c.retencion) as retencion, (c.retencion*100) as pret,  
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, c.estado as estado,  
		date_format(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro,
		date_format(c.fecha_retencion,'%d/%m/%Y') as fretencion, c.num_retencion as nret, 
		c.ncontrol as ncontrol, c.nfactura as nfactura, c.nnota_credito, c.nnota_debito, c.nfactura_afec, 
		p.idProveedor as idp, p.Nombre as proveedor, p.rif as rif_p, p.Direccion1 as dir1, p.Direccion2 as dir2 
		from proveedor p, compra c where c.idProveedor = p.idProveedor and c.idCompra = $id and c.idUsuario = $idu";
		
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		return $data;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaCompras( $dbh, $idu ){
		//Devuelve listado de registros de compras de un usuario

		$lista_c = array();
		$q = "select c.idCompra as idcompra, c.monto as mbase, c.iva as iva, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, ((c.monto * c.iva/100) + c.monto) as mtotal,
		date_format(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		( (( c.monto * c.iva/100 ) + c.monto ) - ((c.iva*c.monto/100)*c.retencion) ) as mpagado,  
		c.ncontrol as ncontrol, c.nfactura as nfactura, c.num_retencion as nretencion, 
		p.idProveedor as idp, p.Nombre as proveedor 
		from proveedor p, compra c where c.idProveedor = p.idProveedor and c.idUsuario = $idu and 
		estado <> 'eliminada' order by c.fecha_emision desc";
		
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaComprasNoPagadas( $dbh, $idu ){
		//Devuelve registro de artículo dado el ID
		$lista_c = array();
		$q = "select c.idCompra as idcompra, c.monto as mbase, c.iva as iva, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, ((c.monto * c.iva/100) + c.monto) as mtotal,
		date_format(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		( (( c.monto * c.iva/100 ) + c.monto ) - ((c.iva*c.monto/100)*c.retencion) ) as mpagado,  
		c.ncontrol as ncontrol, c.nfactura as nfactura, p.idProveedor as idp, p.Nombre as proveedor 
		from proveedor p, compra c where c.idProveedor = p.idProveedor and c.idUsuario = $idu 
		and estado = 'creada' order by c.fecha_emision asc";
		
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function modificarCompra( $dbh, $compra, $idu ){
		//Modifica los datos de una compra
		$fecha_emision = cambiaf_a_mysql( $compra["fecha_emision"] );
		$q = "update compra set idProveedor = $compra[idProveedor], fecha_modificacion = NOW(), 
		monto = $compra[mbase], iva = $compra[iva], ncontrol = '$compra[ncontrol]', 
		nfactura = '$compra[nfactura]', nnota_credito = '$compra[nnota_credito]', nnota_debito = '$compra[nnota_debito]', 
		nfactura_afec = '$compra[nfactura_afec]', fecha_emision = '$fecha_emision', num_retencion = '$compra[nret]', 
		retencion = $compra[retencion] where idCompra = $compra[idCompra] and idUsuario = $idu";
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
		if( $_POST["c_accion"] == "agregar" ){
			/*$compra["ncomprobante"] = obtenerNumeroComprobanteRetencion( $compra["nret"], 
				$compra["fecha_emision"] );*/
			$idc = agregarCompra( $dbh, $compra, $_POST["id_u"] );
		}
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
	if( isset( $_POST["imp_ret"] ) ){
		include( "bd.php" );
		$r = 0;
		$idu = $_POST["id_u"];
		$idc = $_POST["imp_ret"];
		
		$compra = obtenerCompraPorId( $dbh, $idc, $idu );
		if( $compra["nret"] == NULL )
        	$r = obtenerNumeroComprobanteRetencion( $dbh, $idc, $idu );
        
        echo $r;
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
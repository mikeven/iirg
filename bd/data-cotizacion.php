<?php
	/* ----------------------------------------------------------------------------------- */
	/* R&G - Gestión de datos de cotizaciones */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	ini_set( 'display_errors', 1 );
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaCotizaciones( $link, $idu, $estado ){
		$xq = ""; $lista_c = array();
		if( $estado != "" ) $xq = "and estado = '$estado'";
		$q = "Select c.idCotizacion as id, c.tipo as tipo, c.numero as numero, 
		c.estado as estado, date_format(c.fecha_emision,'%d/%m/%Y') as Fecha, 
		c.valor_condicion as vcondicion, k.Nombre as Nombre, c.Total as Total 
		from cotizacion c, cliente k where c.idCliente = k.idCliente and c.tipo = 'cotizacion' 
		and idUsuario = $idu $xq order by c.fecha_emision DESC";
		
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerSolicitudesCotizaciones( $link, $idu ){
		$lista_c = array();
		$q = "Select c.idCotizacion as id, c.tipo as tipo, c.numero as numero, c.estado as estado, date_format(c.fecha_emision,'%d/%m/%Y') 
		as Fecha, p.Nombre as Nombre, c.Total as Total from cotizacion c, proveedor p 
		where c.idCliente = p.idProveedor and c.tipo = 'solicitud' and idUsuario = $idu order by c.fecha_emision DESC";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerProximoNumeroCotizacion( $dbh, $idu ){
		$q = "select MAX(numero) as num from cotizacion where tipo = 'cotizacion' and idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	
	function obtenerProximoNumeroSolicitudCotizacion( $dbh, $idu ){
		$q = "select MAX(numero) as num from cotizacion where tipo = 'solicitud' and idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerDetalleCotizacion( $dbh, $idc ){
		//Retorna una lista con el detalle de una cotización
		$detalle = array();
		$q = "select IdMovimiento as idd, IdArticulo as ida, Descripcion as descripcion, und,  
		Cantidad as cantidad, PrecioUnit as punit, PrecioTotal as ptotal, Comision as comision  
		FROM detallecotizacion WHERE idCotizacion = $idc";
		
		$data = mysql_query( $q, $dbh );
		while( $item = mysql_fetch_array( $data ) ){
			$detalle[] = $item;	
		}
		return $detalle;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCotizacionPorId( $dbh, $idc ){
		//Retorna el registro de una cotización y sus ítems de detalle dado su id
		$q = "select c.numero as nro, c.idCotizacion as idc, c.tipo as tipo, c.estado as estado, 
		c.idCliente as idcliente, DATE_FORMAT(c.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		DATE_FORMAT(c.fecha_aprobacion,'%d/%m/%Y') as faprobacion, 
		DATE_FORMAT(c.fecha_anulacion,'%d/%m/%Y %h:%i %p') as fanulacion, 
		DATE_FORMAT(c.fecha_vencimiento,'%d/%m/%Y') as fvencimiento, 
		c.valor_condicion as vcondicion, c.condicion as validez, c.iva as iva, c.pcontacto as pcontacto, 
		c.iva as iva, c.introduccion as intro, c.Observaciones as obs0, c.Observaciones1 as obs1, 
		c.Observaciones2 as obs2, c.Observaciones3 as obs3, c.moneda as moneda, k.Nombre as nombre, k.Rif as rif, 
		k.direccion1 as dir1, k.direccion2 as dir2, k.telefono1 as tlf1, k.telefono2 as tlf2,
		k.Email as email FROM cotizacion c, cliente k where c.idCotizacion = $idc and c.idCliente = k.idCliente";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetalleCotizacion( $dbh, $idc );
		
		return $cotizacion;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerSolicitudCotizacionPorId( $dbh, $idc ){
		//Obtiene solicitud de cotización dado su id. Usa idcliente como id de proveedor	
		$q = "select c.numero as nro, c.idCotizacion as idc, c.tipo as tipo, c.estado as estado, p.idProveedor as idproveedor, 
		DATE_FORMAT(c.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		DATE_FORMAT(c.fecha_aprobacion,'%d/%m/%Y') as faprobacion, 
		DATE_FORMAT(c.fecha_anulacion,'%d/%m/%Y %h:%i %p') as fanulacion, 
		DATE_FORMAT(c.fecha_vencimiento,'%d/%m/%Y') as fvencimiento, c.validez as validez, c.iva as iva, 
		c.pcontacto as pcontacto, c.iva as iva, c.introduccion as intro, c.Observaciones as obs0, c.Observaciones1 as obs1, 
		c.Observaciones2 as obs2, c.Observaciones3 as obs3, p.Nombre as nombre, p.Rif as rif, p.direccion1 as dir1, 
		p.direccion2 as dir2, p.telefono1 as tlf1, p.telefono2 as tlf2, p.Email as email FROM cotizacion c, proveedor p 
		where c.idCotizacion = ".$idc." and c.idCliente = p.idProveedor";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetalleCotizacion( $dbh, $idc );
		
		return $cotizacion;
	}
	/* ----------------------------------------------------------------------------------- */
	function guardarItemDetalle( $dbh, $idc, $item ){
		//Guarda el registro individual de un ítem del detalle de cotización
		//require_once($_SERVER['DOCUMENT_ROOT'].'/lib/FirePHPCore/fb.php');
		$q = "insert into detallecotizacion ( idCotizacion, IdArticulo, Descripcion, Cantidad, und, 
		PrecioUnit, PrecioTotal, Comision ) values ( $idc, $item->idart, '$item->nart', $item->dcant, 
		'$item->dund', $item->dpunit, $item->dptotal, $item->comision )";
		//echo $q."\n";
		$data = mysql_query( $q, $dbh );
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------- */
	function guardarDetalleCotizacion( $dbh, $idc, $detalle, $iva ){
		//Registra los ítems contenidos en el detalle de la cotización
		$exito = true;
		$nitems = count( $detalle );
		$citem = 0;
		foreach ( $detalle as $item ){
			$id_item = guardarItemDetalle( $dbh, $idc, $item, $iva );
			if( $id_item != 0 ) $citem++;	
		}
		if( $citem != $nitems ) $exito = false;
		
		return $exito;
	}
	/* ----------------------------------------------------------------------------------- */
	function guardarCotizacion( $dbh, $encabezado, $idu ){
		// Guarda el registro de la cotización y solicitud de cotización
		// idCliente funciona para indicar cliente o proveedor según el valor del campo tipo de registro (tipo)
		$fecha_emision = cambiaf_a_mysql( $encabezado->femision );
		if( $encabezado->tipo == "cotizacion" ){
			$param = "valor_condicion, condicion,";
			$valores = $encabezado->vcondicion.", '".$encabezado->ncondicion."',";	
		} else { $param = ""; $valores = ""; }
		
		$q = "insert into cotizacion ( numero, tipo, estado, idCliente, fecha_emision, fecha_vencimiento, 
		fecha_registro, pcontacto, introduccion, observaciones, observaciones1, observaciones2, 
		observaciones3, moneda, $param iva, Total, idUsuario ) 
		values ( $encabezado->numero, '$encabezado->tipo', '$encabezado->estado', 
		$encabezado->idc, '$fecha_emision', '$encabezado->fvencimiento', NOW(), '$encabezado->pcontacto', 
		'$encabezado->introduccion', '$encabezado->obs0', '$encabezado->obs1', '$encabezado->obs2', 
		'$encabezado->obs3', '$encabezado->moneda', $valores $encabezado->iva, $encabezado->total, $idu )";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_insert_id();
	}
	/* ------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Cotizaciones */
	/* ------------------------------------------------------------------------------- */
	//Registro de nueva cotización
	if( isset( $_POST["reg_cotizacion"] ) ){
		include( "bd.php" );
		include( "../fn/fn-documento.php" );
		include( "../bd/data-documento.php" );

		$encabezado = json_decode( $_POST["encabezado"] );
		$encabezado->fvencimiento = agregarFechaVencimiento( $dbh, $encabezado, "cotizacion" );
		$detalle = json_decode( $_POST["detalle"] );
		$idc = guardarCotizacion( $dbh, $encabezado, $encabezado->idu );
		
		if( ( $idc != 0 ) && ( $idc != "" ) ){
			$exito = guardarDetalleCotizacion( $dbh, $idc, $detalle, $encabezado->iva );
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$encabezado->idr = $idc;
				$res["documento"] = arrRespuesta( $encabezado, $encabezado->tipo );
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar detalle de cotización";
			}	
		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar cotización";
		}

		echo json_encode( $res );
	}
	/* ------------------------------------------------------------------------------- */
	function editarCotizacion( $dbh, $encabezado, $idu ){
		//Actualiza los valores del encabezado de una cotización
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		if( $encabezado->tipo == "cotizacion" ){
			$param = "valor_condicion = $encabezado->vcondicion, 
			condicion = '$encabezado->ncondicion',";
		} else { $param = ""; }
		$q = "update cotizacion set 
			idCliente = $encabezado->idc, 
			fecha_emision = '$fecha_mysql',
			fecha_modificacion = NOW(), 
			pcontacto = '$encabezado->pcontacto', 
			iva = $encabezado->iva, 
			Total = $encabezado->total, 
			observaciones1 = '$encabezado->obs1', 
			observaciones2 = '$encabezado->obs2', 
			observaciones3 = '$encabezado->obs3',
			fecha_modificacion = NOW(), 
			$param idUsuario = $idu  
		WHERE idCotizacion = $encabezado->idr and idUsuario = $idu";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();	
	}
	/* ------------------------------------------------------------------------------- */
	//Edición de cotización
	if( isset( $_POST["edit_cotizacion"] ) ){
		
		include( "bd.php" );
		include( "data-documento.php" );
		include( "../fn/fn-documento.php" );
		
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		$r_edit = editarCotizacion( $dbh, $encabezado, $encabezado->idu );

		if( $r_edit != -1 ){
			
			eliminarDetalleDocumento( $dbh, "detallecotizacion", "idCotizacion", $encabezado->idr );
			$exito = guardarDetalleCotizacion( $dbh, $encabezado->idr, $detalle, $encabezado->iva );
			
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$res["documento"] = arrRespuesta( $encabezado, $encabezado->tipo );
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al editar detalle de cotización";
			}

		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al editar cotización";
		}

		echo json_encode( $res );
	}
	/* ------------------------------------------------------------------------------- */
?>
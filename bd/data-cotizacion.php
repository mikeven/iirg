<?php
	/* R&G - Gestión de datos de cotizaciones */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerListaCotizaciones( $link, $idu, $estado ){
		$xq = ""; $lista_c = array();
		if( $estado != "" ) $xq = "and estado = '$estado'";
		$q = "Select c.IdCotizacion2 as idc, c.tipo as tipo, c.numero as numero, c.estado as estado, 
		date_format(c.fecha_emision,'%d/%m/%Y') as Fecha, k.Nombre as Nombre, c.Total as Total 
		from cotizacion c, cliente k where c.IdCliente2 = k.IdCliente2 and c.tipo = 'cotizacion' 
		and idUsuario = $idu $xq order by c.fecha_emision DESC";
		
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerSolicitudesCotizaciones( $link, $idu ){
		$lista_c = array();
		$q = "Select c.IdCotizacion2 as idc, c.tipo as tipo, c.numero as numero, c.estado as estado, date_format(c.fecha_emision,'%d/%m/%Y') 
		as Fecha, p.Nombre as Nombre, c.Total as Total from cotizacion c, proveedor p 
		where c.IdCliente2 = p.idProveedor and c.tipo = 'solicitud' and idUsuario = $idu order by c.fecha_emision DESC";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
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
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerDetalleCotizacion( $dbh, $idc ){
		
		$detalle = array();
		$q = "select IdMovimiento as idd, IdArticulo as ida, Descripcion as descripcion, Cantidad as cantidad, 
		PrecioUnit as punit, PrecioTotal as ptotal, und from detallecotizacion where IdCotizacion2 = $idc";
		
		$data = mysql_query( $q, $dbh );
		while( $item = mysql_fetch_array( $data ) ){
			$detalle[] = $item;	
		}
		return $detalle;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerCotizacionPorId( $dbh, $idc ){
		
		$q = "select c.numero as nro, c.IdCotizacion2 as idc, c.tipo as tipo, c.estado as estado, 
		c.IdCliente2 as idcliente, DATE_FORMAT(c.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(c.fecha_registro,'%d/%m/%Y %h:%i') as fregistro, 
		DATE_FORMAT(c.fecha_aprobacion,'%d/%m/%Y') as faprobacion, 
		DATE_FORMAT(c.fecha_anulacion,'%d/%m/%Y %h:%i') as fanulacion, 
		DATE_FORMAT(c.fecha_vencimiento,'%d/%m/%Y') as fvencimiento, 
		c.idCondicion as idCondicion, c.validez as validez, c.iva as iva, c.pcontacto as pcontacto, 
		c.iva as iva, c.introduccion as intro, c.Observaciones as obs0, c.Observaciones1 as obs1, 
		c.Observaciones2 as obs2, c.Observaciones3 as obs3, k.Nombre as nombre, k.Rif as rif, 
		k.direccion1 as dir1, k.direccion2 as dir2, k.telefono1 as tlf1, k.telefono2 as tlf2,
		k.Email as email FROM cotizacion c, cliente k where c.IdCotizacion2 = $idc and c.IdCliente2 = k.IdCliente2";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetalleCotizacion( $dbh, $idc );
		
		return $cotizacion;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerSolicitudCotizacionPorId( $dbh, $idc ){
		//Obtiene solicitud de cotización dado su id. idcliente = idproveedor	
		$q = "select c.numero as nro, c.IdCotizacion2 as idc, c.tipo as tipo, c.estado as estado, p.idProveedor as idproveedor, 
		DATE_FORMAT(c.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		DATE_FORMAT(c.fecha_aprobacion,'%d/%m/%Y') as faprobacion, 
		DATE_FORMAT(c.fecha_anulacion,'%d/%m/%Y %h:%i %p') as fanulacion, 
		DATE_FORMAT(c.fecha_vencimiento,'%d/%m/%Y') as fvencimiento, c.validez as validez, c.iva as iva, 
		c.pcontacto as pcontacto, c.iva as iva, c.introduccion as intro, c.Observaciones as obs0, c.Observaciones1 as obs1, 
		c.Observaciones2 as obs2, c.Observaciones3 as obs3, p.Nombre as nombre, p.Rif as rif, p.direccion1 as dir1, 
		p.direccion2 as dir2, p.telefono1 as tlf1, p.telefono2 as tlf2, p.Email as email FROM cotizacion c, proveedor p 
		where c.IdCotizacion2 = ".$idc." and c.IdCliente2 = p.idProveedor";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetalleCotizacion( $dbh, $idc );
		
		return $cotizacion;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalle( $dbh, $idc, $item ){
		//Guarda el registro individual de un ítem del detalle de cotización
		//require_once($_SERVER['DOCUMENT_ROOT'].'/lib/FirePHPCore/fb.php');
		$ptotal = $item->dcant * $item->dpunit;
		$q = "insert into detallecotizacion ( IdCotizacion2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idc, $item->idart, '$item->nart', $item->dcant, '$item->dund', $item->dpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";
		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
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
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarCotizacion( $dbh, $encabezado, $idu ){
		// Guarda el registro de la cotización y solicitud de cotización
		// idCliente2 funciona para indicar cliente o proveedor según el valor del campo tipo de registro (tipo)
		$fecha_emision = cambiaf_a_mysql( $encabezado->femision );
		$q = "insert into cotizacion ( numero, tipo, estado, IdCliente2, fecha_emision, fecha_vencimiento, 
		pcontacto, introduccion, observaciones, observaciones1, observaciones2, observaciones3, validez, iva,
		Total, idUsuario  ) values ( $encabezado->numero, '$encabezado->tipo', '$encabezado->estado', 
		$encabezado->idc, '$fecha_emision', '$encabezado->fvencimiento', '$encabezado->pcontacto', 
		'$encabezado->introduccion', '$encabezado->obs0', '$encabezado->obs1', '$encabezado->obs2', 
		'$encabezado->obs3', '$encabezado->validez', $encabezado->iva, $encabezado->total, $idu )";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Cotizaciones */
	/* ----------------------------------------------------------------------------------------------------- */
	//Registro de nueva cotización
	if( isset( $_POST["reg_cotizacion"] ) ){
		include( "bd.php" );
		include( "../fn/fn-documento.php" );
		include( "../bd/data-documento.php" );

		$encabezado = json_decode( $_POST["encabezado"] );
		$encabezado->fvencimiento = agregarFechaVencimiento( $dbh, $encabezado, "cotizacion" );
		$encabezado->validez = obtenerTextoValidez( $dbh, $encabezado, "cotizacion" );
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
	/* ----------------------------------------------------------------------------------------------------- */
	function editarCotizacion( $dbh, $encabezado, $idu ){
		
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$q = "update cotizacion set IdCliente2 = $encabezado->idc, fecha_emision = '$fecha_mysql', 
		pcontacto = '$encabezado->pcontacto', idCondicion = '$encabezado->idcondicion', iva = $encabezado->iva,
		Total = $encabezado->total, validez = '$encabezado->validez', observaciones1 = '$encabezado->obs1', 
		observaciones2 = '$encabezado->obs2', observaciones3 = '$encabezado->obs3', idUsuario = $idu 
		WHERE IdCotizacion2 = $encabezado->idr and idUsuario = $idu";
		
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
		$encabezado->validez = obtenerTextoValidez( $dbh, $encabezado, "cotizacion" );
		$detalle = json_decode( $_POST["detalle"] );
		$r_edit = editarCotizacion( $dbh, $encabezado, $encabezado->idu );
		
		if( $r_edit != -1 ){
			
			eliminarDetalleDocumento( $dbh, "detallecotizacion", "IdCotizacion2", $encabezado->idr );
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
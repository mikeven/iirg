<?php
	/* R&G - Gestión de datos de cotizaciones */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerListaCotizaciones( $link ){
		$lista_c = array();
		$q = "Select c.IdCotizacion2 as idc, c.tipo as tipo, c.numero as numero, date_format(c.fecha_emision,'%d/%m/%Y') as Fecha, 
		k.Nombre as Nombre, c.Total as Total 
		from cotizacion c, cliente k where c.IdCliente2 = k.IdCliente2 and c.tipo = 'cotizacion' order by c.fecha_emision DESC";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerSolicitudesCotizaciones( $link ){
		$lista_c = array();
		$q = "Select c.IdCotizacion2 as idc, c.tipo as tipo, c.numero as numero, date_format(c.fecha_emision,'%d/%m/%Y') as Fecha, 
		p.Nombre as Nombre, c.Total as Total from cotizacion c, proveedor p 
		where c.IdCliente2 = p.idProveedor and c.tipo = 'solicitud' order by c.fecha_emision DESC";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerProximoNumeroCotizacion( $dbh ){
		$q = "select MAX(numero) as num from cotizacion";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	
	function obtenerProximoNumeroSolicitudCotizacion( $dbh ){
		$q = "select MAX(numero) as num from cotizacion where tipo = 'solicitud'";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerTotales( $detalle, $pcge ){
		$subtotal = 0;
		foreach ( $detalle as $d ) {
			$subtotal += ($d["punit"] * $d["cantidad"]);	
		}

		$totales["subtotal"] = number_format( $subtotal, 2, ",", "" ); 
		$totales["iva"] = number_format( $subtotal * $pcge, 2, ",", "" );
		$totales["total"] = number_format( $subtotal + ($subtotal * $pcge), 2, ",", "" );
		
		return $totales;
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
		
		$q = "select c.numero as nro, c.IdCotizacion2 as idc, c.tipo as tipo, c.IdCliente2 as idcliente, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, c.validez as validez, c.iva as iva, c.pcontacto as pcontacto, 
		c.iva as iva, c.Observaciones1 as obs1, c.Observaciones2 as obs2, c.Observaciones3 as obs3, k.Nombre as nombre, 
		k.Rif as rif, k.direccion1 as dir1, k.direccion2 as dir2, k.telefono1 as tlf1, k.telefono2 as tlf2, k.Email as email 
		FROM cotizacion c, cliente k where c.IdCotizacion2 = ".$idc." and c.IdCliente2 = k.IdCliente2";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetalleCotizacion( $dbh, $idc );
		
		return $cotizacion;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalle( $dbh, $idc, $item ){
		//Guarda el registro individual de un ítem del detalle de cotización
		//require_once($_SERVER['DOCUMENT_ROOT'].'/lib/FirePHPCore/fb.php');
		$ptotal = $item->dfcant * $item->dfpunit;
		$q = "insert into detallecotizacion ( IdCotizacion2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idc, $item->idart, '$item->nart', $item->dfcant, '$item->dfund', $item->dfpunit, $ptotal )";
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
	function guardarCotizacion( $dbh, $encabezado ){
		// Guarda el registro de la cotización y solicitud de cotización
		// idCliente2 funciona para indicar cliente o proveedor según el valor del campo tipo de registro (tipo)
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision ); 
		$q = "insert into cotizacion ( numero, tipo, IdCliente2, fecha_emision, pcontacto, observaciones1, 
		observaciones2, observaciones3, iva, Total, validez  ) 
		values ( $encabezado->numero, '$encabezado->tipo', $encabezado->idc, '$fecha_mysql', '$encabezado->pcontacto', 
		'$encabezado->obs1', '$encabezado->obs2', '$encabezado->obs3', $encabezado->iva, $encabezado->total, '$encabezado->cvalidez' )";
		
		echo $q;
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_POST["reg_cotizacion"] ) ){
		include( "bd.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idc = guardarCotizacion( $dbh, $encabezado );
		
		if( ( $idc != 0 ) && ( $idc != "" ) ){
			$exito = guardarDetalleCotizacion( $dbh, $idc, $detalle, $encabezado->iva );
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar detalle de factura";
			}	
		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar factura";
		}

		echo json_encode( $res );
	}
?>
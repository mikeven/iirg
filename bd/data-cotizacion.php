<?php
	/* R&G - Gestión de datos de cotizaciones */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerListaCotizaciones( $link ){
		$lista_c = array();
		$q = "Select IdCotizacion2 as id, numero, date_format(fecha_emision,'%d/%m/%Y') as Fecha, Nombre, Total 
		from cotizacion order by Nombre asc";
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
		
		$q = "select c.numero as nro, c.IdCotizacion2 as idc, c.IdCliente2 as idcliente, c.fecha_emision as femision, c.validez as validez, 
		c.pcontacto as pcontacto, c.iva as iva, c.Observaciones1 as obs1, k.Nombre as nombre, k.Rif as rif, k.Direccion as direccion, 
		k.telefono1 as tlf1, k.telefono2 as tlf2, k.Email as email FROM cotizacion c, cliente k where c.IdCotizacion2 = ".$idc." and c.IdCliente2 = k.IdCliente2";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetalleCotizacion( $dbh, $idc );
		
		return $cotizacion;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalle( $dbh, $idc, $item ){
		//Guarda el registro individual de un ítem del detalle de cotización
		$ptotal = $item->dfcant * $item->dfpunit;
		$q = "insert into detallecotizacion ( IdCotizacion2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idc, $item->idart, '$item->nart', $item->dfcant, '$item->dfund', $item->dfpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarDetalleCotizacion( $dbh, $idc, $detalle, $iva ){
		//Registra los ítems contenidos en el detalle de la cotización
		foreach ( $detalle as $item ){
			guardarItemDetalle( $dbh, $idc, $item, $iva );	
		}
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarCotizacion( $dbh, $encabezado, $detalle ){
		//Guarda el registro de la cotización
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision ); 
		$q = "insert into cotizacion ( numero, IdCliente2, fecha_emision, pcontacto, iva, validez  ) 
		values ( $encabezado->numero, $encabezado->idc, '$fecha_mysql', '$encabezado->pcontacto', $encabezado->iva, '$encabezado->cvalidez' )";
		$data = mysql_query( $q, $dbh );

		//echo $q;

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_POST["reg_cotizacion"] ) ){
		include( "bd.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idc = guardarCotizacion( $dbh, $encabezado, $detalle );
		
		if( ( $idc != 0 ) && ( $idc != "" ) ){
			guardarDetalleCotizacion( $dbh, $idc, $detalle, $encabezado->iva );		
		}
	}
?>
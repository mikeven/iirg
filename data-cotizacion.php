<?php
	/* R&G - Funciones de clentes */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	include( "data-forms.php" );
	/*-----------------------------------------------------------------------------------------------------------------------*/
	
	
	function obtenerListaCotizaciones( $link ){
		$lista_c = array();
		$q = "Select IdCotizacion, date_format(fecha_emision,'%d/%m/%Y') as Fecha, 
				Nombre, Total from cotizacion order by Nombre asc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	
	function guardarItemDetalle( $dbh, $idc, $item, $iva ){
		$q = "insert into detallecotizacion ( IdCotizacion2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, Alicuota  ) 
		values ( $idc, $item->idart, '$item->nart', $item->dfcant, '$item->dfund', $item->dfpunit, $iva )";
		//$data = mysql_query( $q, $dbh );
		echo $q." ";
	}

	function guardarDetalleCotizacion( $dbh, $idc, $detalle, $iva ){
		foreach ( $detalle as $item ) {
			guardarItemDetalle( $dbh, $idc, $item, $iva );	
		}
	}

	function guardarCotizacion( $dbh, $encabezado, $detalle ){
		//Guarda el registro de la cotización
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision ); 
		$q = "insert into cotizacion ( IdCliente2, fecha_emision, pcontacto, iva, validez  ) 
		values ( $encabezado->idc, '$fecha_mysql', '$encabezado->pcontacto', $encabezado->iva, '$encabezado->cvalidez' )";
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_POST["reg_cotizacion"] ) ){
		include( "bd.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idc = 2;//guardarCotizacion( $dbh, $encabezado, $detalle );
		
		if( ( $idc != 0 ) && ( $idc != "" ) ){
			guardarDetalleCotizacion( $dbh, $idc, $detalle, $encabezado->iva );		
		}
	}
?>
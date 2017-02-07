<?php
	/* R&G - Gestión de datos comunes de documentos */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerTotales( $detalle, $pcge ){
	/* Retorna la estructura [subtotal, iva, total] a partir del cálculo en el detalle del documento */
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
	function obtenerTotalesFijos( $encabezado ){
		/* Retorna la estructura de subtotales: subtotal, iva y total a partir de sus valores fijos en la BD */
		$stotal = $encabezado["SubTotal"];
		$iva = $encabezado["iva"]; 

		$totales["subtotal"] = number_format( $stotal, 2, ",", "" ); 
		$totales["iva"] = number_format( $stotal * $iva, 2, ",", "" );
		$totales["total"] = number_format( $stotal + ($stotal * $iva), 2, ",", "" );
		
		return $totales;
	}
?>
<?php
	/* R&G - Gestión de datos comunes de documentos */
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	function idTabla( $tabla ){
		/* Retorna el id de la tabla correspondiente al documento indicado por parámetro */
		$ids = array( "cotizacion" => "IdCotizacion2",
					  "factura" => "IdFactura2",
					  "nota" => "idNota",
					  "orden_compra" => "idOrden" );

		return $ids[$tabla];
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerTotales( $detalle, $pcge ){
	/* Retorna la estructura [subtotal, iva, total] a partir del cálculo en el detalle del documento */
		$subtotal = 0;
		foreach ( $detalle as $d ) {
			$subtotal += ( $d["punit"] * $d["cantidad"] );	
		}

		$totales["subtotal"] = number_format( $subtotal, 2, ".", "" ); 
		$totales["iva"] = number_format( $subtotal * $pcge, 2, ".", "" );
		$totales["total"] = number_format( $subtotal + ($subtotal * $pcge), 2, ".", "" );
		
		return $totales;
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerTotalesFijos( $encabezado ){
		/* Retorna la estructura de subtotales: subtotal, iva y total a partir de sus valores fijos en la BD */
		$stotal = $encabezado["SubTotal"];
		$iva = $encabezado["iva"]; 

		$totales["subtotal"] = number_format( $stotal, 2, ",", "" ); 
		$totales["iva"] = number_format( $stotal * $iva, 2, ",", "" );
		$totales["total"] = number_format( $stotal + ($stotal * $iva), 2, ",", "" );
		
		return $totales;
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function cambiarEstadoDocumento( $link, $id, $tabla, $estado ){

		$idtabla = idTabla( $tabla );
		$campo_fecha = array(
			"aprobada" => "aprobacion", "anulada" => "anulacion", "pagada" => "pago", 
			"vencida" => "vencimiento", "vencida" => "vencimiento"
		);
		$pfecha = "fecha_".$campo_fecha[$estado];
		$q = "Update $tabla set estado = '$estado', $pfecha = NOW() where $idtabla = $id";
		$data = mysql_query( $q, $link );
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function eliminarDetalleDocumento( $link, $tabla, $idtabla, $id_doc ){
		$q = "delete from $tabla WHERE $idtabla = $id_doc";
		$data = mysql_query( $q, $link );
		return mysql_affected_rows();
	}
	/*-------------------------------------------------------------------------------------------------------*/

	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Facturas */
	/* ----------------------------------------------------------------------------------------------------- */
	//Anulación de documento
	if( isset( $_POST["id_doc_estado"] ) ){
		//proviene de fn-hoja-documento.js
		include( "bd.php" );
		cambiarEstadoDocumento( $dbh, $_POST["id_doc_estado"], $_POST["documento"], $_POST["estado"] );
	}
	/*--------------------------------------------------------------------------------------------------------*/
	
?>
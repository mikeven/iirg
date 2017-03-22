<?php
	/* R&G - Gestión de datos comunes de documentos */
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	function mostrarItemDocumento( $ditem, $i ){
		//Muestra un renglón con el ítem de detalle del documento cargado por parámetro
		//nuevo-factura.php, nuevo-nota.php, editar-cotizacion.php, editar-factura.php 
		
		$renglon = "<tr id='it$i'><th>$ditem[descripcion]<input id='idarticulo_$i' 
		name='idart' type='hidden' value='$ditem[ida]' data-nitem='$i'>
		 <input id='ndarticulo_$i' name='nart' type='hidden' value='$ditem[descripcion]' data-nitem='$i'></th>
		 <th><div class='input-group input-space'>
		 <input id='idq_$i' name='dcant' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[cantidad]' 
		 data-nitem='$i' onkeypress='return isIntegerKey(event)' onkeyup='actItemD( this )'></div>
		 </th><th><div class='input-group input-space'>
		 <input id='idund_$i' name='dund' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[und]' data-nitem='$i'></div>
		 </th><th>
		 <div class='input-group input-space'>
		 <input id='idpu_$i' name='dpunit' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[punit]' 
		 	data-nitem='$i' onkeypress='return isNumberKey(event)' onkeyup='actItemD( this )' onblur='initValid()'></div>
		</th><th>
		<div class='input-group input-space'><input id='idpt_$i' name='dptotal' type='text' 
		class='form-control itemtotal_detalle input-sm montoacum' value='$ditem[ptotal]' data-nitem='$i' readonly></div>
		</th><th><button type='button' class='btn btn-block btn-danger btn-xs bedf' onclick='elimItemDetalle(it$i)'>
		<i class='fa fa-times'></i></button></th>
		</tr>";

		return $renglon;
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function idTabla( $tabla ){
		/* Retorna el id de la tabla correspondiente al documento indicado por parámetro */
		$ids = array( "cotizacion" => "IdCotizacion2",
					  "factura" => "IdFactura",
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
		//Actualiza el campo de estado de un documento
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
	function eliminarDetalleDocumento( $link, $tabla, $nombre_idtabla, $id_doc ){
		//Elimina todos los ítems de detalle de un documento de la BD
		$q = "delete from $tabla WHERE $nombre_idtabla = $id_doc";
		$data = mysql_query( $q, $link );
		return mysql_affected_rows();
	}
	/*-------------------------------------------------------------------------------------------------------*/

	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Facturas */
	/* ----------------------------------------------------------------------------------------------------- */
	//Actualización de estado de documento
	if( isset( $_POST["id_doc_estado"] ) ){ //id_doc_estado: proviene de fn-hoja-documento.js
		include( "bd.php" );
		cambiarEstadoDocumento( $dbh, $_POST["id_doc_estado"], $_POST["documento"], $_POST["estado"] );
	}
	/*--------------------------------------------------------------------------------------------------------*/
	
?>
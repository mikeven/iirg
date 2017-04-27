<?php
	/* ----------------------------------------------------------------------------------- */
	/* R&G - Gestión de datos comunes de documentos */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	ini_set( 'display_errors', 1 );
	/* ----------------------------------------------------------------------------------- */
	function obtenerFechaHoy(){
		//Retorna la fecha actual en el formato dd/mm/aaaa
		$fecha_actual = obtenerFechaActual();
		return $fecha_actual["f1"]['fecha'];
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCondiciones( $dbh, $doc, $idu ){
		//Obtiene las condiciones o validez de un documento de acuerdo al usuario en sesión
		$lista_c = array();
		$q = "Select * from condicion where documento = '$doc' and idUsuario = $idu 
		order by valor ASC";
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;			
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerIdCondicion( $dbh, $documento, $nombre ){
		//Obtiene el id de condición a partir de su etiqueta 'nombre'
		$q = "Select valor from condicion where nombre = '$nombre'";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );
		return $data["valor"];
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCondicionDefecto( $dbh, $documento, $idu ){
		//Obtiene el valor y nombre de condición por defecto de sistema de acuerdo al documento
		$q = "Select valor, nombre from condicion where documento = '$documento' and sistema = 1 and idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );
		return $data;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerCondicionPorId( $dbh, $doc, $id ){
		//Obtiene registro de condición a partir de su id de acuerdo al documento indicado
		$q = "Select * from condicion where documento = '$doc' and idCondicion = $id";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );
		return $data;
	}
	/* ----------------------------------------------------------------------------------- */
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
		</th><th><button type='button' class='btn btn-block btn-danger btn-xs bedf blq_bdoc' onclick='elimItemDetalle(it$i)'>
		<i class='fa fa-times'></i></button></th>
		</tr>";

		return $renglon;
	}
	/* ----------------------------------------------------------------------------------- */
	function idTabla( $tabla ){
		/* Retorna el id de la tabla correspondiente al documento indicado por parámetro */
		$ids = array( "cotizacion" => "IdCotizacion2",
					  "factura" => "IdFactura",
					  "nota" => "idNota",
					  "orden_compra" => "idOrden" );

		return $ids[$tabla];
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerFechaFutura( $fecha, $dias ){
		//Obtiene una fecha después de los días especificados
		$fecha_f = date( "Y-m-d", strtotime( "$fecha + $dias day" ) );
		return $fecha_f;
	}
	/* ----------------------------------------------------------------------------------- */
	function agregarFechaVencimiento( $dbh, $encabezado, $doc ){
		//Retorna la fecha de vencimiento de un documento a partir de su fecha de emisión y las condiciones de vencimiento
		//$condicion = obtenerCondicionPorId( $dbh, $doc, $encabezado->idcondicion );
		return obtenerFechaFutura( cambiaf_a_mysql( $encabezado->femision ), $encabezado->vcondicion );
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerTotales( $detalle, $pcge ){
		//Retorna la estructura [subtotal, iva, total] a partir del cálculo en el detalle del documento
		$subtotal = 0;
		foreach ( $detalle as $d ) {
			$subtotal += ( $d["punit"] * $d["cantidad"] );	
		}

		$totales["subtotal"] = number_format( $subtotal, 2, ".", "" ); 
		$totales["iva"] = number_format( $subtotal * $pcge, 2, ".", "" );
		$totales["total"] = number_format( $subtotal + ($subtotal * $pcge), 2, ".", "" );
		
		return $totales;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerTotalesFijos( $encabezado ){
		/* Retorna la estructura [subtotal, iva, total] a partir de sus valores fijos 
		en el encabezado */
		$stotal = $encabezado["SubTotal"];
		$iva = $encabezado["iva"]; 

		$totales["subtotal"] = number_format( $stotal, 2, ".", "" ); 
		$totales["iva"] = number_format( $stotal * $iva, 2, ".", "" );
		$totales["total"] = number_format( $stotal + ($stotal * $iva), 2, ".", "" );
		
		return $totales;
	}
	/* ----------------------------------------------------------------------------------- */
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
	/* ----------------------------------------------------------------------------------- */
	function eliminarDetalleDocumento( $link, $tabla, $nombre_idtabla, $id_doc ){
		//Elimina todos los ítems de detalle de un documento de la BD
		$q = "delete from $tabla WHERE $nombre_idtabla = $id_doc";
		$data = mysql_query( $q, $link );
		return mysql_affected_rows();
	}
	/* ----------------------------------------------------------------------------------- */
	function agregarCondicionDocumento( $dbh, $valor, $documento, $idu ){
		$q = "insert into condicion ( nombre, valor, documento, idUsuario ) 
		values ( '$valor días', $valor, '$documento', $idu )";
		$data = mysql_query( $q, $dbh );

		//echo $q;
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------- */
	function editarCondicion( $dbh, $idc, $valor ){
		//Edita un registro de condición de documento
		$q = "update condicion set valor = $valor, nombre = '$valor días' WHERE idCondicion = $idc";
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();
	}
	/* ----------------------------------------------------------------------------------- */
	function eliminarCondicion( $dbh, $idc ){
		//Elimina un registro de condición de documento dado por su id
		$q = "delete from condicion where idCondicion = $idc";
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();
	}
	/* ----------------------------------------------------------------------------------- */
	function revisarEstadoDocumentos( $dbh, $idu ){
		//Chequea la vigencia de los documentos(cotizaciones y facturas) e invoca 
		//la actualización del estado
		include("data-cotizacion.php");
		$cotizaciones = obtenerListaCotizaciones( $dbh, $idu, "pendiente" );
		foreach ( $cotizaciones as $c ) {
			$dias = $c["dias_validos"];	
		}
	}
	/* ----------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Facturas */
	/* ----------------------------------------------------------------------------------- */
	
	if( isset( $_POST["id_doc_estado"] ) ){ //id_doc_estado: proviene de fn-hoja-documento.js
		//Actualización de estado de un documento
		include( "bd.php" );
		cambiarEstadoDocumento( $dbh, $_POST["id_doc_estado"], $_POST["documento"], $_POST["estado"] );
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_condicion"] ) ){ //id_doc_estado: proviene de fn-hoja-documento.js
		//Registro de condición para documento
		include( "bd.php" );
		$idr = agregarCondicionDocumento( $dbh, $_POST["v"], $_POST["documento"], $_POST["idusuario"] );
		if( ( $idr != 0 ) && ( $idr != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Registro exitoso";
			$res["idr"] = $idr;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar condición de documento";
		}	
		
		echo json_encode( $res );
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["editar_condicion"] ) ){ //id_doc_estado: proviene de fn-hoja-documento.js
		//Eliminación de condición de documento
		include( "bd.php" );
		$idc = $_POST["editar_condicion"];	
		echo editarCondicion( $dbh, $idc, $_POST["val"] );
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["elim_condicion"] ) ){ //id_doc_estado: proviene de fn-hoja-documento.js
		//Eliminación de condición de documento
		include( "bd.php" );
		$idc = $_POST["elim_condicion"];	
		echo eliminarCondicion( $dbh, $idc );
	}
	/* ----------------------------------------------------------------------------------- */
	
?>
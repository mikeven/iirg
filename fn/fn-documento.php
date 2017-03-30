<?php
	/* R&G - Complemento funcional de documento.php y archivos data-(docs).php */
	/*---------------------------------------------------------------------------------------------------------------*/
	/*---------------------------------------------------------------------------------------------------------------*/

	function arrRespuesta( $doc, $ndoc ){
		
		$params_documento = array(
			"solicitud"	=> array (
								"param" => "sctz", "etiqueta" => "Sol. cotización"
							),
			"cotizacion"	=> array (
								"param" => "ctz", "etiqueta" => "Cotización"
							),
			"pedido"		=> array (
								"param" => "ped", "etiqueta" => "Pedido"
							),
			"factura"		=> array (
								"param" => "fac", "etiqueta" => "Factura"
							),
			"orden_compra"	=> array (
								"param" => "odc", "etiqueta" => "Orden de compra"
							),
			"nota"			=> array (
								"param" => "nota&tn=".$doc->tipo, "etiqueta" => "Nota"
							)
		);

		$doc->frm_r = $params_documento[$ndoc];

		return $doc;
	}
	
	/*--------------------------------------------------------------------------------------------------------*/
	
	function iconoEstado( $estado ){

		$icono = array(
			""	=> array("icono" => " fa-sticky-note", "color" => "verde"),
			"pendiente"	=> array("icono" => "fa-clock-o", "color" => "amarillo"),
			"aprobada"	=> array("icono" => "fa-thumbs-up", "color" => "verde"),
			"pagada"	=> array("icono" => "fa-check", "color" => "azul"),
			"vencida"	=> array("icono" => "fa-calendar-times-o", "color" => "gris"),
			"anulada" 	=> array("icono" => "fa-ban", "color" => "rojo")
		);

		return $icono[$estado];	
	}
	
	/*--------------------------------------------------------------------------------------------------------*/
	function admiteCambioEstado( $doc, $encabezado, $accion ){
		//Determina si un documento es anulable
		$admite = true;
		$no_anulables = array( "odc", "ctz", "sctz" );
		
		//Solo se actualizan los documentos con estado 'pendiente'
		if( $encabezado["estado"] != "pendiente" ) $admite = false;
		
		//Orden de compra y solicitudes de cotización: no permite ninguna acción
		if( ($doc == "odc") || ($doc == "sctz") ) $admite = false;
		
		if( in_array( $doc, $no_anulables ) && ( $accion == "anular" ) ) $admite = false;
		
		//Cotización: solo permite aprobación
		if( ( $doc == "ctz" ) && ( $accion != "aprobar" ) ) $admite = false;
		
		//Factura: solo permite pagar o anular
		if( ( $doc == "fac" ) && ( $accion != "marcar_pagada" ) && ( $accion != "anular" ) ) 
			$admite = false;

		//Nota: solo permite anular
		if( ( $doc == "nota" ) && ( $accion != "anular" ) ) $admite = false;

		return $admite;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function enlaceAccion( $documento, $id_doc, $accion, $p ){
	/* Retorna el enlace para modificar/copiar un documento de acuerdo al tipo de documento indicado */
		$ndoc = array(
			"ctz" => "cotizacion", "sctz" => "solicitud-cotizacion",
			"odc" => "orden-compra", "fac" => "factura", "nota" => "nota"
		);
		
		$enlace = $accion."-".$ndoc[$documento].".php?".$p."=".$id_doc;
		return $enlace;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function enlaceCopia( $documento, $id_doc ){
	/* Retorna el enlace para copiar un documento de acuerdo al tipo de documento indicado */
		$ndoc = array(
			"ctz" => "cotizacion", "sctz" => "solicitud-cotizacion",
			"odc" => "orden-compra", "fac" => "factura", "nota" => "nota"
		);
		
		$enlace = "nuevo-".$ndoc[$documento].".php?"."id=".$id_doc;
		return $enlace;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function fechasDocumento( $encabezado ){
		//Retorna el bloque con las fechas registradas de un documento de acuerdo al 
		// tipo de documento para mostrarse en la ficha del mismo
		$bloque_fechas = "";
		$arr_fechas = array( 	
			"femision" => "Emitida", 
			"fregistro" => "Registrada", 
			"fmodificacion" => "Últ. mod.", 
			"faprobacion" => "Aprobada", 
			"fanulacion" => "Anulada", 
			"fpago" => "Pagada"
		);

		while ( $rf = current( $arr_fechas ) ) {
		    $i = key( $arr_fechas );
		    if( ( isset( $encabezado[$i] ) ) && ( $encabezado[$i] != "" ) )
		       $bloque_fechas .= "<div class='fechas_doc'>$rf: $encabezado[$i]</div>";
		    
		    next( $arr_fechas );
		}

		return $bloque_fechas;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	
	if( isset( $_GET["tipo_documento"] ) && ( isset( $_GET["id"] ) ) ){
	    $id = $_GET["id"];
	    $tdd = $_GET["tipo_documento"]; 

	    if( $tdd == "ctz" ){
			$documento = obtenerCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];;
			$detalle_d = $documento["detalle"];
			$tdocumento = "Cotización"; $ftdd = $tdd; $filedoc = "cotizacion";
	    }

	    if( $tdd == "sctz" ){
			$documento = obtenerSolicitudCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Solicitud de Cotización"; $ftdd = $tdd; $filedoc = "cotizacion";
	    }

	    if( $tdd == "ped" ){
			$documento = obtenerPedidoPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Pedido"; $ftdd = $tdd; $filedoc = "pedido";
	    }

		if( $tdd == "odc" ){
			$documento = obtenerOrdenCompraPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Orden de compra"; $ftdd = $tdd; $filedoc = "orden_compra";
	    }

	    if( $tdd == "fac" ){
			$documento = obtenerFacturaPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Factura"; $ftdd = $tdd; $filedoc = "factura";		
	    }
	    if( $tdd == "nota" ){
			$tipo_n = $_GET["tn"];
			$documento = obtenerNotaPorId( $dbh, $id, $tipo_n );
			$encabezado = $documento["encabezado"];

			$t_concepto = $encabezado["tipo_concepto"];
			$detalle_d = $documento["detalle"];

			$tdocumento = etiquetaNota( $tipo_n, "etiqueta" );
			$ftdd = etiquetaNota( $tipo_n, "bd" ); $filedoc = "nota";
			if( $t_concepto != "Ajuste global" )
	    		$totales = obtenerTotales( $detalle_d, $encabezado["iva"] );	//data-documento.php
	    	else
	    		$totales = obtenerTotalesFijos( $encabezado );
	    }

	    $obs1 = $encabezado["obs1"];
		$obs2 = $encabezado["obs2"];
		$obs3 = $encabezado["obs3"];

	    $eiva = $encabezado["iva"] * 100;
	    if( $tdd != "nota" ) //Los totales se calculan para todos los documentos excepto las notas
	    	$totales = obtenerTotales( $detalle_d, $encabezado["iva"] );		//data-documento.php
  	}
  	else{

  	}
	/*--------------------------------------------------------------------------------------------------------*/
?>
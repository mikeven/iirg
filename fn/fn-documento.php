<?php
	/* R&G - Complemento funcional de documento.php y archivos data-(docs).php */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function tipoDocEtiqueta( $etiqueta ){
		$e_documento = array(
			"Cotización" 		=> "ctz",
			"Factura"			=> "fac",
			"Nota"				=> "nota",
			"Orden de compra" 	=> "odc",
			"Sol.Cotiz" 		=> "sctz",
		);
		return $e_documento[$etiqueta];
	}
	/* ----------------------------------------------------------------------------------- */
	function urlParamDoc( $dbh, $nombre, $id ){
		//Retorna el parámetro para la url de un documento: ej: nota&tn=nota_credito 
		$etiqueta = tipoDocEtiqueta( $nombre );
		if( $etiqueta == "nota" ){
			$tn = obtenerTipoNotaPorId( $dbh, $id );
			$etiqueta .= "&tn=$tn";
		}
		return $etiqueta; 
	}
	/* ----------------------------------------------------------------------------------- */
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
			"proforma"		=> array (
								"param" => "fpro", "etiqueta" => "Factura proforma"
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
	/* ----------------------------------------------------------------------------------- */
	function iconoEstado( $estado ){
		//Retorna el ícono acorde al estado de un documento y la clase de estilo denominada por color
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
	/* ----------------------------------------------------------------------------------- */
	function admiteCambioEstado( $doc, $encabezado, $accion ){
		//Determina si un documento es anulable
		$admite = true;
		$no_anulables = array( "odc", "ctz", "sctz", "fpro" );
		
		//Solo se actualizan los documentos con estado 'pendiente'
		if( $encabezado["estado"] != "pendiente" ) $admite = false;

		if( ( $encabezado["estado"] == "vencida" ) && ( $doc == "fac" ) 
			&& ( $accion == "marcar_pagada" || $accion == "anular" ) ) 
			$admite = true; //Pagar facturas vencidas

		if( ( $encabezado["estado"] == "vencida" ) && ( $doc == "ctz" ) && ( $accion == "aprobar" ) ) 
			$admite = true;	//Aprobar cotizaciones vencidas	
		
		//Orden de compra y solicitudes de cotización: no permite ninguna acción
		if( ( $doc == "odc" ) || ( $doc == "sctz") ) $admite = false;
		
		if( in_array( $doc, $no_anulables ) && ( $accion == "anular" ) ) $admite = false;
		
		//Cotización: solo permite aprobación
		if( ( $doc == "ctz" ) && ( $accion != "aprobar" ) ) $admite = false;
		
		//Factura: solo permite pagar o anular
		if( ( $doc == "fac" ) && ( $accion != "marcar_pagada" ) && ( $accion != "anular" ) ) 
			$admite = false;

		//Factura proforma: No permite acciones
		if( ( $doc == "fpro" ) )  $admite = false;

		//Nota: solo permite anular
		if( ( $doc == "nota" ) && ( $accion != "anular" ) ) $admite = false;

		return $admite;
	}
	/* ----------------------------------------------------------------------------------- */
	function esModificable( $dbh, $tdd, $id, $encabezado ){
		//Determina si un documento es modificable
		$modificable = true;
		
		if ( $tdd == "ctz" ) {
			//if ( $encabezado["estado"] == "aprobada" ) $modificable = false;
		}

		if ( $tdd == "fac" ) {
			if( tieneNotaAsociada( $dbh, $id ) ) $modificable = false;
			if ( $encabezado["estado"] == "pagada" ) $modificable = false;
		}
		return $modificable;
	}
	/* ----------------------------------------------------------------------------------- */
	function esCopiable( $tdd ){
		//Determina si se habilita la copia de un documento según el tipo 
		$copiable = true;
		
		if ( $tdd == "fpro" ) $copiable = false;
		
		return $copiable;
	}
	/* ----------------------------------------------------------------------------------- */
	function enlaceAccion( $documento, $id_doc, $accion, $p ){
		//Retorna el enlace para modificar/copiar un documento de acuerdo al tipo indicado
		$ndoc = array(
			"ctz" => "cotizacion", "sctz" => "solicitud-cotizacion",
			"odc" => "orden-compra", "fac" => "factura", "nota" => "nota", 
			"fpro" => "proforma"
		);
		
		$enlace = $accion."-".$ndoc[$documento].".php?".$p."=".$id_doc;
		return $enlace;
	}
	/* ----------------------------------------------------------------------------------- */
	function enlaceCopia( $documento, $id_doc ){
		//Retorna el enlace para copiar un documento de acuerdo al tipo de documento indicado */
		$ndoc = array(
			"ctz" => "cotizacion", "sctz" => "solicitud-cotizacion",
			"odc" => "orden-compra", "fac" => "factura", "nota" => "nota"
		);
		
		$enlace = "nuevo-".$ndoc[$documento].".php?"."id=".$id_doc;
		return $enlace;
	}
	/* ----------------------------------------------------------------------------------- */
	function fechasDocumento( $encabezado ){
		//Retorna el bloque con las fechas registradas de un documento de acuerdo al 
		// tipo de documento para mostrarse en la ficha del mismo
		$bloque_fechas = "";
		$arr_fechas = array( 	
			"femision" => "Emitida",
			"fregistro" => "Registrada", 
			"fvencimiento" => "Vence", 
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
	
	/* ----------------------------------------------------------------------------------- */
	
	if( isset( $_GET["tipo_documento"] ) && ( isset( $_GET["id"] ) ) ){
	    //Asignación de variables para obtener los datos del documento de acuerdo a los parámetros al cargar 
	    //la hoja del documento
	    $id = $_GET["id"];
	    $tdd = $_GET["tipo_documento"]; 
	    $moneda = "BsS";

	    if( $tdd == "ctz" ){	//Cotización
			$documento = obtenerCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Cotización"; $ftdd = $tdd; $filedoc = "cotizacion";
			if( $encabezado["moneda"] == "$") $moneda = "US $";
			$total_comision = obtenerTotalComisionVenta( $detalle_d ); //bd/data-documento.php	
	    }

	    if( $tdd == "sctz" ){	//Solicitud de Cotización
			$documento = obtenerSolicitudCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Solicitud de Cotización"; $ftdd = $tdd; $filedoc = "cotizacion";
	    }

	    if( $tdd == "ped" ){	//Pedido
			$documento = obtenerPedidoPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Pedido"; $ftdd = $tdd; $filedoc = "pedido";
	    }

		if( $tdd == "odc" ){	//Orden de compra
			$documento = obtenerOrdenCompraPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Orden de compra"; $ftdd = $tdd; $filedoc = "orden_compra";
	    }

	    if( $tdd == "fac" ){	//Factura
			$documento = obtenerFacturaPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Factura"; $ftdd = $tdd; $filedoc = "factura";
			$total_comision = obtenerTotalComisionVenta( $detalle_d ); //bd/data-documento.php	
	    }

		if( $tdd == "fpro" ){	//Factura proforma
			$documento = obtenerFacturaProformaPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Fact proforma"; $ftdd = $tdd; $filedoc = "factura_proforma";
	    }

	    if( $tdd == "nota" ){	//Nota
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
	    		$totales = obtenerTotalesFijos( $encabezado );					//data-documento.php
	    }
	    //Bloque de observaciones:
	    $obs1 = $encabezado["obs1"];
		$obs2 = $encabezado["obs2"];
		$obs3 = $encabezado["obs3"];
	    $eiva = $encabezado["iva"] * 100; 

	    if( $tdd != "nota" ) //Los totales se calculan para todos los documentos excepto las notas
	    	$totales = obtenerTotales( $detalle_d, $encabezado["iva"] );		//data-documento.php
  	}
  	else{
  		//Falta el parámetro de documento
  	}
	/* ----------------------------------------------------------------------------------- */
?>
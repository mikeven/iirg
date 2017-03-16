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
			"pendiente"	=> "clock-o",
			"aprobada"	=> "check",
			"pagado"	=> "check",
			"anulada" 	=> "ban"
		);

		return $icono["$estado"];	
	}
	
	/*--------------------------------------------------------------------------------------------------------*/
	
	function enlaceEdicion( $documento, $id_doc ){
	/* Retorna el enlace para modificar un documento de acuerdo al tipo de documento indicado */
		$ndoc = array(
			"ctz" => "cotizacion", "sctz" => "solicitud-cotizacion",
			"odc" => "orden-compra", "fac" => "factura", "nota" => "nota"
		);
		
		$enlace = "editar-".$ndoc[$documento].".php?"."id=".$id_doc;
		return $enlace;
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
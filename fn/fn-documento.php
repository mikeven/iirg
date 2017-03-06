<?php
	/* R&G - Complemento funcional de documento.php */
	/*---------------------------------------------------------------------------------------------------------------*/
	/*---------------------------------------------------------------------------------------------------------------*/
	if( isset( $_GET["tipo_documento"] ) && ( isset( $_GET["id"] ) ) ){
	    $id = $_GET["id"];
	    $tdd = $_GET["tipo_documento"]; 

	    if( $tdd == "ctz" ){
			$documento = obtenerCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];;
			$detalle_d = $documento["detalle"];
			$tdocumento = "Cotización"; $ftdd = $tdd;
	    }

	    if( $tdd == "sctz" ){
			$documento = obtenerSolicitudCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Solicitud de Cotización"; $ftdd = $tdd;
	    }

	    if( $tdd == "ped" ){
			$documento = obtenerPedidoPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Pedido"; $ftdd = $tdd;
	    }

		if( $tdd == "odc" ){
			$documento = obtenerOrdenCompraPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Orden de compra"; $ftdd = $tdd;
	    }

	    if( $tdd == "fac" ){
			$documento = obtenerFacturaPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			
			$tdocumento = "Factura"; $ftdd = $tdd;			
	    }
	    if( $tdd == "nota" ){
			$tipo_n = $_GET["tn"];
			$documento = obtenerNotaPorId( $dbh, $id, $tipo_n );
			$encabezado = $documento["encabezado"];

			$t_concepto = $encabezado["tipo_concepto"];
			$detalle_d = $documento["detalle"];

			$tdocumento = etiquetaNota( $tipo_n, "etiqueta" );
			$ftdd = etiquetaNota( $tipo_n, "bd" );
			if( $t_concepto != "Ajuste global" )
	    		$totales = obtenerTotales( $detalle_d, $encabezado["iva"] );
	    	else
	    		$totales = obtenerTotalesFijos( $encabezado );
	    }

	    $obs1 = $encabezado["obs1"];
		$obs2 = $encabezado["obs2"];
		$obs3 = $encabezado["obs3"];

	    $eiva = $encabezado["iva"] * 100;
	    if( $tdd != "nota" ) //Los totales se calculan para todos los documentos excepto las notas
	    	$totales = obtenerTotales( $detalle_d, $encabezado["iva"] );
  	}
  	else{

  	}
	/*--------------------------------------------------------------------------------------------------------*/
?>
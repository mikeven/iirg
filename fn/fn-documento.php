<?php
	/* R&G - Complemento funcional de documento.php */
	/*---------------------------------------------------------------------------------------------------------------*/
	/*---------------------------------------------------------------------------------------------------------------*/
	if( isset( $_GET["tipo_documento"] ) && ( isset( $_GET["id"] ) ) ){
	    $id = $_GET["id"];
	    $tdd = $_GET["tipo_documento"]; 

	    if( $tdd == "ctz" ){
			$documento = obtenerCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$obs1 = $encabezado["obs1"];
			$obs2 = $encabezado["obs2"];
			$obs3 = $encabezado["obs3"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Cotización"; $ftdd = $tdd;
	    }

	    if( $tdd == "sctz" ){
			$documento = obtenerCotizacionPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$obs1 = $encabezado["obs1"];
			$obs2 = $encabezado["obs2"];
			$obs3 = $encabezado["obs3"];
			$detalle_d = $documento["detalle"];
			$tdocumento = "Solicitud de Cotización"; $ftdd = $tdd;
	    }

	    if( $tdd == "ped" ){
			$documento = obtenerPedidoPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$obs1 = $encabezado["obs1"];
			$obs2 = $encabezado["obs2"];
			$obs3 = "";
			$tdocumento = "Pedido"; $ftdd = $tdd;
	    }
	    if( $tdd == "fac" ){
			$documento = obtenerFacturaPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];
			$detalle_d = $documento["detalle"];
			$obs1 = $encabezado["obs1"];
			$obs2 = $encabezado["obs2"];
			$obs3 = $encabezado["obs3"];
			$tdocumento = "Factura"; $ftdd = $tdd;			
	    }
	    if( $tdd == "nota" ){
			$documento = obtenerNotaPorId( $dbh, $id );
			$encabezado = $documento["encabezado"];

			$t_concepto = $encabezado["tipo_concepto"];
			$detalle_d = $documento["detalle"];
			$tipo_n = $encabezado["tipo"];
			$obs1 = "";
			$obs2 = $encabezado["concepto"];
			$obs3 = "";
			$tdocumento = etiquetaNota( $tipo_n );
			$ftdd = $tipo_n;
			if( $t_concepto != "Ajuste global" )
	    		$totales = obtenerTotales( $detalle_d, $encabezado["iva"] );
	    	else
	    		$totales = obtenerTotalesFijos( $encabezado );
	    }

	    $eiva = $encabezado["iva"] * 100;
	    if( $tdd != "nota" )
	    	$totales = obtenerTotales( $detalle_d, $encabezado["iva"] );
	    $enlace_imp = "impresion.php?tipo_documento=$tdd&id=$id";
  	}
  else{

  }
/*--------------------------------------------------------------------------------------------------------*/
function etiquetaNota( $tipo ){
	$etiquetas = array(	
		"nota_entrega" => "Nota de entrega", 
		"nota_debito" => "Nota de débito", 
		"nota_credito" => "Nota de crédito"
	);
	return $etiquetas[$tipo]; 
}
/*--------------------------------------------------------------------------------------------------------*/
?>
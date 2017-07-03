<?php
	/* R&G - Funciones de reportes */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function reporteEncabezado( $reporte ){
		//Retorna los campos de encabezado de las tablas de reporte
		$encabezados = array(
			"relacion_gastos" => array ("FECHA", "CONCEPTO", "BENEFICIARIO", "BANCO", "F.PAGO", "NRO", "MONTO"),
			"pago_facturas" => array (""),
			"libro_ventas" => array (""),
			"libro_compras" => array (""),
			"facturas_porcobrar" => array ("")
		);

		return $encabezados[$reporte];
	}
	/* ----------------------------------------------------------------------------------- */
	function filaRegistros( $nreporte, $r ){
		//Retorna un registro de reporte bajo el esquema de encabezado de tabla
		$filas = array(
			"relacion_gastos" => array ( $r["fpago"], $r["concepto"], $r["beneficiario"], 
										 $r["banco"], $r["forma_pago"], $r["noperacion"],
										number_format( $r["monto"], 2, ",", "." ) ),
			"pago_facturas" => array (""),
			"libro_ventas" => array (""),
			"libro_compras" => array (""),
			"facturas_porcobrar" => array ("")
		);

		return $filas[$nreporte];
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerPosicionEncabezado( $nreporte, $titulo ){
		//Retorna la posición de un título de encabezado de la tabla de reporte
		$encabezado = reporteEncabezado( $nreporte );
		return array_search( $titulo, $encabezado );
	}
	/* ----------------------------------------------------------------------------------- */
	function ubicacionTotales( $nreporte ){
		// Retorna la posición y el campo de los totales en la tabla del reporte de acuerdo 
		// al título de encabezado 
		$utotales = array();
		$vtotales = array(
			"relacion_gastos" => array ( "MONTO*monto" ),
			"pago_facturas" => array (""),
			"libro_ventas" => array (""),
			"libro_compras" => array (""),
			"facturas_porcobrar" => array ("")
		);

		foreach ( $vtotales[$nreporte] as $total ) {
			$campo = explode( "*", $total ); //[0]: título encabezado, [1]: campo 
			$utotal["posicion"] = $campo[0];
			$utotal["campo"] = $campo[1];
			$utotales[] = $utotal;
		}

		return $utotales;

	}
	/* ----------------------------------------------------------------------------------- */
	function reporteRegistros( $nreporte, $data ){
		//Retorna los registros del reporte solicitado bajo el esquema de la tabla de reporte
		$registros = array();		

		foreach ( $data as $r ) {
			$registros[] = filaRegistros( $nreporte, $r );
		}
		return $registros;
	}
	/* ----------------------------------------------------------------------------------- */
	function totalesReporte( $nreporte, $reporte_data ){
		//Retorna los registros del reporte solicitado bajo el esquema de la tabla de reporte

		$vtotales = array(); 	// Vector de totales [posicion, total]
		$vt = array();			// Vector de total [posicion, total]
		
		$utotales = ubicacionTotales( $nreporte );	//vector de campos y posiciones de totales 	
		foreach ( $utotales as $u ) {
			$total = 0; $vt["posicion"] = $u["posicion"];
			foreach ( $reporte_data as $r ) {
				$total += $r[ $u["campo"] ]; 
			}   $vt["total"] = number_format( $total, 2, ",", "." );
			$vtotales[] = $vt;	
		}
		
		return $vtotales;
	}
	/* ----------------------------------------------------------------------------------- */
?>
<?php
	/* R&G - Funciones de reportes */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	
	function tituloReporte( $nreporte ){
		
		$titulos = array(
			"relacion_gastos" => "INFORME DE GASTOS",
			"relacion_proveedores" => "RELACIÓN DE PROVEEDORES CON RETENCIÓN",
			"pago_facturas" => "INFORME DE PAGO DE FACTURAS",
			"libro_ventas" => "INFORME DE PAGO DE FACTURAS",
			"libro_compras" => "LIBRO DE COMPRA",
			"facturas_porcobrar" => "FACTURAS POR COBRAR"
		);

		return $titulos[$nreporte];	
	}
	/* ----------------------------------------------------------------------------------- */
	function cambiarFormatoFecha( $dbh, $fecha ){
		$q = "select date_format('$fecha','%d/%m/%Y') as fecha";
		$data = mysql_fetch_array( mysql_query( $q, $dbh ) );
		
		return $data["fecha"];
	}
	/* ----------------------------------------------------------------------------------- */
	function reporteEncabezado( $reporte ){
		//Retorna los campos de encabezado de las tablas de reporte
		$encabezados = array(
			"relacion_gastos" => array ("FECHA", "CONCEPTO", "BENEFICIARIO", "BANCO", "F.PAGO", "NRO", "MONTO"),
			
			"relacion_proveedores" => array ("FECHA", "PROVEEDOR", "RIF", "N° FACT", "CONTROL", "N° RET", 
			"BASE IMPON", "IVA", "TOTAL", "RETENCIÓN"),

			"pago_facturas" => array ("FECHA", "CONCEPTO", "BENEFICIARIO", "BANCO", "F.PAGO", "NRO", "MONTO", "MONTO PAGADO"),
			
			"libro_ventas" => array ("FECHA", "CLIENTE", "RIF", "N° FACT", "CONTROL", "MONTO", "IVA", "RET"),
			"libro_compras" => array ("FECHA", "PROVEEDOR", "RIF", "N° FACT", "CONTROL", "MONTO", "IVA", "TOTAL"),
			
			"facturas_porcobrar" => array ("N° FACT", "FECHA EMISION", "FECHA VENC", "CLIENTE", "MONTO", "IVA", "RET", "TOTAL")
		);

		return $encabezados[$reporte];
	}
	/* ----------------------------------------------------------------------------------- */
	function filaRegistros( $nreporte, $r ){
		//Retorna un registro de reporte bajo el esquema de encabezado de tabla
		if( $nreporte == "relacion_gastos" )
			$freporte = array ( $r["fpago"], $r["concepto"], $r["beneficiario"], 
								$r["banco"], $r["forma_pago"], $r["noperacion"],
								number_format( $r["monto"], 2, ",", "." ) );

		if( $nreporte == "relacion_proveedores" )
			$freporte = array ( $r["femision"], $r["proveedor"], $r["rif"], $r["nfactura"], 
				$r["ncontrol"], $r["nret"], number_format( $r["mbase"], 2, ",", "." ), 
				number_format( $r["miva"], 2, ",", "." ), 
				number_format( $r["mtotal"], 2, ",", "." ),
				number_format( $r["mretencion"], 2, ",", "." ) );
		
		if( $nreporte == "pago_facturas" ) 
			$freporte = array ( $r["fpago"], $r["concepto"], $r["beneficiario"], 
								$r["banco"], $r["forma_pago"], $r["noperacion"],
								number_format( $r["monto"], 2, ",", "." ), 
								number_format( $r["monto_pagado"], 2, ",", "." ) );
		
		if( $nreporte == "libro_ventas" )	
			$freporte = array ($r["femision"], $r["cliente"], $r["rif"], $r["numero"], "", 
									   number_format( $r["monto"], 2, ",", "." ),
									   number_format( $r["miva"], 2, ",", "." ), 
									   number_format( $r["mretencion"], 2, ",", "." ));

		if( $nreporte == "libro_compras" )
			$freporte = array ( $r["femision"], $r["proveedor"], $r["rif"], $r["nfactura"], 
									   $r["ncontrol"], number_format( $r["mbase"], 2, ",", "." ),
									   number_format( $r["miva"], 2, ",", "." ), 
									   number_format( $r["mtotal"], 2, ",", "." ) );
		
		if( $nreporte == "facturas_porcobrar" ) 
			$freporte = array ( $r["numero"], $r["femision"], $r["fvencimiento"], $r["cliente"], 
									   number_format( $r["monto"], 2, ",", "." ),
									   number_format( $r["miva"], 2, ",", "." ), 
									   number_format( $r["mtotal"], 2, ",", "." ) );
		

		return $freporte;
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
			"relacion_proveedores" => array ( "RETENCIÓN*mretencion" ),
			"pago_facturas" => array ("MONTO*monto", "MONTO PAGADO*monto_pagado"),
			"libro_ventas" => array ("MONTO*monto", "IVA*miva", "RET*mretencion"),
			"libro_compras" => array ("MONTO*mbase", "IVA*miva", "TOTAL*mtotal"),
			"facturas_porcobrar" => array ("MONTO*mtotal")
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
			}   
			$vt["total"] = number_format( $total, 2, ",", "." );
			$vtotales[] = $vt;	
		}
		
		return $vtotales;
	}
	/* ----------------------------------------------------------------------------------- */
?>
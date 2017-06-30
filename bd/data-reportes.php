<?php
	/* R&G - Gestión de datos comunes de documentos */
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	function reporteEncabezado( $reporte ){
		//Retorna los campos de encabezado de las tablas de reporte
		$encabezados = array(
			"relacion_gastos" => array ("FECHA", "CONCEPTO", "BENEFICIARIO", "MONTO", "BANCO", "F/P", "N°"),
			"pago_facturas" => array (""),
			"libro_ventas" => array (""),
			"libro_compras" => array (""),
			"facturas_porcobrar" => array ("")
		);

		return $encabezados[$reporte];
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerFechaHoy(){
		//Retorna la fecha actual en el formato dd/mm/aaaa
		$fecha_actual = obtenerFechaActual();
		return $fecha_actual["f1"]['fecha'];
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerReporteRelacionGastos( $dbh, $fecha_i, $fecha_f, $idu ){
		$lista_g = array();
		$q = "select idGasto, tipo, beneficiario, concepto, 
		date_format(fecha_pago,'%d/%m/%Y') as fpago, 
		date_format(fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		banco, monto, monto_pagado, forma_pago, noperacion from gasto 
		where ( fecha_pago BETWEEN '$fecha_i' AND '$fecha_f' ) and idUsuario = $idu";		
		
		$data = mysql_query( $q, $dbh );
		while( $g = mysql_fetch_array( $data ) ){
			$lista_g[] = $g;	
		}
		return $lista_g;
	}
	/*-------------------------------------------------------------------------------------------------------*/
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reporte"] ) ){ 
		//Invocación a obtención de reporte
		include( "bd.php" );
		$idu = $_POST["id_u"];
		$nombre_reporte = $_POST["reporte"];	
		if( $nombre_reporte == "relacion_gastos" ){
			$reporte["data"] = obtenerReporteRelacionGastos( $dbh, $_POST["f_ini"], $_POST["f_fin"], $idu );
			$reporte["encabezado"] = reporteEncabezado( $nombre_reporte );
			echo json_encode( $reporte );
		}
	}
	/* ----------------------------------------------------------------------------------------------------- */
	
?>
<?php
	/* R&G - Gestión de datos comunes de documentos */
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
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
		where ( fecha_pago BETWEEN '$fecha_i' AND '$fecha_f' ) and tipo='gasto' and idUsuario = $idu";		
		
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
		include( "../fn/fn-reportes.php" );

		$idu = $_POST["id_u"];
		$nombre_reporte = $_POST["reporte"];	
		if( $nombre_reporte == "relacion_gastos" ){			
			$reporte_data = obtenerReporteRelacionGastos( $dbh, $_POST["f_ini"], $_POST["f_fin"], $idu );
			$reporte["encabezado"] = reporteEncabezado( $nombre_reporte );
			$reporte["registros"] = reporteRegistros( $nombre_reporte, $reporte_data );
			$reporte["totales"] = totalesReporte( $nombre_reporte, $reporte_data );
			echo json_encode( $reporte );
		}
	}
	/* ----------------------------------------------------------------------------------------------------- */
	
?>
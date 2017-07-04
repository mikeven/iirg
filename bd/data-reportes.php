<?php
	/* R&G - Gestión de datos para reportes */
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
	function obtenerReporteRelacionGastos( $dbh, $tipo, $fecha_i, $fecha_f, $idu ){
		$lista_g = array();
		$q = "select idGasto, tipo, beneficiario, concepto, 
		date_format(fecha_pago,'%d/%m/%Y') as fpago, 
		date_format(fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		banco, monto, monto_pagado, forma_pago, noperacion from gasto 
		where ( fecha_pago BETWEEN '$fecha_i' AND '$fecha_f' ) and tipo='$tipo' and idUsuario = $idu 
		order by fecha_pago asc";		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		while( $g = mysql_fetch_array( $data ) ){
			$lista_g[] = $g;	
		}
		return $lista_g;
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerReporteVentas( $dbh, $tipo, $fecha_i, $fecha_f, $idu ){
		//Retorna la fecha actual en el formato dd/mm/aaaa
		$lista_f = array();
		$q = "Select F.IdFactura as id, F.numero as numero, F.estado as estado, 
		C.idCliente as idc, C.Nombre as cliente, F.valor_condicion as vcondicion, 
		date_format(F.fecha_emision,'%d/%m/%Y') as Fecha, F.total as Total 
		From factura F, cliente C where ( fecha_pago BETWEEN '$fecha_i' AND '$fecha_f' ) 
		and F.IdCliente = C.idCliente and idUsuario = $idu and estado = 'pagada' order by F.fecha_emision asc";
		
		$data = mysql_query( $q, $dbh );
		while( $f = mysql_fetch_array( $data ) ){
			$lista_f[] = $f;	
		}
		return $lista_f;
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerReporteCompras( $dbh, $fecha_i, $fecha_f, $idu ){
		//Devuelve registro de artículo dado el ID
		$lista_c = array();
		$q = "select c.idCompra as idcompra, c.monto as mbase, (c.monto * c.iva/100) as miva, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, ((c.monto * c.iva/100) + c.monto) as mtotal,
		date_format(c.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		c.ncontrol as ncontrol, c.nfactura as nfactura, p.rif as rif, p.Nombre as proveedor 
		from proveedor p, compra c where ( c.fecha_emision BETWEEN '$fecha_i' AND '$fecha_f' ) and 
		c.idProveedor = p.idProveedor and c.idUsuario = $idu and estado = 'creada'";
		
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}

	/*-------------------------------------------------------------------------------------------------------*/
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reporte"] ) ){ 
		//Invocación a obtención de reporte
		include( "bd.php" );
		include( "../fn/fn-reportes.php" );

		$idu = $_POST["id_u"];
		$nombre_reporte = $_POST["reporte"];	
		if( $nombre_reporte == "relacion_gastos" )		
			$reporte_data = obtenerReporteRelacionGastos( $dbh, $_POST["tipo"], $_POST["f_ini"], $_POST["f_fin"], $idu );
		if( $nombre_reporte == "pago_facturas" )		
			$reporte_data = obtenerReporteRelacionGastos( $dbh, $_POST["tipo"], $_POST["f_ini"], $_POST["f_fin"], $idu );
		if( $nombre_reporte == "libro_ventas" )		
			$reporte_data = obtenerReporteLibroVentas( $dbh, $_POST["f_ini"], $_POST["f_fin"], $idu );
		if( $nombre_reporte == "libro_compras" )		
			$reporte_data = obtenerReporteCompras( $dbh, $_POST["f_ini"], $_POST["f_fin"], $idu );

		$reporte["encabezado"] = reporteEncabezado( $nombre_reporte );
		$reporte["registros"] = reporteRegistros( $nombre_reporte, $reporte_data );
		$reporte["totales"] = totalesReporte( $nombre_reporte, $reporte_data );
		echo json_encode( $reporte );
	}
	/* ----------------------------------------------------------------------------------------------------- */
	
?>
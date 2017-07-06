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
	function ajustarValoresLV( $lista_r ){
		$lista = array();
		foreach ( $lista_r as $r ) {
			if( $r["estado"] == "anulada" ){
				$r["cliente"] = "ANULADA";
				$r["rif"] = "";
				$r["monto"] = 0.00;
				$r["miva"] = 0.00;
				$r["mretencion"] = 0.00;			
			}
			$lista[] = $r;	
		}
		return $lista;
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerReporteLibroVentas( $dbh, $fecha_i, $fecha_f, $pret, $idu ){
		//
		$lista_f = array();
		$q = "Select F.IdFactura as id, F.numero as numero, F.estado as estado, 
		C.idCliente as idc, C.Nombre as cliente, C.rif as rif, F.valor_condicion as vcondicion, 
		date_format(F.fecha_emision,'%d/%m/%Y') as femision, ($pret * (F.SubTotal * F.iva)) AS mretencion,  
		F.SubTotal as monto, ((F.SubTotal * F.iva)) as miva, F.Total as mtotal 
		From factura F, cliente C where ( F.fecha_emision BETWEEN '$fecha_i' AND '$fecha_f' ) 
		and F.IdCliente = C.idCliente and idUsuario = $idu order by F.fecha_emision asc";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		while( $f = mysql_fetch_array( $data ) ){
			$lista_f[] = $f;	
		}
		return ajustarValoresLV( $lista_f );
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerReporteCompras( $dbh, $fecha_i, $fecha_f, $idu ){
		//
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
	function obtenerReporteRelacionProveedores( $dbh, $fecha_i, $fecha_f, $idu ){
		//
		$lista_c = array();
		$q = "select c.idCompra as idcompra, c.monto as mbase, c.iva as iva, ((c.monto * c.iva/100)) as miva, 
		date_format(c.fecha_emision,'%d/%m/%Y') as femision, ((c.monto * c.iva/100) + c.monto) as mtotal, 
		((c.iva*c.monto/100)*c.retencion) as mretencion, 
		date_format(.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, c.num_retencion as nret,  
		c.ncontrol as ncontrol, c.nfactura as nfactura, p.rif as rif, p.Nombre as proveedor 
		from proveedor p, compra c 
		where ( c.fecha_emision BETWEEN '$fecha_i' AND '$fecha_f' ) and 
		c.idProveedor = p.idProveedor and c.idUsuario = $idu and estado = 'pagada'";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*-------------------------------------------------------------------------------------------------------*/
	function obtenerReporteFacturasPorCobrar( $dbh, $fecha_i, $fecha_f, $idu ){
		//
		$lista_f = array();
		$q = "Select F.IdFactura as id, F.numero as numero, F.estado as estado, 
		C.idCliente as idc, C.Nombre as cliente, C.rif as rif, F.valor_condicion as vcondicion, 
		date_format(F.fecha_emision,'%d/%m/%Y') as femision,  
		date_format(F.fecha_vencimiento,'%d/%m/%Y') as fvencimiento, 
		((F.total / (1+F.iva) ) ) as monto, ((F.SubTotal * F.iva)) as miva, F.total as mtotal 
		From factura F, cliente C where ( F.fecha_emision BETWEEN '$fecha_i' AND '$fecha_f' ) and 
		F.IdCliente = C.idCliente and idUsuario = $idu and estado='pendiente' order by F.fecha_emision asc";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		while( $f = mysql_fetch_array( $data ) ){
			$lista_f[] = $f;	
		}
		return $lista_f;	
	}

	/*-------------------------------------------------------------------------------------------------------*/
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reporte"] ) ){ 
		//Invocación a obtención de reporte
		include( "bd.php" );
		include( "data-sistema.php" );
		include( "../fn/fn-reportes.php" );

		$idu = $_POST["id_u"];
		$nombre_reporte = $_POST["reporte"];	
		
		if( $nombre_reporte == "relacion_gastos" )		
			$reporte_data = obtenerReporteRelacionGastos( $dbh, $_POST["tipo"], $_POST["f_ini"], 
			$_POST["f_fin"], $idu );
		
		if( $nombre_reporte == "relacion_proveedores" )		
			$reporte_data = obtenerReporteRelacionProveedores( $dbh, $_POST["f_ini"], $_POST["f_fin"], $idu );
		
		if( $nombre_reporte == "pago_facturas" )		
			$reporte_data = obtenerReporteRelacionGastos( $dbh, $_POST["tipo"], $_POST["f_ini"], 
			$_POST["f_fin"], $idu );
		
		if( $nombre_reporte == "libro_ventas" )		
			$reporte_data = obtenerReporteLibroVentas( $dbh, $_POST["f_ini"], $_POST["f_fin"], $sisval_ret, $idu );
		
		if( $nombre_reporte == "libro_compras" )		
			$reporte_data = obtenerReporteCompras( $dbh, $_POST["f_ini"], $_POST["f_fin"], $idu );

		if( $nombre_reporte == "facturas_porcobrar" )		
			$reporte_data = obtenerReporteFacturasPorCobrar( $dbh, $_POST["f_ini"], $_POST["f_fin"], $idu );

		//print_r($reporte_data);
		$reporte["encabezado"] = reporteEncabezado( $nombre_reporte );
		$reporte["registros"] = reporteRegistros( $nombre_reporte, $reporte_data );
		$reporte["totales"] = totalesReporte( $nombre_reporte, $reporte_data );
		echo json_encode( $reporte );
	}
	/* ----------------------------------------------------------------------------------------------------- */
	
?>
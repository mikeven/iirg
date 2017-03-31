<?php
	/* R&G - Funciones de clentes */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/	
	function obtenerListaFacturas( $link, $idu ){
		$lista_f = array();
		$q = "Select F.IdFactura as id, F.numero as numero, F.estado as estado, C.IdCliente2 as idc, C.Nombre as cliente, 
		date_format(F.fecha_emision,'%d/%m/%Y') as Fecha, F.total as Total from factura F, cliente C 
		where F.IdCliente2 = C.IdCliente2 and idUsuario = $idu order by F.fecha_emision desc";
		$data = mysql_query( $q, $link );
		while( $f = mysql_fetch_array( $data ) ){
			$lista_f[] = $f;	
		}
		return $lista_f;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerProximoNumeroFactura( $dbh, $idu ){
		$q = "select MAX(numero) as num from factura where idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerDetalleFactura( $dbh, $idf ){
		// Obtiene los ítems del detalle de una factura
		$detalle = array();
		$q = "select IdDetalle as idd, IdArticulo as ida, Descripcion as descripcion, Cantidad as cantidad, 
		PrecioUnit as punit, PrecioTotal as ptotal, und from detallefactura where IdFactura = $idf";
		
		$data = mysql_query( $q, $dbh );
		while( $item = mysql_fetch_array( $data ) ){
			$detalle[] = $item;	
		}
		return $detalle;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerFacturaPorId( $dbh, $idf ){
		//Retorna el registro de factura y sus ítems de detalle
		$q = "select f.numero as nro, f.IdFactura as idf, f.estado as estado, f.IdCliente2 as idcliente, 
		f.idCotizacion as idc, DATE_FORMAT(f.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(f.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, DATE_FORMAT(f.fecha_pago,'%d/%m/%Y %h:%i %p') as fpago, 
		DATE_FORMAT(f.fecha_anulacion,'%d/%m/%Y %h:%i %p') as fanulacion, 
		DATE_FORMAT(f.fecha_modificacion,'%d/%m/%Y %h:%i %p') as fmodificacion, 
		DATE_FORMAT(f.fecha_vencimiento,'%d/%m/%Y') as fvencimiento, f.iva as iva, f.orden_compra as oc, 
		cd.valor as vcondicion, cd.nombre as condicion, f.introduccion as intro, f.Observaciones as obs0, 
		f.Observaciones1 as obs1, f.Observaciones2 as obs2, f.Observaciones3 as obs3, c.Nombre as nombre, 
		c.Rif as rif, c.direccion1 as dir1, c.direccion2 as dir2, c.telefono1 as tlf1, c.telefono2 as tlf2, 
		c.Email as email FROM factura f, cliente c, condicion cd 
		WHERE f.IdFactura = ".$idf." and f.IdCliente2 = c.IdCliente2 and f.idCondicion = cd.idCondicion";
		
		$factura["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$factura["detalle"] = obtenerDetalleFactura( $dbh, $idf );
		
		return $factura;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalleF( $dbh, $idf, $item ){
		//Guarda el registro individual de un ítem del detalle de pedido
		$ptotal = $item->dcant * $item->dpunit;
		$q = "insert into detallefactura ( IdFactura, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idf, $item->idart, '$item->nart', $item->dcant, '$item->dund', $item->dpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarDetalleFactura( $dbh, $idf, $detalle ){
		//Registra los ítems contenidos en el detalle de la factura
		$exito = true;
		$nitems = count( $detalle );
		$citem = 0;
		foreach ( $detalle as $item ){
			$id_item = guardarItemDetalleF( $dbh, $idf, $item );
			if( $id_item != 0 ) $citem++;
		}
		
		if( $citem != $nitems ) $exito = false;
		
		return $exito;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarFactura( $dbh, $encabezado, $detalle, $idu ){
		//Guarda el registro de una factura
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$fecha_mysqlv = $encabezado->fvencimiento;
		$total = number_format( $encabezado->total, 2, ".", "" );
		if( !$encabezado->idcotizacion ) $encabezado->idcotizacion = "NULL";
		$q = "insert into factura ( numero, orden_compra, estado, idCondicion, idCotizacion, IdCliente2, fecha_emision, fecha_vencimiento, 
			introduccion, observaciones, observaciones1, observaciones2, observaciones3, iva, Total, fecha_registro, idUsuario ) 
			values ( $encabezado->numero, '$encabezado->noc', '$encabezado->estado', $encabezado->idcondicion, $encabezado->idcotizacion, 
			$encabezado->idcliente, '$fecha_mysql', '$fecha_mysqlv', '$encabezado->introduccion', '$encabezado->obs0', '$encabezado->obs1', 
			'$encabezado->obs2', '$encabezado->obs3', $encabezado->iva, $encabezado->total, NOW(), $idu )";
		$data = mysql_query( $q, $dbh );

		//echo $q;
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function editarFactura( $dbh, $encabezado, $idu ){
		
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$q = "update factura set idCliente2 = $encabezado->idcliente, fecha_emision = '$fecha_mysql', 
		SubTotal = $encabezado->subtotal, Total = $encabezado->total, fecha_modificacion = NOW(), 
		idCondicion = $encabezado->idcondicion WHERE idFactura = $encabezado->idr and idUsuario = $idu";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();	
	}
	
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Facturas */
	/* ----------------------------------------------------------------------------------------------------- */
	
	//Registro de nueva factura
	if( isset( $_POST["reg_factura"] ) ){
		
		include( "bd.php" );
		include( "../fn/fn-documento.php" );
		include( "../bd/data-documento.php" );

		$encabezado = json_decode( $_POST["encabezado"] );
		$encabezado->fvencimiento = agregarFechaVencimiento( $dbh, $encabezado, "factura" );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idf = guardarFactura( $dbh, $encabezado, $detalle, $encabezado->idu );
		
		if( ( $idf != 0 ) && ( $idf != "" ) ){
			$exito = guardarDetalleFactura( $dbh, $idf, $detalle );
			if( !isset( $encabezado->tipo ) )  $encabezado->tipo = "";
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$encabezado->idr = $idf;
				$res["documento"] = arrRespuesta( $encabezado, "factura" );
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar detalle de factura";
			}	
		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar factura";
		}
		
		echo json_encode( $res );
	}

	//Edición de factura
	if( isset( $_POST["edit_factura"] ) ){
		
		include( "bd.php" );
		include( "data-documento.php" );
		include( "../fn/fn-documento.php" );
		
		$encabezado = json_decode( $_POST["encabezado"] );
		$encabezado->tipo = "factura";
		$detalle = json_decode( $_POST["detalle"] );
		$r_edit = editarFactura( $dbh, $encabezado, $encabezado->idu );
		
		if( $r_edit != -1 ){
			
			eliminarDetalleDocumento( $dbh, "detallefactura", "idFactura", $encabezado->idr );
			$exito = guardarDetalleFactura( $dbh, $encabezado->idr, $detalle, $encabezado->iva );
			
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$res["documento"] = arrRespuesta( $encabezado, $encabezado->tipo );
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al editar detalle de factura";
			}

		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al editar factura";
		}

		echo json_encode( $res );
	}
	/*--------------------------------------------------------------------------------------------------------*/

	
<?php
	/* R&G - Gestión de datos de órdenes de compra */
	/* ------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------- */
	ini_set( 'display_errors', 1 );
	/* ------------------------------------------------------------------------------- */
	function obtenerListaOrdenesCompra( $link, $idu ){
		$lista_o = array();
		$q = "Select o.idOrden as ido, o.numero as numero, p.Nombre as Nombre, o.Total as Total, 
		date_format(o.fecha_emision,'%d/%m/%Y') as fecha from orden_compra o, proveedor p 
		where o.idProveedor = p.idProveedor and idUsuario = $idu order by o.fecha_emision DESC";
		$data = mysql_query( $q, $link );
		while( $o = mysql_fetch_array( $data ) ){
			$lista_o[] = $o;	
		}
		return $lista_o;	
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerProximoNumeroOrdenCompra( $dbh, $idu ){
		$q = "select MAX(numero) as num from orden_compra where idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerDetalleOrdenCompra( $dbh, $ido ){
		
		$detalle = array();
		$q = "select IdMovimiento as idd, IdArticulo as ida, Descripcion as descripcion, Cantidad as cantidad, 
		PrecioUnit as punit, PrecioTotal as ptotal, und from detalleordencompra where idOrden = $ido";
		
		$data = mysql_query( $q, $dbh );
		while( $item = mysql_fetch_array( $data ) ){
			$detalle[] = $item;	
		}
		return $detalle;
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerOrdenCompraPorId( $dbh, $ido ){
		
		$q = "select o.numero as nro, o.idOrden as ido, o.idProveedor as idproveedor, 
		o.estado as estado, 
		DATE_FORMAT(o.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(o.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		DATE_FORMAT(o.fecha_modificacion,'%d/%m/%Y %h:%i %p') as fmodificacion,
		o.iva as iva, o.iva as iva, o.introduccion as intro, o.Observaciones as obs0, 
		o.Observaciones1 as obs1, o.Observaciones2 as obs2, o.Observaciones3 as obs3, 
		p.Nombre as nombre, p.Rif as rif, p.Direccion1 as dir1, p.Direccion2 as dir2, 
		p.telefono1 as tlf1, p.telefono2 as tlf2, p.Email as email FROM orden_compra o, 
		proveedor p where o.idOrden = $ido and o.idProveedor = p.idProveedor";
		
		$orden_compra["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$orden_compra["detalle"] = obtenerDetalleOrdenCompra( $dbh, $ido );
		
		return $orden_compra;
	}
	/* ------------------------------------------------------------------------------- */
	function guardarItemDetalleOC( $dbh, $idc, $item ){
		//Guarda el registro individual de un ítem del detalle de orden de compra
		$ptotal = $item->dcant * $item->dpunit;
		$q = "insert into detalleordencompra ( idOrden, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idc, $item->idart, '$item->nart', $item->dcant, '$item->dund', $item->dpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";
		return mysql_insert_id();
	}
	/* ------------------------------------------------------------------------------- */
	function guardarDetalleOrdenCompra( $dbh, $ido, $detalle, $iva ){
		//Registra los ítems contenidos en el detalle de la orden de compra
		$exito = true;
		$nitems = count( $detalle );
		$citem = 0;
		foreach ( $detalle as $item ){
			$id_item = guardarItemDetalleOC( $dbh, $ido, $item, $iva );
			if( $id_item != 0 ) $citem++;	
		}
		if( $citem != $nitems ) $exito = false;
		
		return $exito;
	}
	/* ------------------------------------------------------------------------------- */
	function editarOrdenCompra( $dbh, $encabezado, $idu ){
		// Edita el registro de una orden de compra
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$q = "update orden_compra set idProveedor = $encabezado->idproveedor, fecha_emision = '$fecha_mysql', 
		SubTotal = $encabezado->subtotal, Total = $encabezado->total, fecha_modificacion = NOW()  
		WHERE idOrden = $encabezado->idr and idUsuario = $idu";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();	
	}
	/* ----------------------------------------------------------------------------------- */
	function guardarOrdenCompra( $dbh, $encabezado, $idu ){
		// Guarda el registro de una orden de compra
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision ); 
		$q = "insert into orden_compra ( numero, idProveedor, estado, fecha_emision, fecha_registro, introduccion, 
		Observaciones, observaciones1, observaciones2, observaciones3, iva, Total, idUsuario ) 
		values ( $encabezado->numero, $encabezado->idproveedor, '$encabezado->estado', '$fecha_mysql', NOW(), 
		'$encabezado->introduccion', '$encabezado->obs0', '$encabezado->obs1', '$encabezado->obs2', '$encabezado->obs3', 
		$encabezado->iva, $encabezado->total, $idu )";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Órdenes de compra */
	/* ----------------------------------------------------------------------------------- */
	//Registro de nueva orden de compra
	if( isset( $_POST["reg_orden_compra"] ) ){
		
		include( "bd.php" );
		include( "../fn/fn-documento.php" );
		
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$ido = guardarOrdenCompra( $dbh, $encabezado, $encabezado->idu );
		
		if( ( $ido != 0 ) && ( $ido != "" ) ){
			$exito = guardarDetalleOrdenCompra( $dbh, $ido, $detalle, $encabezado->iva );
			if( !isset( $encabezado->tipo ) )  $encabezado->tipo = "";
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso"; 
				$encabezado->idr = $ido;
				$res["documento"] = arrRespuesta( $encabezado, "orden_compra" ); 
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar detalle de orden de compra";
			}	
		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar orden de compra";
		}

		echo json_encode( $res );
	}

	//Edición de orden de compra
	if( isset( $_POST["edit_orden_compra"] ) ){
		
		include( "bd.php" );
		include( "data-documento.php" );
		include( "../fn/fn-documento.php" );
		
		$encabezado = json_decode( $_POST["encabezado"] );
		$encabezado->tipo = "orden_compra";
		$detalle = json_decode( $_POST["detalle"] );
		$r_edit = editarOrdenCompra( $dbh, $encabezado, $encabezado->idu );
		
		if( $r_edit != -1 ){
			
			eliminarDetalleDocumento( $dbh, "detalleordencompra", "idOrden", $encabezado->idr );
			$exito = guardarDetalleOrdenCompra( $dbh, $encabezado->idr, $detalle, $encabezado->iva );
			
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$res["documento"] = arrRespuesta( $encabezado, $encabezado->tipo );
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al editar detalle de orden de compra";
			}

		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al editar orden de compra";
		}

		echo json_encode( $res );
	}
?>
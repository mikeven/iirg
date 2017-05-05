<?php
	/* R&G - Funciones de clentes */
	/* ------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------- */	
	function obtenerListaFacturas( $dbh, $idu, $estado ){
		//Obtiene los registros de factura con los datos para mostrar en las tablas
		$xq = ""; $lista_f = array();
		if( $estado != "" ) $xq = "and estado = '$estado'";
		$q = "Select F.IdFactura as id, F.numero as numero, F.estado as estado, 
		C.idCliente as idc, C.Nombre as cliente, F.valor_condicion as vcondicion, 
		date_format(F.fecha_emision,'%d/%m/%Y') as Fecha, F.total as Total 
		From factura F, cliente C where F.IdCliente = C.idCliente and idUsuario = $idu $xq 
		order by F.fecha_emision desc";
		
		$data = mysql_query( $q, $dbh );
		while( $f = mysql_fetch_array( $data ) ){
			$lista_f[] = $f;	
		}
		return $lista_f;	
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerListaFacturasFecha( $dbh, $f1, $f2, $idu ){
		//Obtiene los registros de factura entre dos fechas por usuario
		$xq = ""; $lista_f = array();

		$q = "Select F.IdFactura as id, F.numero as numero, F.estado as estado, 
		C.idCliente as idc, C.Nombre as cliente, F.valor_condicion as vcondicion, 
		date_format(F.fecha_emision,'%d/%m/%Y') as Fecha, F.total as Total 
		From factura F, cliente C where F.IdCliente = C.idCliente and idUsuario = $idu and 
		( F.fecha_emision between '$f1' AND '$f2' ) order by F.fecha_emision desc";
		
		$data = mysql_query( $q, $dbh );
		while( $f = mysql_fetch_array( $data ) ){
			$lista_f[] = $f;	
		}
		return $lista_f;	
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerProximoNumeroFactura( $dbh, $idu ){
		//Retorna el número correspondiente al próximo registro de factura a guardar
		$q = "select MAX(numero) as num from factura where idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/* ------------------------------------------------------------------------------- */
	function tieneNotaAsociada( $dbh, $id ){
		//Determina si un nota (crédito/débito) está asociada a una factura dado su id  
		$asociada = false;
		$q = "select * from nota where idFactura = $id and tipo <> 'nota_entrega'";
		$data = mysql_query ( $q, $dbh ); 
		if( mysql_num_rows( $data ) > 0 )
			$asociada = true;
		
		return $asociada;		
	}
	/* ------------------------------------------------------------------------------- */
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
	/* ------------------------------------------------------------------------------- */
	function obtenerFacturaPorId( $dbh, $idf ){
		//Retorna el registro de factura y sus ítems de detalle dado su id
		$q = "select f.numero as nro, f.IdFactura as idf, f.estado as estado, f.IdCliente as idcliente, 
		f.idCotizacion as idc, DATE_FORMAT(f.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(f.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		DATE_FORMAT(f.fecha_pago,'%d/%m/%Y %h:%i %p') as fpago, 
		DATE_FORMAT(f.fecha_anulacion,'%d/%m/%Y %h:%i %p') as fanulacion, 
		DATE_FORMAT(f.fecha_modificacion,'%d/%m/%Y %h:%i %p') as fmodificacion, 
		DATE_FORMAT(f.fecha_vencimiento,'%d/%m/%Y') as fvencimiento,
		DATE_FORMAT(f.fecha_venc_sist,'%d/%m/%Y') as fvenc_sist, f.valor_condicion as vcondicion, f.iva as iva, 
		f.orden_compra as oc, f.condicion as condicion, f.valor_condicion as vcondicion, f.introduccion as intro, 
		f.Observaciones as obs0, f.Observaciones1 as obs1, f.Observaciones2 as obs2, f.Observaciones3 as obs3, 
		c.Nombre as nombre, c.Rif as rif, c.direccion1 as dir1, c.direccion2 as dir2, c.telefono1 as tlf1, 
		c.telefono2 as tlf2, c.Email as email FROM factura f, cliente c 
		WHERE f.IdFactura = $idf and f.IdCliente = c.idCliente";
		
		$factura["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$factura["detalle"] = obtenerDetalleFactura( $dbh, $idf );
		
		return $factura;
	}
	/* ------------------------------------------------------------------------------- */
	function guardarItemDetalleF( $dbh, $idf, $item ){
		//Guarda el registro individual de un ítem del detalle de pedido
		$ptotal = $item->dcant * $item->dpunit;
		$q = "insert into detallefactura ( IdFactura, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idf, $item->idart, '$item->nart', $item->dcant, '$item->dund', $item->dpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";

		return mysql_insert_id();
	}
	/* ------------------------------------------------------------------------------- */
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
	/* ------------------------------------------------------------------------------- */
	function guardarFactura( $dbh, $encabezado, $detalle, $idu ){
		//Guarda el registro de una factura
		$fecha_emision = cambiaf_a_mysql( $encabezado->femision );
		$total = number_format( $encabezado->total, 2, ".", "" );
		
		if( $encabezado->idcotizacion == "" ) { $pidc = ""; $vidc = ""; } 
		else{ $pidc="idCotizacion,"; $vidc = $encabezado->idcotizacion.","; }
		
		$q = "insert into factura ( numero, orden_compra, estado, $pidc IdCliente, fecha_emision, 
		fecha_vencimiento, introduccion, observaciones, observaciones1, observaciones2, 
		observaciones3, valor_condicion, condicion, iva, Total, fecha_registro, idUsuario ) 
		values ( $encabezado->numero, '$encabezado->noc', '$encabezado->estado',
		$vidc $encabezado->idcliente, '$fecha_emision', '$encabezado->fvencimiento', 
		'$encabezado->introduccion', '$encabezado->obs0', '$encabezado->obs1', '$encabezado->obs2', 
		'$encabezado->obs3', $encabezado->vcondicion, '$encabezado->ncondicion', $encabezado->iva, 
		$encabezado->total, NOW(), $idu )";
		$data = mysql_query( $q, $dbh );

		//echo $q;
		return mysql_insert_id();
	}
	/* ------------------------------------------------------------------------------- */
	function editarFactura( $dbh, $encabezado, $idu ){
		//Actualiza los datos de encabezado de una factura
		$fecha_emision = cambiaf_a_mysql( $encabezado->femision );
		$q = "update factura set 
				idCliente = $encabezado->idcliente, 
				fecha_emision = '$fecha_emision', 
				valor_condicion = $encabezado->vcondicion, 
				condicion = '$encabezado->ncondicion',
				orden_compra = '$encabezado->noc', 
				fecha_vencimiento = '$encabezado->fvencimiento', 
				SubTotal = $encabezado->subtotal, 
				Total = $encabezado->total, 
				fecha_modificacion = NOW() 
			WHERE idFactura = $encabezado->idr and idUsuario = $idu";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();	
	}
	
	/* ------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Facturas */
	/* ------------------------------------------------------------------------------- */
	
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
	/* ------------------------------------------------------------------------------- */
	//Edición de factura
	if( isset( $_POST["edit_factura"] ) ){
		
		include( "bd.php" );
		include( "data-documento.php" );
		include( "../fn/fn-documento.php" );
		
		$encabezado = json_decode( $_POST["encabezado"] );
		$encabezado->fvencimiento = agregarFechaVencimiento( $dbh, $encabezado, "factura" ); //data-documento.php
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
	/* ------------------------------------------------------------------------------- */

	
<?php
	/* R&G - Funciones de notas */
	/* ------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------- */	
	function obtenerListaNotas( $link, $idu ){
		$lista_c = array();
		$q = "Select N.IdNota as id, N.tipo as tipo, N.numero as numero, C.Nombre as cliente, 
		date_format(N.fecha_emision,'%d/%m/%Y') as Fecha, N.total as Total from nota N, cliente C 
		where N.IdCliente = C.idCliente and idUsuario = $idu order by N.fecha_emision desc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerProximoNumeroNota( $dbh, $tipo, $idu ){
		$q = "select MAX(numero) as num from nota where tipo = '$tipo' and idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerDetalleNota( $dbh, $idn ){
		// Obtiene los ítems del detalle de una nota
		$detalle = array();
		$q = "select IdDetalle as idd, IdArticulo as ida, Descripcion as descripcion, Cantidad as cantidad, 
		PrecioUnit as punit, PrecioTotal as ptotal, und from detallenota where idNota = $idn";
		
		$data = mysql_query( $q, $dbh );
		if($data){
			while( $item = mysql_fetch_array( $data ) ){
				$detalle[] = $item;	
			}
		}
		return $detalle;
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerNotaPorId( $dbh, $idn, $tipo_n ){
		//Retorna el registro de nota y sus ítems de detalle si posee
		$cond = ""; $campo = ""; $tabla = "";
		if( $tipo_n != "nota_entrega" ) {
			$cond = "and f.idFactura = n.IdFactura";
			$campo = "f.idFactura as idfactura, f.numero as nfact, "; $tabla = ", factura f";
		}
		
		$q = "select n.numero nro, n.idNota as idn, n.tipo as tipo, $campo n.idCliente as idcliente, 
		n.estado as estado, 
		DATE_FORMAT(n.fecha_emision,'%d/%m/%Y') as femision, 
		DATE_FORMAT(n.fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro,
		DATE_FORMAT(n.fecha_modificacion,'%d/%m/%Y %h:%i %p') as fmodificacion,
		DATE_FORMAT(n.fecha_anulacion,'%d/%m/%Y %h:%i') as fanulacion, 
		n.iva as iva, n.SubTotal as SubTotal, n.Total as Total, n.tipo_concepto as tipo_concepto, 
		n.concepto as concepto, n.introduccion as intro, n.Observaciones as obs0, 
		n.Observaciones1 as obs1, n.Observaciones2 as obs2, n.Observaciones3 as obs3, 
		c.Nombre as nombre, c.Rif as rif, c.direccion1 as dir1, c.direccion2 as dir2, 
		c.telefono1 as tlf1, c.telefono2 as tlf2, c.Email as email FROM nota n, cliente c $tabla 
		WHERE n.idNota = $idn and n.idCliente = c.idCliente $cond";

		//echo $q;
		$factura["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$factura["detalle"] = obtenerDetalleNota( $dbh, $idn );
		
		return $factura;
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerTipoNotaPorId( $dbh, $idn ){
		//Retorna el tipo de nota a partir del id
		$q = "select tipo from nota where idNota = $idn";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["tipo"];
	}
	/* ------------------------------------------------------------------------------- */
	function guardarItemDetalleN( $dbh, $idn, $item ){
		//Guarda el registro individual de un ítem del detalle de la nota
		$ptotal = $item->dcant * $item->dpunit;
		$q = "insert into detallenota ( IdNota, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idn, $item->idart, '$item->nart', $item->dcant, '$item->dund', $item->dpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q;

		return mysql_insert_id();
	}
	/* ------------------------------------------------------------------------------- */
	function guardarDetalleNota( $dbh, $idn, $encabezado, $detalle ){
		//Registra los ítems contenidos en el detalle de la nota
		$exito = true;

		if( $encabezado->tipo_concepto != "Ajuste global" ){
			$nitems = count( $detalle );
			$citem = 0;
			foreach ( $detalle as $item ){
				$id_item = guardarItemDetalleN( $dbh, $idn, $item );
				if( $id_item != 0 ) $citem++;
			}
			if( $citem != $nitems ) $exito = false;
		}
		
		return $exito;
	}
	/* ------------------------------------------------------------------------------- */
	function guardarNota( $dbh, $encabezado, $detalle, $idu ){
		//Guarda el registro de una nota
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$total = number_format( $encabezado->total, 2, ".", "" );
		if( !$encabezado->idfactura ) $encabezado->idfactura = "NULL";
		$q = "insert into nota ( numero, tipo, idFactura, idCliente, estado, fecha_emision, iva, 
		SubTotal, Total, concepto, tipo_concepto, Observaciones, Observaciones1, Observaciones2, 
		Observaciones3, fecha_registro, idUsuario ) 
		values ( $encabezado->numero, '$encabezado->tipo', $encabezado->idfactura, 
		$encabezado->idcliente, 'pendiente', '$fecha_mysql', $encabezado->iva, 
		$encabezado->subtotal, $encabezado->total, '$encabezado->concepto', 
		'$encabezado->tipo_concepto', '$encabezado->obs0', '$encabezado->obs1', 
		'$encabezado->obs2', '$encabezado->obs3', NOW(), $idu )";
		$data = mysql_query( $q, $dbh );

		//echo $q;
		return mysql_insert_id();
	}
	/* ------------------------------------------------------------------------------- */
	function editarNota( $dbh, $encabezado, $idu ){
		//Actualiza los valores del encabezado de una nota
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$q = "update nota set 
			idCliente = $encabezado->idcliente, 
			fecha_emision = '$fecha_mysql', 
			SubTotal = $encabezado->subtotal, 
			Total = $encabezado->total, 
			concepto = '$encabezado->concepto', 
			tipo_concepto = '$encabezado->tipo_concepto', 
			tipo='$encabezado->tipo', 
			fecha_modificacion = NOW() 
		WHERE idNota = $encabezado->idr and idUsuario = $idu";
		
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();
	}
	/* ------------------------------------------------------------------------------- */
	function etiquetaNota( $tipo, $notacion ){
		//Retorna la etiqueta correspondiente al tipo de Nota para formatos y registros en BD
		$etiquetas = array(	
			"nota_entrega" => "Nota de entrega", 
			"nota_debito" => "Nota de débito", 
			"nota_credito" => "Nota de crédito"
		);
		$frt_docbd = array(	
			"nota_entrega" => "nde", "nota_debito" => "ndd", "nota_credito" => "ndc"
		);
		if ( $notacion == "etiqueta" )
			return $etiquetas[$tipo];
		if ( $notacion == "bd" )
			return $frt_docbd[$tipo]; 
	}
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Notas */
	/* ----------------------------------------------------------------------------------------------------- */
	//Obtener próximo número de nota
	if( isset( $_POST["prox_num"] ) ){
		include( "bd.php" );
		$tn = $_POST["prox_num"];
		echo obtenerProximoNumeroNota( $dbh, $tn, $_POST["idu"] );
	}
	/* ----------------------------------------------------------------------------------------------------- */
	// Registro de nueva nota
	if( isset( $_POST["reg_nota"] ) ){ 
		
		include( "bd.php" );
		include( "../fn/fn-documento.php" );
		
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idn = guardarNota( $dbh, $encabezado, $detalle, $encabezado->idu );
		
		if( ( $idn != 0 ) && ( $idn != "" ) ){
			$exito = guardarDetalleNota( $dbh, $idn, $encabezado, $detalle );
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$encabezado->idr = $idn;
				$res["documento"] = arrRespuesta( $encabezado, "nota" );
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar detalle de Nota";
			}	
		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar Nota"; $encabezado->idr = NULL;
			$res["documento"] = arrRespuesta( $encabezado, "nota" );
		}
		
		echo json_encode( $res );
	}
	/* ----------------------------------------------------------------------------------------------------- */
	//Edición de nota
	if( isset( $_POST["edit_nota"] ) ){
		
		include( "bd.php" );
		include( "data-documento.php" );
		include( "../fn/fn-documento.php" );
		
		$encabezado = json_decode( $_POST["encabezado"] );
		$encabezado->tipo_doc = "nota";
		$detalle = json_decode( $_POST["detalle"] );
		$r_edit = editarNota( $dbh, $encabezado, $encabezado->idu );
		
		if( $r_edit != -1 ){
			
			eliminarDetalleDocumento( $dbh, "detallenota", "idNota", $encabezado->idr );
			$exito = guardarDetalleNota( $dbh, $encabezado->idr, $encabezado, $detalle );
			
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$res["documento"] = arrRespuesta( $encabezado, $encabezado->tipo_doc );
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

	
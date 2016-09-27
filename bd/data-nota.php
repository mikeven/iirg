<?php
	/* R&G - Funciones de notas */
	/*-------------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------*/	
	function obtenerListaNotas( $link ){
		$lista_c = array();
		$q = "Select N.IdNota as id, C.Nombre as cliente, date_format(N.fecha_emision,'%d/%m/%Y') as Fecha, 
				N.total as Total from nota N, cliente C where N.IdCliente = C.IdCliente2 order by N.fecha_emision desc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerProximoNumeroNota( $dbh, $tipo ){
		$q = "select MAX(numero) as num from nota where tipo = '$tipo'";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/*--------------------------------------------------------------------------------------------------------*/
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
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerNotaPorId( $dbh, $idn ){
		//Retorna el registro de nota y sus ítems de detalle
		$q = "select n.numero  nro, n.idNota as idn, n.tipo as tipo, f.numero as nfact, n.IdCliente as idcliente, 
		DATE_FORMAT(n.fecha_emision,'%d/%m/%Y') as femision, n.iva as iva, n.tipo_concepto as tipo_concepto, 
		n.concepto as concepto, c.Nombre as nombre, c.Rif as rif, c.direccion1 as dir1, c.direccion2 as dir2, 
		c.telefono1 as tlf1, c.telefono2 as tlf2, c.Email as email 
		FROM nota n, cliente c, factura f 
		where n.idNota = $idn and n.IdCliente = c.IdCliente2 and f.idFactura2 = n.IdFactura";
		
		$factura["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$factura["detalle"] = obtenerDetalleNota( $dbh, $idn );
		
		return $factura;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalleN( $dbh, $idn, $item ){
		//Guarda el registro individual de un ítem del detalle de pedido
		$ptotal = $item->dfcant * $item->dfpunit;
		$q = "insert into detallenota ( IdNota, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idn, $item->idart, '$item->nart', $item->dfcant, '$item->dfund', $item->dfpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
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
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarNota( $dbh, $encabezado, $detalle ){
		//Guarda el registro de una nota
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$total = number_format( $encabezado->total, 2, ".", "" );
		if( !$encabezado->idfactura ) $encabezado->idfactura = "NULL";
		$q = "insert into nota ( numero, tipo, IdFactura, IdCliente, fecha_emision, iva, Total, concepto, tipo_concepto, fecha_reg ) 
			values ( $encabezado->numero, '$encabezado->tipo', $encabezado->idfactura, 
		$encabezado->idcliente, '$fecha_mysql', $encabezado->iva, $encabezado->total, '$encabezado->concepto', 
		'$encabezado->tipo_concepto', NOW() )";
		$data = mysql_query( $q, $dbh );

		//echo $q."<br>";
		
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["prox_num"] ) ){
		include( "bd.php" );
		$tn = $_POST["prox_num"];
		echo obtenerProximoNumeroNota( $dbh, $tn );
	}

	if( isset( $_POST["reg_nota"] ) ){
		include( "bd.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idn = guardarNota( $dbh, $encabezado, $detalle );
		
		if( ( $idn != 0 ) && ( $idn != "" ) ){
			$exito = guardarDetalleNota( $dbh, $idn, $encabezado, $detalle );
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar detalle de nota";
			}	
		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar nota";
		}
		
		echo json_encode( $res );
	}
	/*--------------------------------------------------------------------------------------------------------*/

	
<?php
	/* R&G - Funciones de notas */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/	
	function obtenerListaNotas( $link ){
		$lista_c = array();
		$q = "Select F.IdFactura2 as id, C.Nombre as cliente, date_format(F.fecha_emision,'%d/%m/%Y') as Fecha, 
				F.total as Total from factura F, cliente C where F.IdCliente2 = C.IdCliente2 order by F.fecha_emision desc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerProximoNumeroNota( $dbh ){
		$q = "select MAX(numero) as num from nota";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerDetalleNota( $dbh, $idf ){
		// Obtiene los ítems del detalle de una nota
		$detalle = array();
		$q = "select IdDetalle as idd, IdArticulo as ida, Descripcion as descripcion, Cantidad as cantidad, 
		PrecioUnit as punit, PrecioTotal as ptotal, und from detallefactura where IdFactura2 = $idf";
		
		$data = mysql_query( $q, $dbh );
		while( $item = mysql_fetch_array( $data ) ){
			$detalle[] = $item;	
		}
		return $detalle;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerNotaPorId( $dbh, $idf ){
		//Retorna el registro de nota y sus ítems de detalle
		$q = "select f.numero as nro, f.IdFactura2 as idf, f.IdCliente2 as idcliente, DATE_FORMAT(f.fecha_emision,'%d/%m/%Y') as femision, 
		f.iva as iva, f.orden_compra as oc, f.Observaciones1 as obs1, f.Observaciones2 as obs2, c.Nombre as nombre, c.Rif as rif, 
		c.direccion1 as dir1, c.direccion2 as dir2, c.telefono1 as tlf1, c.telefono2 as tlf2, c.Email as email 
		FROM factura f, cliente c where f.IdFactura2 = ".$idf." and f.IdCliente2 = c.IdCliente2";
		
		$factura["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$factura["detalle"] = obtenerDetalleNota( $dbh, $idf );
		
		return $factura;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalleN( $dbh, $idf, $item ){
		//Guarda el registro individual de un ítem del detalle de pedido
		$ptotal = $item->dfcant * $item->dfpunit;
		$q = "insert into detallefactura ( IdFactura2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idf, $item->idart, '$item->nart', $item->dfcant, '$item->dfund', $item->dfpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarDetalleNota( $dbh, $idp, $detalle ){
		//Registra los ítems contenidos en el detalle de la nota
		$exito = true;
		$nitems = count( $detalle );
		$citem = 0;
		foreach ( $detalle as $item ){
			$id_item = guardarItemDetalleN( $dbh, $idp, $item );
			if( $id_item != 0 ) $citem++;
		}
		
		if( $citem != $nitems ) $exito = false;
		
		return $exito;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarNota( $dbh, $encabezado, $detalle ){
		//Guarda el registro de una nota
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$total = number_format( $encabezado->total, 2, ".", "" );
		if( !$encabezado->idfactura ) $encabezado->idfactura = "NULL";
		$q = "insert into nota ( numero, nfactura, IdFactura, IdCliente2, fecha_emision, iva, Total, fecha_reg  ) 
			values ( $encabezado->numero, '$encabezado->nfactura', $encabezado->idfactura, $encabezado->idcliente, 
			'$fecha_mysql', $encabezado->iva, $encabezado->total, NOW() )";
		$data = mysql_query( $q, $dbh );

		echo $q."<br>";
		
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_nota"] ) ){
		include( "bd.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idf = guardarNota( $dbh, $encabezado, $detalle );
		
		if( ( $idf != 0 ) && ( $idf != "" ) ){
			$exito = guardarDetalleNota( $dbh, $idf, $detalle );
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
			$res["mje"] = "Error al registrar factura";
		}
		
		//echo json_encode( $res );
	}
	/*--------------------------------------------------------------------------------------------------------*/

	
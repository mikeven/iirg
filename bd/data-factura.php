<?php
	/* R&G - Funciones de clentes */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/	
	function obtenerListaFacturas( $link ){
		$lista_c = array();
		$q = "Select F.IdFactura2 as id, F.numero as numero, C.IdCliente2 as idc, C.Nombre as cliente, date_format(F.fecha_emision,'%d/%m/%Y') as Fecha, 
				F.total as Total from factura F, cliente C where F.IdCliente2 = C.IdCliente2 order by F.fecha_emision desc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerProximoNumeroFactura( $dbh ){
		$q = "select MAX(numero) as num from factura";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerDetalleFactura( $dbh, $idf ){
		// Obtiene los ítems del detalle de una factura
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
	function obtenerFacturaPorId( $dbh, $idf ){
		//Retorna el registro de factura y sus ítems de detalle
		$q = "select f.numero as nro, f.IdFactura2 as idf, f.IdCliente2 as idcliente, DATE_FORMAT(f.fecha_emision,'%d/%m/%Y') as femision, 
		f.iva as iva, f.orden_compra as oc, f.Observaciones1 as obs1, f.Observaciones2 as obs2, c.Nombre as nombre, c.Rif as rif, 
		c.direccion1 as dir1, c.direccion2 as dir2, c.telefono1 as tlf1, c.telefono2 as tlf2, c.Email as email 
		FROM factura f, cliente c where f.IdFactura2 = ".$idf." and f.IdCliente2 = c.IdCliente2";
		
		$factura["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$factura["detalle"] = obtenerDetalleFactura( $dbh, $idf );
		
		return $factura;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalleF( $dbh, $idf, $item ){
		//Guarda el registro individual de un ítem del detalle de pedido
		$ptotal = $item->dfcant * $item->dfpunit;
		$q = "insert into detallefactura ( IdFactura2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idf, $item->idart, '$item->nart', $item->dfcant, '$item->dfund', $item->dfpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarDetalleFactura( $dbh, $idp, $detalle ){
		//Registra los ítems contenidos en el detalle de la factura
		$exito = true;
		$nitems = count( $detalle );
		$citem = 0;
		foreach ( $detalle as $item ){
			$id_item = guardarItemDetalleF( $dbh, $idp, $item );
			if( $id_item != 0 ) $citem++;
		}
		
		if( $citem != $nitems ) $exito = false;
		
		return $exito;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarFactura( $dbh, $encabezado, $detalle ){
		//Guarda el registro de una factura
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$total = number_format( $encabezado->total, 2, ".", "" );
		if( !$encabezado->idpedido ) $encabezado->idpedido = "NULL";
		$q = "insert into factura ( numero, orden_compra, IdPedido, IdCliente2, fecha_emision, iva, Total, fecha_reg  ) 
			values ( $encabezado->numero, '$encabezado->noc', $encabezado->idpedido, $encabezado->idcliente, 
			'$fecha_mysql', $encabezado->iva, $encabezado->total, NOW() )";
		$data = mysql_query( $q, $dbh );

		//echo $q."<br>";
		
		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function mostrarItemDocumento( $ditem, $i ){
		//Muestra el renglón con el ítem de detalle al cargar la factura para generar Nota de Crédito/Débito (nuevo-nota.php)
		$renglon = "<tr id='it$i'><th>$ditem[descripcion]<input id='idarticulo_$i' 
		name='idart' type='hidden' value='$ditem[ida]' data-nitem='$i'>
		 <input id='ndarticulo_$i' name='nart' type='hidden' value='$ditem[descripcion]' data-nitem='$i'></th>
		 <th><div class='input-group input-space'>
		 <input id='idfq_$i' name='dfcant' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[cantidad]' data-nitem='$i' onkeypress='return isIntegerKey(event)' onkeyup='actItemF( this )'></div>
		 </th><th><div class='input-group input-space'>
		 <input id='idfund_$i' name='dfund' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[und]' data-nitem='$i'></div>
		 </th><th><div class='input-group input-space'>
		 <input id='idfpu_$i' name='dfpunit' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[punit]' 
		 	data-nitem='$i' onkeypress='return isNumberKey(event)' onkeyup='actItemF( this )' onblur='initValid()'></div>
		</th><th><div class='input-group input-space'><input id='idfpt_$i' name='dfptotal' type='text' class='form-control itemtotal_detalle input-sm montoacum' value='$ditem[ptotal]' data-nitem='$i' readonly></div>
		</th><th><button type='button' class='btn btn-block btn-danger btn-xs bedf' onclick='elimItemF(it$i)'>
		<i class='fa fa-times'></i></button></th>
		</tr>";

		return $renglon;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_factura"] ) ){
		include( "bd.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idf = guardarFactura( $dbh, $encabezado, $detalle );
		
		if( ( $idf != 0 ) && ( $idf != "" ) ){
			$exito = guardarDetalleFactura( $dbh, $idf, $detalle );
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
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
	/*--------------------------------------------------------------------------------------------------------*/

	
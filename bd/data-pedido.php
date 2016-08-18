<?php
	/* R&G - Gestión de datos de pedidos */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerListaPedidos( $link ){
		$lista_p = array();
		$q = "Select p.IdPedido2 as idp, date_format(p.fecha_emision,'%d/%m/%Y') as Fecha, c.Nombre as Nombre, p.Total as Total
				from pedido p, cliente c where p.IdCliente2 = c.IdCliente2 order by p.fecha_emision DESC";
		$data = mysql_query( $q, $link );
		while( $p = mysql_fetch_array( $data ) ){
			$lista_p[] = $p;	
		}
		return $lista_p;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerProximoNumeroPedido( $dbh ){
		//Obtiene el número correspondiente a una nueva factura
		$q = "select MAX(numero) as num from pedido";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function mostrarItemDocumento( $ditem, $i ){
		//Muestra el renglón con el ítem de detalle al cargar el pedido para generar Factura (nuevo-factura-php)
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
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerDetallePedido( $dbh, $idp ){
		// Obtiene los ítems del detalle de un pedido
		$detalle = array();
		$q = "select IdMovimiento as idd, IdArticulo as ida, Descripcion as descripcion, Cantidad as cantidad, 
		PrecioUnit as punit, PrecioTotal as ptotal, und from detallepedido where IdPedido2 = $idp";
		
		$data = mysql_query( $q, $dbh );
		while( $item = mysql_fetch_array( $data ) ){
			$detalle[] = $item;	
		}
		return $detalle;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function obtenerPedidoPorId( $dbh, $idp ){
		//Retorna el registro de pedido y sus ítems de detalle
		$q = "select p.numero as nro, p.IdPedido2 as idp, p.IdCliente2 as idcliente, DATE_FORMAT(p.fecha_emision,'%d/%m/%Y') as femision, p.iva as iva, p.Observaciones1 as obs1, c.Nombre as nombre, c.Rif as rif, c.Direccion as direccion, c.telefono1 as tlf1, c.telefono2 as tlf2, c.Email as email FROM pedido p, cliente c 
			where p.IdPedido2 = ".$idp." and p.IdCliente2 = c.IdCliente2";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetallePedido( $dbh, $idp );
		
		return $cotizacion;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalleP( $dbh, $idp, $item ){
		//Guarda el registro individual de un ítem del detalle de pedido
		$ptotal = $item->dfcant * $item->dfpunit;
		$q = "insert into detallepedido ( IdPedido2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal  ) 
		values ( $idp, $item->idart, '$item->nart', $item->dfcant, '$item->dfund', $item->dfpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarDetallePedido( $dbh, $idp, $detalle ){
		//Registra los ítems contenidos en el detalle de pedido
		foreach ( $detalle as $item ){
			guardarItemDetalleP( $dbh, $idp, $item );	
		}
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarPedido( $dbh, $encabezado, $detalle ){
		//Guarda el registro de un pedido
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$total = number_format( $encabezado->total, 2, ".", "" );
		$q = "insert into pedido ( numero, IdCotizacion2, IdCliente2, fecha_emision, iva, Total  ) 
			values ( $encabezado->numero, $encabezado->idcotiz, $encabezado->idcliente, '$fecha_mysql', 
			$encabezado->iva, $encabezado->total )";
		$data = mysql_query( $q, $dbh );

		echo $q;

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_POST["reg_pedido"] ) ){
		include( "bd.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idp = guardarPedido( $dbh, $encabezado, $detalle );
		
		if( ( $idp != 0 ) && ( $idp != "" ) ){
			guardarDetallePedido( $dbh, $idp, $detalle );		
		}
	}
	/*--------------------------------------------------------------------------------------------------------*/
?>
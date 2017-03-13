<?php
	/* R&G - Gestión de datos de pedidos */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerListaPedidos( $link, $idu ){
		$lista_p = array();
		$q = "Select p.IdPedido2 as idp, p.numero as numero, date_format(p.fecha_emision,'%d/%m/%Y') as Fecha, 
				c.Nombre as Nombre, p.Total as Total from pedido p, cliente c 
				where p.IdCliente2 = c.IdCliente2 and idUsuario = $idu order by p.fecha_emision DESC";
		$data = mysql_query( $q, $link );
		while( $p = mysql_fetch_array( $data ) ){
			$lista_p[] = $p;	
		}
		return $lista_p;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerProximoNumeroPedido( $dbh, $idu ){
		//Obtiene el número correspondiente a un nuevo pedido
		$q = "select MAX(numero) as num from pedido where idUsuario = $idu";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) ); 
		return $data["num"] + 1;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function mostrarItemDocumentoPedido( $ditem, $i ){
		//Muestra el renglón con el ítem de detalle al cargar el pedido para generar Factura (nuevo-factura-php)
		
		$renglon = "<tr id='it$i'><th>$ditem[descripcion]<input id='idarticulo_$i' 
		name='idart' type='hidden' value='$ditem[ida]' data-nitem='$i'>
		 <input id='ndarticulo_$i' name='nart' type='hidden' value='$ditem[descripcion]' data-nitem='$i'></th>
		 <th><div class='input-group input-space'>
		 <input id='idq_$i' name='dcant' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[cantidad]' data-nitem='$i' 
		 onkeypress='return isIntegerKey(event)' onkeyup='actItemD( this )'></div>
		 </th><th><div class='input-group input-space'>
		 <input id='idund_$i' name='dund' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[und]' data-nitem='$i'></div>
		 </th><th>
		 <div class='input-group input-space'>
		 <input id='idpu_$i' name='dpunit' type='text' class='form-control itemtotal_detalle input-sm' value='$ditem[punit]' 
		 	data-nitem='$i' onkeypress='return isNumberKey(event)' onkeyup='actItemD( this )' onblur='initValid()'></div>
		</th><th><div class='input-group input-space'><input id='idpt_$i' name='dptotal' type='text' 
		class='form-control itemtotal_detalle input-sm montoacum' value='$ditem[ptotal]' data-nitem='$i' readonly></div>
		</th><th><button type='button' class='btn btn-block btn-danger btn-xs bedf' onclick='elimItemDetalle(it$i)'>
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
		$q = "select p.numero as nro, p.IdPedido2 as idp, p.IdCliente2 as idcliente, DATE_FORMAT(p.fecha_emision,'%d/%m/%Y') as femision, 
		p.iva as iva, p.introduccion as intro, p.Observaciones as obs0, p.Observaciones1 as obs1, p.Observaciones2 as obs2, 
		p.Observaciones3 as obs3, c.Nombre as nombre, c.Rif as rif, c.direccion1 as dir1, c.direccion2 as dir2, 
		c.telefono1 as tlf1, c.telefono2 as tlf2, c.Email as email FROM pedido p, cliente c 
		where p.IdPedido2 = ".$idp." and p.IdCliente2 = c.IdCliente2";
		
		$cotizacion["encabezado"] = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		$cotizacion["detalle"] = obtenerDetallePedido( $dbh, $idp );
		
		return $cotizacion;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarItemDetalleP( $dbh, $idp, $item ){
		//Guarda el registro individual de un ítem del detalle de pedido
		$ptotal = $item->dcant * $item->dpunit;
		$q = "insert into detallepedido ( IdPedido2, IdArticulo, Descripcion, Cantidad, und, PrecioUnit, PrecioTotal) 
		values ( $idp, $item->idart, '$item->nart', $item->dcant, '$item->dund', $item->dpunit, $ptotal )";
		$data = mysql_query( $q, $dbh );
		//echo $q."<br>";

		return mysql_insert_id();
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarDetallePedido( $dbh, $idp, $detalle ){
		//Registra los ítems contenidos en el detalle de pedido
		$exito = true;
		$nitems = count( $detalle );
		$citem = 0;
		foreach ( $detalle as $item ){
			$id_item = guardarItemDetalleP( $dbh, $idp, $item );
			if( $id_item != 0 ) $citem++;	
		}

		if( $citem != $nitems ) $exito = false;
		
		return $exito;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarPedido( $dbh, $encabezado, $detalle, $idu ){
		//Guarda el registro de un pedido
		$fecha_mysql = cambiaf_a_mysql( $encabezado->femision );
		$total = number_format( $encabezado->total, 2, ".", "" );
		if( !$encabezado->idcotiz ) $encabezado->idcotiz = "NULL";
		$q = "insert into pedido ( numero, IdCotizacion2, IdCliente2, fecha_emision, introduccion, observaciones, 
		observaciones1, observaciones2, observaciones3, iva, Total, idUsuario  ) 
		values ( $encabezado->numero, $encabezado->idcotiz, $encabezado->idcliente, '$fecha_mysql', 
		'$encabezado->introduccion', '$encabezado->obs0', '$encabezado->obs1', '$encabezado->obs2', '$encabezado->obs3', 
		$encabezado->iva, $encabezado->total, $idu )";
		$data = mysql_query( $q, $dbh );

		//echo $q;

		return mysql_insert_id();
	}
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Pedidos */
	/* ----------------------------------------------------------------------------------------------------- */
	//Registro de nuevo pedido
	if( isset( $_POST["reg_pedido"] ) ){
		include( "bd.php" );
		include( "../fn/fn-documento.php" );
		$encabezado = json_decode( $_POST["encabezado"] );
		$detalle = json_decode( $_POST["detalle"] );
		
		$idp = guardarPedido( $dbh, $encabezado, $detalle, $encabezado->idu );
		
		if( ( $idp != 0 ) && ( $idp != "" ) ){
			$exito = guardarDetallePedido( $dbh, $idp, $detalle );
			if( $exito == true ){
				$res["exito"] = 1;
				$res["mje"] = "Registro exitoso";
				$encabezado->idr = $idp;
				$res["documento"] = arrRespuesta( $encabezado, "pedido" );
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar detalle de pedido";
			}		
		}
		else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar pedido";
		}

		echo json_encode( $res );
	}
	/*--------------------------------------------------------------------------------------------------------*/
?>
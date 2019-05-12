<?php
	/* ----------------------------------------------------------------------------------- */
	/* R&G - Funciones de g.s y pagos */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function agregarGasto( $dbh, $gasto, $idu ){
		//Agrega un registro de compra
		$fpago = cambiaf_a_mysql( $gasto["fecha_pago"] );
		$q = "insert into gasto ( tipo, concepto, fecha_registro, fecha_pago, monto, beneficiario, 
		forma_pago, banco, noperacion, idCompra, idUsuario ) values ( '$gasto[tgasto]', '$gasto[concepto]', 
		NOW(), '$fpago', $gasto[monto], '$gasto[beneficiario]', '$gasto[forma_pago]', 
		'$gasto[cbanco]', '$gasto[noper]', $gasto[idCompra], $idu )";
		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerGastoPorId( $dbh, $id, $idu ){
		//Devuelve registro de un registor de gasto dado el ID
		$q = "Select idGasto, tipo, estado, concepto, monto, monto_pagado, concepto, beneficiario, 
		banco, date_format(fecha_pago,'%d/%m/%Y') as fpago, noperacion,  
		date_format(fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, forma_pago
		from gasto where idGasto = $id and idUsuario = $idu";
		
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		return $data;
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaGastos( $dbh, $tipo, $idu ){
		//Devuelve registro de artículo dado el ID
		$lista_g = array();
		$q = "select idGasto, tipo, beneficiario, concepto, 
		date_format(fecha_pago,'%d/%m/%Y') as fpago, 
		date_format(fecha_registro,'%d/%m/%Y %h:%i %p') as fregistro, 
		banco, monto, monto_pagado, forma_pago, noperacion 
		from gasto where tipo='$tipo' and idUsuario = $idu order by fecha_pago desc";		
		
		$data = mysql_query( $q, $dbh );
		while( $g = mysql_fetch_array( $data ) ){
			$lista_g[] = $g;	
		}
		return $lista_g;	
	}
	/* ----------------------------------------------------------------------------------- */
	function modificarGasto( $dbh, $gasto, $idu ){
		//Modifica los datos de un registro de gasto
		$fpago = cambiaf_a_mysql( $gasto["fecha_pago"] );
		$q = "update gasto set concepto='$gasto[concepto]', fecha_modificacion = NOW(), 
		fecha_pago = '$fpago', monto = $gasto[monto], beneficiario = '$gasto[beneficiario]', 
		forma_pago = '$gasto[forma_pago]', banco = '$gasto[cbanco]', 
		noperacion = '$gasto[noper]' where idGasto = $gasto[idGasto] and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return $gasto["idGasto"];		
	}
	/* ----------------------------------------------------------------------------------- */
	function eliminarGasto( $dbh, $idg, $estado, $idu ){
		//Modifica el estado de un gasto ('creado', 'eliminado')
		$q = "update gasto set estado = '$estado' where idGasto = $idg and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();		
	}
	/* ----------------------------------------------------------------------------------- */
	function pagarCompra( $dbh, $idc, $estado, $idu ){
		//Modifica el estado de una compra ('creada', 'eliminada')
		$q = "update compra set estado = '$estado' where idCompra = $idc and idUsuario = $idu";
		//echo $q;
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();		
	}
	/* ----------------------------------------------------------------------------------- */
	function mjeRespuestaEstado( $estado ){
		$mje = array(
			"eliminado" 		=> "Registro eliminado",
			"creado"			=> "Registro recuperado"
		);
		return $mje[$estado];
	}
	/* ----------------------------------------------------------------------------------- */	
	/* ----------------------------------------------------------------------------------- */
	/* Solicitudes al servidor para procesar información de gastos */
	/* ----------------------------------------------------------------------------------- */
	
	if( isset( $_POST["rgasto"] ) ){ 
	//Registro o modificación de un gasto
		include( "bd.php" );
		
		$gasto = array();
		parse_str( $_POST["rgasto"], $gasto );
		if( $_POST["g_accion"] == "agregar" ){
			$idg = agregarGasto( $dbh, $gasto, $_POST["id_u"] );
			pagarCompra( $dbh, $gasto["idCompra"], "pagada", $_POST["id_u"] );
		}
		if( $_POST["g_accion"] == "editar" )
			$idg = modificarGasto( $dbh, $gasto, $_POST["id_u"] );

		if( ( $idg != 0 ) && ( $idg != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Gasto registrado";
			$gasto["id"] = $idg;
			$res["registro"] = $gasto;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar gasto";
		}
		
		echo json_encode( $res );
	}

	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["egasto"] ) ){
		include( "bd.php" );
		$idu = $_POST["id_u"];
		$r = eliminarGasto( $dbh, $_POST["egasto"], $_POST["edo"], $idu );
		
		if( ( $r != 0 ) ){
			$res["exito"] = 1;
			$res["mje"] = mjeRespuestaEstado( $_POST["edo"] );
			$gasto["id"] = $_POST["egasto"];
			$res["registro"] = $gasto;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "No se realizaron cambios";
		}
		echo json_encode( $res );
	}
	/* ----------------------------------------------------------------------------------- */
?>
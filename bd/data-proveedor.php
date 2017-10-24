<?php
	/* R&G - Funciones de clentes */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function agregarProveedor( $p, $dbh ){
		$q = "insert into proveedor (Nombre, Rif, Email, pcontacto, telefono1, telefono2, Direccion1, Direccion2 ) 
		values ( '$p[nombre]', '$p[rif]', '$p[email]', '$p[pcontacto]', '$p[telefono1]', '$p[telefono2]', '$p[direccion1]', '$p[direccion2]' )";
		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function modificarProveedor( $dbh, $p ){
		
		$resp["cambio"] = "exito";
		$q = "update proveedor set Nombre = '$p[nombre]', Rif = '$p[rif]', Email = '$p[email]', 
		pcontacto = '$p[pcontacto]', telefono1 = '$p[telefono1]', telefono2 = '$p[telefono2]', 
		Direccion1 = '$p[direccion1]', Direccion2 = '$p[direccion2]' where idProveedor = $p[idProveedor]";
		$data = mysql_query( $q, $dbh );
		//echo $q;

		$resp["id"] = $p["idProveedor"];
		if( mysql_affected_rows() != 1 )
			$resp["cambio"] = "";
		
		return $resp;		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaProveedores( $link ){
		$lista_c = array();
		$q = "Select * from proveedor order by Nombre asc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerProveedorPorId( $id, $dbh ){
		
		$q = "select * from proveedor where idProveedor = $id";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		
		return $data;	
	}
	/* ------------------------------------------------------------------------------- */
	function obtenerOperacionesProveedor( $dbh, $idp ){
		//Retorna una lista de documentos (facturas, notas, cotizaciones) asociados a un proveedor
		$lista = array();
		//idCliente: hace referencia a proveedor en cotización tipo 'solicitud'
		$q = "Select idCotizacion as id, 'Solicitud de cotización' as documento, estado, numero, 
		DATE_FORMAT(fecha_emision,'%d/%m/%Y') as femision, Total as total 
		FROM cotizacion where idCliente = $idp and tipo='solicitud' UNION ALL 
		Select idOrden as id, 'Orden de compra' as documento, estado, numero, 
		DATE_FORMAT(fecha_emision,'%d/%m/%Y') as femision, Total as total 
		FROM orden_compra WHERE idProveedor = $idp order by femision DESC"; 
		//echo $q;
		$data = mysql_query( $q, $dbh );
		while( $reg = mysql_fetch_array( $data ) ){
			$lista[] = $reg;	
		}
		return $lista;
	}
	/* ----------------------------------------------------------------------------------- */
	function proveedorExistente( $dbh, $campo, $valor ){
		$existente = 0;
		$q = "select * from proveedor where $campo = '$valor'"; 
		$data = mysql_query( $q, $dbh );
		if( mysql_num_rows( $data ) > 0 ) $existente = 1;
		
		return $existente;	
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_proveedor"] ) ){
		include("bd.php");

		$proveedor = array();
		parse_str( $_POST["nproveedor"], $proveedor );
		//print_r( $proveedor );
		
		$idr = agregarProveedor( $proveedor, $dbh );
		if( ( $idr != 0 ) && ( $idr != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Proveedor registrado";
			$proveedor["id"] = $idr;
			$res["registro"] = $proveedor;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar proveedor";
		}

		echo json_encode( $res );	
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["mproveedor"] ) ){
		
		include("bd.php");
		parse_str( $_POST["mproveedor"], $proveedor );
	
		$idr = modificarProveedor( $dbh, $proveedor );
	
		if( ( $idr != 0 ) && ( $idr != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Proveedor actualizado con éxito";
			$proveedor["id"] = $proveedor["idProveedor"];
			$res["registro"] = $proveedor;
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Error al modificar proveedor";
		}
		echo json_encode( $res );
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["existe_rif"] ) ){
		include( "bd.php" );		
		echo proveedorExistente( $dbh, $_POST["campo"], $_POST["valor"] );
	}
	/* ----------------------------------------------------------------------------------- */
?>
<?php
	/* R&G - Funciones de clentes */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function agregarProveedor( $p, $dbh ){
		$q = "insert into proveedor (Nombre, Rif, Email, pcontacto, telefono1, telefono2, Direccion1, Direccion2 ) 
		values ( '$p[nombre]', '$p[rif]', '$p[email]', '$p[pcontacto]', '$p[tel1]', '$p[tel2]', '$p[direccion1]', '$p[direccion2]' )";
		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_insert_id();		
	}
	/* ----------------------------------------------------------------------------------- */
	function modificarProveedor( $p, $dbh ){
		
		$resp["cambio"] = "exito";
		$q = "update proveedor set Nombre = '$p[nombre]', Rif = '$p[rif]', Email = '$p[email]', 
		pcontacto = '$p[pcontacto]', telefono1 = '$p[tel1]', telefono2 = '$p[tel2]', 
		Direccion1 = '$p[direccion1]', Direccion2 = '$p[direccion2]' where idProveedor = $p[id]";
		$data = mysql_query( $q, $dbh );
		//echo $q;

		$resp["id"] = $p["id"];
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
	if( isset( $_POST["reg_proveedor"] ) || isset( $_POST["mod_proveedor"] ) ){
		include("bd.php");
		$p["nombre"] = $_POST["nombre"];
		$p["rif"] = $_POST["rif"];
		$p["email"] = $_POST["email"];
		$p["pcontacto"] = $_POST["pcontacto"];
		$p["direccion1"] = $_POST["direccion1"];
		$p["direccion2"] = $_POST["direccion2"];
		$p["tel1"] = $_POST["telefono1"];
		$p["tel2"] = $_POST["telefono2"];
		
		if( isset( $_POST["reg_proveedor"] )){
			$idr = agregarProveedor( $p, $dbh );
		}
		if( isset( $_POST["mod_proveedor"] )){
			$p["id"] = $_POST["idProveedor"];
			$res = modificarProveedor( $p, $dbh );
			$idr = $res["id"]."&res=$res[cambio]";
		}
		//echo $idr;
		echo "<script>window.location.href='../ficha_proveedor.php?p=$idr'</script>";	
	}
	/* ----------------------------------------------------------------------------------- */
	if( isset( $_POST["existe_rif"] ) ){
		include( "bd.php" );		
		echo proveedorExistente( $dbh, $_POST["campo"], $_POST["valor"] );
	}
	/* ----------------------------------------------------------------------------------- */
?>
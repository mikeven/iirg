<?php
	/* R&G - Funciones de clentes */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	ini_set( 'display_errors', 1 );
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function agregarCliente( $cliente, $dbh ){
		$q = "insert into cliente (Nombre, Rif, Email, telefono1, telefono2, Direccion ) 
		values ( '$cliente[nombre]', '$cliente[rif]', '$cliente[email]', '$cliente[tel1]', '$cliente[tel2]', '$cliente[direccion]' )";
		$data = mysql_query( $q, $dbh );
		
		return mysql_insert_id();		
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function modificarCliente( $cliente, $dbh ){
		
		$resp["cambio"] = "exito";
		$q = "update cliente set Nombre = '$cliente[nombre]', Rif = '$cliente[rif]', Email = '$cliente[email]', telefono1 = '$cliente[tel1]', telefono2 = '$cliente[tel2]', Direccion = '$cliente[direccion]' where idCliente2 = $cliente[id]";
		$data = mysql_query( $q, $dbh );
		
		$resp["id"] = $cliente["id"];
		if( mysql_affected_rows() != 1 )
			$resp["cambio"] = "";
		
		return $resp;		
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerListaClientes( $link ){
		$lista_c = array();
		$q = "Select * from cliente order by Nombre asc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerClientePorId( $id, $dbh ){
		
		$q = "Select * from cliente where idCliente2 = $id";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		
		return $data;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_cliente"] ) || isset( $_POST["mod_cliente"] ) ){
		$cliente["nombre"] = $_POST["nombre"];
		$cliente["rif"] = $_POST["rif"];
		$cliente["email"] = $_POST["email"];
		$cliente["direccion"] = $_POST["direccion"];
		$cliente["tel1"] = $_POST["telefono1"];
		$cliente["tel2"] = $_POST["telefono2"];
		
		if( isset( $_POST["reg_cliente"] )){
			$idr = agregarCliente( $cliente, $dbh );
		}
		if( isset( $_POST["mod_cliente"] )){
			$cliente["id"] = $_POST["idCliente"];
			$res = modificarCliente( $cliente, $dbh );
			$idr = $res["id"]."&res=$res[cambio]";
		}
		
		echo "<script>window.location.href='../ficha_cliente.php?c=$idr'</script>";	
	}
	/*--------------------------------------------------------------------------------------------------------*/
?>
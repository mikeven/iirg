<?php
	/* R&G - Funciones de clentes */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function agregarProveedor( $p, $dbh ){
		$q = "insert into proveedor (Nombre, Rif, Email, pcontacto, telefono1, telefono2, Direccion ) 
		values ( '$p[nombre]', '$p[rif]', '$p[email]', '$p[pcontacto]', '$p[tel1]', '$p[tel2]', '$p[direccion]' )";
		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_insert_id();		
	}
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function modificarProveedor( $p, $dbh ){
		
		$resp["cambio"] = "exito";
		$q = "update proveedor set Nombre = '$p[nombre]', Rif = '$p[rif]', Email = '$p[email]', pcontacto = '$p[pcontacto]', 
		telefono1 = '$p[tel1]', telefono2 = '$p[tel2]', Direccion = '$p[direccion]' where idProveedor = $p[id]";
		$data = mysql_query( $q, $dbh );
		//echo $q;

		$resp["id"] = $p["id"];
		if( mysql_affected_rows() != 1 )
			$resp["cambio"] = "";
		
		return $resp;		
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerProveedorPorId( $id, $dbh ){
		
		$q = "select * from proveedor where idProveedor = $id";
		$data = mysql_fetch_array( mysql_query ( $q, $dbh ) );	
		
		return $data;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_proveedor"] ) || isset( $_POST["mod_proveedor"] ) ){
		include("bd.php");
		$p["nombre"] = $_POST["nombre"];
		$p["rif"] = $_POST["rif"];
		$p["email"] = $_POST["email"];
		$p["pcontacto"] = $_POST["pcontacto"];
		$p["direccion"] = $_POST["direccion"];
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
	/*--------------------------------------------------------------------------------------------------------*/
?>
<?php
	/* R&G - Funciones de sistena */
	/* ----------------------------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerValorIva( $dbh ){
		//Retorna el valor del iva
		$lista = array();
		$q = "select * from valores where nombre = 'iva'";
		$reg = mysql_fetch_array( mysql_query( $q, $dbh ) );

		return $reg["valor"] / 100;
	}
	
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de usuarios */
	/* ----------------------------------------------------------------------------------------------------- */
	
	//Modificar datos de usuario. Bloque: contraseña
	if( isset( $_POST["mod_passw"] ) ){
		
		include("bd.php");
		$usuario["id"] 			= $_POST["idUsuario"];
		$usuario["password"] 	= $_POST["password1"];
		
		$res["exito"] = modificarPassword( $usuario, $dbh );
		
		if( $res["exito"] == 1 )
			$res["mje"] = "Contraseña actualizada con éxito";
		else
			$res["mje"] = "Error al actualizar contraseña";
		
		echo json_encode( $res );	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	$sisval_iva = obtenerValorIva( $dbh );
	/* ----------------------------------------------------------------------------------------------------- */
?>
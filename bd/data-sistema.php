<?php
	/* IIRG - Funciones de sistema */
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
	function actualizarValorIVA( $dbh, $iva ){
		//Edita el valor del IVA
		$q = "update valores set valor = $iva WHERE nombre = 'iva'";
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();
	}
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de usuarios */
	/* ----------------------------------------------------------------------------------------------------- */
	//Modificar valor del IVA
	if( isset( $_POST["act_iva"] ) ){		
		include( "bd.php" );
		echo actualizarValorIVA( $dbh, $_POST["act_iva"] );			
	}
	/* ----------------------------------------------------------------------------------------------------- */
	$sisval_iva = obtenerValorIva( $dbh );
	/* ----------------------------------------------------------------------------------------------------- */
?>
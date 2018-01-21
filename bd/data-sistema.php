<?php
	/* IIRG - Funciones de sistema */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function obtenerValorIva( $dbh ){
		//Retorna el valor del iva
		$lista = array();
		$q = "select * from valores where nombre = 'iva'";
		$reg = mysql_fetch_array( mysql_query( $q, $dbh ) );

		return $reg["valor"] / 100;
	}

	function obtenerValorIva2( $dbh ){
		//Retorna el valor del iva
		$lista = array();
		$q = "select * from valores where nombre = 'iva2'";
		$reg = mysql_fetch_array( mysql_query( $q, $dbh ) );

		return $reg["valor"] / 100;
	}

	function obtenerValorRetencion( $dbh ){
		//Retorna el valor del porcentaje de retención como empresa proveedor
		$lista = array();
		$q = "select * from valores where nombre = 'retencion'";
		$reg = mysql_fetch_array( mysql_query( $q, $dbh ) );

		return $reg["valor"] / 100;
	}

	/* ----------------------------------------------------------------------------------- */
	function actualizarValorIVA( $dbh, $iva, $iva2 ){
		//Edita el valor del IVA
		$q = "update valores set valor = $iva WHERE nombre = 'iva'";
		$q2 = "update valores set valor = $iva2 WHERE nombre = 'iva2'";
		$data = mysql_query( $q, $dbh );
		$data = mysql_query( $q2, $dbh );

		return mysql_affected_rows();
	}
	/* ----------------------------------------------------------------------------------- */
	function actualizarValorRetencion( $dbh, $ret ){
		//Edita el valor de retención
		$q = "update valores set valor = $ret WHERE nombre = 'retencion'";
		$data = mysql_query( $q, $dbh );
		return mysql_affected_rows();
	}
	/* ----------------------------------------------------------------------------------- */
	function navegacionSitio(){
		$raiz = "<li><a href='main.php'><i class='fa fa-dashboard'></i>Inicio</a></li>";
		//sig_nivel = "<li class='active'><a href='$nd[url]'>$nd[enlace]$nd[param]</li>";
		return $raiz;
	}
	/* ----------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de usuarios */
	/* ----------------------------------------------------------------------------------- */
	//Modificar valor del IVA
	if( isset( $_POST["act_iva"] ) ){		
		include( "bd.php" );
		echo actualizarValorIVA( $dbh, $_POST["act_iva"], $_POST["act_iva2"] );			
	}
	//Modificar valor de retención
	if( isset( $_POST["act_ret"] ) ){		
		include( "bd.php" );
		echo actualizarValorRetencion( $dbh, $_POST["act_ret"] );			
	}

	/* ----------------------------------------------------------------------------------- */
	$sisval_iva = obtenerValorIva( $dbh );
	$sisval_iva2 = obtenerValorIva2( $dbh );
	$sisval_ret = obtenerValorRetencion( $dbh );

	/* ----------------------------------------------------------------------------------- */
?>
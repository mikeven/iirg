<?php
	/* IIRG 
	Conexión a base de datos */
	/* ----------------------------------------------------------------------------------- */
	$servidor = "127.0.0.1";
	$usuariobd = "mgideasn_admin";
	$passbd = "adminrg";
	$basedatos = "mgideasn_iirg";
	//require_once($_SERVER['DOCUMENT_ROOT'].'/lib/FirePHPCore/fb.php');
	
	$dbh = mysql_connect ( $servidor, $usuariobd, $passbd ) or die ('No se puede conectar a '.$servidor.": ". mysql_error());
	mysql_select_db ( $basedatos );
	mysql_query("SET NAMES 'utf8'");
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function cambiaf_a_mysql( $fecha ){
		//Obtiene una fecha del formato dd/mm/YYYY al formato YYYY-mm-dd
		list( $dia, $mes, $ano ) = explode( "/", $fecha );
    	$lafecha = "$ano-$mes-$dia";
		return $lafecha; 
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerFechaConFormato( $lnk, $fecha, $formato ){
		$q = "Select DATE_FORMAT('$fecha','$formato') as fecha";
		echo $q;
		$fdata = mysql_fetch_array( mysql_query ( $q, $lnk ) );
		return $fdata["fecha"];		
	}
	/* ----------------------------------------------------------------------------------- */
	function obtenerFechaActual(){
		//Obtiene la fecha actual de acuerdo a la zona horaria especificada, retornándola en varios formatos
		date_default_timezone_set( "America/Caracas" ); 		
		
		$fecha_f1['fecha'] 	= date("d/m/Y");		// formato d/m/aaaa
		$fecha_f1['hora'] 	= date("g:i a");		// Formato mm:ss am/pm ( 12 horas )
		$fecha_f2['fecha'] 	= date("Y-m-d");		// Formato aaaa-mm-dd
		$fecha_f2['hora'] 	= date("G:i:s");		// Formato mm:ss ( 24 horas )
		
		$fecha["f1"] 		= $fecha_f1;
		$fecha["f2"] 		= $fecha_f2;
		
		return $fecha;
	}
	/* ----------------------------------------------------------------------------------- */
?>
<?php
	/* R&G - Funciones de usuarios */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function checkSession( $page ){
		if( isset( $_SESSION["login"] ) ){
			if( $page == "index" ) 
				echo "<script> window.location = 'close.php'</script>";
		}else{
			if( $page == "" )
				echo "<script> window.location = 'index.php'</script>";		
		}
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerDataUsuario( $usuario ){
		$sql = "select usuario, nombre, apellido from usuario where usuario";					
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function registrarInicioSesion( $usuario, $dbh ){
		$adj_time = 96; // Tiempo para ajustar diferencia con hora de servidor ( minutos )
		$adjsql = "NOW() + INTERVAL $adj_time MINUTE";
		$query = "insert into ingreso values ('', $usuario[idUsuario], $adjsql )";
		$Rs = mysql_query ( $query, $dbh );
		return mysql_insert_id();	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function iniciarSesion( $usuario, $pass, $dbh ){
		session_start();
		$idresult = 0; 
		$sql = "select idUsuario, usuario, password, nombre from usuario 
		where usuario ='".$usuario."' and password='".$pass."'";
		$data = mysql_query ( $sql, $dbh );
		$data_user = mysql_fetch_array( $data );
		$nrows = mysql_num_rows( $data );
		
		if( $nrows > 0 ){
			$_SESSION["login"] = 1;
			$_SESSION["user"] = $data_user;
			//registrarInicioSesion( $data_user, $dbh );
			$idresult = 1; 
		}
		
		return $idresult;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["login"] ) ){
		include( "bd.php" );
		$usuario = $_POST["usuario"];
		$pass = $_POST["passw"];
		$return = iniciarSesion( $usuario, $pass, $dbh );
		
		echo $return;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_GET["logout"] ) ){
		//include( "bd.php" );
		unset( $_SESSION["login"] );
		echo "<script> window.location = 'index.php'</script>";		
	}
	/*--------------------------------------------------------------------------------------------------------*/
	if( isset( $_SESSION["login"] ) ){
		$idu = $_SESSION["user"]["idUsuario"];
	}else $idu = NULL;
	/*--------------------------------------------------------------------------------------------------------*/
?>
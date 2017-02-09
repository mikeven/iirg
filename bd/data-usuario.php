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
	function usuarioValido( $usuario, $dbh ){
		$valido = true;

		$q = "select usuario from usuario where usuario = '$usuario'";
		$data_user = mysql_fetch_array( mysql_query ( $q, $dbh ) );
		if( $usuario == $data_user["usuario"] ) $valido = false;

		return $valido;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function obtenerUsuarioPorId( $idu, $dbh ){
		$sql = "select * from usuario where idUsuario = $idu";
		$data_user = mysql_fetch_array( mysql_query ( $sql, $dbh ) );
		return $data_user;					
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
	function registrarUsuario( $usuario, $pass, $dbh ){
		$query = "insert into usuario (usuario, password) values ( '$usuario', '$pass' )";
		//echo $query;
		$Rs = mysql_query ( $query, $dbh );
		
		return mysql_insert_id();	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function iniciarSesion( $usuario, $pass, $dbh ){
		session_start();
		$idresult = 0; 
		$sql = "select idUsuario, usuario, password, nombre from usuario where usuario = '$usuario' and password='$pass'";
		
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
	function modificarDatosEmpresa( $usuario, $dbh ){
		$actualizado = 1;
		$q = "update usuario set empresa = '$usuario[empresa]', subtitulo = '$usuario[subtitulo]', rif = '$usuario[rif]', 
		Email = '$usuario[email]', telefonos = '$usuario[telefonos]', direccion1 = '$usuario[direccion1]', direccion2 = '$usuario[direccion2]', 
		vendedor = '$usuario[vendedor]' where idUsuario = $usuario[id]";
		//echo $q;
		
		mysql_query( $q, $dbh );
		
		mysql_query( $q, $dbh );
		if( mysql_affected_rows() == -1 ) $actualizado = 0;
		
		return $actualizado;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function modificarDatosUsuario( $usuario, $dbh ){
		$actualizado = 1;
		$q = "update usuario set usuario = '$usuario[usuario]', nombre = '$usuario[nombre]' 
		where idUsuario = $usuario[id]";
		//echo $q;
		
		mysql_query( $q, $dbh );
		if( mysql_affected_rows() == -1 ) $actualizado = 0;
		
		return $actualizado;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	function modificarPassword( $usuario, $dbh ){
		$actualizado = 1;
		$q = "update usuario set password = '$usuario[password]' where idUsuario = $usuario[id]";
		//echo $q;
		
		$data = mysql_query( $q, $dbh );
		
		if( mysql_affected_rows() != 1 )
			$actualizado = 0;
		
		return $actualizado;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de usuarios */
	/* ----------------------------------------------------------------------------------------------------- */
	//Inicio de sesión
	if( isset( $_POST["login"] ) ){
		include( "bd.php" );
		$usuario = $_POST["usuario"];
		$pass = $_POST["passw"];
		$return = iniciarSesion( $usuario, $pass, $dbh );
		
		echo $return;
	}
	/* ----------------------------------------------------------------------------------------------------- */
	//Registro de nuevo usuario
	if( isset( $_POST["registro"] ) ){
		include( "bd.php" );
		$usuario = $_POST["rusuario"];
		$pass = $_POST["rpassw1"];
		
		if( usuarioValido( $usuario, $dbh ) == true ){
			$return = registrarUsuario($usuario, $pass, $dbh );
			//echo $return;
			if( $return =! 0 ){
				$res["exito"] = 1;
				$res["mje"] = "El usuario ha sido registrado con éxito";
			}else{
				$res["exito"] = 0;
				$res["mje"] = "Error al registrar usuario";
			}
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Este usuario ya existe";
		}

		echo json_encode( $res );
	}
	
	/* ----------------------------------------------------------------------------------------------------- */
	/* Solicitudes asíncronas al servidor para procesar información de Usuarios */
	/* ----------------------------------------------------------------------------------------------------- */
	//Inicio de sesión
	if( isset( $_SESSION["login"] ) ){
		$idu = $_SESSION["user"]["idUsuario"];
	}else $idu = NULL;
	
	/*--------------------------------------------------------------------------------------------------------*/
	//Cierre de sesión
	if( isset( $_GET["logout"] ) ){
		//include( "bd.php" );
		unset( $_SESSION["login"] );
		echo "<script> window.location = 'index.php'</script>";		
	}	
	/*--------------------------------------------------------------------------------------------------------*/
	//Modificar datos de usuario. Bloque: empresa
	if( isset( $_POST["mod_empresa"] ) ){
		
		include("bd.php");
		$usuario["id"] 			= $_POST["idUsuario"];
		$usuario["empresa"] 	= $_POST["empresa"];
		$usuario["subtitulo"] 	= $_POST["subtitulo"];
		$usuario["rif"] 		= $_POST["rif"];
		$usuario["email"] 		= $_POST["email"];
		$usuario["direccion1"] 	= $_POST["direccion1"];
		$usuario["direccion2"] 	= $_POST["direccion2"];
		$usuario["telefonos"] 	= $_POST["telefonos"];
		$usuario["vendedor"] 	= $_POST["vendedor"];
		
		$res["exito"] = modificarDatosEmpresa( $usuario, $dbh );
		
		if( $res["exito"] == 1 )
			$res["mje"] = "Datos de usuario modificados con éxito";
		else
			$res["mje"] = "Error al modificar datos de usuario";
		
		echo json_encode( $res );	
	}
	//Modificar datos de usuario. Bloque: datos personales
	if( isset( $_POST["mod_usuario"] ) ){
		include( "bd.php" );
		$usuario["id"] 			= $_POST["idUsuario"];
		$usuario["usuario"] 	= $_POST["usuario"];
		$usuario["nombre"] 		= $_POST["nombre"];
		
		$res["exito"] = modificarDatosUsuario( $usuario, $dbh );
		
		if( $res["exito"] == 1 )
			$res["mje"] = "Datos de usuario modificados con éxito";
		else
			$res["mje"] = "Error al modificar datos de usuario";
		
		echo json_encode( $res );
	}
	//Modificar datos de usuario. Bloque: contraseña
	if( isset( $_POST["mod_passw"] ) ){
		
		include("bd.php");
		$usuario["id"] 		= $_POST["idUsuario"];
		$usuario["password"] 	= $_POST["password1"];
		
		$res["exito"] = modificarPassword( $usuario, $dbh );
		
		if( $res["exito"] == 1 )
			$res["mje"] = "Contraseña actualizada con éxito";
		else
			$res["mje"] = "Error al actualizar contraseña";
		
		echo json_encode( $res );	
	}
?>
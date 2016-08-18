<?php
	/*
	 * R&G - Inicio de sesión
	 * 
	 */
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/data-usuario.php" );
	checkSession( '' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<a href="index.php?logout">Salir</a>
</body>
</html>
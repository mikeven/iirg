<?php
	/* R&G - Funciones de formatos de documentos */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerFormatoPorUsuarioDocumento( $dbh, $doc, $idu ){
		$q = "select * from formato where doc = '$doc' and idUsuario = $idu";
		return mysql_fetch_array( mysql_query ( $q, $dbh ) );
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function guardarFormato( $dbh, $documento, $form, $sec ){
		if( $sec == "enc" )
			$q = "update formato set doc = '$documento', enc1 = '$form->l1', enc2 = '$form->l2', enc3 = '$form->l3', 
		enc4 = '$form->l4', enc5 = '$form->l5', enc6 = '$form->l6' where idUsuario = $form->idUsuario";
		
		if( $sec == "ent" )
			$q = "update formato set doc = '$documento', entrada = '$form->entrada' where idUsuario = $form->idUsuario";
		
		if( $sec == "obs" )
			$q = "update formato set doc = '$documento', titulo_obs = '$form->tobs', obs1 = '$form->vobs1', 
			obs2 = '$form->vobs2', obs3 = '$form->vobs3' where idUsuario = $form->idUsuario";


		$data = mysql_query( $q, $dbh );
		//echo $q;
		return mysql_affected_rows();
	}
	/*--------------------------------------------------------------------------------------------------------*/

	if( isset( $_POST["form"] ) ){
		
		include("bd.php");
		$form = json_decode( $_POST["form"] );
		$idr = guardarFormato( $dbh, $_POST["doc"], $form, $_POST["s"] );

		if( $idr != -1 ){
			$res["exito"] = 1;
			$res["mje"] = "Registro exitoso";
		}else{
			$res["exito"] = 0;
			$res["mje"] = "Error al guardar información";
		}

		echo json_encode( $res );
	}
?>
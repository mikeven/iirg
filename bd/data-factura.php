<?php
	/* R&G - Funciones de clentes */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	include( "bd.php" );
	/*-----------------------------------------------------------------------------------------------------------------------*/	
	function obtenerListaFacturas( $link ){
		$lista_c = array();
		$q = "Select F.IdFactura as id, C.Nombre as cliente, date_format(F.fecha_emision,'%d/%m/%Y') as Fecha, 
				F.total as Total from factura F, cliente C where F.IdCliente2 = C.IdCliente2 order by cliente asc";
		$data = mysql_query( $q, $link );
		while( $c = mysql_fetch_array( $data ) ){
			$lista_c[] = $c;	
		}
		return $lista_c;	
	}
	/* ----------------------------------------------------------------------------------------------------- */
	if( isset( $_POST["reg_factura"] ) ){
		//echo "FACTURA ".$_POST["form"];
		$dataform = json_decode($_POST["form"]);
		print_r($dataform);
	}
	/*--------------------------------------------------------------------------------------------------------*/
?>
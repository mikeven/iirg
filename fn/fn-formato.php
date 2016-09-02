<?php
	/* R&G - Funciones de formatos de documentos */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerObservacionesCtz( $fctz ){
		$obs = array();
		for ( $i = 1; $i <= 3; $i++ ) { 
			if( $fctz["obs$i"] == "VALIDEZ DE COTIZACIÓN" ) { 
				$obs[$i]["t"] = "Validez: <label id='nval'></label>"; 
				$obs[$i]["v"] = ""; 
			}
			else { 
				$obs[$i]["t"] = $fctz["obs$i"]; 
				$obs[$i]["v"] = $fctz["obs$i"]; 
			}	
		}
		$obs[0]["t"] = $fctz["titulo_obs"]; $obs[0]["v"] = $fctz["titulo_obs"];
		return $obs;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	
?>
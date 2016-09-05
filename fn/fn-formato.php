<?php
	/* R&G - Funciones de formatos de documentos */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerObservacionesCtz( $fctz ){
		$obs = array();
		for ( $i = 1; $i <= 3; $i++ ) { 
			if( $fctz["obs$i"] == "#vctz" ) { 
				$obs[$i]["t"] = "Validez: "."<label id='vvalz'></label>"; 
				$obs[$i]["v"] = "Validez: ";
				$obs[$i]["dv"] = "VCTZ"; 
			}
			else { 
				$obs[$i]["t"] = $fctz["obs$i"]; 
				$obs[$i]["v"] = $fctz["obs$i"];
				$obs[$i]["dv"] = "";
			}	
		}
		$obs[0]["t"] = $fctz["titulo_obs"]; $obs[0]["v"] = $fctz["titulo_obs"];
		return $obs;
	}

	function dataU( $frt_c, $usuario ){

		if( $frt_c["enc1"] == "" ) { if( $usuario["empresa"] != "" ) $datau[0] = $usuario["empresa"]; } 
			else $datau[0] = $frt_c["enc1"];

	    if( $frt_c["enc2"] == "" ) { if( $usuario["subtitulo"] != "" ) $datau[1] = $usuario["subtitulo"]; } 
	    	else $datau[1] = $frt_c["enc2"];

	    if( $frt_c["enc3"] == "" ) { if( $usuario["direccion1"] != "" ) $datau[2] = $usuario["direccion1"]; } 
	    	else $datau[2] = $frt_c["enc3"];

	    if( $frt_c["enc4"] == "" ) { if( $usuario["direccion2"] != "" ) $datau[3] = $usuario["direccion2"]; } 
	    	else $datau[3] = $frt_c["enc4"];

	    if( $frt_c["enc5"] == "" ) { if( $usuario["telefonos"] != "" ) $datau[4] = $usuario["telefonos"]; } 
	    	else $datau[4] = $frt_c["enc5"];

	    if( $frt_c["enc6"] == "" ) { if( $usuario["email"] != "" ) $datau[5] = $usuario["email"]; } 
	    	else $datau[5] = $frt_c["enc6"];
		
		return $datau;
	}
	/*--------------------------------------------------------------------------------------------------------*/

	function dataObs( $frt_c ){
		$do[1]["p"] = ""; $do[2]["p"] = ""; $do[3]["p"] = "";
		$do[1]["t"] = $frt_c["obs1"]; $do[2]["t"] = $frt_c["obs2"]; $do[3]["t"] = $frt_c["obs3"];
		$do[1]["v"] = $frt_c["obs1"]; $do[2]["v"] = $frt_c["obs2"]; $do[3]["v"] = $frt_c["obs3"];
		$do[1]["dv"] = ""; $do[2]["dv"] = ""; $do[3]["dv"] = "";
    	
    	if( $frt_c["obs1"] == "#vctz" ) { 
    		$do[1]["p"] = "readonly"; $do[1]["t"] = "Validez cotización"; 
    		$do[1]["v"] = "#vctz";  $do[1]["dv"] = "VCTZ"; 
    	}

    	if( $frt_c["obs2"] == "#vctz" ) { 
    		$do[2]["p"] = "readonly"; $do[2]["t"] = "Validez cotización"; 
    		$do[2]["v"] = "#vctz"; $do[2]["dv"] = "VCTZ"; 
    	}

    	if( $frt_c["obs3"] == "#vctz" ) { 
    		$do[3]["p"] = "readonly"; $do[3]["t"] = "Validez cotización"; 
    		$do[3]["v"] = "#vctz"; $do[3]["dv"] = "VCTZ"; 
    	}

    	return $do;
	}
	
?>
<?php
	/* R&G - Funciones de formatos de documentos */
	/*-------------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------*/
	function obtenerFormatoObservacionesCtz( $fctz, $cond_defecto ){
		$obs = array();
		for ( $i = 1; $i <= 3; $i++ ) { 
			if( $fctz["obs$i"] == "#vctz" ) { 
				$obs[$i]["t"] = "Validez: "."<label id='vvalz'></label>"; 
				$obs[$i]["v"] = "Validez: ".$cond_defecto;
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
	/* ----------------------------------------------------------------------------------- */
	function obtenerResumenObs( $frt ){
		/* Retorna el bloque de información referente a las observaciones del formato del documento */
		$obs = array();
		for ( $i = 1; $i <= 3; $i++ ) { 
			$obs[$i] = $frt["obs$i"];
			if( $frt["obs$i"] == "#vctz" ) $obs[$i] = "Validez cotización"; 
			if( $frt["obs$i"] == "#vfac" ) $obs[$i] = "Condición de pago";	 
		}
		$obs[0] = $frt["titulo_obs"];
		return $obs;
	}
	/* ----------------------------------------------------------------------------------- */
	function dataU( $frt_c, $usuario ){
		//Retorna los datos iniciales para mostrar en el encabezado del formato de documentos
		//Si no existe valores en el formato, se toman de la cuenta de usuario
		for ( $i = 0; $i <= 5; $i++ ) { $datau[$i] = ""; }
			
		if( $frt_c["enc1"] == "" ) { 
			if( $usuario["empresa"] != "" ) $datau[0] = $usuario["empresa"]; 
		} 
		else $datau[0] = $frt_c["enc1"]; 	//Nombre de empresa

	    if( $frt_c["enc2"] == "" ) { 
	    	if( $usuario["subtitulo"] != "" ) $datau[1] = $usuario["subtitulo"]; 
		} 
	    else $datau[1] = $frt_c["enc2"];	//Subtítulo

	    if( $frt_c["enc3"] == "" ) { 
	    	if( $usuario["direccion1"] != "" ) $datau[2] = $usuario["direccion1"]; 
	    } 
	    else $datau[2] = $frt_c["enc3"];	//Línea de dirección 1

	    if( $frt_c["enc4"] == "" ) { 
	    	if( $usuario["direccion2"] != "" ) $datau[3] = $usuario["direccion2"]; 
	    } 
	    else $datau[3] = $frt_c["enc4"];	//Línea de dirección 2

	    if( $frt_c["enc5"] == "" ) { 
	    	if( $usuario["telefonos"] != "" ) $datau[4] = $usuario["telefonos"]; 
	    } 
	    else $datau[4] = $frt_c["enc5"];	//Teléfonos

	    if( $frt_c["enc6"] == "" ) { 
	    	if( $usuario["email"] != "" ) $datau[5] = $usuario["email"]; 
	    } 
	    else $datau[5] = $frt_c["enc6"];	//Email
		
		return $datau;
	}
	/* ----------------------------------------------------------------------------------- */
	function configDoc( $doc ){
		/*Retorna el vector de parámetros */
		$config["ctz"] = array( 'idcampo' => '#vctz', 'texto' => 'Validez cotización', 'data-param' => 'VCTZ' );
		$config["fac"] = array( 'idcampo' => '#vfac', 'texto' => 'Condición de pago', 'data-param' => 'VFAC' );
		
		return $config[$doc];
	}
	/* ----------------------------------------------------------------------------------- */
	function dataObs( $frt, $doc ){
		/*	p: parametro para indicar si el campo es readonly o no
			t: texto de la observación
			v: valor del campo de la observación
			dv: 
		*/
		$cfg = configDoc( $doc );
		$do[1]["p"] = ""; $do[2]["p"] = ""; $do[3]["p"] = "";
		$do[1]["t"] = $frt["obs1"]; $do[2]["t"] = $frt["obs2"]; $do[3]["t"] = $frt["obs3"];
		$do[1]["v"] = $frt["obs1"]; $do[2]["v"] = $frt["obs2"]; $do[3]["v"] = $frt["obs3"];
		$do[1]["dv"] = ""; $do[2]["dv"] = ""; $do[3]["dv"] = "";
    	
    	if( $frt["obs1"] == $cfg["idcampo"] ) { 
    		$do[1]["p"] = "readonly"; $do[1]["t"] = $cfg["texto"]; 
    		$do[1]["v"] = $cfg["idcampo"];  $do[1]["dv"] = $cfg["data-param"]; 
    	}

    	if( $frt["obs2"] == $cfg["idcampo"] ) { 
    		$do[2]["p"] = "readonly"; $do[2]["t"] = $cfg["texto"]; 
    		$do[2]["v"] = $cfg["idcampo"]; $do[2]["dv"] = $cfg["data-param"]; 
    	}

    	if( $frt["obs3"] == $cfg["idcampo"] ) { 
    		$do[3]["p"] = "readonly"; $do[3]["t"] = $cfg["texto"]; 
    		$do[3]["v"] = $cfg["idcampo"]; $do[3]["dv"] = $cfg["data-param"]; 
    	}

    	return $do;
	}
	
?>
<?php
	/* R&G - Funciones de formularios */
	/*-----------------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------------------------------------------------*/
	function obtenerDataForm( $pairs ){
		$dataform = array();
		//Chequeo por pares (campo=valor),(campo=valor),...,(campo=valor)
		foreach ( $pairs as $i ) {
			list( $name, $value ) = explode( '=', $i, 2 );
			$par["f"] = urldecode( $name );
			$par["v"] = urldecode( $value );
			$dataform[] = $par;
		}
		//$dataform = insertarFecha( $dataform );
		return $dataform;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function ajustarValor( $val ){
		switch ( $val ) {
			case "on":
				$valor = 1;
				break;
			case "NOW()":
				$valor = $val;
				break;
			default:
       			$valor = "'".$val."'";
		}
		return $valor;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function valuescoma( $campos, $n ){
		//Construcción de la cadena del query con los valores de los campos a llenar
		$vlist = ""; $val = "";
		$cont = 0;
		foreach( $campos as $par ){
			$cont++;
			if( $cont == $n ) $comma = ""; else $comma = ", ";
			$val = ajustarValor( $par["v"] );
			$vlist .= $val.$comma;
		}
		return $vlist;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function fieldscoma( $campos, $n ){
		//Construcción de la cadena del query con los campos de la tabla a llenar
		$list = "";
		$cont = 0;
		foreach($campos as $par){
			$cont++;
			if( $cont == $n ) $comma = ""; else $comma = ", ";
			//if( $par["f"] != "rb_ds" )
				$list .= $par["f"].$comma;
		}
		return $list;	
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function hacerQuery( $tname, $dataform, $n ){
		//Construye el query para insertar un registro en una tabla (INSERT)
		
		$sql = "insert into $tname (";
		$flist = fieldscoma( $dataform, $n );
		$sql .= $flist;
		
		$sql .= " ) values ( ";
		$vlist = valuescoma( $dataform, $n );
		 
		$sql .= $vlist;
		$sql .= ")";
		return $sql;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function selop( $vlist, $vreg ){
		//Retorna el parámetro 'selected' para opciones de listas desplegables: marcar como seleccionada
		$sel = "";
		if( $vlist == $vreg ) $sel = "selected";
		return $sel;
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function opCondicion( $data, $c ){
		//Retorna la etiqueta html option de lista desplegable 
		if( isset( $data ) ) $param = selop( $c["idCondicion"], $data["idCondicion"] );
		$opt = "<option value='$c[idCondicion]' $param>$c[nombre]</option>";
		return $opt;                                                  
	}
	/*--------------------------------------------------------------------------------------------------------*/
?>
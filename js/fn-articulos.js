// JavaScript Document
/*
* fn-articulos.js
*
*/
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function ventanaMensaje( exito, mensaje ){
	var clase_m = ["modal-danger", "modal-success"];
	$("#tx-vmsj").html( "" );	
	$("#ventana_mensaje").addClass( clase_m[exito] );
	$("#tit_vmsj").html( mensaje );
	$("#enl_vmsj").click();
}
/* ----------------------------------------------------------------------------------- */
function enviarRespuesta( res, modo, idhtml ){
	//Manejo de respuesta de acuerdo al modo indicado
	if( modo == "ventana" ){
		ventanaMensaje( res.exito, res.mje );
	}
	if( modo == "redireccion" ){
		var url = "ficha_articulo.php?a=" + res.id;
		window.location.href = url;
	}
	if( modo == "print" ){
		$( idhtml ).html( res.mje );	
	}
}
/* ----------------------------------------------------------------------------------- */
function guardarArticulo( form, modo_respuesta, idhtml ){
	//Invocación a registrar de artículo
	var url_data = "bd/data-articulo.php";
	var frm = form; 
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ articulo: frm.serialize(), regArticulo:1 },
        success: function( response ){
			res = jQuery.parseJSON(response);
			enviarRespuesta( res, modo_respuesta, idhtml );
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function marcarCampo( campo, error ){
	if( error == 1 )
		campo.css({'border-color' : '#dd4b39'});
	if( error == 0 )
		campo.css({'border-color' : '#ccc'});
}
/* ----------------------------------------------------------------------------------- */
function valorExistente( html, clave, val, cres ){
	var url_data = "bd/data-articulo.php";
	var existe = 0;
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ campo: clave, valor: val, existe: 1 },
        success: function( response ){
			$(cres).val(response);
			marcarCampo( html, response );
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function checkArticulo(){
	//Validación de datos de artículo antes de registrarse
	var error = 0;
	if( $("#err_desc").val() == 1 ) {
		error = 1;
		$("#tx-vmsj").html("Nombre de producto ya existe");
	}

	if( $("#err_cod").val() == 1 ) {
		error = 1;
		$("#tx-vmsj").html("Código de producto ya existe");
	}

	if( error == 1 ){
		//Asignar ventana de mensaje como mensaje de error
		$("#ventana_mensaje").addClass("modal-danger");
		$("#tit_vmsj").html( "Error" );
	}

	return error;
}
/* ----------------------------------------------------------------------------------- */
function reg_categoria( frm_categoria ){
	url_data = "bd/data-articulo.php";
	var categ = $("#cnombre").val();
	var desc = $("#cdescripcion").val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ nombre: categ, descripcion: desc, reg_categoria:1 },
        success: function( response ){
			$("#tresp").html(response);
			window.location.href="categorias.php";
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function reg_unidad(){
	url_data = "bd/data-articulo.php";
	var unidad = $("#cuv").val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ nombre: unidad, reg_unidad:1 },
        success: function( response ){
			$("#tresp").html(response);
			window.location.href="categorias.php";
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function actualizarCategoria( idr, campo, valor ){
	url_data = "bd/data-articulo.php";
	if( valor != "" ){
		$.ajax({
	        type:"POST",
	        url:url_data,
	        data:{ act_categ: campo, valor_c: valor, idreg: idr },
	        success: function( response ){
	        	$( "#chkce" + idr ).hide();
				$( "#chk" + idr ).show( 300 ).delay( 2000 ).fadeOut( 1000 );
	        }
	    });
	}else{
		$( "#chkce" + idr ).show( 300 );	
	}
}
/* ----------------------------------------------------------------------------------- */
function actualizarUnidad( idr, valor ){
	url_data = "bd/data-articulo.php";
	if( valor != "" ){
		$.ajax({
	        type:"POST",
	        url:url_data,
	        data:{ act_und: 1, valor_u: valor, idreg: idr },
	        success: function( response ){
				$( "#chkue" + idr ).hide();
				$( "#chku" + idr ).show( 300 ).delay( 2000 ).fadeOut( 1000 );
				//window.location.href="nuevo-articulo.php";
	        }
	    });
	}else{
		$( "#chkue" + idr ).show( 300 );	
	}
}
/* ----------------------------------------------------------------------------------- */
function eliminarUnidad( idr ){
	url_data = "bd/data-articulo.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ elim_und: 1, idreg: idr },
        success: function( response ){
			//alert(response);
			$( "#ru" + idr ).hide('slow', function(){ 
				$( "#ru" + idr ).remove(); 
			});
        }
    });	
}

/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */

$( document ).ready(function() {
	
	$("#bt_reg_articulo").on( "click", function() {
		if( checkArticulo() == 0 )
			guardarArticulo( $("#frm_narticulo"), "redireccion", '' );
		else
			$("#enl_vmsj").click();	
	});

	$("#bt_reg_art_modal").on( "click", function() {
		if( checkArticulo() == 0 )
			guardarArticulo( $("#frm_narticulo"), "redireccion", '' );
		else
			$("#enl_vmsj").click();	
	});
	
	$(".vexistente").on( "change", function() {
		var valor = $(this).val();
		var clave = $(this).attr("name");
		var cres = $(this).attr("data-err");
		valorExistente( $(this), clave, valor, cres );
	});
	/*--------------------*/
	$(".lncat").blur(function(){
		valor = $(this).val(); idr = $(this).attr("id");
		actualizarCategoria( idr, "nombre", valor );
    })
	
	$(".ldcat").blur(function(){
		valor = $(this).val(); idr = $(this).attr("id");
		actualizarCategoria( idr, "descripcion", valor );
    })
    /*--------------------*/
    $(".lnund").on( "change", function(){
		valor = $(this).val(); idr = $( this ).attr("id");
		actualizarUnidad( idr, valor );
    })
    
	$(".euv").on( "click", function() {
		eliminarUnidad( $(this).attr( "data-idu" ) );
	});
});

/* ----------------------------------------------------------------------------------- */


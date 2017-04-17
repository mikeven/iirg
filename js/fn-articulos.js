// JavaScript Document
/*
* fn-articulos.js
*
*/
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function strSerialForm( form, cont ){
	var str = "";
	var art = null;
	if( form != null ) art = frm.serialize();
	else {
		$( cont + " .form-control").each(function() {
			if( $(this).attr('type') != "hidden" )
				str += $(this).attr('name') + "=" + $(this).val() + "&"; 
		});
		art = str.slice(0,-1);
	}
	
	return art;
}
/* ----------------------------------------------------------------------------------- */
function actVentanaModalArt( res ){
	//actVentanaModalArt: actualizar ventana modal de artículos
	//Reinicia valores y elementos gráficos de la ventana modal al registrar un artículo
	
	if( res.exito ){	
		$("#xmodalnuevo_articulo").html("Aceptar");
		$("#xmodalnuevo_articulo").on( "click", function() {
			$("#narticulo").val( res.articulo.descripcion );
			$("#idArticulo").val( res.articulo.id );
			$("#narticulo").css({'border-color' : '#ccc'});
			$("#und_art").val( res.articulo.presentacion );
			$("#xmodalnuevo_articulo").html("Cancelar");
			$("#resalerta").hide();
			resetFrm( "#formulario_narticulo" );
			$("#xmodalnuevo_articulo").click();
		});
	}
}
/* ----------------------------------------------------------------------------------- */
function guardarArticulo( form, modo_respuesta, idhtml ){
	//Invocación a registrar artículo
	var url_data = "bd/data-articulo.php";
	var art = strSerialForm( form, "#formulario_narticulo" ); 
	
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ articulo: art, regArticulo: 1 },
        success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			enviarRespuesta( res, modo_respuesta, idhtml );
			actVentanaModalArt( res );
        }
    });
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
function checkArticulo( mje_destino ){
	//Validación de datos de artículo antes de registrarse
	var error = 0; var mje = "";
	oRes = arrayMjes( mje_destino );
	//$(oRes.idhtml).addClass("modal-danger");

	if( $("#pdescripcion").val() == '' ) {
		error = 1; mje = "Debe escribir un nombre";
		marcarCampo( $("#pdescripcion"), error );
	}

	if( $("#pcodigo").val() == '' ) {
		error = 1; mje = "Debe escribir un código";
		marcarCampo( $("#pcodigo"), error );
	}

	if( $("#err_desc").val() == 1 ) {
		error = 1; mje = "Nombre de producto ya existe";
	}

	if( $("#err_cod").val() == 1 ) {
		error = 1; mje = "Código de producto ya existe";
	}

	if( error == 1 ){
		//Asignar ventana de mensaje como mensaje de error
		$(oRes.mensaje).html( mje );		
		$(oRes.idhtml).addClass(oRes.clase);
		$(oRes.titulo).html( "Error" );
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
		if( checkArticulo('modal') == 0 )
			guardarArticulo( $("#frm_narticulo"), "redireccion", '' );
		else
			$("#enl_vmsj").click();	
	});
	/*--------------------*/
	$("#bt_reg_art_modal").on( "click", function() {
		if( checkArticulo('alerta') == 0 ){
			guardarArticulo( null, "print", 'tresalerta' );

		}
		else
			$("#resalerta").fadeIn("slow");	
	});
	/*--------------------*/
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
	/*--------------------*/
	$(".ldcat").blur(function(){
		valor = $(this).val(); idr = $(this).attr("id");
		actualizarCategoria( idr, "descripcion", valor );
    })
    /*--------------------*/
    $(".lnund").on( "change", function(){
		valor = $(this).val(); idr = $( this ).attr("id");
		actualizarUnidad( idr, valor );
    })
    /*--------------------*/
	$(".euv").on( "click", function() {
		eliminarUnidad( $(this).attr( "data-idu" ) );
	});
});

/* ----------------------------------------------------------------------------------- */


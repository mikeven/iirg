// JavaScript Document
/*
* fn-compras.js
*
*/
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function initValid(){
  
	$('#frm_ncompra').bootstrapValidator({
	    message: 'Revise el contenido del campo',
	    feedbackIcons: {
	        valid: 'glyphicon glyphicon-ok',
	        invalid: 'glyphicon glyphicon-remove',
	        validating: 'glyphicon glyphicon-refresh'
	    },
	    fields: {
	        mbase: {
	            validators: { 
	              notEmpty: { message: 'Debe indicar monto' }, 
	              regexp: { regexp: /^[0-9]+(\.[0-9]{1,2})?$/,    message: 'Formato inválido de monto'} 
	            }
	        },
	        iva: {
	            validators: { notEmpty: { message: 'Debe indicar IVA' } }
	        },
			          nfactura: {
	            validators: { notEmpty: { message: 'Debe indicar nro de factura' } }
	        },
	        ncontrol: {
	            validators: { notEmpty: { message: 'Debe indicar nro de control' } }
	        }
	    },
		callback: function () {
	    	alert("OK");
	    }
	});
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
function strSerialForm( form, cont ){
	var str = "";
	var art = null;
	if( form != null ) art = form.serialize();
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
function guardarCompra( form, modo_respuesta, idhtml, accion ){
	//Invocación a registrar compra
	var url_data = "bd/data-compra.php";
	var compra = strSerialForm( $(form), form ); 
	var idu = $( '#idu_sesion' ).val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ ncompra: compra, id_u: idu, c_accion: accion },
        success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			enviarRespuestaServidor( res, modo_respuesta, idhtml, "ficha_compra.php?id=" );
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function imprimirRetencion(){
	//Invocación a generación e impresión de retención

	var url_data = "bd/data-compra.php"; 
	var idc = $( "#idCompra" ).val();
	var idu = $( '#idu_sesion' ).val();

	$.ajax({
        type:"POST",
        url:url_data,
        data:{ imp_ret: idc, id_u: idu },
        success: function( response ){
			console.log(response);
			if( response != -1 ){
				window.location.href = "impresion-retencion.php?idr=" + idc;
			}
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function estadoCompra( id, estado, modo_respuesta, idhtml ){
	//Invocación a registrar compra
	var url_data = "bd/data-compra.php";
	var idu = $( '#idu_sesion' ).val();
	$.ajax({
        type:"POST", url:url_data, 
        data:{ ecompra: id, edo: estado, id_u: idu },
        success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			enviarRespuestaServidor( res, modo_respuesta, idhtml, "" );
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
function checkCompra( mje_destino ){
	//Validación de datos de artículo antes de registrarse
	var error = 0; var mje = "";
	oRes = arrayMjes( mje_destino );
	marcarCampo( $(".form-control"), 0 );
	//$(oRes.idhtml).addClass("modal-danger");

	if( $("#nproveedor").val() == '' ) {
		error = 1; mje = "Debe indicar proveedor";
		marcarCampo( $("#nproveedor"), error );
	}

	if( $("#ncontrol").val() == '' ) {
		error = 1; mje = "Debe escribir un número de control";
		marcarCampo( $("#ncontrol"), error );
	}
	/* ----------------------------- */
	if( $("#sel_tipo_doc").val() == 'fac' ){

		if( $("#nfactura").val() == '' ) {
			error = 1; mje = "Debe escribir un número de factura";
			marcarCampo( $("#nfactura"), error );
		}

	}
	/* ............................. */
	if( $("#sel_tipo_doc").val() == 'ndc' ){

		if( $("#nncredito").val() == '' ) {
			error = 1; mje = "Debe escribir un número de nota";
			marcarCampo( $("#nncredito"), error );
		}

	}
	/* ............................. */
	if( $("#sel_tipo_doc").val() == 'ndd' ){

		if( $("#nndebito").val() == '' ) {
			error = 1; mje = "Debe escribir un número de nota";
			marcarCampo( $("#nndebito"), error );
		}

	}
	/* ............................. */
	if( $("#sel_tipo_doc").val() == 'ndc' || $("#sel_tipo_doc").val() == 'ndd' ){
	
		if( $("#nfactura_afec").val() == '' ) {
			error = 1; mje = "Debe ingresar número de factura afectada";
			marcarCampo( $("#nfactura_afec"), error );
		}
	}

	/* ----------------------------- */

	if( $("#iva").val() == '' ) {
		error = 1; mje = "Debe ingresar monto de IVA";
		marcarCampo( $("#iva"), error );
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

function iniciarVentanaConfirmacion( boton, titulo ){
	$("#titulo_emergente").html( titulo );
	$("#mje_confirmacion").html( "¿ Confirmar acción ?" );
	$("#btn_confirm").attr("id", boton );
}

/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */

$( document ).ready(function() {

	initValid();

	$('#femision').datepicker({
		autoclose: true,
		format:'dd/mm/yyyy',
		language:'es',
		title:true
	});
	/*--------------------*/
	$(".item_proveedor_lmodal").click( function(){

		$("#nproveedor").val( $(this).attr("data-label") );
		$("#idProveedor").val( $(this).attr("data-idp") );
		$("#nproveedor").css({'border-color' : '#ccc'});
		$("#xmodalproveedor").click();
    });
	/*--------------------*/
	$("#bt_reg_compra").on( "click", function() {	// Agregar registro de compra
		if( checkCompra('modal') == 0 )
			guardarCompra( "#frm_ncompra", "redireccion", '', "agregar" );
		else
			$("#enl_vmsj").click();	
	});
	/*--------------------*/
	$("#bt_mod_compra").on( "click", function() {	// Modificar registro de compra
		if( checkCompra('modal') == 0 )
			guardarCompra( "#frm_mcompra", "redireccion", '', "editar" );
		else
			$("#enl_vmsj").click();	
	});
	/*--------------------*/
	$("#bt_edo_compra").on( "click", function() {	// Eliminar/Recuperar registro de compra
		$("#closeModal").click();
		estadoCompra( $("#idCompra").val(), $("#edoaccion").val(), "ventana", '' );
		$(".btn_edo_accion").fadeOut("slow");
		$("#ventana_mensaje").on("hidden.bs.modal", function () {
		    location.reload();
		});	
	});
	/*--------------------*/
	$("#sel_tipo_doc").change( function(){
		var tdoc = $(this).val();
		if( tdoc == 'fac' ){
			$(".campo_nota").fadeOut();
			$("#campo_fac").fadeIn();
			$("#campo_fac_afectada").fadeOut();
			$("#nfactura_afec").val(""); $(".cmp_nota").val("");
		}else{
			$("#nfactura").val("");
			$("#campo_fac").fadeOut();
			$(".campo_nota").fadeOut();
			$("#campo_fac_afectada").fadeIn();
			if( tdoc == 'ndc' ) $("#campo_ndc").fadeIn();
			if( tdoc == 'ndd' ) $("#campo_ndd").fadeIn();
		}
	});
	/*--------------------*/
	$("#bt_imp_ret").on( "click", function() {	// Imprimir retención
		imprimirRetencion();	
	});
});

/* ----------------------------------------------------------------------------------- */


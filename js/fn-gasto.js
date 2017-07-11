// JavaScript Document
/*
* fn-gasto.js
*
*/
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function initValid(){
  
	$('#frm_ngasto').bootstrapValidator({
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
function guardarGasto( form, modo_respuesta, idhtml, accion ){
	//Invocación a registrar compra
	var url_data = "bd/data-gasto.php";
	var gasto = strSerialForm( $(form), form ); 
	var idu = $( '#idu_sesion' ).val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ rgasto: gasto, id_u: idu, g_accion: accion },
        success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			enviarRespuestaServidor( res, modo_respuesta, idhtml, "ficha_gasto.php?id=" );
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function estadoGasto( id, estado, modo_respuesta, idhtml ){
	//Invocación a registrar compra
	var url_data = "bd/data-gasto.php";
	var idu = $( '#idu_sesion' ).val();
	$.ajax({
        type:"POST", url:url_data, 
        data:{ egasto: id, edo: estado, id_u: idu },
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
function checkGasto( mje_destino ){
	//Validación de datos de gasto antes de registrarse
	var error = 0; var mje = "";
	oRes = arrayMjes( mje_destino );
	marcarCampo( $(".form-control"), 0 );
	//$(oRes.idhtml).addClass("modal-danger");

	if( $("#tgasto").val() == 0 ) {
		error = 1; mje = "Debe indicar tipo de gasto";
		marcarCampo( $("#tgasto"), error );
	}

	if( $("#concepto").val() == '' ) {
		error = 1; mje = "Debe escribir un concepto";
		marcarCampo( $("#concepto"), error );
	}

	if( $("#beneficiario").val() == '' ) {
		error = 1; mje = "Debe escribir un beneficiario";
		marcarCampo( $("#beneficiario"), error );
	}

	if( $("#monto").val() == '' ) {
		error = 1; mje = "Debe ingresar un monto";
		marcarCampo( $("#monto"), error );
	}

	if( $("#mpagado").val() == '' ) {
		error = 1; mje = "Debe indicar el monto pagado";
		marcarCampo( $("#mpagado"), error );
	}

	if( $("#forma_pago").val() == 0 ) {
		error = 1; mje = "Debe indicar forma de pago";
		marcarCampo( $("#forma_pago"), error );
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
	$("#selcompra").hide();

	$('#fpago').datepicker({
		autoclose: true,
		format:'dd/mm/yyyy',
		language:'es',
		title:true
	});
	/*--------------------*/
	$(".item_compra_lmodal").click( function(){

		$("#ncompra").val( $(this).attr("data-label") );
		$("#monto").val( $(this).attr("data-tmonto") );
		$("#mpagado").val( $(this).attr("data-mpagado") );
		$("#idCompra").val( $(this).attr("data-idcompra") );
		$("#bt_umpag").attr( "data-m", $(this).attr("data-tmonto") );
		$("#concepto").val( $(this).attr("data-concepto") );
		$("#beneficiario").val( $(this).attr("data-beneficiario") );
		$("#ncompra").css({'border-color' : '#ccc'});
		$("#xmodalcompra").click();
    });

	$("#tgasto").on( "change", function() {
		if( $(this).val() == "pago" ){
			$("#selcompra").show(300);
			$("#bloc_mpagado").fadeIn(300);
		}else{
			$("#selcompra").fadeOut(300);
			$("#bloc_mpagado").fadeOut(300);
		}
    });

	/*--------------------*/
	$("#bt_reg_gasto").on( "click", function() {	// Agregar registro de gasto
		if( checkGasto('modal') == 0 )
			guardarGasto( "#frm_ngasto", "redireccion", '', "agregar" );
		else
			$("#enl_vmsj").click();	
	});
	/*--------------------*/
	$("#bt_mod_gasto").on( "click", function() {	// Modificar registro de gasto
		if( checkGasto('modal') == 0 )
			guardarGasto( "#frm_mgasto", "redireccion", '', "editar" );
		else
			$("#enl_vmsj").click();	
	});

	$("#bt_umpag").on( "click", function() {	// Modificar registro de compra
		$("#mpagado").val( $(this).attr("data-m") );	
	});
	/*--------------------*/
	$("#bt_edo_gasto").on( "click", function() {	// Eliminar/Recuperar registro de compra
		$("#closeModal").click();
		estadoGasto( $("#idGasto").val(), $("#edoaccion").val(), "ventana", '' );
		$(".btn_edo_accion").fadeOut("slow");
		$("#ventana_mensaje").on("hidden.bs.modal", function () {
		    location.reload();
		});	
	});
	/*--------------------*/
});

/* ----------------------------------------------------------------------------------- */


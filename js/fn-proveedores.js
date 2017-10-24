// JavaScript Document
/*
* fn-clientes.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function valorExistente( html, clave, val, cres ){
	var url_data = "bd/data-proveedor.php";
	var existe = 0;
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ campo: clave, valor: val, existe_rif: 1 },
        success: function( response ){
			$(cres).val(response);
			marcarCampo( html, response );
        }
    });
}
/* --------------------------------------------------------- */
function reg_proveedor( frm_nproveedor ){
	url_data = "bd/data-proveedor.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ nproveedor: frm_nproveedor.serialize(), reg_proveedor:1 },
        success: function( response ){
			res = jQuery.parseJSON(response);
			enviarRespuestaServidor( res, "redireccion", '', "ficha_proveedor.php?p=" );
        }
    });
}
/* --------------------------------------------------------- */
function mod_proveedor( form ){
	url_data = "bd/data-proveedor.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ mproveedor: form.serialize() },
        success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			enviarRespuestaServidor( res, "redireccion", '', "ficha_proveedor.php?p=" );
        }
    });
}
/* --------------------------------------------------------- */
function checkProveedor( mje_destino ){
	//Validación de datos de proveedor antes de registrarse
	var error = 0; var mje = "";
	oRes = arrayMjes( mje_destino );	//fn-ui.js
	//$(oRes.idhtml).addClass("modal-danger");

	if( $("#err_rif").val() == 1 ) {
		error = 1; mje = "RIF ya registrado en un proveedor";
	}

	if( $("#err_email").val() == 1 ) {
		error = 1; mje = "Email ya registrado en un proveedor";
	}

	if( error == 1 ){
		//Asignar ventana de mensaje como mensaje de error
		$(oRes.mensaje).html( mje );		
		$(oRes.idhtml).addClass(oRes.clase);
		$(oRes.titulo).html( "Error" );
	}

	return error;
}
/* --------------------------------------------------------- */
function bt_reg_proveedor(){
	if( checkProveedor('modal') == 0 )
		reg_proveedor( $("#frm_nproveedor") );
	else
		$("#enl_vmsj").click();
}
/* --------------------------------------------------------- */
function bt_mod_proveedor(){
	//if( checkProveedor('modal') == 0 )
	mod_proveedor( $("#frm_mproveedor") );
	/*else
		$("#enl_vmsj").click();*/
}
/* --------------------------------------------------------- */
$(document).ready(function(){

	$('#frm_nproveedor').bootstrapValidator({
        message: 'Revise el contenido del campo',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: { 
                	notEmpty: { message: 'Debe indicar un email' },
					emailAddress: { message: 'Debe especificar un email válido' } }
                },
			nombre: {
                validators: { notEmpty: { message: 'Debe indicar nombre' } }
            },
			rif: {
                validators: { notEmpty: { message: 'Debe indicar RIF' } }
            }
        },
		callback: function () {
    		alert("OK-CALLBACK");
        }
    }).on('submit', function (e) {
	  	if ( e.isDefaultPrevented() ) {  } 
		else {
	    	bt_reg_proveedor();
	    	return false;
		}
	});

    

	$(".bdir").attr("maxlength", 46);

	$(".vexistente").on( "change", function() {
		var valor = $(this).val();
		var clave = $(this).attr("name");
		var cres = $(this).attr("data-err");
		valorExistente( $(this), clave, valor, cres );
	});

});

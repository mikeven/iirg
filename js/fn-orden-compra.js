// JavaScript Document
/*
* fn-cotizacion.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function initValid(){
	$('#frm_nordencompra').bootstrapValidator({
		message: 'Revise el contenido del campo',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
		  nombre_proveedor: {
		      validators: { notEmpty: { message: 'Debe indicar proveedor' } }
		  },
		  punit: {
		      validators: { 
		        regexp: { regexp: /^[0-9]+(\.[0-9]{1,2})?$/, message: 'Formato inválido de monto'} 
		      }
		  }
		},
		onSuccess: function(e, data) {
         	e.preventDefault();
        	//bt_reg_ordencompraclick();
        }
  	}); 
}
/* --------------------------------------------------------- */
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey; 
/* --------------------------------------------------------- */
function obtenerVectorEncabezado( numero, idproveedor, femision, total, iva ){
	encabezado = new Object();
	encabezado.numero = $( '#nordencompra' ).val();
	encabezado.idproveedor = $( '#idProveedor' ).val();
	encabezado.femision = $( '#femision' ).val();
	encabezado.idu = $( '#idu_sesion' ).val();

	encabezado.introduccion = $( '#tentrada' ).val();
	encabezado.obs0 = $( '#tobs0' ).val();
	encabezado.obs1 = $( '#tobs1' ).val();
	encabezado.obs2 = $( '#tobs2' ).val();
	encabezado.obs3 = $( '#tobs3' ).val();

	encabezado.total = $( '#total' ).val();
	encabezado.iva = $( '#iva' ).val();

	return JSON.stringify( encabezado );
}
/* --------------------------------------------------------- */
function guardarOrdenCompra(){
		
	fencabezado = obtenerVectorEncabezado();
	oc_detalle = obtenerVectorDetalle();

	$.ajax({
		type:"POST",
		url:"bd/data-orden-compra.php",
		data:{ encabezado: fencabezado, detalle: oc_detalle, reg_orden_compra : 1 },
		beforeSend: function (){
			$("#btn_confirmacion").fadeOut(200);
		},
		success: function( response ){
			//console.log(response);
			res = jQuery.parseJSON(response);
			var enlace = obtenerEnlaceDocumentoCreado( res.documento, res.documento.frm_r );
			ventanaMensaje( res.exito, res.mje, enlace );
			bloquearDocumento();
		}
	});		
}
/* --------------------------------------------------------- */
function checkOrdenCompra(){
	//Validación de formulario de orden de compra previo a su registro
	var error = 0;
	
	if( $("#idProveedor").val() == "" ){
		//Proveedor no seleccionado
		$("#tx-vmsj").html("Debe indicar un proveedor");
		$("#nproveedor").css({'border-color' : '#dd4b39'});
		error = 1;
	}

	if( ( contarItems() == 0 ) && ( error == 0 ) ){
		//Orden de compra sin ítems
		$("#tx-vmsj").html("Debe ingresar ítems en la orden de compra");
		error = 1;
	}

	if( error == 1 ){
		//Asignar ventana de mensaje como mensaje de error
		$("#ventana_mensaje").addClass("modal-danger");
		$("#tit_vmsj").html( "Error" );
	}
	
	return error;	
}
/* --------------------------------------------------------- */
$( document ).ready(function() {
	$("#titulo_emergente").html("Guardar orden de compra");
	$("#mje_confirmacion").html("¿Confirmar registro?");
	$("#btn_confirm").attr("id", "bt_reg_ordencompra");

	var cant = "";

	$("#fordc").blur( function(){
		if( $(this).val() != "" )
			$(this).css({'border-color' : '#ccc'});
    });
	
	/* =============================================================================== */
    $("#bt_reg_ordencompra").on( "click", function(){
		$("#closeModal").click();
		if( checkOrdenCompra() == 0 )
			guardarOrdenCompra();
		else
			$("#enl_vmsj").click();
    });
    /* =============================================================================== */
});
/* ----------------------------------------------------------------------------------- */


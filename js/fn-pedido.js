// JavaScript Document
/*
* fn-cotizacion.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function initValid(){
  
	$('#frm_npedido').bootstrapValidator({
		message: 'Revise el contenido del campo',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
		  punit: {
		      validators: { 
		        notEmpty: { message: 'Debe indicar precio' }, 
		        regexp: { regexp: /^[0-9]+(\.[0-9]{1,2})?$/,    message: 'Formato inválido de monto'} 
		      }
		  },
		  dfpunit: {
		      validators: { 
		        notEmpty: { message: 'Debe indicar precio' }, 
		        regexp: { regexp: /^[0-9]+(\.[0-9]{1,2})?$/,    message: 'Formato inválido de monto'} 
		      }
		  }
		},
		callback: function () {
        	alert("OK");
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
function obtenerVectorEncabezado( numero, idcotiz, idcliente, femision, total, iva ){
	encabezado = new Object();
	encabezado.numero = $( '#npedido' ).val();
	encabezado.idcotiz = $( '#idCotizacion' ).val();
	encabezado.idcliente = $( '#idCliente' ).val();
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
function guardarPedido(){
		
	pencabezado = obtenerVectorEncabezado();
	pdetalle = obtenerVectorDetalle();
	console.log(pdetalle);
	$.ajax({
		type:"POST",
		url:"bd/data-pedido.php",
		data:{ encabezado: pencabezado, detalle: pdetalle, reg_pedido : 1 },
		beforeSend: function () {
			$("#bt_reg_pedido").fadeOut(200);
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
function checkPedido(){
	//Validación de formulario de pedido previo a su registro 
	var error = 0;
	var det_ped = JSON.parse( obtenerVectorDetalle() );
	
	if( $("#idCliente").val() == "" ){
		//Cliente no seleccionado
		$("#mje_error").fadeIn("slow");
		$("#tx-vmsj").html("Debe indicar un cliente");
		$("#ncliente").css({'border-color' : '#dd4b39'});
		error = 1;
	}

	if( ( contarItems() == 0 ) && ( error == 0 ) ){
		//Pedido sin ítems
		$("#mje_error").fadeIn("slow");
		$("#tx-vmsj").html("Debe ingresar ítems en el pedido");
		error = 1;
	}

	if( ( det_ped.length == 0 ) && ( error == 0 ) ){
		//Pedido sin ítems (fallo en sistema)
		$("#mje_error").fadeIn("slow");
		$("#tx-vmsj").html("Error al generar detalle de pedido");
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
function checkItemForm( idart, punit, qant ){
	var valido = 1;

	if( idart == "0" ) { $("#narticulo").css({'border-color' : '#dd4b39'}); valido = 0; }
	
	if( punit == "" ) { $("#fpunit").css({'border-color' : '#dd4b39'}); valido = 0; }
		else $("#fpunit").css({'border-color' : '#ccc'});
	
	if( qant == "" || qant == "0" ) { $("#fcantidad").css({'border-color' : '#dd4b39'}); valido = 0; } 
		else $("#fcantidad").css({'border-color' : '#ccc'});
	
	if( $( "#fptotal" ).val() == "0.00" ){ $( "#fptotal" ).css({'border-color' : '#dd4b39'}); valido = 0; }
		else $("#fptotal").css({'border-color' : '#ccc'});

	return valido;
}
/* --------------------------------------------------------- */
$( document ).ready(function() {
	
	var cant = "";

	$("#titulo_emergente").html("Guardar Pedido");
	$("#mje_confirmacion").html("¿Confirmar registro?");
	$("#btn_confirm").attr("id", "bt_reg_pedido");
	/* =============================================================================== */
	$("#bt_reg_pedido").on( "click", function(){
		$("#closeModal").click();
		if( checkPedido() == 0 )
			guardarPedido(); 
		else 
			$("#enl_vmsj").click();
    });
    /* =============================================================================== */
});
/* ----------------------------------------------------------------------------------- */


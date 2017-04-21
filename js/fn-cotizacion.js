// JavaScript Document
/*
* fn-cotizacion.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function initValid(){
  
	$('#frm_ncotizacion').bootstrapValidator({
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
function iniciarVentanaConfirmacion( boton, titulo ){
	$("#titulo_emergente").html( titulo );
	$("#mje_confirmacion").html( "¿ Confirmar acción ?" );
	$("#btn_confirm").attr("id", boton );
}
/* --------------------------------------------------------- */
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey; 
/* --------------------------------------------------------- *
/* --------------------------------------------------------- */
function checkCotizacion(){
	//Validación de formulario de cotización previo a su registro
	var error = 0;
	var ente_asociado = "cliente";

	if( $("#idCliente").val() == "" ){
		//Cliente/Proveedor no seleccionado 
		if( $("#tipo").val() == "solicitud" ) ente_asociado = "proveedor";
		$("#tx-vmsj").html("Debe indicar un " + ente_asociado );
		$("#ncliente").css({'border-color' : '#dd4b39'});
		error = 1;
	}

	if( ( contarItems() == 0 ) && ( error == 0 ) ){
		//Cotización sin ítems
		$("#tx-vmsj").html("Debe ingresar ítems en la cotización");
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
function obtenerVectorEncabezado(){
	//Retorna un objeto con los datos de encabezado de una cotización
	encabezado = obtenerEncabezadoBase();
	
	encabezado.tipo = $( '#tipo' ).val();
	encabezado.idc = $( '#idCliente' ).val();
	encabezado.pcontacto = $( '#cpcontacto' ).val();

	return JSON.stringify( encabezado );
}
/* --------------------------------------------------------- */
function guardarCotizacion(){
		
	cencabezado = obtenerVectorEncabezado();
	cdetalle = obtenerVectorDetalle();
	
	$.ajax({
		type:"POST",
		url:"bd/data-cotizacion.php",
		data:{ encabezado: cencabezado, detalle: cdetalle, reg_cotizacion : 1 },
		beforeSend: function () {			
			$("#bt_reg_cotizacion").fadeOut( 200 );
		},
		success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			var enlace = obtenerEnlaceDocumentoCreado( res.documento, res.documento.frm_r );
			ventanaMensaje( res.exito, res.mje, enlace );
			bloquearDocumento();
		}
	});
}
/* --------------------------------------------------------- */
function editarCotizacion(){
	cencabezado = obtenerVectorEncabezado();
	cdetalle = obtenerVectorDetalle();
	
	$.ajax({
		type:"POST",
		url:"bd/data-cotizacion.php",
		data:{ encabezado: cencabezado, detalle: cdetalle, edit_cotizacion : 1 },
		beforeSend: function () {			
			$("#bt_edit_cotizacion").fadeOut( 200 );
			$("#btn_confirmacion").fadeOut( 200 );
		},
		success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			var enlace = obtenerEnlaceDocumentoCreado( res.documento, res.documento.frm_r );
			ventanaMensaje( res.exito, res.mje, enlace );
			bloquearDocumento();
		}
	});	
}
/* --------------------------------------------------------- */
function checkItemFormSolicitud( idart, qant ){
	/* Validación para agregar ítems a los detalles de la solicitud de cotización */
	var valido = 1;

	if( idart == "0" ) { $("#narticulo").css({'border-color' : '#dd4b39'}); valido = 0; }
	
	if( qant == "" || qant == "0" ) { $("#fcantidad").css({'border-color' : '#dd4b39'}); valido = 0; } 
		else $("#fcantidad").css({'border-color' : '#ccc'});

	return valido;
}
/* ================================================================================= */
$( document ).ready(function() {
	
	var cant = "";

	/* --------------------------------------------------------- */
	/* Adición de ítems a los detalles de la solicitud de cotización */
	$("#ag_item_sc").click( function(){
		var art = $("#narticulo").val(); 	var idart = $("#idArticulo").val();
		var punit = $("#punit").val();		var qant = $("#cantidad").val(); 
		var ptot = $("#ptotal").val();		var nitem = $("#cont_item").val();	
		var und = $("#und_art").val();	
		//alert( $("#punit").val() );
		nitem++;
		
		if( checkItemFormSolicitud( idart, qant ) == 1 ){	
			agregarItemDocumento( nitem, idart, art, qant, und, punit, ptot );	
		}
    });
	/* --------------------------------------------------------- */
	/* Asignación de la etiqueta de validez de la cotización ( pie de documento ) */
	$("#vcondicion").on( "change", function(){
		var valor = $( "#vcondicion option:selected" ).text();
		$('#vvalz').html(valor);
		//En caso de que el formato de cotización muestre la validez del documento
		$('input[data-v=VCTZ]').val( "Validez: " + valor );	
		
		//En caso de que el formato de cotización muestre la validez del documento
		//oectz: observaciones en edición de cotización
		$bvalidez = $( ".oectz:contains('Validez')" );
		$bvalidez.html("Validez: <label id='vvalz'>" + valor + "</label>");
		//data-vo: valor oculto
		$ovalidez = $( "#tobs" + $bvalidez.attr("data-vo") );
		$ovalidez.val("Validez: " + valor );
    });
	/* =============================================================================== */
	$("#bt_reg_cotizacion").on( "click", function(){
		$("#closeModal").click();
		if( checkCotizacion() == 0 )
			guardarCotizacion();
		else
			$("#enl_vmsj").click();
    });

	$("#bt_edit_cotizacion").on( "click", function(){
	
		$("#closeModal").click();
		if( checkCotizacion() == 0 )
			editarCotizacion();
		else
			$("#enl_vmsj").click();
    });    
    /* =============================================================================== */
});
/* ----------------------------------------------------------------------------------- */


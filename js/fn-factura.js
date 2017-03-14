// JavaScript Document
/*
* fn-cotizacion.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function initValid(){
  
	$('#frm_nfactura').bootstrapValidator({
		message: 'Revise el contenido del campo',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
		  orden_compra: {
		      validators: { notEmpty: { message: 'Debe indicar orden de compra' } }
		  },
		  punit: {
		      validators: { 
		        regexp: { regexp: /^[0-9]+(\.[0-9]{1,2})?$/, message: 'Formato inválido de monto'} 
		      }
		  }
		},
		onSuccess: function(e, data) {
         	e.preventDefault();
        	bt_reg_facturaclick();
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
function obtenerVectorEncabezado(){
	encabezado = new Object();
	encabezado.numero = $( '#nfactura' ).val();
	encabezado.noc = $( '#fordc' ).val();
	encabezado.idpedido = $( '#idPedido' ).val();
	encabezado.idcliente = $( '#idCliente' ).val();
	encabezado.femision = $( '#femision' ).val();
	encabezado.idu = $( '#idu_sesion' ).val();

	encabezado.introduccion = $( '#tentrada' ).val();
	encabezado.obs0 = $( '#tobs0' ).val();
	encabezado.obs1 = $( '#tobs1' ).val();
	encabezado.obs2 = $( '#tobs2' ).val();
	encabezado.obs3 = $( '#tobs3' ).val();

	encabezado.subtotal = $( '#subtotal' ).val();
	encabezado.total = $( '#total' ).val();
	encabezado.iva = $( '#iva' ).val();

	return JSON.stringify( encabezado );
}
/* --------------------------------------------------------- */
function agregarItemFactura( nitem, idart, art, qant, und, punit, ptot ){
	c_qant = obtenerItemDCotizacion( nitem, qant, "idfq_" + nitem, "dfcant", "onkeypress='return isIntegerKey(event)' onKeyUp='actItemF( this )'", "text");
	c_punit = obtenerItemDCotizacion( nitem, punit, "idfpu_" + nitem, "dfpunit", "onkeypress='return isNumberKey(event)' onKeyUp='actItemF( this )' onBlur='initValid()'" );
	c_ptot = obtenerItemDCotizacion( nitem, ptot, "idfpt_" + nitem, "dfptotal", "readonly", "text" );
	c_und = obtenerItemDCotizacion( nitem, und, "idfund_" + nitem, "dfund", "", "text" );
	
	c_idart = obtenerCampoOcultoIF( "idarticulo_" + nitem, "idart", idart, nitem );
	c_nart = obtenerCampoOcultoIF( "ndarticulo_" + nitem, "nart", art, nitem );
	id_bot_elim = "it" + nitem; $("#itemcont").val( nitem );
	 
	var itemf = "<tr style='display: none;' id='"+ id_bot_elim + "'><th>" +
				art + c_idart + c_nart + "</th><th>" +
				c_qant + "</th><th>" +
				c_und + "</th><th>" +
				c_punit + "</th><th>" +
				c_ptot + "</th><th><button type='button' class='btn btn-block btn-danger btn-xs bedf' onClick='elimItemF("+ id_bot_elim +")'>"+
				"<i class='fa fa-times'></i></button></th></tr>";
	
	$( itemf ).appendTo("#df_table tbody").show("slow");
	resetItemsCotizacion();
	calcularTotales();
}
/* --------------------------------------------------------- */
function obtenerEnlaceRFACCreado(id){
	var ndoc = $("#nfactura").val();
	var enl = "documento.php?tipo_documento=fac&id=" + id;
	var ico = "<i class='fa fa-file-text fa-2x'></i>";

	var e_enl = "<a href='" + enl + "' class='btn btn-app' target='_blank'>" 
	+ ico + " Factura #" + ndoc + "</a>";

	return e_enl;
}

function bloquearDocumento(){
	$(".blq_bdoc").prop('disabled', true);
	$("#frm_nfactura input").prop('readonly', true);
}
/* --------------------------------------------------------- */
function guardarFactura(){
	
	idcliente = $( '#idCliente' ).val();
	total = $( '#total' ).val().replace(",", ".");

	if( idcliente != "" && total != "" && total != 0.00 ){
		
		fencabezado = obtenerVectorEncabezado();
		fdetalle = obtenerVectorDetalle(); 	// fn-documento.js
		//console.log(fdetalle);
		$.ajax({
			type:"POST",
			url:"bd/data-factura.php",
			data:{ encabezado: fencabezado, detalle: fdetalle, reg_factura : 1 },
			beforeSend: function () {
				$("#bt_reg_factura").fadeOut(200);
				$("#btn_confirmacion").fadeOut(200);
			},
			success: function( response ){
				res = jQuery.parseJSON(response);
				//console.log(response);
				var enlace = obtenerEnlaceDocumentoCreado( res.documento, res.documento.frm_r );
				ventanaMensaje( res.exito, res.mje, enlace );
				bloquearDocumento();
			}
		});	
	}	
}
/* --------------------------------------------------------- */
function checkFactura(){
	
	var error = 0; 
	
	if( $("#idCliente").val() == "" ){
		$("#tx-vmsj").html("Debe indicar un cliente");
		$("#ncliente").css({'border-color' : '#dd4b39'});	
		error = 1;
	}

	if( ( contarItems() == 0 ) && ( error == 0 ) ){
		$("#tx-vmsj").html("Debe ingresar ítems en la factura");
		error = 1; 
	}

	if( $("#fordc").val() == "" ){
		$("#fordc").val("N/A");
	}

	if( error == 1 ){
		$("#ventana_mensaje").addClass("modal-danger");
		$("#tit_vmsj").html( "Error" );
	}
	
	return error;	
}
/* --------------------------------------------------------- */
function checkItemForm_X( idart, punit, qant ){
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

	$("#titulo_emergente").html("Guardar Factura");
	$("#mje_confirmacion").html("¿Confirmar registro?");
	$("#btn_confirm").attr("id", "bt_reg_factura");

	var cant = "";
		
	/*===============================================================================*/
    $("#bt_reg_factura").on( "click", function(){
		$("#closeModal").click();
		if( checkFactura() == 0 )
			guardarFactura();
		else
			$("#enl_vmsj").click();
    });
});
/* --------------------------------------------------------- */


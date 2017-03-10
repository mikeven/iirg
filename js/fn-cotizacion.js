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
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey; 
/* --------------------------------------------------------- *
/* --------------------------------------------------------- */
function checkCotizacion(){
	var error = 0;
	var ente_asociado = "cliente";

	if( $("#idCliente").val() == "" ){
		if( $("#tipo").val() == "solicitud" ) ente_asociado = "proveedor";
		$("#tx-vmsj").html("Debe indicar un " + ente_asociado );
		$("#ncliente").css({'border-color' : '#dd4b39'});
		error = 1;
	}

	if( ( contarItems() == 0 ) && ( error == 0 ) ){
		$("#tx-vmsj").html("Debe ingresar ítems en la cotización");
		error = 1;
	}

	if( error == 1 ){
		$("#ventana_mensaje").addClass("modal-danger");
		$("#tit_vmsj").html( "Error" );
	}
	
	return error;	
}
/* --------------------------------------------------------- */
function obtenerVectorDetalleC(){
	var detalle = new Array();
	var renglon = new Object();
	
	$("#df_table input").each(function (){ 
		name = $(this).attr("name");
		renglon["" + name + ""] = $(this).val();

		if( name == "dfptotal" ){	
			//name: campo referencia para indicar fin de renglón, guardar y pasar al siguiente
			detallef.push( renglon );
			renglon = new Object();
		}
	});
	return JSON.stringify( detalle );
}
/* --------------------------------------------------------- */
function obtenerVectorEncabezado(){
	encabezado = new Object();
	encabezado.numero = $( '#ncotiz' ).val();
	encabezado.tipo = $( '#tipo' ).val();
	encabezado.idc = $( '#idCliente' ).val();
	encabezado.femision = $( '#femision' ).val();
	encabezado.cvalidez = $( '#cvalidez' ).val();
	encabezado.pcontacto = $( '#cpcontacto' ).val();
	encabezado.idu = $( '#idu_sesion' ).val();

	encabezado.introduccion = $( '#tentrada' ).val();
	encabezado.obs0 = $( '#tobs0' ).val();
	encabezado.obs1 = $( '#tobs1' ).val();
	encabezado.obs2 = $( '#tobs2' ).val();
	encabezado.obs3 = $( '#tobs3' ).val();

	encabezado.total = parseFloat( $( '#total' ).val() );
	encabezado.iva = $( '#iva' ).val();

	return JSON.stringify( encabezado );
}
/* --------------------------------------------------------- */
function dataUrlDoc( tipo ){
	frm = new Array();
	if(tipo == "solicitud"){
		frm["param"] = "sctz";
		frm["etiqueta"] = "Sol. de cotización";
	}else{
		frm["param"] = "ctz";
		frm["etiqueta"] = "Cotización";
	}

	return frm;
}
/* --------------------------------------------------------- */
function obtenerEnlaceRCTZCreado( id, tipo ){
	var ndoc = $("#ncotiz").val();
	var frm = dataUrlDoc( tipo );
	var enl = "documento.php?tipo_documento=" + frm["param"] + "&id=" + id;
	var ico = "<i class='fa fa-file-text fa-2x'></i>";

	var e_enl = "<a href='" + enl + "' class='btn btn-app' target='_blank'>" + 
	ico + frm["etiqueta"] + " #" + ndoc + "</a>";

	return e_enl;
}
/* --------------------------------------------------------- */
function guardarCotizacion(){
		
	cencabezado = obtenerVectorEncabezado();
	cdetalle = obtenerVectorDetalleC();
	
	$.ajax({
		type:"POST",
		url:"bd/data-cotizacion.php",
		data:{ encabezado: cencabezado, detalle: cdetalle, reg_cotizacion : 1 },
		beforeSend: function () {			
			$("#bt_reg_cotizacion").fadeOut( 200 );
		},
		success: function( response ){
			//console.log(response);
			res = jQuery.parseJSON(response);
			ventanaMensaje( res.exito, res.mje, obtenerEnlaceRCTZCreado( res.idr, res.tipo ) );
		}
	});
}
/* --------------------------------------------------------- */
/*
function obtenerItemDCotizacion( nitem, valor, id, nombre, param ){
	var clase = "";
	
	if( param == "readonly" ) clase = "montoacum";
	var campo = "<div class='input-group input-space'><input id='" + id + "' name='" + nombre 
					+ "' type='text' class='form-control itemtotal_detalle input-sm " + clase + 
					"' value='" + valor + "' data-nitem='" + nitem + "' " + param + "></div>";
	
	return campo;
}
function obtenerCampoOcultoIF(  id, nombre, valor, nitem ){
	var campo = "<input id='" + id + "' name='" + nombre + "' type='hidden' value='" + valor + "' data-nitem='" + nitem + "'>";
	return campo;
}
function agregarItemCotizacion( nitem, idart, art, qant, und, punit, ptot ){
	c_qant = obtenerItemDCotizacion( nitem, qant, "idfq_" + nitem, "dfcant", "onkeypress='return isIntegerKey(event)' onKeyUp='actItemF( this )'" );
	
	c_punit = obtenerItemDCotizacion( nitem, punit, "idfpu_" + nitem, "dfpunit", "onkeypress='return isNumberKey(event)' onKeyUp='actItemF( this )' onBlur='initValid()'" );
	if( $("#tipo").val() == "solicitud" )
		c_punit = obtenerItemDCotizacion( nitem, punit, "idfpu_" + nitem, "dfpunit", "readonly" );	
	
	c_ptot = obtenerItemDCotizacion( nitem, ptot, "idfpt_" + nitem, "dfptotal", "readonly" );
	c_und = obtenerItemDCotizacion( nitem, und, "idfund_" + nitem, "dfund", "" );
	
	c_idart = obtenerCampoOcultoIF( "idarticulo_" + nitem, "idart", idart, nitem );
	c_nart = obtenerCampoOcultoIF( "ndarticulo_" + nitem, "nart", art, nitem );
	id_bot_elim = "it" + nitem; $("#itemcont").val( nitem );
	 
	var itemf = "<tr style='display: none;' id='"+ id_bot_elim + "'><th>" +
				art + c_idart + c_nart + "</th><th>" +
				c_qant + "</th><th>" +
				c_und + "</th><th>" +
				c_punit + "</th><th>" +
				c_ptot + "</th><th><button type='button' class='btn btn-block btn-danger btn-sm bedf' onClick='elimItemF("+ id_bot_elim +")'>"+
				"<i class='fa fa-times'></i></button></th></tr>";
	
	$( itemf ).appendTo("#df_table tbody").show("slow");
	resetItemsCotizacion();
	calcularTotales();
}
function calcularTotales(){
	var subtotal = parseFloat( 0 );
	$(".montoacum").each(function (){ 
		subtotal = parseFloat( $(this).val() ) + subtotal;
	});
	
	var piva = subtotal * $("#iva").val();
	var total = subtotal + parseFloat( piva );
	
	$("#fstotal").val( subtotal.toFixed( 2 ) );
	$("#fiva").val( piva.toFixed( 2 ) );
	$("#ftotal").val( total.toFixed( 2 ) );	
}
function resetItemsCotizacion(){
	$("#narticulo").val("");
	$("#idArticulo").val( 0 );
	$("#fcantidad").val( "" );
	$("#fpunit").val( (0.00).toFixed( 2 ) );
	$("#fptotal").val( 0.00 );
}
function elimItemF( fila ){
	$( fila ).hide('slow', function(){ 
		$( fila ).remove(); 
		calcularTotales(); 
	});
}
function actItemF( itemf ){
	
	var nitem = $(itemf).attr("data-nitem");
	
	var qant = $("#idfq_" + nitem ).val();
	var punit = $("#idfpu_" + nitem ).val();
	var ptot = $("#idfpt_" + nitem ).val();
	
	$("#idfpt_" + nitem ).val( ( qant * punit ).toFixed( 2 ) );
	calcularTotales();
}
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
}*/
/* --------------------------------------------------------- */
function checkItemFormSolicitud( idart, qant ){
	/* Validación para agregar ítems a los detalles de la solicitud de cotización */
	var valido = 1;

	if( idart == "0" ) { $("#narticulo").css({'border-color' : '#dd4b39'}); valido = 0; }
	
	if( qant == "" || qant == "0" ) { $("#fcantidad").css({'border-color' : '#dd4b39'}); valido = 0; } 
		else $("#fcantidad").css({'border-color' : '#ccc'});

	return valido;
}
/* --------------------------------------------------------- */
function asignarEtiquetaConfirmacion(){
	if( $("#tipo").val() == "cotizacion" )
		$("#titulo_emergente").html("Guardar cotización");
	if( $("#tipo").val() == "solicitud" )
		$("#titulo_emergente").html("Guardar solicitud de cotización");
}
/* --------------------------------------------------------- */
$( document ).ready(function() {
	
	var cant = "";
	
	$("#mje_confirmacion").html( "¿Confirmar registro?" );
	$("#btn_confirm").attr("id", "bt_reg_cotizacion");
	//$("#enl_oculto").hide();

	/* Asignación de etiqueta de Nombre de cliente en encabezado de cotización al seleccionarlo de la lista de clientes*/
	$(".item_cliente_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#ncliente").val(texto);
		$("#idCliente").val( $(this).attr("data-idc") );
		$("#cpcontacto").val( $(this).attr("data-npc") );
		$("#ncliente").css({'border-color' : '#ccc'});
		$("#xmodalcliente").click();
    });
	
	/* Asignación de datos de proveedor en encabezado de solicitud de cotización al seleccionarlo de la lista de proveedores*/
	$(".item_proveedor_lmodal").click( function(){
		
		$("#nproveedor").val( $(this).attr("data-label") );
		$("#idCliente").val( $(this).attr("data-idp") );	//idCliente indica id de proveedor cuando se trata de solicitud de cotización
		$("#cpcontacto").val( $(this).attr("data-npc") );
		$("#nproveedor").css({'border-color' : '#ccc'});
		$("#xmodalproveedor").click();
    });
	/* --------------------------------------------------------- */
	/* Asignación de etiqueta de Nombre de artículo en encabezado de cotización al seleccionarlo de la lista de artículos*/
	$(".item_articulo_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#narticulo").val( texto );
		$("#idArticulo").val( $(this).attr("data-ida") );
		$("#narticulo").css({'border-color' : '#ccc'});
		$("#und_art").val( $(this).attr("data-und") );
		$("#xmodalarticulo").click();
    });
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
	$("#cvalidez").on( "change", function(){
		var valor = $(this).val();
		$('#vvalz').html(valor);
		$('input[data-v=VCTZ]').val( "Validez: " + valor );
    });
	/*===============================================================================*/
	$("#bt_reg_cotizacion").on( "click", function(){
		$("#closeModal").click();
		if( checkCotizacion() == 0 )
			guardarCotizacion();
		else
			$("#enl_vmsj").click();
    });
});
/* --------------------------------------------------------- */


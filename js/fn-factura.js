// JavaScript Document
/*
* fn-factura.js
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

function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey; 

function obtenerVectorDetalleF(){
	var valxitem = 6;
	var detallef = new Array();
	var renglon = new Array();
	var contval = 0;
	
	$("#df_table input").each(function (){ 
		renglon.push( $(this).val() );
		contval++;

		if( contval == valxitem ){
			detallef.push( renglon );
			renglon = []; contval = 0;
		}
	});
	return JSON.stringify(detallef);
}
/* --------------------------------------------------------- */
function guardarFactura(){
	
	var form = $( '#frm_nfactura' );
	var idc = $( '#idCliente' ).val();
	var femision = $( '#femision' ).val();
	var fcondpago = $( '#fcondpago' ).val();
	
	jsons = obtenerVectorDetalleF();
	
	$.ajax({
		type:"POST",
		url:"bd/data-factura.php",
		data:{ form: jsons, reg_factura : 1 },
		beforeSend: function () {
			$("#waitconfirm").html("Espere...");
		},
		success: function( response ){
			$("#waitconfirm").html( response );
		}
	});
}
/* --------------------------------------------------------- */
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if ( charCode != 46 && charCode > 31 && ( charCode < 48 || charCode > 57 ))
		return false;
	return true;
}

function isIntegerKey(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if ( charCode < 48 || charCode > 57 )
		return false;
	return true;
}
/* --------------------------------------------------------- */
function obtenerItemDFactura( nitem, valor, id, nombre, param ){
	var clase = "";
	if( param == "readonly" ) clase = "montoacum";
	var campo = "<div class='input-group input-space'><input id='" + id + "' name='" + nombre 
					+ "' type='text' class='form-control itemtotal_detalle input-sm " + clase + 
					"' value='" + valor + "' data-nitem='" + nitem + "' " + param + "></div>";
	
	return campo;
}
/* --------------------------------------------------------- */
function obtenerCampoOcultoIF(  id, nombre, valor, nitem ){
	var campo = "<input id='" + id + "' name='" + nombre + "' type='hidden' value='" + valor + "' data-nitem='" + nitem + "'>";
	return campo;
}
/* --------------------------------------------------------- */
function agregarItemFactura( nitem, idart, art, qant, und, punit, ptot ){
	
	c_qant = obtenerItemDFactura( nitem, qant, "idfq_" + nitem, "dfcant", "onkeypress='return isIntegerKey(event)' onKeyUp='actItemF( this )'", "text" );
	c_punit = obtenerItemDFactura( nitem, punit, "idfpu_" + nitem, "dfpunit", "onkeypress='return isNumberKey(event)' onKeyUp='actItemF( this )' onBlur='initValid()'" );
	c_ptot = obtenerItemDFactura( nitem, ptot, "idfpt_" + nitem, "dfptotal", "readonly", "text" );
	c_und = obtenerItemDFactura( nitem, und, "idfund_" + nitem, "dfund", "", "text" );
	
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
	resetItemsFactura();
	calcularTotales();
	
}
/* --------------------------------------------------------- */
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
/* --------------------------------------------------------- */
function resetItemsFactura(){
	$("#narticulo").val("");
	$("#idArticulo").val( 0 );
	$("#fcantidad").val( "" );
	$("#fpunit").val( "" );
	$("#fptotal").val( 0.00 );
}
/* --------------------------------------------------------- */
function elimItemF( fila ){
	$( fila ).hide('slow', function(){ 
		$( fila ).remove(); 
		calcularTotales(); 
	});
}
/* --------------------------------------------------------- */
function actItemF( itemf ){
	
	var nitem = $(itemf).attr("data-nitem");
	
	var qant = $("#idfq_" + nitem ).val();
	var punit = $("#idfpu_" + nitem ).val();
	var ptot = $("#idfpt_" + nitem ).val();
	
	$("#idfpt_" + nitem ).val( ( qant * punit ).toFixed( 2 ) );
	calcularTotales();
}
/* --------------------------------------------------------- */
$( document ).ready(function() {
	
	var cant = "";
	$(".item_cliente_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#ncliente").val(texto);
		$("#idCliente").val( $(this).attr("data-idc") );
		$("#xmodalcliente").click();
    });
	
	$(".item_articulo_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#narticulo").val( texto );
		$("#idArticulo").val( $(this).attr("data-ida") );
		$("#undart").val( $(this).attr("data-und") );
		$("#xmodalarticulo").click();
    });
	
	$(".itemtotal").on( "blur keyup", function(){
		var cant = $("#fcantidad").val(); 
		var punit = $("#fpunit").val();
		
		$( "#fptotal" ).val( ( cant * punit ).toFixed( 2 ) );
    });
	
	$("#aitemf").click( function(){
		var art = $("#narticulo").val(); 	var idart = $("#idArticulo").val();
		var punit = $("#fpunit").val();		var qant = $("#fcantidad").val(); var ptot = $("#fptotal").val();
		var nitem = $("#itemcont").val();	var und = $("#undart").val();	
		nitem++;
		
		if( $("#idArticulo").val() != "0" && $( "#fptotal" ).val() != "0.00" ){
			agregarItemFactura( nitem, idart, art, qant, und, punit, ptot );	
		}
    });
	
	/*===============================================================================*/
	
	$("#bt_reg_factura").on( "click", function(){
		guardarFactura();	
    });
	
});
/* --------------------------------------------------------- */

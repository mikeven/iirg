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
/* --------------------------------------------------------- */
function obtenerVectorDetalleP(){
	var detallef = new Array();
	var renglon = new Object();
	
	$("#dp_table input").each(function (){ 
		name = $(this).attr("name");
		renglon["" + name + ""] = $(this).val();

		if( name == "dfptotal" ){
			detallef.push( renglon );
			renglon = new Object();
		}
	});
	return JSON.stringify( detallef );
}
/* --------------------------------------------------------- */
function obtenerVectorEncabezado( numero, idcotiz, idcliente, femision, total, iva ){
	encabezado = new Object();
	encabezado.numero = numero;
	encabezado.idcotiz = idcotiz;
	encabezado.idcliente = idcliente;
	encabezado.femision = femision;
	encabezado.total = total;
	encabezado.iva = iva;

	return JSON.stringify( encabezado );
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
function obtenerItemDCotizacion( nitem, valor, id, nombre, param ){
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
function agregarItemPedido( nitem, idart, art, qant, und, punit, ptot ){
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
	
	//alert(itemf);
	$( itemf ).appendTo("#dp_table tbody").show("slow");
	resetItemsCotizacion();
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
function resetItemsCotizacion(){
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
function guardarPedido(){
	
	var idcliente = $( '#idCliente' ).val();
	var numero = $( '#npedido' ).val();
	var idcotiz = $( '#idCotizacion' ).val();
	var femision = $( '#femision' ).val();
	var total = $( '#ftotal' ).val().replace(",", ".");
	var iva = $( '#iva' ).val();
	
	if( idcliente != "" && total != "" && total != 0.00 ){
		
		pencabezado = obtenerVectorEncabezado( numero, idcotiz, idcliente, femision, total, iva );
		pdetalle = obtenerVectorDetalleP();
	
		$.ajax({
			type:"POST",
			url:"bd/data-pedido.php",
			data:{ encabezado: pencabezado, detalle: pdetalle, reg_pedido : 1 },
			beforeSend: function () {
				//$("#waitconfirm").html("Espere...");
				$("#bt_reg_pedido").fadeOut(200);
			},
			success: function( response ){
				res = jQuery.parseJSON(response);
				if( res.exito == '1' ){
					$("#txexi").html(res.mje);
					$("#mje_exito").show();
				}
				if( res.exito == '0' ){
					$("#mje_error").show();
					$("#txerr").html(res.mje);
				}
				//$("#waitconfirm").html(response);
			}
		});	
	}
	
}
/* --------------------------------------------------------- */
function contarItems(){
	var contitems = 0;
	$("#dp_table input").each(function (){ 
		contitems++;
	});
	return contitems;
}
/* --------------------------------------------------------- */
function checkPedido(){
	var error = 0;
	if( contarItems() == 0 ){
		$("#mje_error").fadeIn("slow");
		$("#txerr").html("Debe ingresar ítems en el pedido");
		error = 1;
	}
	if( $("#idCliente").val() == "" ){
		$("#mje_error").fadeIn("slow");
		$("#txerr").html("Debe indicar un cliente");
		$("#ncliente").css({'border-color' : '#dd4b39'});
		error = 1;
	}
	$("#closeModal").click();
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

	$(".alert").click( function(){
		$(this).hide("slow");
    });

	$(".item_cliente_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#ncliente").val(texto);
		$("#ncliente").css({'border-color' : '#ccc'});
		$("#idCliente").val( $(this).attr("data-idc") );
		$("#cpcontacto").val( $(this).attr("data-npc") );
		$("#xmodalcliente").click();
    });
	
	$(".item_articulo_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#narticulo").val( texto );
		$("#narticulo").css({'border-color' : '#ccc'});
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
		
		if( checkItemForm( idart, punit, qant ) == 1 ){	
			agregarItemPedido( nitem, idart, art, qant, und, punit, ptot );	
		}
    });
	
	/*===============================================================================*/
	$("#bt_reg_pedido").on( "click", function(){
		if( checkPedido() == 0 )
			guardarPedido();
    });
});
/* --------------------------------------------------------- */


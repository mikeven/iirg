// JavaScript Document
/*
* fn-nota.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function initValid(){
  
	$('#frm_nnota').bootstrapValidator({
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
function obtenerVectorDetalleN(){
	var detallef = new Array();
	var renglon = new Object();
	
	$("#dn_table input").each(function (){ 
		name = $(this).attr("name");
		renglon["" + name + ""] = $(this).val();

		if( name == "dfptotal" ){
			//Campo final de renglón
			detallef.push( renglon );
			renglon = new Object();
		}
	});
	return JSON.stringify( detallef );
}
/* --------------------------------------------------------- */
function obtenerVectorEncabezado( numero, nfactura, idfactura, idcliente, femision, total, iva ){
	encabezado = new Object();
	encabezado.numero = numero;
	encabezado.nfactura = nfactura;
	encabezado.idfactura = idfactura;
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
function obtenerItemDNota( nitem, valor, id, nombre, param ){
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
function agregarItemNota( nitem, idart, art, qant, und, punit, ptot ){
	c_qant = obtenerItemDNota( nitem, qant, "idfq_" + nitem, "dfcant", "onkeypress='return isIntegerKey(event)' onKeyUp='actItemF( this )'", "text");
	c_punit = obtenerItemDNota( nitem, punit, "idfpu_" + nitem, "dfpunit", "onkeypress='return isNumberKey(event)' onKeyUp='actItemF( this )' onBlur='initValid()'" );
	c_ptot = obtenerItemDNota( nitem, ptot, "idfpt_" + nitem, "dfptotal", "readonly", "text" );
	c_und = obtenerItemDNota( nitem, und, "idfund_" + nitem, "dfund", "", "text" );
	
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
	
	$( itemf ).appendTo("#dn_table tbody").show("slow");
	resetItemsNota();
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
function resetItemsNota(){
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
function obtenerNumeroNota( tipo_nota ){
	$.ajax({
		type:"POST",
		url:"bd/data-nota.php",
		data:{ tn:tipo_nota },
		beforeSend: function () {
			
		},
		success: function( response ){
			//res = jQuery.parseJSON(response);
			$("#waitconfirm").html(response);
			if( res.exito == '1' ){
				$("#txexi").html(res.mje);
				$("#mje_exito").show("slow");
				$("#mje_error").hide(100);
			}
			if( res.exito == '0' ){
				$("#mje_error").show();
				$("#txerr").html(res.mje);
			}
		}
	});		
}
/* --------------------------------------------------------- */
function guardarNota(){
	
	var idcliente = $( '#idCliente' ).val();
	var numero = $( '#nnota' ).val();
	var nfactura = $( '#nFactura' ).val();
	var idfactura = $( '#idFactura' ).val();
	var femision = $( '#femision' ).val();
	var total = $( '#ftotal' ).val().replace(",", ".");
	var iva = $( '#iva' ).val();
	
	if( idcliente != "" && total != "" && total != 0.00 ){
		
		fencabezado = obtenerVectorEncabezado( numero, nfactura, idfactura, idcliente, femision, total, iva );
		fdetalle = obtenerVectorDetalleN();
	
		$.ajax({
			type:"POST",
			url:"bd/data-nota.php",
			data:{ encabezado: fencabezado, detalle: fdetalle, reg_nota : 1 },
			beforeSend: function () {
				$("#bt_reg_nota").fadeOut(200);
			},
			success: function( response ){
				//res = jQuery.parseJSON(response);
				$("#waitconfirm").html(response);
				if( res.exito == '1' ){
					$("#txexi").html(res.mje);
					$("#mje_exito").show("slow");
					$("#mje_error").hide(100);
				}
				if( res.exito == '0' ){
					$("#mje_error").show();
					$("#txerr").html(res.mje);
				}
			}
		});	
	}
}
function contarItems(){
	var contitems = 0;
	$("#dn_table input").each(function (){ 
		contitems++;
	});
	return contitems;
}
/* --------------------------------------------------------- */
function checkNota(){
	var error = 0;
	
	var tipo_nota = $("#tipofte").val();
	
	if ( tipo_nota != "" ){
		$("#tnota").css({'border-color' : '#ccc'});

		if( $("#idCliente").val() == "" ){
			$("#mje_error").fadeIn("slow");
			$("#txerr").html("Debe indicar un cliente");
			$("#ncliente").css({'border-color' : '#dd4b39'});
			error = 1;
		}else{
			if( contarItems() == 0 ){
				$("#mje_error").fadeIn("slow");
				$("#txerr").html("Debe ingresar ítems en la nota");
				error = 1;
			}
		}

		if( tipo_nota != "nota_entrega" ){
			if( $("#nFactura").val() == "" ){
				$("#mje_error").fadeIn("slow");
				$("#txerr").html("Debe hacer referencia a una factura");
				$("#nFactura").css({'border-color' : '#dd4b39'});
				error = 1;
			}
		}
	}else{
		$("#mje_error").fadeIn("slow");
		$("#txerr").html("Debe seleccionar tipo de nota");
		$("#tnota").css({'border-color' : '#dd4b39'});	
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
	$(".alert").click( function(){
		$(this).hide("slow");
    });

	$("#fordc").blur( function(){
		if( $(this).val() != "" )
			$(this).css({'border-color' : '#ccc'});
    });

	$(".item_cliente_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#ncliente").val(texto);
		$("#ncliente").css({'border-color' : '#ccc'});
		$("#idCliente").val( $(this).attr("data-idc") );
		$("#cpcontacto").val( $(this).attr("data-npc") );
		$("#xmodalcliente").click();
    });

    /*$(".item_facturas_lmodal").click( function(){
		$("#ndatafac").val( $(this).attr("data-factura") );
		$("#ndatafac").css({'border-color' : '#ccc'});
		$("#idCliente").val( $(this).attr("data-idc") );
		$("#nFactura").val( $(this).attr("data-nf") );
		$("#idFactura").val( $(this).attr("data-idf") );
		$("#xmodalfacturas").click();
    });*/
	
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
			agregarItemNota( nitem, idart, art, qant, und, punit, ptot );	
		}
    });

    $("#tnota").change( function(){
		var tipo_nota = $(this).val();
		$("#nnota").val( obtenerNumeroNota( tipo_nota ) );
		$("#tipofte").val( tipo_nota );

		if( tipo_nota == "nota_entrega" ){
			
			$("#bloquen_facturas").hide(150);
			$("#bloque_concepto").hide(100);
			$("#bloquen_clientes").show(300);
			if ( $("#tipofte").val() != "" && $("#tipofte").val() != "nota_entrega" ) 
				window.location.href = "nuevo-nota.php?t=nota_entrega";
		}
		else{
			$("#bloque_concepto").show(300);
			$("#bloquen_facturas").show(300);
			$("#bloquen_clientes").hide(300);
			$(".enlnn").attr("href", $(".enlnn").attr("href") + "&t=" + tipo_nota );
		}
    });
	
	/*===============================================================================*/
    $("#bt_reg_nota").on( "click", function(){
		if( checkNota() == 0 )
			guardarNota();
    });
});
/* --------------------------------------------------------- */


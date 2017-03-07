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
function obtenerVectorEncabezado(){
	
	encabezado = new Object();
	encabezado.numero = $( '#nnota' ).val();
	encabezado.nfactura = $( '#nFactura' ).val();
	encabezado.idfactura = $( '#idFactura' ).val();
	encabezado.idcliente = $( '#idCliente' ).val();
	encabezado.femision = $( '#femision' ).val();
	encabezado.tipo = $( '#tipofte' ).val();
	encabezado.idu = $( '#idu_sesion' ).val();
	
	if ( $("#cnc").length )  encabezado.concepto = $("#cnc").val(); else encabezado.concepto = "";
	if ( $("#tconcepto").length ) encabezado.tipo_concepto = $("#tconcepto").val(); else encabezado.tipo_concepto = "";
	
	encabezado.introduccion = $( '#tentrada' ).val();
	encabezado.obs0 = $( '#tobs0' ).val();
	encabezado.obs1 = $( '#tobs1' ).val();
	encabezado.obs2 = $( '#tobs2' ).val();
	encabezado.obs3 = $( '#tobs3' ).val();

	encabezado.subtotal = $( '#fstotal' ).val().replace(",", ".");
	encabezado.total = $( '#ftotal' ).val().replace(",", ".");
	encabezado.iva = $( '#iva' ).val();

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
function obtenerEnlaceRNOTACreado( id, tipo ){
	var ndoc = $("#nnota").val();
	var enl = "documento.php?tipo_documento=nota&tn=" + tipo + "&id=" + id;
	var ico = "<i class='fa fa-file-text fa-2x'></i>";

	var e_enl = "<a href='" + enl + "' class='btn btn-app' target='_blank'>" + 
	ico + " Nota #" + ndoc + "</a>";

	return e_enl;
}
/* --------------------------------------------------------- */
function guardarNota(){
	
	var idcliente = $( '#idCliente' ).val();
	var total = $( '#ftotal' ).val().replace(",", ".");

	if( idcliente != "" && total != "" && total != 0.00 ){
		
		fencabezado = obtenerVectorEncabezado();
		fdetalle = obtenerVectorDetalleN();
	
		$.ajax({
			type:"POST",
			url:"bd/data-nota.php",
			data:{ encabezado: fencabezado, detalle: fdetalle, reg_nota : 1 },
			beforeSend: function () {
				$("#bt_reg_nota").fadeOut(200);
				$("#btn_confirmacion").fadeOut(200);
			},
			success: function( response ){
				res = jQuery.parseJSON(response);
				//$("#waitconfirm").html(response);
				if( res.exito == '1' ){
					$("#ventana_mensaje").addClass("modal-success");
					$("#tit_vmsj").html( res.mje );
					$("#tx-vmsj").html( obtenerEnlaceRNOTACreado( res.idr, res.tipo ) );
					$("#enl_vmsj").click();
				}
				if( res.exito == '0' ){
					$("#mje_error").show();
					$("#txerr").html(res.mje);
				}
			}
		});	
	}
}
/* --------------------------------------------------------- */
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
	$("#ventana_mensaje").addClass("modal-danger");
	$("#tit_vmsj").html( "Error" );
	
	var tipo_nota = $("#tipofte").val();
	
	if ( tipo_nota != "" ){
		$("#tnota").css({'border-color' : '#ccc'});

		if( $("#idCliente").val() == "" ){
			$("#tx-vmsj").html("Debe indicar un cliente");
			$("#ncliente").css({'border-color' : '#dd4b39'});
			error = 1;
		}else{
			if( contarItems() == 0 ){
				$("#tx-vmsj").html("Debe ingresar ítems en la nota");
				error = 1;
			}
		}

		if( tipo_nota != "nota_entrega" ){
			if( $("#nFactura").val() == "" ){
				$("#tx-vmsj").html("Debe hacer referencia a una factura");
				$("#nFactura").css({'border-color' : '#dd4b39'});
				$("#ndatafac").css({'border-color' : '#dd4b39'});
				error = 1;
			}
			var monto_inicial = parseFloat( $("#mototalnota").val() );
			var monto_ajuste = parseFloat( $("#ftotal").val() );
			if( monto_ajuste > monto_inicial ){
				$("#tx-vmsj").html("El monto de ajuste supera al valor inicial de la factura");
				$("#fstotal").css({'border-color' : '#dd4b39'});
				error = 1;
			}
		}
	}else{
		$("#tx-vmsj").html("Debe seleccionar tipo de nota");
		$("#tnota").css({'border-color' : '#dd4b39'});
		error = 1;
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
function actualizarFormatoDocumento( data_frt ){
	
	$("#tentrada").html( data_frt.entrada );
	$("#t_tobs_notas").html( data_frt.titulo_obs );
	$("#t_tobs_notas").html( data_frt.titulo_obs );
	$("#tobs0").val( data_frt.titulo_obs ); 
	$("#tx0b1").html( data_frt.obs1 ); $("#tobs1").val( data_frt.obs1 );
	$("#tx0b2").html( data_frt.obs2 ); $("#tobs2").val( data_frt.obs2 );
	$("#tx0b3").html( data_frt.obs3 ); $("#tobs3").val( data_frt.obs3 );
}
/* --------------------------------------------------------- */
function asignarOpcionesConcepto( tn ){
	if( tn == "nota_credito" ){
		$("#on1").html("Devolución de mercancía");
		$("#on2").html("Descuento o beneficio");
		$("#on3").html("Ajuste global");
	}
	if( tn == "nota_debito" ){
		$("#on1").html("Error en factura");
		$("#on2").html("Gastos adicionales");
		$("#on3").html("Ajuste global");
	}
}
/* --------------------------------------------------------- */
function obtenerNumeroNota( tipo_nota ){
	var id_usuario = $("#idu_sesion").val();
	$.ajax({
		type:"POST",
		url:"bd/data-nota.php",
		data:{ prox_num:tipo_nota, idu:id_usuario },
		beforeSend: function () {},
		success: function( response ){
			$("#nnota").val(response);
		}
	});		
}
/* --------------------------------------------------------- */
function obtenerFormatoDocumento( doc ){
	var id_usuario = $("#idu_sesion").val();
	$.ajax({
		type:"POST",
		url:"bd/data-formato.php",
		data:{ fdoc:doc, idu:id_usuario },
		beforeSend: function () {},
		success: function( response ){
			data_frt = jQuery.parseJSON( response );
			actualizarFormatoDocumento( data_frt );
		}
	});	
}
/* --------------------------------------------------------- */
$( document ).ready(function() {
	
	$(".alert").hide();
    $(".bloque_nota").hide();
    $("#titulo_emergente").html("Guardar Nota");
	$("#mje_confirmacion").html("¿Confirmar registro?");
	$("#btn_confirm").attr("id", "bt_reg_nota");

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
		$("#ndatafac").css({'border-color' : '#ccc'});
    });*/
	
	$(".item_articulo_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#narticulo").val( texto );
		$("#narticulo").css({'border-color' : '#ccc'});
		$("#idArticulo").val( $(this).attr("data-ida") );
		$("#undart").val( $(this).attr("data-und") );
		$("#xmodalarticulo").click();
    });
	/*-------------------------------------------------------------------------------------*/
	$("#fstotal").on( "blur keyup", function(){
		var subtotal = parseFloat( $(this).val() ); 
		var piva = subtotal * $("#iva").val();
		var total = subtotal + parseFloat( piva );
		
		$("#fiva").val( piva.toFixed( 2 ) );
		$("#ftotal").val( total.toFixed( 2 ) );
    });
    $("#fstotal").on( "blur", function(){ 
    	var subtotal = parseFloat( $(this).val() );  
    	$("#fstotal").val( subtotal.toFixed( 2 ) );   
    });
    /*-------------------------------------------------------------------------------------*/
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

    $(".ocn").click( function(){ //Selección de ajuste global
		$("#tconcepto").val( $(this).html() );
		$("#etq_concepto").html( $(this).html() );
		if( $(this).html() == "Ajuste global" ){
			$("#dn_table").fadeOut(200); $("#fstotal").removeAttr("readonly");

		}else{
			$("#dn_table").fadeIn(200); $("#fstotal").attr("readonly", "true"); calcularTotales();
		}
    });

    /* Acciones ejecutadas al seleccionar tipo de nota */
    $("#tnota").change( function(){
		var tipo_nota = $(this).val();
		obtenerNumeroNota( tipo_nota );
		obtenerFormatoDocumento( tipo_nota );
		$("#tipofte").val( tipo_nota );
		asignarOpcionesConcepto( tipo_nota );

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
			//$(".enlnn").attr("href", $(".enlnn").attr("href") + "&t=" + tipo_nota );
		}
    });

    $(".enlnn").on( "click", function(){
		var lnk = $(this).attr("data-href") + "&t=" + $("#tipofte").val();
		window.location.href = lnk;
    });
	
	/*===============================================================================*/
    $("#bt_reg_nota").on( "click", function(){
		$("#closeModal").click();
		if( checkNota() == 0 )
			guardarNota();
		else
			$("#enl_vmsj").click();
    });
});
/* --------------------------------------------------------- */


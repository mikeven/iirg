// JavaScript Document
/*
* fn-nota.js
*
*/
/* ----------------------------------------------------------------------------------- */	
/* ----------------------------------------------------------------------------------- */
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
/* ----------------------------------------------------------------------------------- */
function iniciarVentanaConfirmacion( boton, titulo ){
	$("#titulo_emergente").html( titulo );
	$("#mje_confirmacion").html( "¿ Confirmar acción ?" );
	$("#btn_confirm").attr("id", boton );
}
/* ----------------------------------------------------------------------------------- */
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey; 
/* ----------------------------------------------------------------------------------- */
function anularIva(){
	$("#iva").val(0.00);
	$(".iva_valor").fadeOut("200");
	calcularTotales();
}
/* ----------------------------------------------------------------------------------- */
function reestablecerIva(){
	$("#iva").val( $("#iva_orig").val() );
	$(".iva_valor").fadeIn("200");
	calcularTotales();		
}
/* ----------------------------------------------------------------------------------- */
function obtenerVectorEncabezado(){
	//Retorna un objeto con los datos de encabezado de una nota
	encabezado = obtenerEncabezadoBase();
	encabezado.nfactura = $( '#nFactura' ).val();
	encabezado.idfactura = $( '#idFactura' ).val();
	encabezado.idcliente = $( '#idCliente' ).val();
	encabezado.tipo = $( '#tipofte' ).val();
	
	if ( $("#cnc").length )  encabezado.concepto = $("#cnc").val(); 
		else encabezado.concepto = "";
	if ( $("#tconcepto").length ) encabezado.tipo_concepto = $("#tconcepto").val(); 
		else encabezado.tipo_concepto = "";

	return JSON.stringify( encabezado );
}
/* ----------------------------------------------------------------------------------- */
function guardarNota(){
	//Obtiene los datos de encabezado y detalle de nota para su registro
	fencabezado = obtenerVectorEncabezado();
	fdetalle = obtenerVectorDetalle();
	
	$.ajax({
		type:"POST",
		url:"bd/data-nota.php",
		data:{ encabezado: fencabezado, detalle: fdetalle, reg_nota : 1 },
		beforeSend: function () {
			$("#bt_reg_nota").fadeOut(200);
			$("#btn_confirmacion").fadeOut(200);
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
/* ----------------------------------------------------------------------------------- */
function editarNota(){
	nencabezado = obtenerVectorEncabezado();
	ndetalle = obtenerVectorDetalle();
	
	$.ajax({
		type:"POST",
		url:"bd/data-nota.php",
		data:{ encabezado: nencabezado, detalle: ndetalle, edit_nota : 1 },
		beforeSend: function () {			
			$("#bt_edit_factura").fadeOut( 200 );
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
/* ----------------------------------------------------------------------------------- */
function checkNota(){
	//Validación de datos de nota antes de registrarse
	var error = 0;
	$("#ventana_mensaje").removeClass("modal-danger");
	var tipo_nota = $("#tipofte").val();
	
	if ( tipo_nota != "" ){
		$("#tnota").css({'border-color' : '#ccc'});

		if( $("#idCliente").val() == "" ){
			$("#tx-vmsj").html("Debe indicar un cliente");
			$("#ncliente").css({'border-color' : '#dd4b39'});
			error = 1;
		}
		
		if( $("#tconcepto").val() != "Ajuste global" ) {
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
			var monto_ajuste = parseFloat( $("#total").val() );
			if( monto_ajuste > monto_inicial ){
				$("#tx-vmsj").html("El monto de ajuste supera al valor inicial de la factura");
				$("#subtotal").css({'border-color' : '#dd4b39'});
				error = 1;
			}
		}
	}
	else{
		$("#tx-vmsj").html("Debe seleccionar tipo de nota");
		$("#tnota").css({'border-color' : '#dd4b39'});
		error = 1;
	}

	if( error == 1 ){
		//Asignar ventana de mensaje como mensaje de error
		$("#ventana_mensaje").addClass("modal-danger");
		$("#tit_vmsj").html( "Error" );
	}

	return error;	
}
/* ----------------------------------------------------------------------------------- */
function actualizarFormatoDocumento( data_frt ){
	
	$("#tentrada").html( data_frt.entrada );
	$("#t_tobs_notas").html( data_frt.titulo_obs );
	$("#t_tobs_notas").html( data_frt.titulo_obs );
	$("#tobs0").val( data_frt.titulo_obs ); 
	$("#tx0b1").html( data_frt.obs1 ); $("#tobs1").val( data_frt.obs1 );
	$("#tx0b2").html( data_frt.obs2 ); $("#tobs2").val( data_frt.obs2 );
	$("#tx0b3").html( data_frt.obs3 ); $("#tobs3").val( data_frt.obs3 );
}
/* ----------------------------------------------------------------------------------- */
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
/* ----------------------------------------------------------------------------------- */
function obtenerNumeroNota( tipo_nota ){
	var id_usuario = $("#idu_sesion").val();
	$.ajax({
		type:"POST",
		url:"bd/data-nota.php",
		data:{ prox_num:tipo_nota, idu:id_usuario },
		beforeSend: function () {},
		success: function( response ){
			$("#ndocumento").val(response);
		}
	});		
}
/* ----------------------------------------------------------------------------------- */
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
/* ----------------------------------------------------------------------------------- */
function initSubtotal(){
	if ( $("#subtotal").is('[readonly]') == false ){
		$("#subtotal").on( "blur keyup", function(){
			var subtotal = parseFloat( $(this).val() ); 
			var piva = subtotal * $("#iva").val();
			var total = subtotal + parseFloat( piva );
			
			$("#v_iva").val( piva.toFixed( 2 ) );
			$("#total").val( total.toFixed( 2 ) );
	    });

	    $("#subtotal").on( "blur", function(){ 
	    	var subtotal = parseFloat( $(this).val() );  
	    	$("#subtotal").val( subtotal.toFixed( 2 ) );   
	    });
	}
}
/* ----------------------------------------------------------------------------------- */
$( document ).ready(function() {
	
    $(".bloque_nota").hide();
    initSubtotal();	
	var cant = "";

    $(".ocn").click( function(){ // Selección de ajuste global
		$("#tconcepto").val( $(this).html() );
		$("#etq_concepto").html( $(this).html() );
		
		if( $(this).html() == "Ajuste global" ){
			$("#tdetalle").fadeOut(200); $("#subtotal").removeAttr("readonly");
		}else{
			$("#tdetalle").fadeIn(200); $("#subtotal").attr("readonly", "true"); 
			calcularTotales();
		}
		initSubtotal();
    });
	/* ------------------------------------------------------------------------------- */
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
			anularIva();
		}
		else{

			$("#bloque_concepto").show(300);
			$("#bloquen_facturas").show(300);
			$("#bloquen_clientes").hide(300);
			reestablecerIva();
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

    $("#bt_edit_nota").on( "click", function(){
	
		$("#closeModal").click();
		if( checkNota() == 0 )
			editarNota();
		else
			$("#enl_vmsj").click();
    });
    /*===============================================================================*/
});
/* ----------------------------------------------------------------------------------- */


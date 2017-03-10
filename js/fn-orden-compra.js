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
		beforeSend: function () {
			$("#btn_confirmacion").fadeOut(200);
		},
		success: function( response ){
			res = jQuery.parseJSON(response);
			console.log(response);
			var enlace = obtenerEnlaceDocumentoCreado( res.documento, res.documento.frm_r );
			ventanaMensaje( res.exito, res.mje, enlace );
		}
	});		
}
/* --------------------------------------------------------- */
function checkOrdenCompra(){
	var error = 0;
	$("#ventana_mensaje").addClass("modal-danger");
	$("#tit_vmsj").html( "Error" );
	
	if( $("#idProveedor").val() == "" ){
		$("#tx-vmsj").html("Debe indicar un proveedor");
		$("#nproveedor").css({'border-color' : '#dd4b39'});
		error = 1;
	}

	if( ( contarItems() == 0 ) && ( error == 0 ) ){
		$("#tx-vmsj").html("Debe ingresar ítems en la orden de compra");
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
$( document ).ready(function() {
	$("#titulo_emergente").html("Guardar orden de compra");
	$("#mje_confirmacion").html("¿Confirmar registro?");
	$("#btn_confirm").attr("id", "bt_reg_ordencompra");

	var cant = "";
	$(".alert").click( function(){
		$(this).hide("slow");
    });

	$("#fordc").blur( function(){
		if( $(this).val() != "" )
			$(this).css({'border-color' : '#ccc'});
    });

	$(".item_proveedor_lmodal").click( function(){
		/* Asignación de valores al seleccionar proveedor de la lista */
		$("#nproveedor").val( $(this).attr("data-label") );
		$("#nproveedor").css({'border-color' : '#ccc'});
		$("#idProveedor").val( $(this).attr("data-idp") );
		$("#xmodalproveedor").click();
    });
	
	$(".item_articulo_lmodal").click( function(){
		/* Asignación de valores al seleccionar artículo de la lista */
		$("#narticulo").val( $(this).attr("data-label") );
		$("#narticulo").css({'border-color' : '#ccc'});
		$("#idArticulo").val( $(this).attr("data-ida") );
		$("#und_art").val( $(this).attr("data-und") );
		$("#xmodalarticulo").click();
    });
	/*===============================================================================*/
    $("#bt_reg_ordencompra").on( "click", function(){
		$("#closeModal").click();
		if( checkOrdenCompra() == 0 )
			guardarOrdenCompra();
		else
			$("#enl_vmsj").click();
    });
});
/* --------------------------------------------------------- */


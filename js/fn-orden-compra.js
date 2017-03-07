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
function obtenerVectorDetalleOC(){
	var detalle_oc = new Array();
	var renglon = new Object();
	
	$("#d_oc_table input").each(function (){ 
		name = $(this).attr("name");
		renglon["" + name + ""] = $(this).val();

		if( name == "dfptotal" ){
			detalle_oc.push( renglon );
			renglon = new Object();
		}
	});
	return JSON.stringify( detalle_oc );
}
/* --------------------------------------------------------- */
function obtenerVectorEncabezado( numero, idproveedor, femision, total, iva ){
	encabezado = new Object();
	encabezado.numero = numero;
	encabezado.idproveedor = idproveedor;
	encabezado.femision = femision;
	encabezado.idu = $( '#idu_sesion' ).val();

	encabezado.introduccion = $( '#tentrada' ).val();
	encabezado.obs0 = $( '#tobs0' ).val();
	encabezado.obs1 = $( '#tobs1' ).val();
	encabezado.obs2 = $( '#tobs2' ).val();
	encabezado.obs3 = $( '#tobs3' ).val();

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
function obtenerItemDOrdenCompra( nitem, valor, id, nombre, param ){
	var clase = "";
	if( param == "readonly" ) clase = "montoacum";
	var campo = "<div class='input-group input-space'><input id='" + id + "' name='" + nombre 
					+ "' type='text' class='form-control itemtotal_detalle input-sm " + clase + 
					"' value='" + valor + "' data-nitem='" + nitem + "' " + param + "></div>";
	
	return campo;
}
/* --------------------------------------------------------- */
function obtenerCampoOcultoIF(  id, nombre, valor, nitem ){
	//Retorna una etiqueta de campo oculto con parámetros de definición
	var campo = "<input id='" + id + "' name='" + nombre + "' type='hidden' value='" + valor + "' data-nitem='" + nitem + "'>";
	return campo;
}
/* --------------------------------------------------------- */
function agregarItemOrdenCompra( nitem, idart, art, qant, und, punit, ptot ){
	c_qant = obtenerItemDOrdenCompra( nitem, qant, "idfq_" + nitem, "dfcant", "onkeypress='return isIntegerKey(event)' onKeyUp='actItemF( this )'", "text");
	c_punit = obtenerItemDOrdenCompra( nitem, punit, "idfpu_" + nitem, "dfpunit", "onkeypress='return isNumberKey(event)' onKeyUp='actItemF( this )' onBlur='initValid()'" );
	c_ptot = obtenerItemDOrdenCompra( nitem, ptot, "idfpt_" + nitem, "dfptotal", "readonly", "text" );
	c_und = obtenerItemDOrdenCompra( nitem, und, "idfund_" + nitem, "dfund", "", "text" );
	
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
	
	$( itemf ).appendTo("#d_oc_table tbody").show("slow");
	resetItemsOrdenCompra();
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
function resetItemsOrdenCompra(){
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
function guardarOrdenCompra(){
	
	var idproveedor = $( '#idProveedor' ).val();
	var numero = $( '#nordencompra' ).val();
	var femision = $( '#femision' ).val();
	var total = $( '#ftotal' ).val().replace(",", ".");
	var iva = $( '#iva' ).val();
	
	if( idproveedor != "" && total != "" && total != 0.00 ){
		
		fencabezado = obtenerVectorEncabezado( numero, idproveedor, femision, total, iva );
		oc_detalle = obtenerVectorDetalleOC();
	
		$.ajax({
			type:"POST",
			url:"bd/data-orden-compra.php",
			data:{ encabezado: fencabezado, detalle: oc_detalle, reg_orden_compra : 1 },
			beforeSend: function () {
				$("#btn_confirmacion").fadeOut(200);
			},
			success: function( response ){
				res = jQuery.parseJSON(response);
				//$("#waitconfirm").html(response);
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
	$("#d_oc_table input").each(function (){ 
		contitems++;
	});
	return contitems;
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
			agregarItemOrdenCompra( nitem, idart, art, qant, und, punit, ptot );	
		}
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


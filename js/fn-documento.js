// JavaScript Document
/*
* fn-documento.js
*
*/
/* ----------------------------------------------------------------------------------- */	
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey; 
/* ----------------------------------------------------------------------------------- */
function obtenerNombreCondicionForm(){
	//Obtiene el nombre de condición resultante del formulario del documento
	var valor = $( "#vcondicion" ).val();
	if ( ( valor != null ) && ( valor != "" ) ) 
		var valor = $("#vcondicion option:selected").text();
	else
		valor = $("#condicion_defecto").attr("data-condicion");
	return valor;
}
/* ----------------------------------------------------------------------------------- */
function obtenerCondicionForm(){
	//Obtiene el valor de condición resultante del formulario del documento
	var valor = $( "#vcondicion" ).val();

	if (( valor == null ) || ( valor == "" ) ){
		valor = $("#condicion_defecto").val();
	}
	
	return valor;
}
/* ----------------------------------------------------------------------------------- */
function obtenerEncabezadoBase(){
	//Retorna un objeto con los elementos comunes del encabezado de un documento
	encabezado = new Object();
	encabezado.idu = $( '#idu_sesion' ).val();		// sub-scripts/nav/perfil.php
	encabezado.idr = $( '#id_documento' ).val();
	encabezado.numero = $( '#ndocumento' ).val();
	encabezado.estado = $( '#estado' ).val();
	encabezado.vcondicion = obtenerCondicionForm();
	encabezado.ncondicion = obtenerNombreCondicionForm();
	encabezado.femision = $( '#femision' ).val();

	encabezado.introduccion = $( '#tentrada' ).val();
	encabezado.obs0 = $( '#tobs0' ).val();
	encabezado.obs1 = $( '#tobs1' ).val();
	encabezado.obs2 = $( '#tobs2' ).val();
	encabezado.obs3 = $( '#tobs3' ).val();

	encabezado.subtotal = $( '#subtotal' ).val();
	encabezado.total = parseFloat( $( '#total' ).val() );
	encabezado.iva = $( '#iva' ).val();

	return encabezado;
}
/* ----------------------------------------------------------------------------------- */
function obtenerVectorDetalle(){
	//Retorna un arreglo con los elementos de detalle del documento
	var detalle = new Array();
	var renglon = new Object();
	
	$("#tdetalle input").each(function (){ 
		name = $(this).attr("name");
		renglon["" + name + ""] = $(this).val();

		if( name == "dptotal" ){
			detalle.push( renglon );
			renglon = new Object();
		}
	});
	return JSON.stringify( detalle );
}
/* ----------------------------------------------------------------------------------- */
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
/* ----------------------------------------------------------------------------------- */
function hacerCampoItem( nitem, valor, id, nombre, param ){
	//Genera la etiqueta para los campos del ítem detalle de documento nuevo
	var clase = "";
	if( param == "readonly" ) clase = "montoacum";
	var campo = "<div class='input-group input-space'><input id='" + id + "' name='" + nombre 
				 + "' type='text' class='form-control itemtotal_detalle input-sm " + clase + "' value='" + valor 
				 + "' data-nitem='" + nitem + "' " + param + "></div>";
	
	return campo;
}
/* ----------------------------------------------------------------------------------- */
function hacerCampoItemOculto(  id, nombre, valor, nitem ){
	//Genera la etiqueta de campo oculto para un ítem detalle de documento nuevo
	var campo = "<input id='" + id + "' name='" + nombre + "' type='hidden' value='" + valor + "' data-nitem='" + nitem + "'>";
	return campo;
}
/* ----------------------------------------------------------------------------------- */
function agregarItemDocumento( nitem, idart, art, qant, und, punit, ptot ){
	//Agrega un renglón de ítem al bloque de detalle de documento nuevo
	var tabla = "#tdetalle";
	qant = hacerCampoItem( nitem, qant, "idq_" + nitem, "dcant", "onkeypress='return isIntegerKey(event)' onKeyUp='actItemD( this )'" );
	
	if( $("#tipo").val() == "solicitud" )
		param = "readonly";
	else
		param = "onkeypress='return isNumberKey(event)' onKeyUp='actItemD( this )' onBlur='initValid()'";
	
	punit = hacerCampoItem( nitem, punit, "idpu_" + nitem, "dpunit", param );
	
	ptot = hacerCampoItem( nitem, ptot, "idpt_" + nitem, "dptotal", "readonly" );
	und = hacerCampoItem( nitem, und, "idund_" + nitem, "dund", "text maxlength='3'" );
	
	idart = hacerCampoItemOculto( "idarticulo_" + nitem, "idart", idart, nitem );
	nart = hacerCampoItemOculto( "ndarticulo_" + nitem, "nart", art, nitem );

	id_bot_elim = "it" + nitem; $("#cont_item").val( nitem );
	
	var item_d = "<tr style='display: none;' id='"+ id_bot_elim + "'><th>" +
				art + idart + nart + "</th><th>" +
				qant + "</th><th>" +
				und + "</th><th>" +
				punit + "</th><th>" +
				ptot + "</th><th><button type='button' class='btn btn-block btn-danger btn-xs bedf blq_bdoc' "+
				"onClick='elimItemDetalle("+id_bot_elim +")'>" + "<i class='fa fa-times'></i></button></th></tr>";
	
	$( item_d ).appendTo( tabla + " tbody").show("slow");
	
	resetItemsDocumento();
	calcularTotales();
}
/* ----------------------------------------------------------------------------------- */
function calcularTotales(){
	//Suma los valores totales de ítems y calcula los totales del documento nuevo: subtotal, iva, total
	var subtotal = parseFloat( 0 );
	$(".montoacum").each(function (){ 
		subtotal = parseFloat( $(this).val() ) + subtotal;
	});
	
	var piva = subtotal * $("#iva").val();
	var total = subtotal + parseFloat( piva );
	
	$("#subtotal").val( subtotal.toFixed( 2 ) );
	$("#v_iva").val( piva.toFixed( 2 ) );
	$("#total").val( total.toFixed( 2 ) );	
}
/* ----------------------------------------------------------------------------------- */
function resetItemsDocumento(){
	//Reinicia los campos para agregar nuevo ítem al detalle de documento nuevo
	$("#narticulo").val("");
	$("#idArticulo").val( 0 );
	$("#cantidad").val( "" );
	if( $("#tipo").val() == "solicitud" ) 
		$("#punit").val( parseFloat(0.00).toFixed( 2 ) ); 
	else 
		$("#punit").val( "" );
	$("#ptotal").val( 0.00 );
}
/* ----------------------------------------------------------------------------------- */
function elimItemDetalle( fila ){
	//Elimina ítem de la tabla detalle de documento nuevo
	//Actualiza totales generales de documento nuevo
	$( fila ).hide('slow', function(){ 
		$( fila ).remove(); 
		calcularTotales(); 
	});
}
/* ----------------------------------------------------------------------------------- */
function actItemD( item ){
	//Actualiza el valor de precio total de ítem, en la tabla detalle de documento nuevo
	//Actualiza totales generales de documento
	var nitem = $(item).attr("data-nitem");
	
	var qant = $("#idq_" + nitem ).val();
	var punit = $("#idpu_" + nitem ).val();
	var ptot = $("#idpt_" + nitem ).val();
	
	$("#idpt_" + nitem ).val( ( qant * punit ).toFixed( 2 ) );
	calcularTotales();
}
/* ----------------------------------------------------------------------------------- */
function contarItems(){
	//Cuenta la cantidad de ítems en el detalle de un documento nuevo
	var contitems = 0;
	$("#tdetalle input").each(function (){ 
		contitems++;
	});
	return contitems;
}
/* ----------------------------------------------------------------------------------- */
function checkItemForm( idart, punit, qant ){
	//Validaciones para agregar ítem al detalle de documento
	var valido = 1;

	if( idart == "0" ) { $("#narticulo").css({'border-color' : '#dd4b39'}); valido = 0; }
	
	if( punit == "" ) { $("#punit").css({'border-color' : '#dd4b39'}); valido = 0; }
		else $("#punit").css({'border-color' : '#ccc'});
	
	if( qant == "" || qant == "0" ) { $("#cantidad").css({'border-color' : '#dd4b39'}); valido = 0; } 
		else $("#cantidad").css({'border-color' : '#ccc'});
	
	if( $( "#ptotal" ).val() == "0.00" ){ $( "#ptotal" ).css({'border-color' : '#dd4b39'}); valido = 0; }
		else $("#ptotal").css({'border-color' : '#ccc'});
	
	return valido;
}
/* ----------------------------------------------------------------------------------- */
function formatearMonto( monto ){
	return monto.replace(/\D/g, "")
	.replace(/([0-9])([0-9]{2})$/, '$1,$2')
	.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
}
/* ----------------------------------------------------------------------------------- */
function bloquearDocumento(){
	$(".blq_bdoc").prop('disabled', true);
	$(".frm_documento input").prop('readonly', true);
}
/* ----------------------------------------------------------------------------------- */
function initDoc(){
	$("#narticulo_asinc").on( "click", function(){
		$( "#bt_reg_articulo" ).hide('slow');
		$( "#bt_reg_art_modal" ).show();
    });	
}
/* ----------------------------------------------------------------------------------- */
function checkExcento( condicion ){
	//Verifica la condición de cliente excento para asignar valor al IVA: 0
	if( $("#tipofte").val() != "nota_entrega" ){
		if( condicion == "excento" ){
			$("#iva").val(0.00);
			$("#labiva").html("(0%)");
		}else{
			$iva_orig = $("#iva_orig").val();
			$("#iva").val( $iva_orig );
			$("#labiva").html( "(" + $iva_orig * 100 + "%)" );
		}
	}
	calcularTotales();
}
/* =================================================================================== */

$( document ).ready(function() {
	
	initValid();
	initDoc();

	$('#femision').datepicker({
		autoclose: true,
		format:'dd/mm/yyyy',
		language:'es',
		title:true
	});

    /* Asignación de etiqueta de Nombre de cliente en encabezado de documento al seleccionarlo de la lista de clientes*/
	$(".item_cliente_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#ncliente").val(texto);
		$("#idCliente").val( $(this).attr("data-idc") );
		$("#cpcontacto").val( $(this).attr("data-npc") );
		$("#ncliente").css({'border-color' : '#ccc'});
		checkExcento( $(this).attr("data-iex") );
		$("#xmodalcliente").click();
    });

    /* Asignación de datos de proveedor en encabezado de documento al seleccionarlo de la lista de proveedores*/
	$(".item_proveedor_lmodal").click( function(){
		
		$("#nproveedor").val( $(this).attr("data-label") );
		$("#idProveedor").val( $(this).attr("data-idp") );	// Para órdenes de compra
		$("#idCliente").val( $(this).attr("data-idp") );	//idCliente = id de proveedor cuando se trata de sol. de cotización
		$("#cpcontacto").val( $(this).attr("data-npc") );
		$("#nproveedor").css({'border-color' : '#ccc'});
		$("#xmodalproveedor").click();
    });

    /* Asignación de etiqueta de Nombre de artículo en encabezado de documento al seleccionarlo de la lista de artículos*/
	$(".item_articulo_lmodal").click( function(){
		texto = $(this).attr("data-label"); 
		$("#narticulo").val( texto );
		$("#idArticulo").val( $(this).attr("data-ida") );
		$("#narticulo").css({'border-color' : '#ccc'});
		$("#und_art").val( $(this).attr("data-und") );
		$("#xmodalarticulo").click();
    });
	
	$(".itemtotal").on( "blur keyup", function(){
		//Actualización y asignación de precio total (cant x punit) en la sección agregar ítems
		var cant = $("#cantidad").val(); 
		var punit = $("#punit").val();
		
		$( "#ptotal" ).val( ( cant * punit ).toFixed( 2 ) );
    });
	
	$("#ag_item").click( function(){
		//Chequea y agrega ítems de detalle al documento
		var art = $("#narticulo").val(); 	var idart = $("#idArticulo").val();
		var punit = parseFloat( $("#punit").val() ).toFixed( 2 );		
		var qant = $("#cantidad").val(); 	var ptot = $("#ptotal").val();		
		var nitem = $("#cont_item").val(); 	var und = $("#und_art").val();
		nitem++;	
		
		if( checkItemForm( idart, punit, qant ) == 1 ){	
			agregarItemDocumento( nitem, idart, art, qant, und, punit, ptot );	
		}
    });
    /* ---------------------------------------------------------------------------- */
});
/* -------------------------------------------------------------------------------- */


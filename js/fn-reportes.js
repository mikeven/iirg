// JavaScript Document
/*
* fn-reportes.js
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
function reiniciarTabla(){
	$( '#tabla_reporte thead' ).html("");
	$( '#tabla_reporte tbody' ).html("");		
}
/* ----------------------------------------------------------------------------------- */
function agregarEncabezados( tencabezado, encabezado ){
	//Retorna los encabezados de la tabla del reporte
	tencabezado += "<tr class='enc_tab_rep'>";
	$.each( encabezado, function( key, value ) {
	  tencabezado += "<td align='center'>" + value + "</td>";
	});	tencabezado += "</tr>";
	return tencabezado;
}
/* ----------------------------------------------------------------------------------- */
function agregarFilasReporte( filas, registros ){
	//Retorna las filas con los registros del reporte
	$.each( registros, function( arreglo, fila ) {
	  filas += "<tr class='fila_tab_rep'>";	
	  $.each( fila, function( campo, valor ) {
	  	filas += "<td align='center'>" + valor + "</td>";
	  }); filas += "</tr>";
	});
	return filas;
}
/* ----------------------------------------------------------------------------------- */
function agregarFilaSeperacion( encabezado ){
	//Agrega una fila para separar los encabezados
	var cc = 0;
	var fila = "<tr>";
	$.each( encabezado, function() { cc++; });
	fila += "<td colspan='" + cc + "'><div id='bordeado_doble'></div></td></tr>";
	return fila;
}
/* ----------------------------------------------------------------------------------- */
function agregarFilaVacia( encabezado ){
	//Agrega una fila vacía para separar los registros de la totalización
	var fila = "<tr>";
	$.each( encabezado, function() { fila += "<td>&nbsp;</td>"; });
	fila += "</tr>";
	return fila;
}
/* ----------------------------------------------------------------------------------- */
function agregarFilaTotales( encabezado, totales ){
	//Ingresa los totales en las columnas correspondientes del reporte
	var fila = "<tr>"; 
	var col = "<td></td>";
	var coincide_titulo = false;
	
	$.each( encabezado, function( ntitulo, titulo ) {
		coincide_titulo = false;
		$.each( totales, function( vector, valor ) {
			if( titulo == valor.posicion ){
				fila += "<td align='center'><b>" + valor.total + "</b></td>";
				coincide_titulo = true;
			}
		});
		if ( coincide_titulo == false ) fila += col;
	}); fila += "</tr>";

	return fila;
}
/* ----------------------------------------------------------------------------------- */
function enviarDataReporte( data_reporte ){
	//Recibe los datos del reporte y los imprime en la tabla de resultados
	var encabezado = data_reporte.encabezado;
	var registros = data_reporte.registros;
	var totales = data_reporte.totales;
	var tencabezado = "";
	var filas = "";
	reiniciarTabla();
	tencabezado += agregarEncabezados( tencabezado, encabezado );
	//tencabezado += agregarFilaSeperacion( encabezado );
	
	filas += agregarFilasReporte( filas, registros );
	filas += agregarFilaVacia( encabezado );
	filas += agregarFilaTotales( encabezado, totales );

	$( '#tabla_reporte thead' ).append( tencabezado ).show('slow');
	$( '#tabla_reporte tbody' ).append( filas ).show('slow');
}
/* ----------------------------------------------------------------------------------- */
function obtenerReporte( r, fini, ffin, p ){
	var idu = $( '#idu_sesion' ).val();
	var url_data = "bd/data-reportes.php";
	var tg = "";
	if( r == "relacion_gastos" ) tg = "gasto";
	if( r == "pago_facturas" ) tg = "pago";

	$.ajax({
        type:"POST",
        url:url_data,
        data:{ reporte: r, tipo:tg, f_ini: fini, f_fin: ffin, id_u:idu },
        beforeSend: function () {
			$("#impresion_reporte").hide();	
		},
        success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			enviarDataReporte( res );
			if( p == "rep" )
				$("#impresion_reporte").fadeIn("slow");
			if( p == "imp" )
				window.print();
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function r(){

	var fecha_ini = $("#fini").val();
	var fecha_fin = $("#ffin").val();
	var reporte =  	$("#idr").val();
	obtenerReporte( reporte, fecha_ini, fecha_fin, "imp" );
}
/* =================================================================================== */
$( document ).ready(function() {
	$("#impresion_reporte").hide();
	//Date range picker
    $('#frango').daterangepicker({
		"format": "DD/MM/YYYY",
		"locale": {
	        "separator": " - ",
	        "applyLabel": "OK",
	        "cancelLabel": "Cancelar",
	        "fromLabel": "Desde",
	        "toLabel": "Hasta",
	        "customRangeLabel": "Custom",
	        "weekLabel": "W",
	        "daysOfWeek": [
	            "Do", "Lu", "Ma",
	            "Mie","Ju", "Vi", "Sa"
	        ],
        	"monthNames": [
	            "Enero", "Febrero", "Marzo", "Abril",
	            "Mayo", "Junio", "Julio", "Agosto", 
	            "Septiembre", "Octubre", "Noviembre", "Deciembre"
        	]
        }
	});

	$(".selreporte").on( "click", function(){
		$(".selreporte").removeClass( "rseleccionado" );
		$(this).addClass("rseleccionado");

    });

    $(".treporte").on( "click", function(){
		$("#titulo_reporte").html( $(this).html() );
		$("#bt_breporte").attr("data-r", $(this).attr("id") );		
    });

    $("#bt_breporte").on( "click", function(){
		var fecha_ini = $('#frango').data('daterangepicker').startDate.format('YYYY-MM-DD');
		var fecha_fin = $('#frango').data('daterangepicker').endDate.format('YYYY-MM-DD');
		var reporte = $(this).attr("data-r");
		var idu = $( '#idu_sesion' ).val();

		$("#eimpresion").attr("href", "impresion-reporte.php?idr=" + reporte + "&f1=" 
			+ fecha_ini + "&f2=" + fecha_fin + "idu=" + idu );

		obtenerReporte( reporte, fecha_ini, fecha_fin, "rep" );
    });

    /* ---------------------------------------------------------------------------- */
});
/* -------------------------------------------------------------------------------- */


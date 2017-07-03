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
function reiniciarTabla(){
	$( '#tabla_reporte thead' ).html("");
	$( '#tabla_reporte tbody' ).html("");		
}
/* ----------------------------------------------------------------------------------- */
function agregarEncabezados( tencabezado, encabezado ){
	//Retorna los encabezados de la tabla del reporte
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
	$.each( encabezado, function( ntitulo, titulo ) {
		$.each( totales, function( vector, total ) {
			if( titulo == total.posicion )
				fila += "<td align='center'><b>" + total.total + "</b></td>";
			else
				fila += col;
		});
	}); fila += "</tr>";

	return fila;
}
/* ----------------------------------------------------------------------------------- */
function enviarDataReporte( data_reporte ){
	var encabezado = data_reporte.encabezado;
	var registros = data_reporte.registros;
	var totales = data_reporte.totales;
	var tencabezado = "<tr class='enc_tab_rep'>";
	var filas = "";
	reiniciarTabla();
	tencabezado += agregarEncabezados( tencabezado, encabezado );
	
	filas += agregarFilasReporte( filas, registros );
	filas += agregarFilaVacia( encabezado );
	filas += agregarFilaTotales( encabezado, totales );

	$( '#tabla_reporte thead' ).append( tencabezado ).show('slow');
	$( '#tabla_reporte tbody' ).append( filas ).show('slow');
}
/* ----------------------------------------------------------------------------------- */
function obtenerReporte( r, fini, ffin ){
	var idu = $( '#idu_sesion' ).val();
	var url_data = "bd/data-reportes.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ reporte: r, f_ini: fini, f_fin: ffin, id_u:idu },
        	success: function( response ){
			console.log(response);
			res = jQuery.parseJSON(response);
			enviarDataReporte( res );
        }
    });
}
/* =================================================================================== */
$( document ).ready(function() {
	
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
		obtenerReporte( reporte, fecha_ini, fecha_fin );
    });

    /* ---------------------------------------------------------------------------- */
});
/* -------------------------------------------------------------------------------- */


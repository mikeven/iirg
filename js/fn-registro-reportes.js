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
function enviarDataReporte( data_reporte ){
	var encabezado = data_reporte.encabezado;
	var registros = data_reporte.data;
	var tencabezado = "<tr class='enc_tab_rep'>";
	var tfila = "<tr class='fila_tab_rep'>";
	reiniciarTabla();

	$.each( encabezado, function( key, value ) {
	  tencabezado += "<td>" + value + "</td>";
	});	tencabezado += "</tr>";
	
	$.each( registros ) {
	  tfila += "<td>" + value + "</td>";
	}); tfila += "</tr>";

	$( '#tabla_reporte thead' ).append( tencabezado ).show('slow');
	$( '#tabla_reporte tbody' ).append( tfila ).show('slow');
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
			//console.log(response);
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


// JavaScript Document
/*
* fn-hoja-documento.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
/* --------------------------------------------------------- */
function actualizarEstadoDocumento( id, filedoc, status ){
	
	$.ajax({
		type:"POST",
		url:"bd/data-documento.php",
		data:{ id_doc_estado: id, documento: filedoc, estado: status },
		beforeSend: function () {			
		},
		success: function( response ){
			console.log( response );
			location.reload();
		}
	});		
}

/*===============================================================================================*/

$( document ).ready(function() {
	
	$(".actestado").click( function(){
		$("#accion_estado").attr('data-estado', $(this).attr('data-valor') );
		$("#taccionestado").html( $(this).attr('data-taccion') );	
    });	

	$("#accion_estado").click( function(){
		var filedoc = $(this).attr("data-file-doc");
		var id = $("#id_documento").val();
		actualizarEstadoDocumento( id, filedoc, $(this).attr('data-estado') );	
    });  
});
/* --------------------------------------------------------- */


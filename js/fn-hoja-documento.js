// JavaScript Document
/*
* fn-hoja-documento.js
*
*/
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function actualizarEstadoDocumento( id, filedoc, status, redir ){
	
	$.ajax({
		type:"POST",
		url:"bd/data-documento.php",
		data:{ id_doc_estado: id, documento: filedoc, estado: status },
		beforeSend: function () {			
		},
		success: function( response ){
			console.log( response );
			if( redir == "" ) location.reload();
			else
				window.location.href=redir;
		}
	});		
}

/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */

$( document ).ready(function() {
	
	$(".actestado").click( function(){
		$("#accion_estado").attr('data-estado', $(this).attr('data-valor') );
		$("#accion_estado").attr('data-rdir', $(this).attr('data-rdir') );
		$("#taccionestado").html( $(this).attr('data-taccion') );	
    });	

	$("#accion_estado").click( function(){
		var filedoc = $(this).attr("data-file-doc");
		var id = $("#id_documento").val();
		var rdir = $(this).attr("data-rdir");
		actualizarEstadoDocumento( id, filedoc, $(this).attr('data-estado'), rdir );	
    });
     	
});
/* ----------------------------------------------------------------------------------- */


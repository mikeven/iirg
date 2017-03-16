// JavaScript Document
/*
* fn-hoja-documento.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
/* --------------------------------------------------------- */
function anularDocumento( id, filedoc ){
	
	$.ajax({
		type:"POST",
		url:"bd/data-documento.php",
		data:{ id_doc_anul: id, documento: filedoc },
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
	
	$(".btn_anulacion").click( function(){
		var filedoc = $(this).attr("data-file-doc");
		var id = $("#id_documento").val();
		anularDocumento( id, filedoc );	
    });  
});
/* --------------------------------------------------------- */


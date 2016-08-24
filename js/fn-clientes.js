// JavaScript Document
/*
* fn-clientes.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function reg_cliente( frm_cliente ){
	url_data = "bd/data-cliente.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ form: frm_cliente.serialize(), reg_cliente:1 },
        success: function( response ){
			//alert(response);
			/*if( response == 1 ){
				window.location = "main.php";
			}
			else 
				$("#response").html( error_m );*/
        }
    });
}
/* --------------------------------------------------------- */
$(document).ready(function(){
	$("#bt_reg_cliente").click(function(e){ 
		var frm = $("#frm_ncliente");
		//reg_cliente( frm );
	});
});

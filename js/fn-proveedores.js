// JavaScript Document
/*
* fn-clientes.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function reg_proveedor( frm_nproveedor ){
	url_data = "bd/data-proveedor.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ form: frm_nproveedor.serialize(), reg_proveedor:1 },
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
	$("#bt_reg_proveedor").click(function(e){ 
		//reg_proveedor( $("#frm_nproveedor") );
	});
});

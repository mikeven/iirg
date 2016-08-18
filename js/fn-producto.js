// JavaScript Document
/*
* fn-clientes.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function reg_categoria( frm_categoria ){
	url_data = "bd/data-producto.php";
	var categ = $("#cnombre").val();
	var desc = $("#cdescripcion").val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ nombre: categ, descripcion: desc, reg_categoria:1 },
        success: function( response ){
			window.location.href="nuevo_producto.php?c=" + response;
        }
    });
}

function actualizarCategoria( idr, campo, valor ){
	url_data = "bd/data-producto.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ act_categ: campo, valor_c: valor, idreg: idr },
        success: function( response ){
			alert(response);
			//window.location.href="nuevo-producto.php";
        }
    });
}

$( document ).ready(function() {
	$(".lncat").blur(function(){
		valor = $(this).val(); idr = $(this).attr("id");
		actualizarCategoria( idr, "nombre", valor );
    })
	$(".ldcat").blur(function(){
		valor = $(this).val(); idr = $(this).attr("id");
		actualizarCategoria( idr, "descripcion", valor );
    })	
});
/* --------------------------------------------------------- */


// JavaScript Document
/*
* fn-clientes.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function valorExistente( html, clave, val, cres ){
	var url_data = "bd/data-proveedor.php";
	var existe = 0;
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ campo: clave, valor: val, existe_rif: 1 },
        success: function( response ){
			$(cres).val(response);
			marcarCampo( html, response );
        }
    });
}
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
function checkProveedor( mje_destino ){
	//Validación de datos de proveedor antes de registrarse
	var error = 0; var mje = "";
	oRes = arrayMjes( mje_destino );
	//$(oRes.idhtml).addClass("modal-danger");

	if( $("#err_rif").val() == 1 ) {
		error = 1; mje = "RIF ya registrado en un proveedor";
	}

	if( $("#err_email").val() == 1 ) {
		error = 1; mje = "Email ya registrado en un proveedor";
	}

	if( error == 1 ){
		//Asignar ventana de mensaje como mensaje de error
		$(oRes.mensaje).html( mje );		
		$(oRes.idhtml).addClass(oRes.clase);
		$(oRes.titulo).html( "Error" );
	}

	return error;
}
/* --------------------------------------------------------- */
$(document).ready(function(){

	$(".bdir").attr("maxlength", 46);

	$(".vexistente").on( "change", function() {
		var valor = $(this).val();
		var clave = $(this).attr("name");
		var cres = $(this).attr("data-err");
		valorExistente( $(this), clave, valor, cres );
	});

	$("#bt_reg_proveedor").on( "click", function() {
		if( checkProveedor('modal') == 0 )
			reg_proveedor( $("#frm_nproveedor"), "redireccion", '' );
		else
			$("#enl_vmsj").click();	
	});
});

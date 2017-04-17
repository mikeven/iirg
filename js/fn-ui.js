// JavaScript Document
/*
* fn-ui.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
/* --------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function ventanaMensaje( exito, mensaje ){
	var clase_m = ["modal-danger", "modal-success"];
	$("#tx-vmsj").html( "" );	
	$("#ventana_mensaje").addClass( clase_m[exito] );
	$("#tit_vmsj").html( mensaje );
	$("#enl_vmsj").click();
}
/* ----------------------------------------------------------------------------------- */
function alertaMensaje( exito, mensaje ){
	//$("#resalerta").removeClass("alert-danger", "alert-success");
	var clase_m = ["alert-danger", "alert-success"];
	$("#tresalerta").html( "" );	
	$("#resalerta").addClass( clase_m[exito] );
	$("#txmjealerta").html( mensaje );
	$("#resalerta").fadeIn("slow");
}
/* ----------------------------------------------------------------------------------- */
function resetFrm( frm ){
	$( frm + " input" ).each(function() { $(this).val(""); 	});
}
/* ----------------------------------------------------------------------------------- */
function marcarCampo( campo, error ){
	if( error == 1 )
		campo.css({'border-color' : '#dd4b39'});
	if( error == 0 )
		campo.css({'border-color' : '#ccc'});
}
/* ----------------------------------------------------------------------------------- */
function enviarRespuesta( res, modo, idhtml ){
	//Manejo de respuesta de acuerdo al modo indicado
	if( modo == "ventana" ){
		ventanaMensaje( res.exito, res.mje );
	}
	if( modo == "redireccion" ){
		var url = "ficha_articulo.php?a=" + res.articulo.id;
		window.location.href = url;
	}
	if( modo == "print" ){
		alertaMensaje( res.exito, res.mje );
	}
}
/* ----------------------------------------------------------------------------------- */
function arrayMjes( modo ){
	//
	var amensajes = [], modalmje = [], alertmje = [];
	
	modalmje["idhtml"] = "#ventana_mensaje";
	modalmje["titulo"] = "#tit_vmsj";
	modalmje["mensaje"] = "#tx-vmsj";
	modalmje["clase"] = "modal-danger";
	alertmje["idhtml"] = "#resalerta";
	alertmje["titulo"] = "#tresalerta";
	alertmje["mensaje"] = "#txmjealerta";
	alertmje["clase"] = "alert-danger";

	amensajes["modal"] = modalmje;
	amensajes["alerta"] = alertmje;

	return amensajes[modo];
}
/*=====================================================================================*/
$( document ).ready(function() {
	
	$(".close-alt").on( "click", function() {
		$("#" + $(this).attr("data-target") ).hide('slow');	
	});    
});
/* ----------------------------------------------------------------------------------- */

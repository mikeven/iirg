// JavaScript Document
/*
* fn-condicion.js
*
*/
/* ----------------------------------------------------------------------------------- */	
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function isIntegerKey(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if ( charCode < 48 || charCode > 57 )
		return false;
	return true;
}
/* ----------------------------------------------------------------------------------- */
function ventanaMensaje( exito, mensaje, enlace ){
	var clase_m = ["modal-danger", "modal-success"];
	if( exito == '1' )
		$("#tx-vmsj").html( enlace );
		
	$("#ventana_mensaje").addClass( clase_m[exito] );
	$("#tit_vmsj").html( mensaje );
	$("#enl_vmsj").click();
}
/* ----------------------------------------------------------------------------------- */
function checkCondicion( vcond ){
	//Validación de formulario de condiciones previo a su registro
	var error = 0;
	elem_existentes = vcond.attr("data-ve"); //data-ve: data-valores existentes
	
	if( vcond.val() == "" ){
		//Valor vacío
		$("#tx-vmsj").html("Debe ingresar un valor");
		vcond.css({'border-color' : '#dd4b39'});	
		error = 1;
	}

	$("." + elem_existentes).each(function(){
		if( $(this).val() == vcond.val() ){
			//Valor ya registrado
			$("#tx-vmsj").html("Este valor ya está registrado");
			return error = 1;
		}
	});

	if( error == 1 ){
		//Asignar ventana de mensaje como mensaje de error
		$("#ventana_mensaje").addClass("modal-danger");
		$("#tit_vmsj").html( "Error" );
	}

	return error; 
}
/* ----------------------------------------------------------------------------------- */
function agregarFilaCondicionTabla( data, nf, idCondicion ){
	var vclase = data.attr("data-ve");
	var valor = data.val();
	var tabla = "#lista_condiciones_" + vclase;

	var elem = "<tr id='" + vclase + nf + "'>" + 
	                "<th width='90%' class='tit_tdf_i'>" +
                  "<div class='input-group'>" + 
                    "<input type='text' class='form-control iik " + vclase + "' id='" + idCondicion + "' "
                    + "name='condicion' value='" + valor + "' maxlength='2'>" +
                    "<span class='input-group-addon'>días</span>" +
                  "</div></th>" +                
                "<th width='7%' class='tit_tdf_d'>"+
                  "<button type='button' class='btn btn-block btn-danger ecd' data-fila='" + vclase + nf + "' " + 
                  "data-idc='" + idCondicion + "'><i class='fa fa-times'></i></button></th></tr>";

    $( elem ).fadeIn('slow', function(){ 
		$( elem ).appendTo( tabla + " tbody"); 
	});
}
/* ----------------------------------------------------------------------------------- */
function registrarCondicion( valor ){
	//
	var idu = $("#idUsuario").val();
	var nf = $("#nregs" + valor.attr("data-ve") ).val();
	
	$.ajax({
		type:"POST",
		url:"bd/data-documento.php",
		data:{ v: valor.val(), documento:valor.attr('data-d'), idusuario:idu, reg_condicion : 1 },
		beforeSend: function () {			

		},
		success: function( response ){
			//console.log(response);
			res = jQuery.parseJSON(response);
			agregarFilaCondicionTabla( valor, nf+1, res.idr );
		}
	});
}
/* ----------------------------------------------------------------------------------- */
function eliminarCondicion( idcond, fila ){
	var idu = $("#idUsuario").val();
	$.ajax({
		type:"POST",
		url:"bd/data-documento.php",
		data:{ elim_condicion: idcond },
		beforeSend: function () {			

		},
		success: function( response ){
			if( response > 0 )
			$( "#" + fila ).hide('slow', function(){ 
				$( "#" + fila ).remove(); 
			});			
		}
	});
}
/* ----------------------------------------------------------------------------------- */
$( document ).ready(function() {
	/* =============================================================================== */
	
	$( ".iik" ).keypress(function( evt ) {
		return isIntegerKey(evt); 	
	});
	
	$(".ag_cond").on( "click", function(){
		var vcond = $(this).attr("data-v");
		if( checkCondicion( $("#" + vcond ) ) == 0 ){
			registrarCondicion( $("#" + vcond ) );
		}
		else
			$("#enl_vmsj").click();
    });
	
	$(".ecd").on( "click", function(){
		var idcond = $(this).attr("data-idc");
		var fila = $(this).attr("data-fila");
		eliminarCondicion( idcond, fila );
    });

    /* =============================================================================== */
});
/* ----------------------------------------------------------------------------------- */


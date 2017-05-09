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
function actualizarValorIVA( iva ){
	var icon_ok = "<i class='fa fa-check-square-o'></i>";
	$.ajax({
		type:"POST",
		url:"bd/data-sistema.php",
		data:{ act_iva : iva },
		beforeSend: function () {
		},
		success: function( response ){
			console.log(response);
			if( response != -1 ){
			    $("#ivares").fadeOut("slow", function(){
			        $("#ivares").html( icon_ok );
			       	$("#ivares").fadeIn( 300 );	
			    });
			}
		}
	});	
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
function agregarFilaCondicionTabla( data, idCondicion ){
	var vclase = data.attr("data-ve");
	var valor = data.val();
	var tabla = "#lista_condiciones_" + vclase;

	var elem = "<tr id='" + vclase + idCondicion + "'>" + 
	                "<th width='90%' class='tit_tdf_i'>" +
                  "<div class='input-group'>" + 
                    "<input type='text' class='form-control iik " + vclase + "' id='" + idCondicion + "' "
                    + "name='condicion' value='" + valor + "' maxlength='2'>" +
                    "<span class='input-group-addon'>días</span>" +
                  "</div></th>" +                
	                "<th width='7%' class='tit_tdf_d'>" +
	                "<button type='button' class='btn btn-block btn-danger ecd'" +
	                "data-fila='" + vclase + idCondicion + "' data-idc='" + idCondicion + "'>"+
	                "<i class='fa fa-times'></i></button></th></tr>";

	$( elem ).appendTo( tabla + " tbody").show("slow");
	initBotonEliminarCondicion();
}
/* ----------------------------------------------------------------------------------- */
function registrarCondicion( valor ){
	//Invoca la inserción de un registro de condición de documento
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
			agregarFilaCondicionTabla( valor, res.idr );
		}
	});
}
/* ----------------------------------------------------------------------------------- */
function actualizarCondicion( idcond, valor ){
	//Invoca la actualización de un registro de condición de documento
	if( valor != "" ){
		$.ajax({
			type:"POST",
			url:"bd/data-documento.php",
			data:{ editar_condicion: idcond, val:valor },
			beforeSend: function () {
			},
			success: function( response ){
				if( response != -1 ){
					$( "#chkue" + idcond ).hide();
					$( "#chku" + idcond ).show( 300 ).delay( 2000 ).fadeOut( 1000 );
				}			
			}
		});
	}
	else
		$( "#chkue" + idcond ).show( 300 );
	
}
/* ----------------------------------------------------------------------------------- */
function eliminarCondicion( idcond, fila ){
	//Invoca la eliminación de un registro de condición de documento

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
function initBotonEliminarCondicion(){
	$(".ecd").on( "click", function(){
		var idcond = $(this).attr("data-idc");
		var fila = $(this).attr("data-fila");
		eliminarCondicion( idcond, fila );
    });	
}
/* ----------------------------------------------------------------------------------- */
$( document ).ready(function() {
	/* =============================================================================== */
	
	$('#calendar').datepicker({
	    format:'dd/mm/yyyy',
	    language:'es'
	});
	
	$(".cont_det").hide();
	$(".lnk_detres").on( "click", function(){
		$("#" + $(this).attr("data-det")).fadeToggle( 500, "easeInOutQuint");
		$("i", this).toggleClass("fa-arrow-circle-down fa-arrow-circle-up");
    });

	/* ------------------------------------------------------------------------------- */
	$("#bt_act_iva").on( "click", function(){
		var iva = $("#iva_valor").val();
		actualizarValorIVA( iva );
    });

	/* ------------------------------------------------------------------------------- */
	$(".chkupdt").hide();
    $(".chkupdt_e").hide();
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
	
    $(".vecc, .vecf").on( "change", function(){
		valor = $(this).val(); idr = $( this ).attr("id");
		actualizarCondicion( idr, valor );
    })

	initBotonEliminarCondicion();

    /* =============================================================================== */
});
/* ----------------------------------------------------------------------------------- */


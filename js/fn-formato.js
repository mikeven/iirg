// JavaScript Document
/*
* fn-formato.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function dataform( frm, param ){
	vector = new Object();
	if(param != "ent"){
		$( frm + " input" ).each( function (){ vector["" + $(this).attr("name") + ""] = $(this).val(); 	} );
	}
	if(param == "ent"){
		vector["entrada"] = $("#tentctz").val();  vector["idUsuario"] = $("#idUsuario").val();
	}
	console.log(JSON.stringify( vector ));	
	return JSON.stringify( vector );
}
/* --------------------------------------------------------- */
function reg_formato( documento, frm, param ){
	url_data = "bd/data-formato.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ form: dataform( frm, param ), doc:documento, s:param },
        success: function( response ){
			res = jQuery.parseJSON(response);
			//$("#waitconfirm").html(response);
			if( res.exito == '1' ){
				$("#txexi").html(res.mje);
				$("#mje_exito").show("slow").delay(5000).hide("slow");
				$("#mje_error").hide();
			}
			if( res.exito == '0' ){
				$("#mje_exito").hide();
				$("#mje_error").show("slow").delay(10000).hide("slow");;
				$("#txerr").html(res.mje);
			}
        }
    });
}
/* -------------------------------------------------------------------------------------------------------------- */
$( document ).ready(function() {
    $(".alert").hide();
    $('#frm_mencabezc').bootstrapValidator({
        fields: {
				  l1: { validators: { notEmpty: { message: 'Debe indicar encabezado' } } }
        },
		onSuccess: function( e, data ) {
          e.preventDefault();
          reg_formato( "ctz", "#frm_mencabezc", "enc" );
        }
    });

    $('#frm_mctzent').bootstrapValidator({
        fields: {
            entrada: { validators: { notEmpty: { message: 'Debe indicar texto de entrada' } } }
        },
        onSuccess: function(e, data) {
          e.preventDefault();
          reg_formato( "ctz", "#frm_mctzent", "ent" );
        }
    });

    $('#frm_mctzobs').bootstrapValidator({
        fields: {
            obs1: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
          e.preventDefault();
          reg_formato( "ctz", "#frm_mctzobs", "obs" );
        }
    });

    $('#frm_mfacobs').bootstrapValidator({
        fields: {
            obs1: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
          e.preventDefault();
          reg_formato( "fac", "#frm_mfacobs", "obs" );
        }
    });


    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });

    /* Configuración de observaciones formato cotización */
    $('.solectura').click( function(){
        var target = $(this).attr("data-c");
        $(".csctzobs").each(function (){ 
            if( $(this).attr("data-v") == "VCTZ" ){ $(this).val(""); $(this).attr("data-v", "");  } 
        });
        $(".csctzobs").removeAttr("readonly");
        $("#" + target).val("Validez cotización");
        $("#" + target).attr("readonly", "true"); $("#" + target).attr( "data-v", "VCTZ" );
        $("#v" + target).val("#vctz");
    });

    $('.blocampo').click( function(){
        var target = $(this).attr("data-c");
        $("#" + target).val(""); $("#" + target).attr("readonly", "true");
    });
    
    $('.libresc').click( function(){
        var target = $(this).attr("data-c");
        if( $("#" + target).attr("data-v") == "VCTZ" ){ $("#" + target).val(""); $("#" + target).attr("data-v", ""); } 
        $("#" + target).removeAttr("readonly");
    });

    $('.csctzobs').blur( function(){
        var target = "v" + $(this).attr("id");
        $("#" + target).val( $(this).val() );
    });

    /* Configuración de observaciones formato factura */
    $('.solecturaf').click( function(){
        var target = $(this).attr("data-f");
        $(".csfacobs").each(function (){ 
            if( $(this).attr("data-v") == "VFAC" ){ $(this).val(""); $(this).attr("data-v", "");  } 
        });
        $(".csfacobs").removeAttr("readonly");
        $("#" + target).val("Condición de pago");
        $("#" + target).attr("readonly", "true"); $("#" + target).attr( "data-v", "VFAC" );
        $("#v" + target).val("#vfac");
    });

    $('.blocampof').click( function(){
        var target = $(this).attr("data-f");
        $("#" + target).val(""); $("#" + target).attr("readonly", "true");
    });
    
    $('.libresf').click( function(){
        var target = $(this).attr("data-f");
        if( $("#" + target).attr("data-v") == "VFAC" ){ $("#" + target).val(""); $("#" + target).attr("data-v", ""); } 
        $("#" + target).removeAttr("readonly");
    });

    $('.csfacobs').blur( function(){
        var target = "v" + $(this).attr("id");
        $("#" + target).val( $(this).val() );
    });

});
/* --------------------------------------------------------- */

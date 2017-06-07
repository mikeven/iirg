// JavaScript Document
/*
* fn-formato.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function dataform( frm, param ){
	vector = new Object();
	
	if( param != "ent" ){
		$( frm + " input" ).each(function (){  
			vector["" + $(this).attr("name") + ""] = $(this).val(); 	
		});
	}
	
	if( param == "ent" ){
		vector["entrada"] = $( frm + " #tentrada" ).val();  
		vector["idUsuario"] = $("#idUsuario").val();
	}
	
	//console.log( JSON.stringify( vector ) );	
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
				$("#tx-vmsj").html( res.mje );
				$("#ventana_mensaje").addClass("modal-success");				
			}
			if( res.exito == '0' ){
                $("#tx-vmsj").html(res.mje);				
				$("#ventana_mensaje").addClass("modal-danger");				
			}
            $("#enl_vmsj").click();
        }
    });
}
/* -------------------------------------------------------------------------------------------------------------- */
$( document ).ready(function() {
    
	$(".alert").hide();
    $(".dataobs").attr("maxlength", 50);
    
	/* --------------------------------------------------------------------------- */ 
	/* Validaciones: cotizaciones */ 
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
	
	/* --------------------------------------------------------------------------- */
	/* Validaciones: solicitud de cotizaciones */
	$('#frm_mencabez_solc').bootstrapValidator({	// Encabezado
        fields: {
			l1: { validators: { notEmpty: { message: 'Debe indicar encabezado' } } }
        },
		onSuccess: function( e, data ) {
        	e.preventDefault();
        	reg_formato( "sctz", "#frm_mencabez_solc", "enc" );
        }
    });

    $('#frm_msol_ctzent').bootstrapValidator({		// Texto entrada
        fields: {
            entrada: { validators: { notEmpty: { message: 'Debe indicar texto de entrada' } } }
        },
        onSuccess: function(e, data) {
			e.preventDefault();
			reg_formato( "sctz", "#frm_msol_ctzent", "ent" );
        }
    });

    $('#frm_msolctzobs').bootstrapValidator({		// Observaciones
        fields: {
            obs1: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
			e.preventDefault();
			reg_formato( "sctz", "#frm_msolctzobs", "obs" );
        }
    });
	/* --------------------------------------------------------------------------- */
	/* Validaciones: facturas */
    $('#frm_mfacobs').bootstrapValidator({
        fields: {
            obs1: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
			e.preventDefault();
			reg_formato( "fac", "#frm_mfacobs", "obs" );
        }
    });
	/* --------------------------------------------------------------------------- */
	/* Validaciones: orden de compra */
    $('#frm_mencabezado_oc').bootstrapValidator({	// Encabezado
        fields: {
        },
		onSuccess: function( e, data ) {
        	e.preventDefault();
        	reg_formato( "odc", "#frm_mencabezado_oc", "enc" );
        }
    });
	
	$('#frm_mocent').bootstrapValidator({			// Texto entrada
        fields: {
            entrada: { validators: { notEmpty: { message: 'Debe indicar texto de entrada' } } }
        },
        onSuccess: function(e, data) {
			e.preventDefault();
			reg_formato( "odc", "#frm_mocent", "ent" );
        }
    });
	
	$('#frm_mocobs').bootstrapValidator({			// Observaciones
        fields: {
            obs1: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
			e.preventDefault();
			reg_formato( "odc", "#frm_mocobs", "obs" );
        }
    });
    /* --------------------------------------------------------------------------- */
    /* Validaciones: nota de crédito */
    $('#frm_mencabeznc').bootstrapValidator({    // Encabezado
        fields: {
            l1: { validators: { notEmpty: { message: 'Debe indicar encabezado' } } }
        },
        onSuccess: function( e, data ) {
            e.preventDefault();
            reg_formato( "ndc", "#frm_mencabeznc", "enc" );
        }
    });

    $('#frm_mnotcent').bootstrapValidator({      // Texto entrada
        fields: {
            
        },
        onSuccess: function(e, data) {
            e.preventDefault();
            reg_formato( "ndc", "#frm_mnotcent", "ent" );
        }
    });

    $('#frm_mnotcobs').bootstrapValidator({       // Observaciones
        fields: {
            tobs: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
            e.preventDefault();
            reg_formato( "ndc", "#frm_mnotcobs", "obs" );
        }
    });
    /* --------------------------------------------------------------------------- */
    /* Validaciones: nota de débito */
    $('#frm_mencabeznd').bootstrapValidator({    // Encabezado
        fields: {
            l1: { validators: { notEmpty: { message: 'Debe indicar encabezado' } } }
        },
        onSuccess: function( e, data ) {
            e.preventDefault();
            reg_formato( "ndd", "#frm_mencabeznd", "enc" );
        }
    });

    $('#frm_mnotdent').bootstrapValidator({      // Texto entrada
        fields: {
            entrada: { validators: { notEmpty: { message: 'Debe indicar texto de entrada' } } }
        },
        onSuccess: function(e, data) {
            e.preventDefault();
            reg_formato( "ndd", "#frm_mnotdent", "ent" );
        }
    });

    $('#frm_mnotdobs').bootstrapValidator({       // Observaciones
        sfields: {
            tobs: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
            e.preventDefault();
            reg_formato( "ndd", "#frm_mnotdobs", "obs" );
        }
    });
    /* --------------------------------------------------------------------------- */
    /* Validaciones: nota de entrega */
    $('#frm_mencabezne').bootstrapValidator({    // Encabezado
        fields: {
            l1: { validators: { notEmpty: { message: 'Debe indicar encabezado' } } }
        },
        onSuccess: function( e, data ) {
            e.preventDefault();
            reg_formato( "nde", "#frm_mencabezne", "enc" );
        }
    });

    $('#frm_mnoteent').bootstrapValidator({      // Texto entrada
        fields: {
            
        },
        onSuccess: function(e, data) {
            e.preventDefault();
            reg_formato( "nde", "#frm_mnoteent", "ent" );
        }
    });

    $('#frm_mnoteobs').bootstrapValidator({       // Observaciones
        fields: {
            tobs: { validators: { notEmpty: { message: 'Debe indicar texto' } } }
        },
        onSuccess: function(e, data) {
            e.preventDefault();
            reg_formato( "nde", "#frm_mnoteobs", "obs" );
        }
    });
	/* --------------------------------------------------------------------------- */
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue'
    });
	/* --------------------------------------------------------------------------- */
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
        $("#" + target).val(""); $("#v" + target).val( $(this).val() );
        $("#" + target).attr("readonly", "true");
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
	/* --------------------------------------------------------------------------- */
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
        $("#" + target).val(""); $("#v" + target).val( $(this).val() );
        $("#" + target).attr("readonly", "true");
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

    
    /* Configuración de observaciones formato notas */
    $('.blocampon').click( function(){
        var target = $(this).attr("data-c");
        $("#" + target).val(""); $("#v" + target).val(""); 
        $("#" + target).attr("readonly", "true");
    });
});
/* --------------------------------------------------------- */

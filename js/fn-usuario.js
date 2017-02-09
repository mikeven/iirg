// JavaScript Document
/*
* setup.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function log_in(){
	var error_m = "<div class='alert alert-warning' role='alert'>Verifica usuario y contraseña</div>";
	var form = $('#loginform');
	$.ajax({
        type:"POST",
        url:"bd/data-usuario.php",
        data:form.serialize(),
        success: function( response ){
			if( response == 1 ){
				window.location = "main.php";
			}
			else {
				$("#response").html( error_m );
			}
        }
    });
}
/* --------------------------------------------------------- */
function registroU(){
	var form = $('#regform');
	$.ajax({
        type:"POST",
        url:"bd/data-usuario.php",
        data:form.serialize(),
        success: function( response ){
			//$("#rreg").html(response);
			res = jQuery.parseJSON(response);
			if( res.exito == '1' ){
				$("#txexi").html(res.mje);
				$("#mje_exito").show("slow");
				$("#mje_error").hide(100);
			}
			if( res.exito == '0' ){
				$("#mje_error").show(100);
				$("#txerr").html(res.mje);
			}
        }
    });
}
/* --------------------------------------------------------- */
function initValid(){
  
	$('#frm_mcuenta').bootstrapValidator({
		message: 'Revise el contenido del campo',
		feedbackIcons: {
		  valid: 'glyphicon glyphicon-ok',
		  invalid: 'glyphicon glyphicon-remove',
		  validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
		  email: {
		      validators: { notEmpty: { message: 'Debe indicar un email' }}
		  },
		  nombre: {
		      validators: { notEmpty: { message: 'Debe indicar nombre' } }
		  },
		  rif: {
		      validators: { notEmpty: { message: 'Debe indicar RIF' } }
		  }
		},
		onSuccess: function(e, data) {
			e.preventDefault();
			modificarDatosUsuario( "#frm_mcuenta" );
		}
	});

	$('#frm_musuario').bootstrapValidator({
		message: 'Revise el contenido del campo',
		feedbackIcons: {
		    valid: 'glyphicon glyphicon-ok',
		    invalid: 'glyphicon glyphicon-remove',
		    validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
		    usuario: {
		        validators: { notEmpty: { message: 'Debe indicar nombre de usuario' } }
		    }
		},
		onSuccess: function(e, data) {
		  e.preventDefault();
		  modificarDatosUsuario( "#frm_musuario" );
		}
	});

	$('#frm_mpassw').bootstrapValidator({
		message: 'Revise el contenido del campo',
		feedbackIcons: {
		    valid: 'glyphicon glyphicon-ok',
		    invalid: 'glyphicon glyphicon-remove',
		    validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
		    password1: {
		        validators: { notEmpty: { message: 'Debe indicar constraseña' } }
		    },
		    password2:{
		        validators: { 
		          identical: {
		            field: 'password1',
		            message: 'Las contraseñas deben coincidir'
		          }
		        }
		    }
		},
		onSuccess: function(e, data) {
			e.preventDefault();
			$(".alert").hide();
			modificarDatosUsuario( "#frm_mpassw" );//modificarDatosUsuario( $(this) );
		}
	});

}
/* --------------------------------------------------------- */
function modificarDatosUsuario( param ){
	
	$.ajax({
        type:"POST",
        url:"bd/data-usuario.php",
        data: $(param).serialize(),
        success: function( response ){
			res = jQuery.parseJSON(response);
			//$("#waitconfirm").html(response);
			if( res.exito == '1' ){
				$("#txexi").html(res.mje);
				$("#mje_exito").show("slow");
				$("#mje_error").hide(100);
			}
			if( res.exito == '0' ){
				$("#mje_error").show(100);
				$("#txerr").html(res.mje);
			}
        }
    });
}
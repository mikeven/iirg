// JavaScript Document
/*
* R&G
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
			else 
				$("#response").html( error_m );
        }
    });
}

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
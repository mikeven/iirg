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
/* --------------------------------------------------------- */
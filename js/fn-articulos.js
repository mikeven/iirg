// JavaScript Document
/*
* fn-articulos.js
*
*/
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
function guardarArticulo(){
	var url_data = "bd/data-articulo.php";
	var unidad = $("#cuv").val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ nombre: unidad, reg_unidad:1 },
        success: function( response ){
			$("#tresp").html(response);
			window.location.href="categorias.php";
        }
    });
}
/* ----------------------------------------------------------------------------------- */
var valorExistente = function( clave, val, callback ){
	var url_data = "bd/data-articulo.php";
	var existe = 0;
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ campo: clave, valor: val, existe:1 },
        success: function( response ){
			if( response == 1 )	existe = 1;
			callback( existe );
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function checkArticulo(){
	var error = 0;
	var t = "nada";
	valorExistente( 
		"descripcion", $("#pdescripcion").val(), 
		function(data){ error = data; if( error == 1 ) t = "desc"; alert(1); }
	);

	valorExistente( 
		"codigo", $("#pcodigo").val(), 
		function(data){ error = data; if( error == 1 ) t = "cod"; alert(2); }
	);
	
	alert(3);
}
/* ----------------------------------------------------------------------------------- */
function reg_categoria( frm_categoria ){
	url_data = "bd/data-articulo.php";
	var categ = $("#cnombre").val();
	var desc = $("#cdescripcion").val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ nombre: categ, descripcion: desc, reg_categoria:1 },
        success: function( response ){
			$("#tresp").html(response);
			window.location.href="categorias.php";
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function reg_unidad(){
	url_data = "bd/data-articulo.php";
	var unidad = $("#cuv").val();
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ nombre: unidad, reg_unidad:1 },
        success: function( response ){
			$("#tresp").html(response);
			window.location.href="categorias.php";
        }
    });
}
/* ----------------------------------------------------------------------------------- */
function actualizarCategoria( idr, campo, valor ){
	url_data = "bd/data-articulo.php";
	if( valor != "" ){
		$.ajax({
	        type:"POST",
	        url:url_data,
	        data:{ act_categ: campo, valor_c: valor, idreg: idr },
	        success: function( response ){
	        	$( "#chkce" + idr ).hide();
				$( "#chk" + idr ).show( 300 ).delay( 2000 ).fadeOut( 1000 );
	        }
	    });
	}else{
		$( "#chkce" + idr ).show( 300 );	
	}
}
/* ----------------------------------------------------------------------------------- */
function actualizarUnidad( idr, valor ){
	url_data = "bd/data-articulo.php";
	if( valor != "" ){
		$.ajax({
	        type:"POST",
	        url:url_data,
	        data:{ act_und: 1, valor_u: valor, idreg: idr },
	        success: function( response ){
				$( "#chkue" + idr ).hide();
				$( "#chku" + idr ).show( 300 ).delay( 2000 ).fadeOut( 1000 );
				//window.location.href="nuevo-articulo.php";
	        }
	    });
	}else{
		$( "#chkue" + idr ).show( 300 );	
	}
}
/* ----------------------------------------------------------------------------------- */
function eliminarUnidad( idr ){
	url_data = "bd/data-articulo.php";
	$.ajax({
        type:"POST",
        url:url_data,
        data:{ elim_und: 1, idreg: idr },
        success: function( response ){
			//alert(response);
			$( "#ru" + idr ).hide('slow', function(){ 
				$( "#ru" + idr ).remove(); 
			});
        }
    });	
}

/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------- */

$( document ).ready(function() {
	
	$("#bt_reg_articulo").on( "click", function() {
		if( checkArticulo() == 0 )
			guardarArticulo();
		else
			$("#enl_vmsj").click();	
	});

	$(".lncat").blur(function(){
		valor = $(this).val(); idr = $(this).attr("id");
		actualizarCategoria( idr, "nombre", valor );
    })
	
	$(".ldcat").blur(function(){
		valor = $(this).val(); idr = $(this).attr("id");
		actualizarCategoria( idr, "descripcion", valor );
    })
    /*--------------------*/
    $(".lnund").on( "change", function(){
		valor = $(this).val(); idr = $( this ).attr("id");
		actualizarUnidad( idr, valor );
    })
    
	$(".euv").on( "click", function() {
		eliminarUnidad( $(this).attr( "data-idu" ) );
	});
});

/* ----------------------------------------------------------------------------------- */


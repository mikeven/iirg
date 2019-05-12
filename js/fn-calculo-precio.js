// JavaScript Document
/*
* fn-cotizacion.js
*
*/
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
function obtenerDB(){
 	var db = $("#pdebito_bancario").val();
 	var cmasiva = $("#r_cmasiva").text();
 	
 	return ( parseFloat(db) * parseFloat(cmasiva) ).toFixed(2);
}

function obtenerCostoMasIva(){
 	var iva = $("#val_piva").val();
 	var costo = $("#costo_base").val();
 	var db = $("#pdebito_bancario").val();

 	var cmasiva = parseFloat(costo) * parseFloat(iva) + parseFloat(costo);
 	
 	return ( parseFloat(cmasiva)  ).toFixed(2);
}

function obtenerPV() {
	var costo = $("#costo_base").val();			//Costo base
	var pvar = $("#pganancia_estimada").val();	//porcentaje ganancia estimada
	var r_db = $("#r_db").text();				//result débito bancario

	var pv = ( parseFloat(costo) + parseFloat(r_db) ) / parseFloat(pvar);
	
	return pv.toFixed(2);

}

function obtenerPGE_IVA_PV(){
 	var iva = $("#val_piva").val(); 		//Valor IVA
 	var pv = $("#r_pv").text(); 			//RES: precio de venta
 	var dif_r = $("#pdif_retencion").val();	//porcentaje diferencia retención	
 	
 	return ( parseFloat(pv) * parseFloat(iva) * parseFloat(dif_r) ).toFixed(2) ;
}

function obtenerTotalVenta(){
 	var piva = $("#r_piva").text();
 	var pv = $("#r_pv").text();				//RES: precio de venta
 	
 	return ( parseFloat(piva) + parseFloat(pv) ).toFixed(2) ;
}

function obtenerGananciaPrecio(){
 	var ptotalv = $("#r_tv").text();
 	var cmasiva = $("#r_cmasiva").text();
 	var r_db = $("#r_db").text();
 	var cmasiva_masdb = parseFloat(cmasiva) + parseFloat(r_db);

 	return ( parseFloat(ptotalv) - parseFloat( cmasiva_masdb ) ).toFixed(2);
}

function obtenerPGEGanancia(){
 	var ganancia = $("#r_ganancia").text();
 	var cmasiva = $("#r_cmasiva").text();		//RES: precio de venta
 	
 	return ( parseFloat(ganancia) / parseFloat(cmasiva) * 100 ).toFixed(2) ;
}

function obtenerComisionV(){
 	var ptotalv = $("#r_pv").text();
 	var r_db = $("#r_db").text();
 	var pgecomision = parseFloat ( $("#pcomision").val() ) / 100;

 	return ( (parseFloat(ptotalv) - parseFloat(r_db)) * pgecomision ).toFixed(2) ;
}
/* ================================================================================= */
$( document ).ready(function() {
	
	/* Cálculo de precio venta */
    $(".calc_pvp").on( "keyup blur", function(){
		$("#r_cmasiva").text( parseFloat (obtenerCostoMasIva()) );
		$("#r_db").text( parseFloat ( obtenerDB() ) );
		$("#r_pvar").text( $("#pganancia_estimada").val() );
		$("#r_pv").text( obtenerPV() );
		$("#r_piva").text( obtenerPGE_IVA_PV() );
		$("#r_tv").text( obtenerTotalVenta() );
		$("#r_ganancia").text( obtenerGananciaPrecio() );
		$("#r_pgegan").text( obtenerPGEGanancia() + '%' );

		$("#r_comision").text( obtenerComisionV() );
    });


    /* Asignación de precio unitario en ítem de cotización con previo cálculo */
    $("#r_pv").on( "click", function(){
    	$("#punit").val( $(this).text() );
    	var comis = isNaN( $("#r_comision").text() ) ? 0.00 : $("#r_comision").text();
    	$("#icomision").val( comis );
		$("#xmodalcalculopv").click();
		$("#punit").focus();
    });
});
/* ----------------------------------------------------------------------------------- */


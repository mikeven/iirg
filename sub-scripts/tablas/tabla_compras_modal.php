<?php 
	/*
	*/
	$compras = obtenerListaComprasNoPagadas( $dbh, $idu );
?>
<div class="modal fade" id="lista_compras" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de Compras</h4>
      </div>
      <div class="modal-body">
      	<table id="lcompras" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Fecha</th><th>Proveedor</th><th>N° Factura</th><th>Monto Base</th><th>IVA</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach( $compras as $c ){?>  
              <tr>
                  <td> <?php echo $c["femision"];?></td>
                  <td>
                    <div class="item_compra_lmodal" data-label="<?php echo $c["proveedor"]." "."( $c[femision] )";?>" 
                      data-tmonto="<?php echo number_format( $c["mtotal"], 2, ".", "" ); ?>"  
                      data-concepto="<?php echo "PAGO FACT N° ".$c["nfactura"]; ?>" 
                      data-beneficiario="<?php echo $c["proveedor"]; ?>"
                      data-mpagado="<?php echo number_format( $c["mpagado"], 2, ".", "" ); ?>"
                      data-idcompra="<?php echo $c["idcompra"]; ?>">
                       <a href="#!"><?php echo $c["proveedor"];?></a>
                    </div>
                  </td>
                  <td> <?php echo $c["nfactura"];?></td>
                  <td> <?php echo number_format( $c["mbase"], 2, ",", "." ); ?></td>
                  <td> <?php echo number_format( $c["iva"], 2, ",", "." ); ?></td>
              </tr>
              <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Fecha</th><th>Proveedor</th><th>N° Factura</th><th>Monto Base</th><th>IVA</th>
            </tr>
          </tfoot>
      </table>
      </div>
      <div class="modal-footer">
      	<button id="xmodalcompra" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
	$('#lcompras').DataTable({
	  "paging": true,
	  "iDisplayLength": 10,
	  "lengthChange": true,
	  "searching": true,
	  "ordering": true,
	  "info": true,
	  "autoWidth": false,
	  "language": {
		"lengthMenu": "Mostrar _MENU_ resultados por página",
		"zeroRecords": "No se encontraron resultados",
		"info": "Mostrando pág _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros",
		"infoFiltered": "(filtrados de _MAX_ regs)",
		"search": "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Último",
			"next":       "Próximo",
			"previous":   "Anterior"
		}
	}
	});
  });
</script>

<?php 
	/*
	*/
	$productos = obtenerListaProductos( $dbh );
?>
<div class="modal fade" id="lista_productos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de Productos</h4>
      </div>
      <div class="modal-body">
      	<table id="lproductos" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach( $productos as $p ){?>  
                <tr>
                    <td>
                    	<div class="item_producto_lmodal" data-label="<?php echo $p["Descripcion"];?>" 
                        data-idp="<?php echo $p["idProducto"];?>">
							<?php echo $p["Descripcion"];?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Descripción</th>
                </tr>
            </tfoot>
        </table>
      </div>
      <div class="modal-footer">
      	<button id="xmodalproducto" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
	$('#lproductos').DataTable({
	  "paging": true,
	  "iDisplayLength": 10,
	  "lengthChange": true,
	  "searching": true,
	  "ordering": true,
	  "info": true,
	  "autoWidth": false,
	  "language": {
		"lengthMenu": "Mostrar _MENU_ regs por página",
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
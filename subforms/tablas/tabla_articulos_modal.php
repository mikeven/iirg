<?php 
	/*
	*/
	$articulos = obtenerListaArticulos( $dbh );
?>
<div class="modal fade" id="lista_articulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de Artículos</h4>
      </div>
      <div class="modal-body">
      	<table id="larticulos" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach( $articulos as $a ){?>  
                <tr>
                    <td>
                    	<div class="item_articulo_lmodal" data-label="<?php echo $a["Descripcion"];?>" 
                        data-ida="<?php echo $a["idArticulo"];?>" data-und="<?php echo $a["Presentacion"];?>">
							<?php echo $a["Descripcion"];?>
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
      	<button id="xmodalarticulo" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
	$('#larticulos').DataTable({
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
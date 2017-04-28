<?php 
	/*
	*/
	$proveedores = obtenerListaProveedores( $dbh );
?>
<div class="modal fade" id="lista_proveedores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de Proveedores</h4>
      </div>
      <div class="modal-body">
      	<table id="lproveedores" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach( $proveedores as $p ){?>  
                <tr>
                    <td>
                    	<div class="item_proveedor_lmodal" data-label="<?php echo $p["Nombre"];?>" 
                        	data-idp="<?php echo $p["idProveedor"];?>" data-npc="<?php echo $p["pcontacto"];?>">
                            <a href="#!"><?php echo $p["Nombre"];?></a>
						          </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                </tr>
            </tfoot>
        </table>
      </div>
      <div class="modal-footer">
      	<button id="xmodalproveedor" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
	$('#lproveedores').DataTable({
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

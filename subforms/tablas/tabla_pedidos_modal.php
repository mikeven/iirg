<?php 
	/*
	*/
	$pedidos = obtenerListaPedidos( $dbh );
?>
<div class="modal fade" id="lista_pedidos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de Pedidos</h4>
      </div>
      <div class="modal-body">

            <table id="lpedidos" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Número</th><th>Fecha</th><th>Cliente</th><th>Total</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach( $pedidos as $p ){ ?>  
                    <tr>
                        <td><?php echo $p["numero"];?></td>
                        <td><?php echo $p["Fecha"];?></td>
                        <td><a href="nuevo-factura.php?idp=<?php echo $p["idp"]; ?>"><?php echo $p["Nombre"]; ?></a></td>
                        <td align="right"><?php echo number_format( $p["Total"], 2, ",", "" ); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Número</th><th>Fecha</th><th>Cliente</th><th>Total</th>
                    </tr>
                </tfoot>
            </table>

        </div>
      <div class="modal-footer">
        <button id="xmodalcotizacion" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
    $('#lpedidos').DataTable({
      "paging": true,
      "iDisplayLength": 10,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
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
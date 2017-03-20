<?php 
	/*
	*/
	$cotizaciones = obtenerListaCotizaciones( $dbh, $usuario["idUsuario"] );
  $destino = "nuevo-factura.php";
?>
<div class="modal fade" id="lista_cotizaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de Cotizaciones</h4>
      </div>
      <div class="modal-body">

            <table id="lcotizaciones" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Número</th><th>Fecha</th><th>Cliente</th><th>Total</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach( $cotizaciones as $c ){?>  
                    <tr>
                        <td><?php echo $c["numero"];?></td>
                        <td><?php echo $c["Fecha"];?></td>
                        <td><a href="<?php echo $destino; ?>?idc=<?php echo $c["idc"]; ?>">
                          <?php echo $c["Nombre"]; ?></a>
                        </td>
                        <td><?php echo number_format( $c["Total"], 2, ",", "." ); ?></td>
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
    $('#lcotizaciones').DataTable({
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
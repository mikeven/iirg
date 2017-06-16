<?php 
	/*
	*/

	$facturas = obtenerListaFacturas( $dbh, $usuario["idUsuario"], "" );
?>
<div class="modal fade" id="lista_facturas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de Facturas</h4>
      </div>
      <div class="modal-body">

            <table id="lfacturas" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Número</th><th>Fecha</th><th>Cliente</th><th>Estado</th><th>Total</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach( $facturas as $f ){ 
                      $df = $f["cliente"]." ($f[Fecha])"; 
                      $ie = iconoEstado( $f["estado"] );
                    ?>
                    <?php if($f["estado"] != "anulada" ) { ?>  
                    <tr>
                        <td><?php echo $f["numero"];?></td>
                        <td><?php echo $f["Fecha"];?></td>
                        <td>
                          <a href="#!" data-href="nuevo-nota.php?idf=<?php echo $f["id"]; ?>" class="enlnn"><?php echo $f["cliente"]; ?></a>
                        </td>
                        <td align="center">
                          <i class="fa fa-2x <?php echo $ie["icono"]." ".$ie["color"]; ?>"></i>
                        </td>
                        <td><?php echo number_format( $f["Total"], 2, ",", "." ); ?></td>
                    </tr>
                    <?php } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Número</th><th>Fecha</th><th>Cliente</th><th>Estado</th><th>Total</th>
                    </tr>
                </tfoot>
            </table>

        </div>
      <div class="modal-footer">
        <button id="xmodalfacturas" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
    $('#lfacturas').DataTable({
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
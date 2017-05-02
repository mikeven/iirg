<?php 
	/*
  *
  *
	*/
	if( isset( $_GET["p"] ) ) {
    $idp = $_GET["p"];
    $operaciones = obtenerOperacionesProveedor( $dbh, $idp );
  }
?>
<table id="lista_operaciones_proveedor" class="table table-bordered table-striped">
    <thead>
      <tr> <th>Documento</th><th>Fecha emisión</th><th>Monto</th><th align="center">Estado</th> </tr>
    </thead>
    <tbody>
        <?php 
          foreach( $operaciones as $o ){ 
            $ie = iconoEstado( $o["estado"] );
            if( $o["documento"] == "Solicitud de cotización" ) $td = "sctz";
            if( $o["documento"] == "Orden de compra" ) $td = "odc";
            $lnk = "documento.php?tipo_documento=$td&id=$o[id]";
        ?>  
        <tr>
            <td>
              <a href="<?php echo $lnk; ?>"> 
                <?php echo $o["documento"]. " Nro. ".$o["numero"];  ?>
              </a>
            </td>
            <td> <?php echo $o["femision"];   ?></td>
            <td align="right"> <?php echo number_format( $o["total"], 2, ",", "." ); ?></td>
            <td align="center">
              <i class="fa fa-2x <?php echo $ie["icono"]." ".$ie["color"]; ?>"></i>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr> <th>Documento</th><th>Fecha emisión</th><th>Monto</th><th align="center">Estado</th> </tr>
    </tfoot>
</table>
<script>
  $(function () {
    $('#lista_operaciones_proveedor').DataTable({
      "paging": true,
      "iDisplayLength": 10,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
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
<?php 
	/*
  *
  *
	*/
?>
<table id="ldocs_porvencer" class="table table-bordered table-striped tresumen">
    <thead>
      <tr><th>Fecha emisión</th><th>Documento</th><th>Monto</th><th>Validez</th></tr>
    </thead>
    <tbody>
        <?php 
          foreach( $porvencer["data"] as $o ){ 
            $ie = iconoEstado( $o["estado"] );
            $td = tipoDocEtiqueta( $o["documento"] );
            $lnk = "documento.php?tipo_documento=$td&id=$o[id]";
        ?>  
        <tr>
          <td align="center"><?php echo $o["femision"]; ?></td>
          <td><a href="<?php echo $lnk; ?>"> 
              <?php echo $o["documento"]. " Nro. ".$o["numero"];  ?></a>
          </td>
          <td align="left"> <?php echo number_format( $o["total"], 2, ",", "." ); ?></td>
          <td align="center"><?php echo $o["condicion"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<script>
  $(function () {
    $('#ldocs_porvencer').DataTable({
      "paging": false,
      "iDisplayLength": 10,
      "lengthChange": true,
      "searching": false,
      "ordering": false,
      "info": false,
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
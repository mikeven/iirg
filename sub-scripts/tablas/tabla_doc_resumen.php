<?php 
	/*
  *
  *
	*/
?>
<table id="lmovdia" class="table table-bordered table-striped tresumen">
    <thead>
      <tr> <th>Documento</th><th>Monto</th><th align="center">Estado</th> </tr>
    </thead>
    <tbody>
        <?php 
          foreach( $movdia["data"] as $o ){ 
            $ie = iconoEstado( $o["estado"] );
            $td = tipoDocEtiqueta( $o["documento"] );
            $lnk = "documento.php?tipo_documento=$td&id=$o[id]";
        ?>  
        <tr>
            <td><a href="<?php echo $lnk; ?>"> 
                <?php echo $o["documento"]. " Nro. ".$o["numero"];  ?></a>
            </td>
            <td align="right"> <?php echo number_format( $o["total"], 2, ",", "." ); ?></td>
            <td align="center">
              <i class="fa fa-2x <?php echo $ie["icono"]." ".$ie["color"]; ?>"></i>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<script>
  $(function () {
    $('#lmovdia').DataTable({
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
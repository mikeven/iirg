<?php 
	/*
	*/
	$cotizaciones = obtenerListaCotizaciones( $dbh );
?>
<table id="lista_ctz" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Número</th><th>Fecha</th><th>Cliente</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $cotizaciones as $c ){ ?>  
        <tr>
            <td> <?php echo $c["numero"];  ?></td>
            <td> <?php echo $c["Fecha"];  ?></td>
            <td> <a href="documento.php?tipo_documento=ctz&id=<?php echo $c["idc"]; ?>"><?php echo $c["Nombre"]; ?></a> </td>
            <td> <?php echo $c["Total"];  ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
          <th>Número</th><th>Fecha</th><th>Cliente</th><th>Total</th>
        </tr>
    </tfoot>
</table>
<script>
  $(function () {
    $('#lista_ctz').DataTable({
      "paging": true,
      "iDisplayLength": 10,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
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
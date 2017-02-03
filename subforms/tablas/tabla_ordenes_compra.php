<?php 
	/*
	*/
	$ordenes = obtenerListaOrdenesCompra( $dbh );
?>
<table id="lordenescompra" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Número</th><th>Fecha</th><th>Proveedor</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $ordenes as $o ){?>  
        <tr>
            <td> <?php echo $o["numero"];?></td>
            <td> <?php echo $o["fecha"];?></td>
            <td> <a href="documento.php?tipo_documento=odc&id=<?php echo $o["ido"]; ?>"><?php echo $o["Nombre"]; ?></a> </td>
            <td> <?php echo $o["Total"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Número</th><th>Fecha</th><th>Proveedor</th><th>Total</th>
        </tr>
    </tfoot>
</table>
<script>
  $(function () {
    $('#lordenescompra').DataTable({
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
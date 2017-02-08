<?php 
	/*
	*/
	$facturas = obtenerListaFacturas( $dbh, $usuario["idUsuario"] );
?>
<table id="lfacturas" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Fecha</th><th>Número</th><th>Cliente</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $facturas as $f ){?>  
        <tr>
            <td> <?php echo $f["Fecha"];?> </td>
            <td> <?php echo $f["numero"];?> </td>
            <td> <a href="documento.php?tipo_documento=fac&id=<?php echo $f["id"]; ?>"><?php echo $f["cliente"]; ?></a> </td>
            <td> <?php echo $f["Total"]; ?> </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
      <tr>
          <th>Fecha</th><th>Número</th><th>Cliente</th><th>Total</th>
      </tr>
    </tfoot>
</table>
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
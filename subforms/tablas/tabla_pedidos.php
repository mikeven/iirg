<?php 
	/*
	*/
	$pedidos = obtenerListaPedidos( $dbh );
?>
<table id="lpedidos" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Número</th><th>Fecha</th><th>Cliente</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $pedidos as $p ){?>  
        <tr>
            <td> <?php echo $p["numero"];?></td>
            <td> <?php echo $p["Fecha"];?></td>
            <td> <a href="documento.php?tipo_documento=ped&id=<?php echo $p["idp"]; ?>"><?php echo $p["Nombre"]; ?></a> </td>
            <td> <?php echo $p["Total"]; ?></td>
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
    $('#lpedidos').DataTable({
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
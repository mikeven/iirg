<?php 
	/*
	*/
	$compras = obtenerListaCompras( $dbh, $idu );
?>
<table id="lcompras" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Fecha</th><th>Proveedor</th><th>N° Retención</th>
        <th>N° Factura</th><th>Monto Base</th><th>IVA</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $compras as $c ){?>  
        <tr>
            <td> <?php echo $c["femision"];?></td>
            <td> <a href="ficha_compra.php?id=<?php echo $c["idcompra"]; ?>">
              <?php echo $c["proveedor"]; ?></a> 
            </td>
            <td> <?php echo $c["nretencion"];?></td>
            <td> <?php echo $c["nfactura"];?></td>
            <td> <?php echo number_format( $c["mbase"], 2, ",", "." ); ?></td>
            <td> <?php echo number_format( $c["iva"], 2, ",", "." ); ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <th>Fecha</th><th>Proveedor</th><th>N° Factura</th><th>Monto Base</th><th>IVA</th>
      </tr>
    </tfoot>
</table>
<script>
  $(function () {
    $('#lcompras').DataTable({
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
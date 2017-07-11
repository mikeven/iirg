<?php 
	/*
	*/
	$gastos = obtenerListaGastos( $dbh, "pago", $idu );
?>
<table id="lcompras" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Fecha pago</th><th>Concepto</th><th>Beneficiario</th>
        <th>Monto total</th><th>Monto Pagado</th><th>Operación</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $gastos as $g ){?>  
        <tr>
            <td> <?php echo $g["fpago"];?></td>
            <td> <a href="ficha_gasto.php?id=<?php echo $g["idGasto"]; ?>">
              <?php echo $g["concepto"]; ?></a> 
            </td>
            <td> <?php echo $g["beneficiario"]; ?></td>
            <td> <?php echo number_format( $g["monto"], 2, ",", "." ); ?></td>
            <td> <?php echo number_format( $g["monto_pagado"], 2, ",", "." ); ?></td>
            <td> <?php echo "(".$g["forma_pago"].") ".$g["banco"]." #".$g["noperacion"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <th>Fecha pago</th><th>Concepto</th><th>Beneficiario</th>
        <th>Monto total</th><th>Monto Pagado</th><th>Operación</th>
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
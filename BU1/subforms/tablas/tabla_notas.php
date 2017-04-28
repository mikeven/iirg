<?php 
	/*
	*/
	$notas = obtenerListaNotas( $dbh, $usuario["idUsuario"] );
  function ttNota($tipo){
    $t = array("nota_entrega" => "Nota de entrega", 
              "nota_credito" => "Nota de crédito", 
              "nota_debito" => "Nota de débito"
    );
    return $t[$tipo];
  }
?>
<table id="lnotas" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Fecha</th><th>Tipo</th><th>Número</th><th>Cliente</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $notas as $n ){?>  
        <tr>
            <td> <?php echo $n["Fecha"];?> </td>
            <td> <?php echo ttNota( $n["tipo"] ) ;?> </td>
            <td><?php echo $n["numero"];?> </td>
            <td> <a href="documento.php?tipo_documento=nota&tn=<?php echo $n["tipo"]; ?>&id=<?php echo $n["id"]; ?>">
                  <?php echo $n["cliente"]; ?>
                 </a> </td>
            <td> <?php echo number_format( $n["Total"], 2, ",", "." ); ?> </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Fecha</th><th>Tipo</th><th>Número</th><th>Cliente</th><th>Total</th>
        </tr>
    </tfoot>
</table>
<script>
  $(function () {
    $('#lnotas').DataTable({
      "paging": true,
      "iDisplayLength": 10,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
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
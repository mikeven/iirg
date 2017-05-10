<?php 
	/*
	*/
?>
<table id="lfacturas_mes" class="table table-bordered table-striped tresumen" align="center">
    <thead>
      <tr>
        <th>Fecha</th><th>N°</th><th>Cliente</th><th>Total</th><th>Estado</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $factmes["data"] as $f ){ $ie = iconoEstado( $f["estado"] ); ?>  
        <tr>
            <td> <?php echo $f["femision"];?> </td>
            <td> <?php echo $f["numero"];?> </td>
            <td> <a href="documento.php?tipo_documento=fac&id=<?php echo $f["id"]; ?>">
            <?php echo $f["cliente"]; ?></a> </td>
            <td> <?php echo number_format( $f["Total"], 2, ",", "." ); ?> </td>
            <td align="center">
              <i class="fa fa-2x <?php echo $ie["icono"]." ".$ie["color"]; ?>"></i>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    
</table>
<script>
  $(function () {
    $('#lfacturas_mes').DataTable({
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
<?php 
	/*
	*/
	$tipo = "";
	if( isset( $_GET["t"] ) ) $tipo = $_GET["t"];
	
	if( $tipo == "solicitud" )
		$cotizaciones = obtenerSolicitudesCotizaciones( $dbh, $usuario["idUsuario"] );
	else
		$cotizaciones = obtenerListaCotizaciones( $dbh, $usuario["idUsuario"], "" );
?>
<table id="lista_ctz" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Número</th>
        <th>Fecha</th>
        <?php if( $tipo != "solicitud" ) { ?> <th>Cliente</th> <?php } else { ?><th>Proveedor</th> <?php } ?> 
		<?php if( $tipo != "solicitud" ) { ?> <th>Total</th> <?php } ?>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
        <?php 
          foreach( $cotizaciones as $c ){ 
            if ( $tipo == "solicitud" ) $td = "sctz"; else $td = "ctz";
            $ie = iconoEstado( $c["estado"] );
        ?>  
        <tr>
            <td> <?php echo $c["numero"];  ?></td>
            <td> <?php echo $c["Fecha"];  ?></td>
            <td>
              <a href="documento.php?tipo_documento=<?php echo $td; ?>&id=<?php echo $c["idc"]; ?>"><?php echo $c["Nombre"]; ?></a>
            </td>
            <?php if( $tipo != "solicitud" ) { ?> 
              <td> 
                <?php echo number_format( $c["Total"], 2, ",", "." );  ?>
              </td>
            <?php } ?>
            <td align="center">
              <i class="fa fa-2x <?php echo $ie["icono"]." ".$ie["color"]; ?>"></i>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
        <th>Número</th>
        <th>Fecha</th>
        <?php if( $tipo != "solicitud" ) { ?> <th>Cliente</th> <?php } else { ?><th>Proveedor</th> <?php } ?> 
		<?php if( $tipo != "solicitud" ) { ?> <th>Total</th> <?php } ?>
        <th>Estado</th>
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
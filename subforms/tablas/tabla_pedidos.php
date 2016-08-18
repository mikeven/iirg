<?php 
	/*
	*/
	$cotizaciones = obtenerListaPedidos( $dbh );
?>
<table id="example2" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Fecha</th><th>Cliente</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $cotizaciones as $c ){?>  
        <tr>
            <td><?php echo $c["Fecha"];?></td>
            <td><?php echo $c["Nombre"]; ?></td>
            <td><?php echo $c["Total"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Nombre</th><th>Descripción</th><th>Total</th>
        </tr>
    </tfoot>
</table>
<?php 
	/*
	*/
	$facturas = obtenerListaFacturas( $dbh );
?>
<table id="example2" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Fecha</th><th>Cliente</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $facturas as $f ){?>  
        <tr>
            <td><?php echo $f["Fecha"];?></td>
            <td><?php echo $f["cliente"]; ?></td>
            <td><?php echo $f["Total"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Nombre</th><th>Descripción</th><th>Total</th>
        </tr>
    </tfoot>
</table>
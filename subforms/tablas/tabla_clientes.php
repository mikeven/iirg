<?php 
	/*
	*/
	$clientes = obtenerListaClientes( $dbh );
?>
<table id="example2" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>RIF</th>
        <th>NIT</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $clientes as $c ){?>  
        <tr>
            <td><?php echo $c["Nombre"];?></td>
            <td><?php echo $c["Rif"]; ?></td>
            <td><?php echo $c["Nit"];?></td>
            <td><?php echo $c["Email"];?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Nombre</th>
            <th>RIF</th>
            <th>NIT</th>
            <th>Email</th>
        </tr>
    </tfoot>
</table>
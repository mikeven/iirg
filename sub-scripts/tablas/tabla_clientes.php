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
            <td><a href="ficha_cliente.php?c=<?php echo $c["idCliente"]; ?>"><?php echo $c["nombre"];?></a></td>
            <td><?php echo $c["rif"]; ?></td>
            <td><?php echo $c["nit"];?></td>
            <td><?php echo $c["email"];?></td>
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
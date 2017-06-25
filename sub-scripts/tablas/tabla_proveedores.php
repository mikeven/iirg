<?php 
	/*
	*/
	$proveedores = obtenerListaProveedores( $dbh );
?>
<table id="tproveedores" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>RIF</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $proveedores as $p ){?>  
        <tr>
            <td><a href="ficha_proveedor.php?p=<?php echo $p["idProveedor"]; ?>"><?php echo $p["Nombre"];?></a></td>
            <td><?php echo $p["rif"]; ?></td>
            <td><?php echo $p["Email"];?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Nombre</th>
            <th>RIF</th>
            <th>Email</th>
        </tr>
    </tfoot>
</table>
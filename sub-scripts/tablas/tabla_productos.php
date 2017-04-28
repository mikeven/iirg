<?php 
	/*
	*/
	$productos = obtenerListaProductos( $dbh );
?>
<table id="example2" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Código</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $productos as $p ){?>  
        <tr>
            <td><?php echo $p["Codigo"];?></td>
            <td><?php echo $p["Descripcion"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Código</th>
        	<th>Descripción</th>
        </tr>
    </tfoot>
</table>
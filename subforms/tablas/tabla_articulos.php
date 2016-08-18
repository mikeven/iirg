<?php 
	/*
	*/
	$articulos = obtenerListaArticulos( $dbh );
?>
<table id="example2" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Código</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach( $articulos as $a ){?>  
        <tr>
            <td><?php echo $a["Codigo"];?></td>
            <td><div class="lpart"><a href="ficha_articulo.php?a=<?php echo $a["idArticulo"];?>"><?php echo $a["Descripcion"]; ?></div></td>
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
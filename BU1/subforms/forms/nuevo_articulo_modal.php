<?php 
  /*
  */
  $unidades = obtenerUnidadesVenta( $dbh );
  $categorias = obtenerCategoriasArticulos( $dbh );
?>
<div class="modal fade" id="nuevo_articulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:30%;">
    <div class="modal-content">
      
      <div class="modal-body">
        <?php include( "sub-scripts/forms/form-agregar-articulo.php" ); ?>
      </div>
      
      <div class="alert alert-danger alert-dismissible" id="resalerta" style="display:none;">
        <button type="button" class="close close-alt" aria-hidden="true" 
        data-target="resalerta">×</button>
        <h4></i> <span id="tresalerta"></span></h4>
        <div id="txmjealerta"></div>
      </div>

      <div class="modal-footer">
      	<button id="xmodalnuevo_articulo" type="button" class="btn btn-default" 
        data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>
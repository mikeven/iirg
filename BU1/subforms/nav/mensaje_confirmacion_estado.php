<div class="modal fade" id="ventana_estado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="titulo_emergente">
          <label id="taccionestado"></label> <?php echo $tdocumento." #".$encabezado["nro"]; ?>
        </h4>
      </div>
      <div id="mje_confirmacion" class="modal-body">Confirmar acción</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal">Cancelar</button>
        <button id="accion_estado" type="button" class="btn btn-primary" 
        data-file-doc="<?php echo $filedoc;?>" data-estado="">Confirmar</button>
      </div>
    </div>
  </div>
</div>
      
    
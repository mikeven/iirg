<div class="modal fade" id="ventana_anular" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="titulo_emergente">
          Anular <?php echo $tdocumento." #".$encabezado["nro"]; ?>
        </h4>
      </div>
      <div id="mje_confirmacion" class="modal-body">Confirmar anulación</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal">Cancelar</button>
        <button type="button" class="btn btn-primary btn_anulacion" data-file-doc="<?php echo $filedoc;?>">Anular</button>
      </div>
    </div>
  </div>
</div>
      
    
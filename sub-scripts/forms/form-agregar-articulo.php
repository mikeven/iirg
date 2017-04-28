<div id="formulario_narticulo" class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">AGREGAR NUEVO ARTÍCULO</h3>
    <div class="icon-color"><i class="fa fa-barcode fa-2x"></i></div>
  </div><!-- /.box-header -->
  <form role="form" id="frm_narticulo" name="form_agregar_articulo">
     
      <div class="box-body">
        <div class="form-group">
          <!--<label for="exampleInputEmail1">Email address</label>-->
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-bookmark-o"></i></div>
              <input type="text" class="form-control vexistente" id="pdescripcion" 
              placeholder="Descripción" name="descripcion" data-err="#err_desc">
              <input type="hidden" class="form-control" id="err_desc" value="0">
            </div>
        </div><!-- /.form group -->
        
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                <input id="pcodigo" type="text" class="form-control vexistente" placeholder="Código" 
                name="codigo" data-err="#err_cod">
                <input type="hidden" class="form-control" id="err_cod" value="0">
            </div><!-- /.input group -->
        </div><!-- /.form group -->
        
        <div class="form-group">
          <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-cube"></i></div>
                <select name="presentacion" id="ppresentacion" class="form-control">
                    <option value="0" disabled selected>Presentación</option>
                    <?php foreach( $unidades as $u ){ ?>
                    <option value="<?php echo $u["nombre"] ?>"><?php echo $u["nombre"] ?></option>
                    <?php } ?>
                </select>
            </div><!-- /.input group -->
        </div><!-- /.form group -->
        
        <div class="form-group">
          <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-sitemap"></i></div>
                <select name="categoria" id="pcategoria" class="form-control">
                    <option value="0" disabled selected>Categoria</option>
                    <?php foreach( $categorias as $c ){ ?>
                    <option value="<?php echo $c["idCategoria"]; ?>"><?php echo $c["nombre"]; ?></option>
                    <?php } ?>
                </select>
            </div><!-- /.input group -->
        </div><!-- /.form group -->
          
      </div><!-- /.box-body -->

    <div class="box-footer" align="center">
      <button type="button" class="btn btn-primary original" id="bt_reg_articulo">Guardar</button>
      <button type="button" class="btn btn-primary" id="bt_reg_art_modal" style="display:none;">Guardar</button>
    </div>
  </form>
</div><!-- /.box -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">AGREGAR NUEVO ARTÍCULO</h3>
    <div class="icon-color"><i class="fa fa-barcode fa-2x"></i></div>
  </div><!-- /.box-header -->
  <form role="form" id="frm_narticulo" name="form_agregar_articulo">
     <input name="reg_articulo" type="hidden" value="1">
      <div class="box-body">
        <div class="form-group">
          <!--<label for="exampleInputEmail1">Email address</label>-->
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-bookmark-o"></i></div>
              <input type="text" class="form-control" id="pdescripcion" placeholder="Descripción" name="descripcion">
            </div>
        </div><!-- /.form group -->
        
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                <input id="pcodigo" type="text" class="form-control" placeholder="Código" data-mask name="codigo">
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
      <button type="button" class="btn btn-primary" id="bt_reg_articulo">Guardar</button>
    </div>
  </form>
</div><!-- /.box -->
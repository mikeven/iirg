<div class="panel box box-default"> <!-- Panel sección -->
  
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#formato_nota_c">
        <i class="fa fa-sticky-note"></i> Formato de nota de crédito
      </a>
    </h4>
  </div>
  
  <div id="formato_nota_c" class="panel-collapse collapse"> <!-- #formato_cotizaciones-->
    
    <div class="box-body">
      
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $usuario["idUsuario"];?>">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_nc1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_nc2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_nc3" data-toggle="tab">Modificar Texto introductorio</a></li>
          <li><a href="#tab_nc4" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_nc1">
          
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <hr>
            <div class="tcontab"><b>Texto introductorio</b></div>
            <div><?php echo $frt_nc["entrada"]; ?></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $ncobs[0]; ?></b></div>
            <div><?php echo $ncobs[1]; ?></div>
            <div><?php echo $ncobs[2]; ?></div>
            <div><?php echo $ncobs[3]; ?></div>
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_nc2">
            
            <form role="form" id="frm_mencabeznc" method="post">
              <input name="mod_enc_notc" type="hidden" value="1">
              <div class="box-body">

              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_encnotac">Guardar</button>
              </div>
          </form>   
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_nc3">
          
            <form role="form" id="frm_mnotcent" name="form_ent_notc" method="post">
              <input name="mod_fnotc_ent" type="hidden" value="1">
              <div class="box-body">
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <textarea class="form-control" name="entrada" rows="3" cols="50" id="tentrada"><?php echo $frt_nc["entrada"];?></textarea>
                    <span class="input-group-addon">Entrada</span>
                  </div>
                </div><!-- /.form group -->
              </div><!-- /.box-body -->
              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_entnotc">Guardar</button>
              </div>
            </form>
          
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="tab_nc4">
          
            <form role="form" id="frm_mnotcobs" name="form_mobs_notc" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_fnot_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" value="<?php echo $frt_nc["titulo_obs"]?>">
                    <span class="input-group-addon">Título sección observaciones</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tonc1">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tonc1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs1" id="tonc1" 
                    value="<?php echo $frt_nc["obs1"]; ?>" <?php echo $frt_nc["obs1"]; ?>>
                    <input type="hidden" name="vobs1" id="vtonc1" value="<?php echo $frt_nc["obs1"];?>">
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tonc2">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tonc2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs2" id="tonc2" 
                    value="<?php echo $frt_nc["obs2"];?>" <?php echo $frt_nc["obs2"]; ?>>
                    <input type="hidden" name="vobs2" id="vtonc2" value="<?php echo $frt_nc["obs2"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tonc3">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tonc3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs3" id="tonc3" 
                    value="<?php echo $frt_nc["obs3"];?>" <?php echo $frt_nc["obs3"]; ?>>
                    <input type="hidden" name="vobs3" id="vtonc3" value="<?php echo $frt_nc["obs3"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_notcobs">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
      
      </div><!-- /. nav-tabs-custom -->
    
    </div><!-- /. box-body -->
  
  </div> <!-- /. #formato_cotizaciones-->

</div> <!-- /. Panel sección -->
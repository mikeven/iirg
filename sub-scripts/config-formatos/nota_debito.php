<div class="panel box box-default"> <!-- Panel sección -->
  
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#formato_nota_d">
        <i class="fa fa-sticky-note"></i> Formato de nota de débito
      </a>
    </h4>
  </div>
  
  <div id="formato_nota_d" class="panel-collapse collapse"> <!-- #formato_cotizaciones-->
    
    <div class="box-body">
      
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $usuario["idUsuario"];?>">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_nd1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_nd2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_nd3" data-toggle="tab">Modificar Texto de Entrada</a></li>
          <li><a href="#tab_nd4" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_nd1">
          
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <hr>
            <div class="tcontab"><b>Texto introductorio</b></div>
            <div><?php echo $frt_nd["entrada"]; ?></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $ndobs[0]; ?></b></div>
            <div><?php echo $ndobs[1]; ?></div>
            <div><?php echo $ndobs[2]; ?></div>
            <div><?php echo $ndobs[3]; ?></div>
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_nd2">
            
            <form role="form" id="frm_mencabeznd" method="post">
              <input name="mod_enc_notd" type="hidden" value="1">
              <div class="box-body">
              
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_encnotad">Guardar</button>
              </div>
          </form>   
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_nd3">
          
            <form role="form" id="frm_mnotdent" name="form_ent_notd" method="post">
              <input name="mod_fnotd_ent" type="hidden" value="1">
              <div class="box-body">
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <textarea class="form-control" name="entrada" rows="3" cols="50" id="tentrada"><?php echo $frt_nd["entrada"];?></textarea>
                    <span class="input-group-addon">Entrada</span>
                  </div>
                </div><!-- /.form group -->
              </div><!-- /.box-body -->
              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_entnotd">Guardar</button>
              </div>
            </form>
          
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="tab_nd4">
          
            <form role="form" id="frm_mnotdobs" name="form_mobs_notd" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_fnot_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" value="<?php echo $frt_nd["titulo_obs"]?>">
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
                        <li><a href="#!" class="libresc" data-c="tond1">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tond1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs1" id="tond1" 
                    value="<?php echo $frt_nd["obs1"]; ?>" <?php echo $frt_nd["obs1"]; ?>>
                    <input type="hidden" name="vobs1" id="vtond1" value="<?php echo $frt_nd["obs1"];?>">
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tond2">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tond2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs2" id="tond2" 
                    value="<?php echo $frt_nd["obs2"];?>" <?php echo $frt_nd["obs2"]; ?>>
                    <input type="hidden" name="vobs2" id="vtond2" value="<?php echo $frt_nd["obs2"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tond3">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tond3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs3" id="tond3" 
                    value="<?php echo $frt_nd["obs3"];?>" <?php echo $frt_nd["obs3"]; ?>>
                    <input type="hidden" name="vobs3" id="vtond3" value="<?php echo $frt_nd["obs3"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_notdobs">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
      
      </div><!-- /. nav-tabs-custom -->
    
    </div><!-- /. box-body -->
  
  </div> <!-- /. #formato_cotizaciones-->

</div> <!-- /. Panel sección -->
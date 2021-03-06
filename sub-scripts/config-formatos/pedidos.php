<div class="panel box box-default">
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#formato_pedidos">
        <i class="fa fa-clipboard"></i> Formato de pedidos
      </a>
    </h4>
  </div>
  <div id="formato_pedidos" class="panel-collapse collapse"> <!-- formato_facturas -->
    
    <div class="box-body">
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_p1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_p2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_p3" data-toggle="tab">Modificar texto de entrada</a></li>
          <li><a href="#tab_p4" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_p1">
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div><?php echo $frt_p["enc1"]; ?></div>
            <div><?php echo $frt_p["enc2"]; ?></div>
            <div><?php echo $frt_p["enc3"]; ?></div>
            <div><?php echo $frt_p["enc4"]; ?></div>
            <div><?php echo $frt_p["enc5"]; ?></div>
            <div><?php echo $frt_p["enc6"]; ?></div>
            <hr>
            <div class="tcontab"><b>Texto introductorio</b></div>
            <div><?php echo $frt_p["entrada"]; ?></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $pobs[0]; ?></b></div>
            <div><?php echo $pobs[1]; ?></div>
            <div><?php echo $pobs[2]; ?></div>
            <div><?php echo $pobs[3]; ?></div>
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_p2">
            
            <form role="form" id="frm_mencabezado_p" name="frm_mencab_p" method="post">
              <input name="mod_enc_p" type="hidden" value="1">
              <div class="box-body">
                <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $usuario["idUsuario"];?>">
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="l1" value="<?php echo $datau[0]; ?>">
                    <span class="input-group-addon">L1</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="l2" value="<?php echo $datau[1]; ?>">
                    <span class="input-group-addon">L2</span>
                  </div>                                        
                </div><!-- /.form group -->

                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="l3" value="<?php echo $datau[2]; ?>">
                    <span class="input-group-addon">L3</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="l4" value="<?php echo $datau[3]; ?>">
                    <span class="input-group-addon">L4</span>
                  </div>                                        
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="l5" value="<?php echo $datau[4]; ?>">
                    <span class="input-group-addon">L5</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="l6" value="<?php echo $datau[5]; ?>">
                    <span class="input-group-addon">L6</span>
                  </div>                                        
                </div><!-- /.form group -->
                <div id="cres"></div> 
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_ep">Guardar</button>
              </div>
          </form>   
          </div><!-- /.tab-pane -->

          
          <div class="tab-pane" id="tab_p3">
          
            <form role="form" id="frm_mpent" name="form_ent_p" method="post">
              
              <input name="mod_fp_ent" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <textarea class="form-control" name="entrada" rows="3" cols="50" id="tentrada"><?php echo $frt_p["entrada"];?></textarea>
                    <span class="input-group-addon">Entrada</span>
                  </div>
                </div><!-- /.form group -->

              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_entp">Guardar</button>
              </div>
          </form>
          </div><!-- /.tab-pane -->

          
          <div class="tab-pane" id="tab_p4">

            <form role="form" id="frm_mpobs" name="form_mobs_p" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_p_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" value="<?php echo $frt_p["titulo_obs"]?>">
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
                        <li><a href="#" class="libresf" data-f="to_p1">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampof" data-f="to_p1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs" name="obs1" id="to_p1" value="<?php echo $frt_p["obs1"]; ?>" <?php echo $dof[1]["p"]; ?>>
                    <input type="hidden" name="vobs1" id="vto_p1" value="<?php echo $frt_p["obs1"];?>">
                  </div>
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#" class="libresf" data-f="to_p2">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampof" data-f="to_p2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs" name="obs2" id="to_p2" 
                    value="<?php echo $frt_p["obs2"];?>" <?php echo $frt_p["obs2"]; ?>>
                    <input type="hidden" name="vobs2" id="vto_p2" value="<?php echo $frt_p["obs2"]; ?>">
                  </div>                                        
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#" class="libresf" data-f="to_p3">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampof" data-f="to_p3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs" name="obs3" id="to_p3" 
                    value="<?php echo $frt_p["obs3"];?>" <?php echo $frt_p["obs3"]; ?>>
                    <input type="hidden" name="vobs3" id="vto_p3" value="<?php echo $frt_p["obs3"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_pobs">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
      
      </div><!-- /.nav-tabs-custom -->
    
    </div> <!--/.box-body-->
  
  </div><!-- /.formato_pedidos-->
</div>
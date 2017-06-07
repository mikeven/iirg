<div class="panel box box-default"> <!-- Panel sección -->
  
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#formato_oc">
        <i class="fa fa-file-text-o"></i> Formato de orden de compra
      </a>
    </h4>
  </div>
  
  <div id="formato_oc" class="panel-collapse collapse"> <!-- formato_facturas -->
    
    <div class="box-body">
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_oc1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_oc2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_oc3" data-toggle="tab">Modificar texto de entrada</a></li>
          <li><a href="#tab_oc4" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_oc1">
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div><?php echo $frt_oc["enc1"]; ?></div>
            <div><?php echo $frt_oc["enc2"]; ?></div>
            <div><?php echo $frt_oc["enc3"]; ?></div>
            <div><?php echo $frt_oc["enc4"]; ?></div>
            <div><?php echo $frt_oc["enc5"]; ?></div>
            <div><?php echo $frt_oc["enc6"]; ?></div>
            <hr>
            <div class="tcontab"><b>Texto introductorio</b></div>
            <div><?php echo $frt_oc["entrada"]; ?></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $ocobs[0]; ?></b></div>
            <div><?php echo $ocobs[1]; ?></div>
            <div><?php echo $ocobs[2]; ?></div>
            <div><?php echo $ocobs[3]; ?></div>
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_oc2">
            
            <form role="form" id="frm_mencabezado_oc" name="frm_mencab_oc" method="post">
              <input name="mod_enc_oc" type="hidden" value="1">
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
                <button type="submit" class="btn btn-primary" id="bt_mod_eoc">Guardar</button>
              </div>
          </form>   
          
          </div><!-- /.tab-pane -->

          
          <div class="tab-pane" id="tab_oc3">
          
            <form role="form" id="frm_mocent" name="form_ent_oc" method="post">
              
              <input name="mod_foc_ent" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <textarea class="form-control" name="entrada" rows="3" cols="50" id="tentrada"><?php echo $frt_oc["entrada"];?></textarea>
                    <span class="input-group-addon">Entrada</span>
                  </div>
                </div><!-- /.form group -->

              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_entoc">Guardar</button>
              </div>
          </form>
          </div><!-- /.tab-pane -->

          
          <div class="tab-pane" id="tab_oc4">

            <form role="form" id="frm_mocobs" name="form_mobs_oc" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_oc_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" value="<?php echo $frt_oc["titulo_obs"]?>">
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
                        <li><a href="#" class="libresf" data-f="to_oc1">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampof" data-f="to_oc1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs1" id="to_oc1" 
                    value="<?php echo $frt_oc["obs1"]; ?>" <?php echo $dof[1]["p"]; ?>>
                    <input type="hidden" name="vobs1" id="vto_oc1" value="<?php echo $frt_oc["obs1"];?>">
                  </div>
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#" class="libresf" data-f="to_oc2">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampof" data-f="to_oc2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs2" id="to_oc2" 
                    value="<?php echo $frt_oc["obs2"];?>" <?php echo $frt_oc["obs2"]; ?>>
                    <input type="hidden" name="vobs2" id="vto_oc2" value="<?php echo $frt_oc["obs2"]; ?>">
                  </div>                                        
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" 
                      data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#" class="libresf" data-f="to_oc3">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampof" data-f="to_oc3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs3" id="to_oc3" 
                    value="<?php echo $frt_oc["obs3"];?>" <?php echo $frt_oc["obs3"]; ?> >
                    <input type="hidden" name="vobs3" id="vto_oc3" value="<?php echo $frt_oc["obs3"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_facobs">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
      
      </div><!-- /.nav-tabs-custom -->
    
    </div> <!--/.box-body-->
  
  </div><!-- /.formato_oc-->

</div> <!-- /.Panel sección -->
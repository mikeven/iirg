<div class="panel box box-default"> <!-- Panel sección -->
  
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#formato_nota_e">
        <i class="fa fa-sticky-note"></i> Formato de nota de entrega
      </a>
    </h4>
  </div>
  
  <div id="formato_nota_e" class="panel-collapse collapse"> <!-- #formato_cotizaciones-->
    
    <div class="box-body">
      
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $usuario["idUsuario"];?>">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_ne1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_ne2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_ne3" data-toggle="tab">Modificar Texto de Entrada</a></li>
          <li><a href="#tab_ne4" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_ne1">
          
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div><?php echo $frt_ne["enc1"]; ?></div>
            <div><?php echo $frt_ne["enc2"]; ?></div>
            <div><?php echo $frt_ne["enc3"]; ?></div>
            <div><?php echo $frt_ne["enc4"]; ?></div>
            <div><?php echo $frt_ne["enc5"]; ?></div>
            <div><?php echo $frt_ne["enc6"]; ?></div>
            <hr>
            <div class="tcontab"><b>Texto introductorio</b></div>
            <div><?php echo $frt_ne["entrada"]; ?></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $neobs[0]; ?></b></div>
            <div><?php echo $neobs[1]; ?></div>
            <div><?php echo $neobs[2]; ?></div>
            <div><?php echo $neobs[3]; ?></div>
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_ne2">
            
            <form role="form" id="frm_mencabezne" method="post">
              <input name="mod_enc_note" type="hidden" value="1">
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
                <div id="cres_ne"></div> 
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_encnotae">Guardar</button>
              </div>
          </form>   
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_ne3">
          
            <form role="form" id="frm_mnoteent" name="form_ent_note" method="post">
              <input name="mod_fnote_ent" type="hidden" value="1">
              <div class="box-body">
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <textarea class="form-control" name="entrada" rows="3" cols="50" id="tentrada"><?php echo $frt_ne["entrada"];?></textarea>
                    <span class="input-group-addon">Entrada</span>
                  </div>
                </div><!-- /.form group -->
              </div><!-- /.box-body -->
              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_entnote">Guardar</button>
              </div>
            </form>
          
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="tab_ne4">
          
            <form role="form" id="frm_mnoteobs" name="form_mobs_note" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_fnote_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" value="<?php echo $frt_ne["titulo_obs"]?>">
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
                        <li><a href="#!" class="libresn" data-c="tone1">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tone1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs1" id="tone1" 
                    value="<?php echo $frt_ne["obs1"]; ?>" <?php echo $frt_ne["obs1"]; ?>>
                    <input type="hidden" name="vobs1" id="vtone1" value="<?php echo $frt_ne["obs1"];?>">
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresn" data-c="tone2">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tone2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs2" id="tone2" 
                    value="<?php echo $frt_ne["obs2"];?>" <?php echo $frt_ne["obs2"]; ?>>
                    <input type="hidden" name="vobs2" id="vtone2" value="<?php echo $frt_ne["obs2"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresn" data-c="tone3">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampon" data-c="tone3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs dataobs" name="obs3" id="tone3" 
                    value="<?php echo $frt_ne["obs3"];?>" <?php echo $frt_ne["obs3"]; ?>>
                    <input type="hidden" name="vobs3" id="vtone3" value="<?php echo $frt_ne["obs3"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_noteobs">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
      
      </div><!-- /. nav-tabs-custom -->
    
    </div><!-- /. box-body -->
  
  </div> <!-- /. #formato_cotizaciones-->

</div> <!-- /. Panel sección -->
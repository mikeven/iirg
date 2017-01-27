<div class="panel box box-default"> <!-- Panel sección -->
  
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#formato_cotizaciones">
        <i class="fa fa-book"></i> Formato de Cotizaciones
      </a>
    </h4>
  </div>
  
  <div id="formato_cotizaciones" class="panel-collapse collapse"> <!-- #formato_cotizaciones-->
    
    <div class="box-body">
      
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $usuario["idUsuario"];?>">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_3" data-toggle="tab">Modificar Texto de Entrada</a></li>
          <li><a href="#tab_4" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_1">
          
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div><?php echo $frt_c["enc1"]; ?></div>
            <div><?php echo $frt_c["enc2"]; ?></div>
            <div><?php echo $frt_c["enc3"]; ?></div>
            <div><?php echo $frt_c["enc4"]; ?></div>
            <div><?php echo $frt_c["enc5"]; ?></div>
            <div><?php echo $frt_c["enc6"]; ?></div>
            <hr>
            <div class="tcontab"><b>Texto introductorio</b></div>
            <div><?php echo $frt_c["entrada"]; ?></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $cobs[0]; ?></b></div>
            <div><?php echo $cobs[1]; ?></div>
            <div><?php echo $cobs[2]; ?></div>
            <div><?php echo $cobs[3]; ?></div>
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_2">
            
            <form role="form" id="frm_mencabezc" method="post">
              <input name="mod_enc_ctz" type="hidden" value="1">
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
                <button type="submit" class="btn btn-primary" id="bt_mod_cuenta">Guardar</button>
              </div>
          </form>   
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_3">
          
            <form role="form" id="frm_mctzent" name="form_ent_ctz" method="post">
              
              <input name="mod_fctz_ent" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <textarea class="form-control" name="entrada" rows="3" cols="50" id="tentrada"><?php echo $frt_c["entrada"];?></textarea>
                    <span class="input-group-addon">Entrada</span>
                  </div>
                </div><!-- /.form group -->

              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_cuenta">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="tab_4">
          
            <form role="form" id="frm_mctzobs" name="form_mobs_ctz" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_fctz_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" value="<?php echo $frt_c["titulo_obs"]?>">
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
                        <li><a href="#" class="libresc" data-c="toc1">Texto</a></li>
                        <li><a href="#" class="solectura" data-c="toc1">Validez de cotización</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampo" data-c="toc1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs" name="obs1" id="toc1" 
                    data-v="<?php echo $doc[1]["dv"]; ?>" value="<?php echo $doc[1]["t"]; ?>" <?php echo $doc[1]["p"]; ?>>
                    <input type="hidden" name="vobs1" id="vtoc1" value="<?php echo $doc[1]["v"];?>">
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#" class="libresc" data-c="toc2">Texto</a></li>
                        <li><a href="#" class="solectura" data-c="toc2">Validez de cotización</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampo" data-c="toc2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs" name="obs2" id="toc2" 
                    data-v="<?php echo $doc[2]["dv"]; ?>" value="<?php echo $doc[2]["t"];?>" <?php echo $doc[2]["p"]; ?>>
                    <input type="hidden" name="vobs2" id="vtoc2" value="<?php echo $doc[2]["v"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#" class="libresc" data-c="toc3">Texto</a></li>
                        <li><a href="#" class="solectura" data-c="toc3">Validez de cotización</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="blocampo" data-c="toc3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csctzobs" name="obs3" id="toc3" 
                    data-v="<?php echo $doc[3]["dv"]; ?>" value="<?php echo $doc[3]["t"];?>" <?php echo $doc[3]["p"]; ?>>
                    <input type="hidden" name="vobs3" id="vtoc3" value="<?php echo $doc[3]["v"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_ctzobs">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
      
      </div><!-- /. nav-tabs-custom -->
    
    </div><!-- /. box-body -->
  
  </div> <!-- /. #formato_cotizaciones-->

</div> <!-- /. Panel sección -->
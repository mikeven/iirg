<div class="panel box box-default"> <!-- Panel sección -->
  
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" 
      href="#formato_facturas_proformas">
        <i class="fa fa-file-text-o"></i> Formato de facturas proformas
      </a>
    </h4>
  </div>
  
  <div id="formato_facturas_proformas" class="panel-collapse collapse"> 
    <!-- #formato_facturas_proformas -->
    
    <div class="box-body">
      
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $usuario["idUsuario"];?>">
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#tab_fp1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_fp2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_fp3" data-toggle="tab">Modificar Texto de Entrada</a></li>
          <li><a href="#tab_fp4" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_fp1">
          
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div><?php echo $frt_fp["enc1"]; ?></div>
            <div><?php echo $frt_fp["enc2"]; ?></div>
            <div><?php echo $frt_fp["enc3"]; ?></div>
            <div><?php echo $frt_fp["enc4"]; ?></div>
            <div><?php echo $frt_fp["enc5"]; ?></div>
            <div><?php echo $frt_fp["enc6"]; ?></div>
            <hr>
            <div class="tcontab"><b>Texto introductorio</b></div>
            <div><?php echo $frt_fp["entrada"]; ?></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $cobs[0]; ?></b></div>
            <div><?php echo $cobs[1]; ?></div>
            <div><?php echo $cobs[2]; ?></div>
            <div><?php echo $cobs[3]; ?></div>
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_fp2">
            
            <form role="form" id="frm_mencabezfp" method="post">
              <input name="mod_enc_facp" type="hidden" value="1">
              <div class="box-body">
                <input name="idUsuario" type="hidden" id="idUsuario" 
                value="<?php echo $usuario["idUsuario"];?>">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="l1" 
                    value="<?php echo $frt_fp['enc1']; ?>">
                    <span class="input-group-addon">L1</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="l2" 
                    value="<?php echo $frt_fp['enc2']; ?>">
                    <span class="input-group-addon">L2</span>
                  </div>                                        
                </div><!-- /.form group -->

                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="l3" 
                    value="<?php echo $frt_fp['enc3']; ?>">
                    <span class="input-group-addon">L3</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="l4" 
                    value="<?php echo $frt_fp['enc4']; ?>">
                    <span class="input-group-addon">L4</span>
                  </div>                                        
                </div><!-- /.form group -->
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="l5" 
                    value="<?php echo $frt_fp['enc5'] ?>">
                    <span class="input-group-addon">L5</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="l6" 
                    value="<?php echo $frt_fp['enc6']; ?>">
                    <span class="input-group-addon">L6</span>
                  </div>                                        
                </div><!-- /.form group -->
                <div id="cres"></div> 
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" 
                id="bt_mod_cuenta">Guardar</button>
              </div>
          </form>   
          
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_fp3">
          
            <form role="form" id="frm_mfacpent" name="form_ent_facp" method="post">
              
              <input name="mod_ffacp_ent" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <textarea class="form-control" name="entrada" rows="3" cols="50" 
                    id="tentrada"><?php echo $frt_fp["entrada"];?></textarea>
                    <span class="input-group-addon">Entrada</span>
                  </div>
                </div><!-- /.form group -->

              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mod_cuenta">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="tab_fp4">
          
            <form role="form" id="frm_mfacpobs" name="form_mobs_ctz" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_ffacp_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" 
                    value="<?php echo $frt_fp["titulo_obs"]?>">
                    <span class="input-group-addon">Título sección observaciones</span>
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tofp1">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampo" data-c="tofp1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs1" id="tofp1"  
                    data-v="<?php echo $dofp[1]["dv"]; ?>" value="<?php echo $dofp[1]["t"]; ?>" <?php echo $dofp[1]["p"]; ?>>
                    <input type="hidden" name="vobs1" id="vtofp1" value="<?php echo $dofp[1]["v"];?>">
                  </div>
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tofp2">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampo" data-c="tofp2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs2" id="tofp2" 
                    data-v="<?php echo $dofp[2]["dv"]; ?>" value="<?php echo $dofp[2]["t"];?>" <?php echo $dofp[2]["p"]; ?>>
                    <input type="hidden" name="vobs2" id="vtofp2" value="<?php echo $doc[2]["v"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" data-toggle="dropdown" 
                      aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresc" data-c="tofp3">Texto</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampo" data-c="tofp3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs3" id="tofp3" 
                    data-v="<?php echo $dofp[3]["dv"]; ?>" value="<?php echo $dofp[3]["t"];?>" <?php echo $dofp[3]["p"]; ?>>
                    <input type="hidden" name="vobs3" id="vtofp3" value="<?php echo $dofp[3]["v"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                
              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_facpobs">Guardar</button>
              </div>
          </form>
          
          </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
      
      </div><!-- /. nav-tabs-custom -->
    
    </div><!-- /. box-body -->
  
  </div> <!-- /. #formato_cotizaciones-->

</div> <!-- /. Panel sección -->
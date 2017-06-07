<div class="panel box box-default"> <!-- Panel sección -->
  
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#formato_facturas">
        <i class="fa fa-file-text-o"></i> Formato de facturas
      </a>
    </h4>
  </div>
  
  <div id="formato_facturas" class="panel-collapse collapse"> <!-- formato_facturas -->
    
    <div class="box-body">
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_f1" data-toggle="tab">Resumen</a></li>
          <li><a href="#tab_f2" data-toggle="tab">Modificar Datos de Encabezado</a></li>
          <li><a href="#tab_f3" data-toggle="tab">Modificar Observaciones</a></li>
        </ul>
        
        <div class="tab-content">
          
          <div class="tab-pane active" id="tab_f1">
            <div class="tcontab"><b>Datos de encabezado</b></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <hr>
            <div class="tcontab"><b>Observaciones</b></div>
            <div><b><?php echo $fobs[0]; ?></b></div>
            <div><?php echo $fobs[1]; ?></div>
            <div><?php echo $fobs[2]; ?></div>
            <div><?php echo $fobs[3]; ?></div>
          </div><!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_f2">
          
            <form role="form" id="frm_mencabezf" name="form_mencabezadof" method="post" action="bd/data-usuario.php">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_enc_fac" type="hidden" value="1">
              <div class="box-body">

              </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="submit" class="btn btn-primary" id="bt_mef">Guardar</button>
              </div>
            </form>   
          
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="tab_f3">

            <form role="form" id="frm_mfacobs" name="form_mobs_fac" method="post">
              <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
              <input name="mod_fac_obs" type="hidden" value="1">
              <div class="box-body">
                
                <div class="form-group">
                  <!--<label for="tobs">Titulo_obs</label>-->
                  <div class="input-group">
                    <input type="text" class="form-control" name="tobs" value="<?php echo $frt_f["titulo_obs"]?>">
                    <span class="input-group-addon">Título sección observaciones</span>
                  </div>
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs1">obs1</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresf" data-f="tof1">Texto</a></li>
                        <li><a href="#!" class="solecturaf" data-f="tof1">Condición de pago</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampof" data-f="tof1">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs1" id="tof1" 
                    data-v="<?php echo $dof[1]["dv"]; ?>" 
                    value="<?php echo $dof[1]["t"]; ?>" <?php echo $dof[1]["p"]; ?>>
                    <input type="hidden" name="vobs1" id="vtof1" value="<?php echo $dof[1]["v"];?>">
                  </div>
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs2">obs2</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresf" data-f="tof2">Texto</a></li>
                        <li><a href="#!" class="solecturaf" data-f="tof2">Condición de pago</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampof" data-f="tof2">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs2" id="tof2" 
                    data-v="<?php echo $dof[2]["dv"]; ?>" 
                    value="<?php echo $dof[2]["t"];?>" <?php echo $dof[2]["p"]; ?>>
                    <input type="hidden" name="vobs2" id="vtof2" value="<?php echo $dof[2]["v"];?>">
                  </div>                                        
                </div><!-- /.form group -->
                <div class="form-group">
                  <!--<label for="obs3">obs3</label>-->
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle libresc" data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu menuobs">
                        <li><a href="#!" class="libresf" data-f="tof3">Texto</a></li>
                        <li><a href="#!" class="solecturaf" data-f="tof3">Condición de pago</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" class="blocampof" data-f="tof3">No mostrar</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control csfacobs dataobs" name="obs3" id="tof3" 
                    data-v="<?php echo $dof[3]["dv"]; ?>" 
                    value="<?php echo $dof[3]["t"];?>" <?php echo $dof[3]["p"]; ?>>
                    <input type="hidden" name="vobs3" id="vtof3" value="<?php echo $dof[3]["v"];?>">
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
  
  </div><!-- /.formato_facturas-->

</div> <!-- /.Panel sección -->
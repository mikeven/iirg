<?php
	/*
	* IIRG - Ficha de datos de cliente
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-sistema.php" );
  include( "bd/data-usuario.php" );
	include( "bd/data-documento.php" );
	include( "fn/fn-formato.php" );
	checkSession( '' );
	
  $iva = $sisval_iva * 100;
  $iva2 = $sisval_iva2 * 100;
  $ret = $sisval_ret * 100;
  $idb = $sisval_db * 100; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Opciones de sistema </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="css/ionicons.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->

    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	  <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="plugins/bootstrapvalidator-dist-0.5.3/dist/css/bootstrapValidator.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/select2/select2.full.min.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
	  <script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>

    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>

    <script src="js/fn-sistema.js"></script>
    <style>
      .iconlab{ line-height: 0; } .tcontab{ color:#3c8dbc; }
      .chkupdt, #db_s, .ivares{ color: green; font-size:17px; } .chkupdt_e{ color: red; font-size:17px; }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <?php include("sub-scripts/nav/logo.html");?>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Mensajes: style can be found in dropdown.less-->
          <?php include("sub-scripts/nav/mensajes.php");?>
          <!-- Mensajes-->
          <!-- Notificaciones: style can be found in dropdown.less -->
          <?php include("sub-scripts/nav/notificaciones.php");?>
          <!-- Notificaciones-->
          <!-- Tareas: style can be found in dropdown.less -->
          <?php include("sub-scripts/nav/tareas.php");?>
          <!-- Tareas: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <?php include("sub-scripts/nav/perfil.php");?>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <?php 
    include("sub-scripts/nav/menu_ppal.php");
  ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php 
    $condiciones_ctz = obtenerCondiciones( $dbh, "cotizacion", $usuario["idUsuario"] );
    $condiciones_fac = obtenerCondiciones( $dbh, "factura", $usuario["idUsuario"] );
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include("sub-scripts/nav/contenido-cabecera.php");?>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
            <div class="col-md-12">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Ajustes</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <input type="hidden" name="id_usuario" id="idUsuario" value="<?php echo $usuario["idUsuario"]?>">
                    <div class="box-body">
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab1" data-toggle="tab">Porcentaje del IVA</a></li>
                          <li><a href="#tab2" data-toggle="tab">Porcentaje del IGTF (Débito Bancario)</a></li>
                          <li><a href="#tab3" data-toggle="tab">Porcentaje retención</a></li>
                          <li><a href="#tab4" data-toggle="tab">Condiciones de cotización</a></li>
                          <li><a href="#tab5" data-toggle="tab">Condiciones de facturación</a></li>
                        </ul>                        
                        
                        <div class="tab-content">
                          
                          <div class="tab-pane active" id="tab1">                            
                            
                            <div class="form-group">
                              <label for="iva">Porcentaje Impuesto Valor Agregado</label>
                              <div class="input-group" style="width:50%;">
                                <input type="text" class="form-control" id="iva_valor" name="iva" 
                                value="<?php echo $iva; ?>">
                                <span class="input-group-addon">
                                  <span id="iva_s" class="ivares">%</span>
                                </span>
                              </div>
                            </div><!-- /.form group -->
                            
                            <div class="form-group">
                              <label for="iva2">Porcentaje Impuesto Valor Agregado secundario</label>
                              <div class="input-group" style="width:50%;">
                                <input type="text" class="form-control" id="iva_valor_2" name="iva2" 
                                value="<?php echo $iva2; ?>">
                                <span class="input-group-addon">
                                  <span id="iva_s2" class="ivares">%</span>
                                </span>
                              </div>
                            </div><!-- /.form group -->

                            <div class="box-footer" align="center" style="width:50%;">
                              <button type="submit" class="btn btn-primary" id="bt_act_iva">Guardar</button>
                            </div>                          
                          </div><!-- /.tab-pane -->

                          <div class="tab-pane" id="tab2">                            
                            
                            <div class="form-group">
                              <label for="iva">Porcentaje Impuesto Grandes Transferencias Financieras (Débito Bancario)</label>
                              <div class="input-group" style="width:50%;">
                                <input type="text" class="form-control" id="db_valor" name="db" value="<?php echo $idb; ?>">
                                <span class="input-group-addon"><span id="db_s">%</span></span>
                              </div>
                            </div><!-- /.form group -->
                          

                            <div class="box-footer" align="center" style="width:50%;">
                              <button type="submit" class="btn btn-primary" 
                              id="bt_act_db">Guardar</button>
                            </div>                          
                          </div><!-- /.tab-pane -->

                          <div class="tab-pane" id="tab3">                            
                            <div class="form-group">
                              <label for="iva">Porcentaje de retención de empresa como proveedor</label>
                              <div class="input-group" style="width:50%;">
                                <input type="text" class="form-control" id="ret_valor" name="ret" 
                                value="<?php echo $ret; ?>">
                                <span class="input-group-addon"><span id="retpje">%</span></span>
                              </div>
                            </div><!-- /.form group -->
                            <div class="box-footer" align="center" style="width:50%;">
                              <button type="submit" class="btn btn-primary" id="bt_act_ret">Guardar</button>
                            </div>                          
                          </div><!-- /.tab-pane -->
                          
                          <div class="tab-pane" id="tab4">
                            <div id="agregar_condicion_ctz">
                              <form role="form" id="frm_condiciones_ctz" name="frm_condiciones">
                                
                                <div class="form-group" style="width:50%;">
                                  <label for="diasctz">Agregar condición de cotización</label>
                                  <div class="input-group margin">
                                    <input type="text" class="form-control iik" placeholder="días" id="diasctz" 
                                    data-d="cotizacion" data-ve="vecc">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat ag_cond" data-v="diasctz">Guardar</button>
                                    </span>
                                  </div>
                                </div><!-- /.form group -->
                              
                              </form>
                              <hr>
                              <div>
                                <label for="lista_condiciones_ctz">Condiciones registradas</label>
                                <table class="table table-condensed" id="lista_condiciones_vecc">
                                  <tbody>
                                      <?php 
                                        foreach( $condiciones_ctz as $c ){ 
                                          $val = $c["valor"]; $p1 = ""; $p2 = "";
                                          $idcond = $c["idCondicion"];
                                          if( $c["valor"] == 1 ){
                                            $val = $c["nombre"]; $p1 = "readonly"; $p2 = "disabled";
                                          }
                                      ?>
                                      <tr id="vecc<?php echo $idcond; ?>">
                                        <th width="90%" class="tit_tdf_i">
                                          <div class="input-group">
                                            <input type="text" class="form-control iik vecc" id="<?php echo $idcond; ?>" 
                                            name="condicion" value="<?php echo $val; ?>" maxlength="2" <?php echo $p1; ?>>
                                            <span class="input-group-addon">días</span>
                                          </div>
                                        </th>

                                        <th width="3%" class="tit_tdf">
                                          <i class="fa fa-check-square-o chkupdt" id="chku<?php echo $idcond; ?>"></i>
                                          <i class="fa fa-times chkupdt_e" id="chkue<?php echo $idcond; ?>"></i>
                                        </th>
                                        
                                        <th width="7%" class="tit_tdf_d">
                                          <button type="button" class="btn btn-block btn-danger ecd" 
                                          data-fila="vecc<?php echo $c["idCondicion"]; ?>" 
                                          data-idc="<?php echo $idcond; ?>" 
                                          <?php echo $p2; ?>>
                                            <i class='fa fa-times'></i>
                                          </button>
                                        </th>
                                      </tr>

                                      <?php } ?>
                                  </tbody>
                                </table>
                                
                              </div>
                              
                            </div>
                              
                          </div><!-- /.tab-pane -->
                          
                          <div class="tab-pane" id="tab5">
                            <div id="agregar_condicion_fac">
                              <form role="form" id="frm_condiciones_fac" name="frm_condiciones">
                                <label for="diasfac">Agregar condición de facturación</label>
                                <div class="form-group" style="width:50%;">
                                  <div class="input-group margin">
                                    <input type="text" class="form-control iik" placeholder="días" id="diasfac" 
                                    data-d="factura" data-ve="vecf">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat ag_cond" data-v="diasfac">Guardar</button>
                                    </span>
                                  </div>
                                </div><!-- /.form group -->
                              
                              </form>
                              <hr>
                              <div>
                                <label for="lista_condiciones_fac">Condiciones registradas</label>
                                <table class="table table-condensed" id="lista_condiciones_vecf">
                                  <tbody>
                                      <?php
                                        foreach( $condiciones_fac as $c ){ 
                                          $val = $c["valor"]; $p1 = ""; $p2 = "";
                                          $idcond = $c["idCondicion"];
                                          if( $c["sistema"] == 1 ){
                                            $val = $c["nombre"]; $p1 = "readonly"; $p2 = "disabled";
                                          }
                                      ?>
                                        <tr id="vecf<?php echo $idcond; ?>">
                                          <th width="90%" class="tit_tdf_i">
                                            <div class="input-group">
                                              <input type="text" class="form-control iik vecf" id="<?php echo $idcond; ?>" 
                                              name="condicion" value="<?php echo $val; ?>" maxlength="2" <?php echo $p1; ?>>
                                              <span class="input-group-addon">días</span>
                                            </div>
                                          </th>

                                          <th width="3%" class="tit_tdf">
                                            <i class="fa fa-check-square-o chkupdt" id="chku<?php echo $idcond; ?>"></i>
                                            <i class="fa fa-times chkupdt_e" id="chkue<?php echo $idcond; ?>"></i>
                                          </th>

                                          <th width="7%" class="tit_tdf_d">
                                            <button type="button" class="btn btn-block btn-danger ecd" 
                                             data-fila="vecf<?php echo $idcond; ?>" data-idc="<?php echo $idcond; ?>" <?php echo $p2; ?>>
                                              <i class='fa fa-times'></i>
                                            </button>
                                          </th>

                                        </tr>
                                      <?php } ?>
                                  </tbody>
                                </table>
                                
                              </div>
                              
                            </div>
                        
                        </div><!-- /.tab-content -->
                        <!-- Bloque de respuesta del servidor -->
                          <button type="button" id="enl_vmsj" data-toggle="modal" data-target="#ventana_mensaje" class="hidden"></button>
                          <?php include("sub-scripts/nav/mensaje_respuesta.php");?>
                        <!-- /.Bloque de respuesta del servidor -->
                      </div><!-- /.nav-tabs-custom -->
                    
                    </div> <!--/.box-body-->

                  </div>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <!-- right column -->
            
            <div class="col-md-6">
              
              
              
            </div><!--/.col (right) -->
          </div>  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /footer -->
  <?php include("sub-scripts/nav/footer.php"); ?>
  <!-- /.footer -->
  
  <!-- Panel de configuración -->
  <?php include("sub-scripts/nav/panel_control.php"); ?>
  <!-- /.Panel de configuración -->

</div>
<!-- ./wrapper -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js'></script>
<script src="js/velocity-setup.js"></script>
</body>
</html>

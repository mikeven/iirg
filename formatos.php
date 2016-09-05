<?php
	/*
	* IIRG - Ficha de datos de cliente
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
  include( "bd/data-formato.php" );
  include( "fn/fn-formato.php" );
	checkSession( '' );
	
  $nombre_usuario = $_SESSION["user"]["nombre"];
  for ( $i = 0; $i <= 5; $i++ ) { $datau[$i] = ""; }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Formato de documentos </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
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
    <script src="plugins/fastclick/fastclick.min.js"></script>
	<script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/demo.js"></script>

    <script src="js/fn-formato.js"></script>
    <style>
      .iconlab{ line-height: 0; } .tcontab{ color:#3c8dbc; }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="main.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>

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
          <?php include("subforms/nav/mensajes.php");?>
          <!-- Mensajes-->
          <!-- Notificaciones: style can be found in dropdown.less -->
          <?php include("subforms/nav/notificaciones.php");?>
          <!-- Notificaciones-->
          <!-- Tareas: style can be found in dropdown.less -->
          <?php include("subforms/nav/tareas.php");?>
          <!-- Tareas: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <?php include("subforms/nav/perfil.php");?>
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
    include("subforms/nav/menu_ppal.php");
    
    $frt_c = obtenerFormatoPorUsuarioDocumento( $dbh, "ctz", $usuario["idUsuario"] );
    $datau = dataU( $frt_c, $usuario );
    $do = dataObs( $frt_c );

  ?>
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Version 2.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
            <div class="col-md-8">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Formato de documentos</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <i class="fa fa-book"></i> Formato de Cotizaciones
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
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
                                <div><b><?php echo $frt_c["titulo_obs"]; ?></b></div>
                                <div><?php echo $frt_c["obs1"]; ?></div>
                                <div><?php echo $frt_c["obs2"]; ?></div>
                                <div><?php echo $frt_c["obs3"]; ?></div>
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
                                        <textarea class="form-control" name="entrada" rows="3" cols="50" id="tentctz"><?php echo $frt_c["entrada"];?></textarea>
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
                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                                          <ul class="dropdown-menu menuobs">
                                            <li><a href="#" class="libresc" data-c="toc1">Texto</a></li>
                                            <li><a href="#" class="solectura" data-c="toc1">Validez de cotización</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" class="blocampo" data-c="toc1">No mostrar</a></li>
                                          </ul>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control csctzobs" name="obs1" id="toc1" 
                                        data-v="<?php echo $do[1]["dv"]; ?>" 
                                        value="<?php echo $do[1]["t"]; ?>" <?php echo $do[1]["p"]; ?>>
                                        <input type="hidden" name="vobs1" id="vtoc1" value="<?php echo $do[1]["v"];?>">
                                      </div>
                                    </div><!-- /.form group -->
                                    <div class="form-group">
                                      <!--<label for="obs2">obs2</label>-->
                                      <div class="input-group">
                                        <div class="input-group-btn">
                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Mostrar <span class="fa fa-caret-down"></span></button>
                                          <ul class="dropdown-menu menuobs">
                                            <li><a href="#" class="libresc" data-c="toc2">Texto</a></li>
                                            <li><a href="#" class="solectura" data-c="toc2">Validez de cotización</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" class="blocampo" data-c="toc2">No mostrar</a></li>
                                          </ul>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control csctzobs" name="obs2" id="toc2" 
                                        data-v="<?php echo $do[2]["dv"]; ?>" 
                                        value="<?php echo $do[2]["t"];?>" <?php echo $do[2]["p"]; ?>>
                                        <input type="hidden" name="vobs2" id="vtoc2" value="<?php echo $do[2]["v"];?>">
                                      </div>                                        
                                    </div><!-- /.form group -->
                                    <div class="form-group">
                                      <!--<label for="obs3">obs3</label>-->
                                      <div class="input-group">
                                        <div class="input-group-btn">
                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" class="libresc">Mostrar <span class="fa fa-caret-down"></span></button>
                                          <ul class="dropdown-menu menuobs">
                                            <li><a href="#" class="libresc" data-c="toc3">Texto</a></li>
                                            <li><a href="#" class="solectura" data-c="toc3">Validez de cotización</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" class="blocampo" data-c="toc3">No mostrar</a></li>
                                          </ul>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control csctzobs" name="obs3" id="toc3" 
                                        data-v="<?php echo $do[3]["dv"]; ?>" 
                                        value="<?php echo $do[3]["t"];?>" <?php echo $do[3]["p"]; ?>>
                                        <input type="hidden" name="vobs3" id="vtoc3" value="<?php echo $do[3]["v"];?>">
                                      </div>                                        
                                    </div><!-- /.form group -->
                                    
                                  </div><!-- /.box-body -->
                
                                  <div class="box-footer" align="center">
                                    <button type="submit" class="btn btn-primary" id="bt_ctzobs">Guardar</button>
                                  </div>
                              </form>
                              </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                          </div><!-- nav-tabs-custom -->


                        </div>
                      </div>
                    </div>
                    <div class="panel box box-danger">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <i class="fa fa-clipboard"></i> Formato de Pedidos
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="box-body">
                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                      </div>
                    </div>
                    <div class="panel box box-success">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <i class="fa fa-file-text-o"></i> Formato de Facturas
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
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
                                <div><b>Datos de encabezado</b></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <hr>
                                <div><b>Observaciones</b></div>
                                <div></div>
                                <div></div>
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
                                <form role="form" id="frm_mfacobs" name="form_mobs_ctz" method="post" action="bd/data-usuario.php">
                                  <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
                                  <input name="mod_fctz_obs" type="hidden" value="1">
                                  <div class="box-body">
                                    
                                    <div class="form-group">
                                      <!--<label for="obs1">obs1</label>-->
                                      <div class="input-group">
                                        <input type="textarea" class="form-control" name="obs1" rows="3">
                                        <span class="input-group-addon">Observación 1</span>
                                      </div>
                                    </div><!-- /.form group -->
                                    <div class="form-group">
                                      <!--<label for="obs2">obs2</label>-->
                                      <div class="input-group">
                                        <input type="text" class="form-control" name="obs2">
                                        <span class="input-group-addon">Observación 2</span>
                                      </div>                                        
                                    </div><!-- /.form group -->
                                    <div class="form-group">
                                      <!--<label for="obs3">obs3</label>-->
                                      <div class="input-group">
                                        <input type="text" class="form-control" name="obs3">
                                        <span class="input-group-addon">Observación 3</span>
                                      </div>                                        
                                    </div><!-- /.form group -->
                                    
                                  </div><!-- /.box-body -->
                
                                  <div class="box-footer" align="center">
                                    <button type="submit" class="btn btn-primary" id="bt_mod_cuenta">Guardar</button>
                                  </div>
                              </form>
                              </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                          </div><!-- nav-tabs-custom -->
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Bloque de respuesta del servidor -->
                  <?php include("subforms/nav/mensaje_rcpf.php");?>
                  <!-- /.Bloque de respuesta del servidor -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <!-- right column -->
            <div class="col-md-6">
              <!-- Horizontal Form -->
              
              
            </div><!--/.col (right) -->
          </div>  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.2
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->

      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
</body>
</html>

<?php
	/*
	* IIRG - Registro de nueva cotización
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-articulo.php" );
	include( "bd/data-proveedor.php" );
	include( "bd/data-formato.php" );
	include( "bd/data-cotizacion.php" );
	include( "fn/fn-formato.php" );
	//require_once( 'lib/FirePHPCore/fb.php' );
	
	$iva = 0.12;
	$eiva = $iva * 100;
	$num_nvacotiz = obtenerProximoNumeroSolicitudCotizacion( $dbh );
	checkSession( '' );
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Solicitud de cotización</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!--<link rel="stylesheet" type="text/css" href="plugins/bootstrapvalidator-dist-0.5.3/dist/css/bootstrapValidator.css">-->
    <style>
    	.input-space{	width:95%; }
		.itemtotal_detalle, .itemtotalcotizacion{ width:95%; border:0; background:#FFF; text-align:right;}
  		.totalitem_detalle, .ftotalizacion{ width:100%; text-align:right; }
  		.tit_tdf_i{ text-align: left; } .tit_tdf{ text-align: center; } .tit_tdf_d{ text-align: right; }
  		.iconlab{ line-height: 0; }
  		.form-group { margin-bottom: 5px; }
    </style>
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
    
	<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
    
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="js/fn-cotizacion.js"></script>
    <script>
        $( document ).ready(function() {
            //Initialize Select2 Elements
            $('#femision').datepicker({
              autoclose: true,
              format:'dd/mm/yyyy',
              language:'es',
              title:true
            });
            
            initValid();
            $(".alert").hide();
        });
    </script>
    
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
  <?php 
    $frt_sctz = obtenerFormatoPorUsuarioDocumento( $dbh, "sctz", $usuario["idUsuario"] );
  ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include("subforms/nav/menu_ppal.php");?>
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
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
				<div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title">CREAR NUEVA SOLICITUD DE COTIZACIÓN</h3>
                  <div class="icon-color"><i class="fa fa fa-book fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_nscotizacion" name="form_agregar_solicitud_cotizacion">
                	<input name="reg_cliente" type="hidden" value="1">
                    <div class="box-body">
                    	<div class="row" id="encabezado_cotizacion">
                    		<div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                          <button type="button" class="btn btn-primary" data-toggle="modal" 
                                          data-target="#lista_proveedores">PROVEEDOR</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input type="text" class="form-control" id="nproveedor" readonly name="nombre_proveedor">
                                        <input type="hidden" class="form-control" id="idCliente" value="">
                                        <input type="hidden" class="form-control" id="tipo" value="solicitud">
                                	</div>
                                </div><!-- /.form group -->
                                <!-- Modal -->
                                	<?php include( "subforms/tablas/tabla_proveedores_modal.php" ); ?>
                                <!-- /.Modal -->
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i> 
                                                <label for="datepicker" class="iconlab">Fecha emisión:</label>
                                            </div>
                                            <input type="text" class="form-control" id="femision" name="fecha_emision" required readonly 
                                            value="<?php echo date("d/m/Y");?>">
                                        </div>
                                    </div><!-- /.form group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <!--<label for="fcondpago" class="">Validez:</label>-->
                                        <!--<div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                            <select name="validez" id="cvalidez" class="form-control">
                                                <option value="0" disabled selected>Validez</option>
                                                <option value="3 días">3 días</option>
                                                <option value="5 días">5 días</option>
                                                <option value="8 días">8 días</option>
                                            </select>
                                        </div>-->
                                    </div><!-- /.form group -->
                    			       </div>
                                </div>
                                
                                <div class="row"><!-- 3era fila -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-slack"></i> 
                                                    <label for="datepicker" class="iconlab">N°:</label>
                                                </div>
                                                <input type="text" class="form-control" id="ncotiz" name="numero" required readonly value="<?php echo $num_nvacotiz; ?>">
                                            </div>
                                        </div><!-- /.form group -->
                                    </div>
                                    <div class="col-md-8">
                                    	<div class="form-group">
                                            <!--<label for="fcondpago" class="">Validez:</label>-->
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i> 
                                                    <label for="datepicker" class="iconlab">P. Contacto:</label>
                                                </div>
                                                <input type="text" class="form-control" id="cpcontacto" name="pcontacto" required value="">
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->	
                                    </div>
                                </div><!-- /.3era fila -->
                            
                            </div><!--/.columna izquierda-->
                            
                            <div class="col-md-6">
                            	<div id="articulos_cotizacion">
                                	<!--<div style="padding:11px 0 10px 0;"><span class="lead">Ítems de cotizacion</span></div>-->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-info" data-toggle="modal" 
                                              data-target="#lista_articulos">ARTÍCULO</button>
                                            </div>
                                            <!-- /btn-group -->
                                            <input type="text" class="form-control" id="narticulo" readonly>
                                            <input type="hidden" id="idArticulo" value="0">
                                            <input type="hidden" id="undart" value="0">
                                        </div>
                                    </div><!-- /.form group -->
                                    <!-- Modal -->
                                    <?php include( "subforms/tablas/tabla_articulos_modal.php" ); ?>
                                    <!-- /.Modal -->
                                    
                                    <div class="row" id="sumador_items">
                                      <div class="col-md-6">
                                      	<div class="form-group">
                                              <!--<label for="cantidad" class="">Cantidad:</label>-->
                                              <div class="input-group">
                                                  <div class="input-group-addon"><i class="fa fa-unsorted"></i></div>
                                                  <input type="text" class="form-control itemtotal" id="fcantidad" name="cantidad" 
                                                  placeholder="CANT" onkeypress="return isIntegerKey(event)">
                                              </div>
                                          </div><!-- /.col -->
                                      </div><!-- /.form group -->
                                      <div class="col-md-6">
                                      	<div class="form-group">
                                              <!--<label for="punit" class="">Precio unitario:</label>-->
                                              <div class="input-group">
                                                  <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                                                  <input type="text" class="form-control itemtotal" id="fpunit" name="punit" value="0.00" readonly>
                                              </div>
                                          </div><!-- /.form group -->
                                      </div><!-- /.col -->
                                    
                                      <div class="col-md-6">
                                      	<div class="form-group">
                                              <!--<label for="punit" class="">Total item:</label>-->
                                              <div class="input-group">
                                                  <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                                                  <input type="text" class="form-control" id="fptotal" name="ptotal" 
                                                  placeholder="Total" value="0.00" readonly>
                                              </div>
                                          </div><!-- /.form group -->
                                      </div><!-- /.col -->
                                      <div class="col-md-6">
                                      	<button class="btn btn-block btn-success" type="button" id="aitemfsol">Agregar</button>
                                      </div><!-- /.col -->
                                    </div><!-- /.sumador_items -->                            	
                                </div><!--/.articulos_cotizacion-->		
                            </div>
                        
                        </div><!-- /.encabezado_cotizacion -->
                        <!-- ************************************************************************************************ -->
                        <div class="row" id="division_cntral"><div class="col-md-12"><hr></div></div>
                        <!-- ************************************************************************************************ -->
                        <div class="row" id="ficha_cotizacion">
                        	<div class="col-md-10 col-md-offset-1">
                            	
                                <div id="detalle_cotizacion">
                                    
                                    <div class="box box-primary">	
                                        <div class="box-body">
                                        	<input id="itemcont" name="contadoritems" type="hidden" value="0">
                                            <table class="table table-condensed" id="df_table">
                                                <tbody>
                                                    <tr>
                                                        <th width="45%" class="tit_tdf_i">Descripción</th>
                                                        <th width="10%" class="tit_tdf">Cantidad</th>
                                                        <th width="10%" class="tit_tdf">UND</th>
                                                        <th width="15%" class="tit_tdf">Precio Unit</th>
                                                        <th width="15%" class="tit_tdf">Total item</th>
                                                        <th width="5%" class="tit_tdf"></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    					
                                </div><!--/.detalle_cotizacion-->
                                <input id="cvalidez" name="validez" type="hidden" value="">
                                <input id="iva" name="ivap" type="hidden" value="<?php echo $iva;?>">
                                <input id="ftotal" name="ivap" type="hidden" value="0.00" >
                                <!--<div class="row" id="pie_cotizacion">
                                	<table class="table table-condensed" id="pietabla_table">
                                        <tbody>
                                            <tr>
                                                <th width="65%"></th>
                                                <th width="15%">SubTotal</th>
                                                <th width="15%">
                                                	<div id="fsub_total" class="ftotalizacion">
                                                    	<div class="input-group">
                                                    		<input type="text" class="form-control itemtotalcotizacion ftotalizacion" 
                                                            id="fstotal" value="0.00" readonly>
                                                		</div>
                                                	</div>
                                                </th>
                                                <th width="5%"></th>
                                            </tr>
                                            <tr>
                                                <th width="65%"></th>
                                                <th width="15%">IVA (<?php //echo $eiva; ?>%)</th>
                                                <th width="15%">
                                                	<div id="fimpuesto" class="ftotalizacion">
                                                    	<div class="input-group">
                                                        	<input id="iva" name="ivap" type="hidden" value="<?php //echo $iva;?>">
                                                    		<input type="text" class="form-control itemtotalcotizacion ftotalizacion" 
                                                            id="fiva" value="0.00" readonly>
                                                		</div>
                                                	</div></th>
                                                <th width="5%"></th>
                                            </tr>
                                            <tr>
                                                <th width="65%"></th>
                                                <th width="15%">Total</th>
                                                <th width="15%">
                                                	<div id="fac_total" class="ftotalizacion">
                                                    	<div class="input-group">
                                                    		<input type="text" class="form-control itemtotalcotizacion ftotalizacion" 
                                                            id="ftotal" value="0.00" readonly>
                                                		</div>
                                                	</div>
                                                </th>
                                                <th width="5%"></th>
                                            </tr>
                                        </tbody>
                                    </table>			
                                </div>-->
                                
                                <dic id="observaciones">
                                  <div class="titobs"><?php echo $frt_sctz["titulo_obs"];?></div>
                                  
                                  <div class="obsctz"><?php echo $frt_sctz["obs1"];?>
                                    <input id="tobs1" type="hidden" value="<?php echo $frt_sctz["obs1"];?>" 
                                    data-v="<?php echo $obs[1];?>">
                                  </div>
                                  <div class="obsctz"><?php echo $frt_sctz["obs2"];?>
                                    <input id="tobs2" type="hidden" value="<?php echo $frt_sctz["obs2"];?>" 
                                    data-v="<?php echo $obs[2];?>">
                                  </div>
                                  <div class="obsctz"><?php echo $frt_sctz["obs3"];?>
                                    <input id="tobs3" type="hidden" value="<?php echo $frt_sctz["obs3"];?>" 
                                    data-v="<?php echo $obs[3];?>">
                                  </div>
                                </dic>
                            </div><!--/.col-md-8-->
                        	
                        </div><!-- /.pie_cotizacion -->
                        
                        <!-- Bloque de respuesta del servidor -->
                          <?php include("subforms/nav/mensaje_rcpf.php");?>
                        <!-- /.Bloque de respuesta del servidor -->
                    
                    </div><!-- /.box-body -->
                    <div class="box-footer" align="center">
                    	<button type="button" class="btn btn-primary" id="btn_confirmacion" data-toggle="modal" 
                      data-target="#ventana_confirmacion">Guardar</button>
                    </div>
                    <?php 
                      include( "subforms/nav/mensaje_confirmacion.php" );
                    ?>
                </form>
              
              </div><!-- /.box -->
            
            </div><!--/.col (main) -->
            
            <!-- right column -->
          
		</div>  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /footer -->
  <?php include("subforms/nav/footer.php"); ?>
  <!-- /.footer -->

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

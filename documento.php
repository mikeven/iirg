<?php
	/*
	* IIRG - Visualización de documento
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
  include( "bd/data-pedido.php" );
	include( "bd/data-articulo.php" );
  include( "bd/data-factura.php" );
	include( "bd/data-cotizacion.php" );

	checkSession( '' );
	
  if( isset( $_GET["tipo_documento"] ) && ( isset( $_GET["id"] ) ) ){
    $id = $_GET["id"];
    $tdd = $_GET["tipo_documento"]; 

    if( $tdd == "ctz" ){
    	$documento = obtenerCotizacionPorId( $dbh, $id );
    	$encabezado = $documento["encabezado"];
      $obs1 = $encabezado["obs1"];
      $obs2 = "Validez".$encabezado["validez"];
      $detalle_d = $documento["detalle"];
      $tdocumento = "Cotización";
    }
    if( $tdd == "ped" ){
      $documento = obtenerPedidoPorId( $dbh, $id );
      $encabezado = $documento["encabezado"];
      $detalle_d = $documento["detalle"];
      $obs1 = $encabezado["obs1"];
      $obs2 = $encabezado["obs2"];
      $tdocumento = "Pedido";
    }
    if( $tdd == "fac" ){
      $documento = obtenerFacturaPorId( $dbh, $id );
      $encabezado = $documento["encabezado"];
      $detalle_d = $documento["detalle"];
      $obs1 = $encabezado["obs1"];
      $obs2 = $encabezado["obs2"];
      $tdocumento = "Factura";
    }
    $eiva = $encabezado["iva"] * 100;
    $totales = obtenerTotales( $detalle_d, $encabezado["iva"] );
  }
  else{

  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $tdocumento." Nro. ".$encabezado["nro"];?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    	#lin1{ font-size:22px; } #lin2{ font-size:18px; } .membrete3{ font-size:16px; }
      .tit_tdf_i{ text-align: left; } .tit_tdf{ text-align: center; } .tit_tdf_d{ text-align: right; }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
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
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
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
	  <?php include( "subforms/nav/menu_ppal.php" );?>
      <!-- Left side column. contains the logo and sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $tdocumento." #".$encabezado["nro"]; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Invoice</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <!--<div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> AdminLTE, Inc.
                <small class="pull-right">Date: 2/10/2014</small>
              </h2>
            </div>
          </div>-->
          <!-- info row -->
            <div class="row invoice-info" id="membrete">
                <div class="col-sm-2 invoice-col"></div><!-- /.col -->
                <div class="col-sm-8 invoice-col" align="center">
                    <div id="lin1">INSUMOS INFORMÁTICOS R & G, C.A.</div>
                    <div id="lin2">Suministros para Computación y Papelería</div>
                    <div id="lin3" class="membrete3">Calle Este 16, Sordo a Peláez, Residencias Sorpe, P.B. Local 1</div>
                    <div id="lin4" class="membrete3">Parroquia Santa Rosalía - Caracas</div>
                    <div id="lin5" class="membrete3">Telefonos (0212) 545.6529 / 395-5955 / Telefax: 5424137 CEL. 0416-624-4269</div>
                    <div id="lin6" class="membrete3">email: insumos_rg@cantv.net    /   rginsumosinformaticos@gmail.com</div>
                </div><!-- /.col -->
                <div class="col-sm-2 invoice-col"></div><!-- /.col -->
          	</div><!-- /.row -->
			
            <div class="row invoice-info" id="encabezado" style="margin:20px 0;">
                <div class="col-sm-4 invoice-col" id="dcliente">
                    <div id="dc_nombre">Señores</div>
                    <div id="dc_nombre">Nombre del cliente: <?php echo $encabezado["nombre"]?></div>
                    <div id="dc_nombre">Ciudad: Caracas</div>
                </div><!-- /.col -->
                <div class="col-sm-5 invoice-col"> </div><!-- /.col -->
                <div class="col-sm-3 invoice-col" id="dcotizacion">
                    <div id="dctz_numero"><?php echo $tdocumento.":   ".$encabezado["nro"];?></div>
                    <div id="dctz_fecha">Fecha: &nbsp;<?php echo $encabezado["femision"];?></div>
                    <div id="dctz_tlf">Teléfono: 0212 - 5456529</div>
                    <div id="dctz_fax">Fax:</div>
                </div><!-- /.col -->
            </div><!-- /.row -->
          
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="tit_tdf_i">Descripción</th>
                    <th class="tit_tdf">Cant</th>
                    <th class="tit_tdf">UND</th>
                    <th class="tit_tdf">Precio Unitario</th>
                    <th class="tit_tdf">Total ítem</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach( $detalle_d as $item ) { ?>
                  <tr>
                    <td class="tit_tdf_i"><?php echo $item["descripcion"];?></td>
                    <td class="tit_tdf"><?php echo $item["cantidad"];?></td>
                    <td class="tit_tdf"><?php echo $item["und"];?></td>
                    <td align="right"><?php echo $item["punit"];?></td>
                    <td align="right"><?php echo ($item["ptotal"]);?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              <p class="lead">Observaciones:</p>
                <div><?php echo $obs1; ?></div>
                <div><?php echo $obs2; ?></div>  
              </p>
            </div><!-- /.col -->
            <div class="col-xs-6">
              <p class="lead">Totales</p>
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td class="tit_tdf_d"><?php echo $totales["subtotal"]; ?></td>
                  </tr>
                  <tr>
                    <th>IVA (<?php echo $eiva; ?>%)</th>
                    <td class="tit_tdf_d"><?php echo $totales["iva"]; ?></td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td class="tit_tdf_d"><?php echo $totales["total"]; ?></td>
                  </tr>
                </table>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
              <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer no-print">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
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
            </ul><!-- /.control-sidebar-menu -->

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
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
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
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
  </body>
</html>

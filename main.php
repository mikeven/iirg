<?php
	/*
	 * R&G - Panel inicial
	 * 
   * Panel informativo con reportes puntuales:
   * - Facturación de día
   * - Movimientos del día
   * - Documentos de vencimiento del día
   * - Documentos por vencerse
   * - Facturación del mes
   * - Documentos vencidos desde hace un período de tiempo
	 */
	session_start();
	ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
  include( "fn/fn-documento.php" );
	checkSession( '' );
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IIRG | Inicio</title>
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
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
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
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <style>
      .cont_det{ background: #FFF; }
      .tresumen{ width: 95%; color:#000; }
    </style>
  </head>
  <?php 
    $hoy = obtenerFechaActual();
    chequearActualizacion( $dbh, $hoy["f2"]['fecha'], $idu );
    
    $factdia = obtenerFacturacionDia( $dbh, $hoy["f2"]['fecha'], $idu );
    $movdia = obtenerMovimientosDia( $dbh, $hoy["f2"]['fecha'], $idu );
    $vencdia = obtenerDocsVencenHoy( $dbh, $hoy["f2"]['fecha'], $idu );
    $porvencer = obtenerDocsPorVencer( $dbh, $hoy["f2"]['fecha'], $idu );
    $factmes = obtenerFacturacionMes( $dbh, $hoy["f2"]['fecha'], $idu );
    $doc_vencidos = obtenerDocVencidos( $dbh, $hoy["f2"]['fecha'], $idu );
    
  ?>
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
      <?php include("sub-scripts/nav/menu_ppal.php");?>
      <!-- Left side column. contains the logo and sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php include("sub-scripts/nav/contenido-cabecera.php");?>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- Calendario -->
            <div class="col-lg-3 col-xs-6">
              
              <div class="box box-solid bg-aqua">
                <div class="box-header">
                  <i class="fa fa-calendar"></i>

                  <h3 class="box-title">Calendario</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bars"></i></button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Add new event</a></li>
                        <li><a href="#">Clear events</a></li>
                        <li class="divider"></li>
                        <li><a href="#">View calendar</a></li>
                      </ul>
                    </div>
                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-default btn-sm" 
                    data-widget="remove"><i class="fa fa-times"></i> </button> -->
                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <!--The calendar -->
                  <div id="calendar" style="width: 100%"></div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- Facturación del día -->
            <div class="col-lg-5 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>
                    <?php echo "Bsf ".$factdia["total"]." (".$factdia["nregs"].")"; ?>               
                  </h3>
                  <p>Facturación del día</p>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text-o"></i>
                </div>
                <a href="#!" class="small-box-footer lnk_detres" data-det="det_factdia">
                  Detalles <i class="fa fa-arrow-circle-down"></i>
                </a>
                <div id="det_factdia" class="cont_det">
                  <?php include("sub-scripts/tablas/tabla_facturas_resumen.php");?>
                </div>
              </div>
            </div>
            <!-- ./col -->
            
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-teal">
                <div class="inner">
                  <h3><?php echo $movdia["nregs"]; ?></h3>
                  <p>Movimientos del día</p>
                </div>
                <div class="icon">
                  <i class="fa fa-list"></i>
                </div>
                <a href="#!" class="small-box-footer lnk_detres" data-det="det_movdia">
                  Detalles <i class="fa fa-arrow-circle-down"></i>
                </a>
                <div id="det_movdia" class="cont_det">
                  <?php include("sub-scripts/tablas/tabla_doc_resumen.php"); ?>
                </div>
              </div>
            </div>

          </div>
          <!-- /.box -->          


          <div class="row">
            
          </div>
          <!-- /.row -->

          <div class="row">

            <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $vencdia["nregs"]; ?></h3>
                  <p>Documentos que vencen hoy</p>
                </div>
                <div class="icon">
                  <i class="fa fa-warning"></i>
                </div>
                <a href="#!" class="small-box-footer lnk_detres" data-det="det_vencdia">
                  Detalles <i class="fa fa-arrow-circle-down"></i>
                </a>
                <div id="det_vencdia" class="cont_det">
                  <?php include("sub-scripts/tablas/tabla_venchoy_resumen.php"); ?>
                </div>
              </div>
            </div>
            
            <!-- ./col -->
            <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $porvencer["nregs"]; ?></h3>
                  <p>Documentos por vencerse</p>
                </div>
                <div class="icon">
                  <i class="fa fa-clock-o"></i>
                </div>
                <a href="#!" class="small-box-footer lnk_detres" data-det="det_porvencer">
                  Detalles <i class="fa fa-arrow-circle-down"></i>
                </a>
                <div id="det_porvencer" class="cont_det">
                  <?php include("sub-scripts/tablas/tabla_porvencer_resumen.php"); ?>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->

          <div class="row">
            <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo "Bsf ".$factmes["total"]." (".$factmes["nregs"].")"; ?></h3>
                  <p>Facturación del mes</p>
                </div>
                <div class="icon">
                  <i class="fa fa-line-chart"></i>
                </div>
                <a href="#!" class="small-box-footer lnk_detres" data-det="det_factmes">
                  Detalles <i class="fa fa-arrow-circle-down"></i>
                </a>
                <div id="det_factmes" class="cont_det">
                  <?php include("sub-scripts/tablas/tabla_factmes_resumen.php"); ?>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-gray">
                <div class="inner">
                  <h3><?php echo $doc_vencidos["nregs"]; ?></h3>
                  <p>Documentos vencidos</p>
                </div>
                <div class="icon">
                  <i class="fa fa-calendar-times-o"></i>
                </div>
                <a href="#!" class="small-box-footer lnk_detres" data-det="det_docvenc">
                  Detalles <i class="fa fa-arrow-circle-down"></i>
                </a>
                <div id="det_docvenc" class="cont_det">
                  <?php include("sub-scripts/tablas/tabla_docvenc_resumen.php"); ?>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
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
    <!-- jQuery 2.1.4 -->
      
      <!-- Bootstrap 3.3.5 -->
      <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
      
      <script src="plugins/select2/select2.full.min.js"></script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
      <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
      <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
      <script src="plugins/daterangepicker/daterangepicker.js"></script>
      <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
      
      <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
      <script src="plugins/iCheck/icheck.min.js"></script>
      <script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>
      <!-- DataTables -->
      <script src="plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
      
      <!-- <script src="dist/js/pages/dashboard.js"></script> -->
      <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
      <script src="plugins/knob/jquery.knob.js"></script>
      <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
      <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script><!-- jvectormap -->
      <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
      <script src="plugins/morris/morris.min.js"></script>
      <script src="js/fn-sistema.js"></script>

      <!-- <script src="plugins/input-mask/jquery.inputmask.js"></script>
      <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
      <script src="dist/js/app.min.js"></script>
      <script src="plugins/fastclick/fastclick.js"></script>
      <script>$.widget.bridge('uibutton', $.ui.button);</script> -->
      
  </body>
</html>
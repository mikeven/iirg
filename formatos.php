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
	  <script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>

    <script src="js/fn-formato.js"></script>
    <style>
      .iconlab{ line-height: 0; } .tcontab{ color:#3c8dbc; }
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
    /* $usuario:perfil.php */
    /* Data cotizaciones */
    $frt_c = obtenerFormatoPorUsuarioDocumento( $dbh, "ctz", $usuario["idUsuario"] );
    $datau = dataU( $frt_c, $usuario ); 	// en: "fn/fn-formato.php"
    $doc = dataObs( $frt_c, "ctz" );		  // en: "fn/fn-formato.php"
    $cobs = obtenerResumenObs( $frt_c );	// en: "fn/fn-formato.php"

    /* Data solicitud cotizaciones */
    $frt_sc = obtenerFormatoPorUsuarioDocumento( $dbh, "sctz", $usuario["idUsuario"] );
    $scobs = obtenerResumenObs( $frt_sc );  // en: "fn/fn-formato.php"
	
    /* Data facturas */
    $frt_f = obtenerFormatoPorUsuarioDocumento( $dbh, "fac", $usuario["idUsuario"] );
    $dof = dataObs( $frt_f, "fac" );
    $fobs = obtenerResumenObs( $frt_f );

    /* Data orden de compra */
    $frt_oc = obtenerFormatoPorUsuarioDocumento( $dbh, "odc", $usuario["idUsuario"] );
    $ocobs = obtenerResumenObs( $frt_oc );

    /* Data Nota de crédito */
    $frt_nc = obtenerFormatoPorUsuarioDocumento( $dbh, "ndc", $usuario["idUsuario"] );
    $ncobs = obtenerResumenObs( $frt_nc );

    /* Data Nota de débito */
    $frt_nd = obtenerFormatoPorUsuarioDocumento( $dbh, "ndd", $usuario["idUsuario"] );
    $ndobs = obtenerResumenObs( $frt_nd );

    /* Data Nota de entrega */
    $frt_ne = obtenerFormatoPorUsuarioDocumento( $dbh, "nde", $usuario["idUsuario"] );
    $neobs = obtenerResumenObs( $frt_ne );

  ?>
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include("sub-scripts/nav/contenido-cabecera.php");?>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
            <div class="col-md-10">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Formato de documentos</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    
                    <!-- Sección panel formato de cotizaciones -->
                    <?php include( "sub-scripts/config-formatos/cotizaciones.php" ); ?>
                    <!-- /.Sección panel formato de cotizaciones -->
                    
                    <!-- Sección panel formato de cotizaciones -->
                    <?php include( "sub-scripts/config-formatos/solicitud_cotizaciones.php" ); ?>
                    <!-- /.Sección panel formato de cotizaciones -->
                    
                    <!-- Sección panel formato de facturas -->
                    <?php include( "sub-scripts/config-formatos/facturas.php" ); ?>
                    <!-- /.Sección panel formato de facturas -->

                    <!-- Sección panel formato de orden de compra -->
                    <?php include( "sub-scripts/config-formatos/orden_compra.php" ); ?>
                    <!-- /.Sección panel formato de orden de compra -->

                    <!-- Sección panel formato de facturas -->
                    <?php include( "sub-scripts/config-formatos/nota_credito.php" ); ?>
                    <!-- /.Sección panel formato de facturas -->

                    <!-- Sección panel formato de facturas -->
                    <?php include( "sub-scripts/config-formatos/nota_debito.php" ); ?>
                    <!-- /.Sección panel formato de facturas -->

                    <!-- Sección panel formato de facturas -->
                    <?php include( "sub-scripts/config-formatos/nota_entrega.php" ); ?>
                    <!-- /.Sección panel formato de facturas -->

                  </div>

                  <!-- Bloque de respuesta del servidor -->
                  <button type="button" id="enl_vmsj" data-toggle="modal" 
                  data-target="#ventana_mensaje" class="hidden"></button>
                  <?php include("sub-scripts/nav/mensaje_respuesta.php"); ?>
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

  <!-- /footer -->
  <?php include("sub-scripts/nav/footer.php"); ?>
  <!-- /.footer -->
  
  <!-- Panel de configuración -->
  <?php include("sub-scripts/nav/panel_control.php"); ?>
  <!-- /.Panel de configuración -->

</div>
<!-- ./wrapper -->
<script src='js/velocity/velocity.min.js'></script>
<script src='js/velocity/velocity.ui.min.js'></script>
<script src="js/velocity-setup.js"></script>
</body>
</html>

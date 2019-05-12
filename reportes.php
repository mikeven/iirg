<?php
  /*
   * R&G - Reportes
   * 
   */
  session_start();
  ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-usuario.php" );
  //include( "bd/data-cotizacion.php" );
  include( "fn/fn-documento.php" );
  checkSession( '' );
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Reportes</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="css/ionicons.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
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

    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- page script -->
    <script src="js/fn-reportes.js"></script>
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
  <?php include("sub-scripts/nav/menu_ppal.php");?>
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include("sub-scripts/nav/contenido-cabecera.php");?>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <!-- Panel selección de resportes -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <h3 class="profile-username text-center">Reportes</h3>

              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-default">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                        Informes mensuales
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                      <ul class="list-group list-group-unbordered">
                        <li class="list-group-item selreporte">
                          <a href="#!" id="relacion_gastos" class="treporte"><b>Relación de gastos</b> 
                          <span class="pull-right"></span></a>
                        </li>
                        <li class="list-group-item selreporte">
                          <a href="#!" id="relacion_proveedores" class="treporte">
                          <b>Relación de proveedores con retención</b> 
                          <span class="pull-right"></span></a>
                        </li>
                        <li class="list-group-item selreporte">
                          <a href="#!" id="pago_facturas" class="treporte"><b>Pago de facturas</b> 
                          <span class="pull-right"></span></a>
                        </li>
                        <li class="list-group-item selreporte">
                          <a href="#!" id="libro_ventas" class="treporte"><b>Libro de Ventas</b> 
                          <span class="pull-right"></span></a>
                        </li>
                        <li class="list-group-item selreporte">
                          <a href="#!" id="libro_compras" class="treporte"><b>Libro de Compras</b> 
                          <span class="pull-right"></span></a>
                        </li>
                        <li class="list-group-item selreporte">
                          <a href="#!" id="facturas_porcobrar" class="treporte"><b>Facturas por cobrar</b> 
                          <span class="pull-right"></span></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                
                <div class="panel box box-default">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                        Estadísticas
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                      
                    </div>
                  </div>
                </div>
                
              </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        
        <!-- Panel exposición de reportes -->
        <div class="col-md-9">
          <div class="box">
                
            <div class="box-header">
              <h3 class="box-title"><span id="titulo_reporte"></span></h3>
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <div class="form-group">
                <label>Rango de fecha:</label>
                <div class="input-group">
                  <input type="text" class="form-control pull-right" id="frango" readonly="true">
                  <span class="input-group-btn">
                    <button id="bt_breporte" type="button" class="btn btn-primary btn-flat" data-r="">Buscar</button>
                  </span>
                </div><!-- /.input group -->
              </div>

            </div> <!--/.box-body -->

          </div>
          
          <div class="box">
            <div class="box-header"><!--<h3 class="box-title">Resultados</h3>--></div>
            
            <div class="box-body table-responsive no-padding">
              <table id="tabla_reporte" class="table table-hover">
                <thead>
                  
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div><!-- /.box-body -->

            <div id="impresion_reporte">
              <a id="eimpresion" href="" class="btn btn-app" target="blank">
                <i class="fa fa-print fa-2x"></i> Imprimir
              </a>
            </div>

          </div>
        
        </div>
        <!-- /.col -->
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
    
</body>
</html>

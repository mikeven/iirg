<?php
	/*
	* IIRG - Registro de nuevo proveedor
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-usuario.php" );
	include( "bd/data-proveedor.php" );
	checkSession( '' );
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Crear nuevo proveedor</title>
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
    <link rel="stylesheet" type="text/css" 
    href="plugins/bootstrapvalidator-dist-0.5.3/dist/css/bootstrapValidator.css">
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
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
    		$("#crif").inputmask({mask: "a-99999999-9"});
    		$(".ctel").inputmask({mask: "(9999)-999.99.99"});
      });
    </script>
    
    <script src="js/fn-proveedores.js"></script>
    <script src="js/fn-ui.js"></script>
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
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">AGREGAR NUEVO PROVEEDOR</h3>
                  <div class="icon-color"><i class="fa fa-truck fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_nproveedor" name="form_agregar_proveedor" method="post">
					          <input name="reg_proveedor" type="hidden" value="1">
                    <div class="box-body">
                        <div class="form-group">
                        	<!--<label for="exampleInputEmail1">Email address</label>-->
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-bookmark-o"></i></div>
                              <input type="text" class="form-control" id="cnombre" placeholder="Nombre" name="nombre">
                            </div>
                        </div><!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                            	<div class="input-group-addon"><i class="fa fa-registered"></i></div>
                            	<input id="crif" type="text" class="form-control vexistente" placeholder="RIF" data-mask name="rif" data-err="#err_rif">
                              <input type="hidden" class="form-control" id="err_rif" value="0">
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                      	<div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                              <input id="cemail" type="text" class="form-control vexistente" 
                              placeholder="Email" data-mask name="email" data-err="#err_email">
                              <input type="hidden" class="form-control" id="err_email" value="0">
                            </div><!-- /.input group -->
                    	  </div><!-- /.form group -->
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input id="pcontacto" type="text" class="form-control" placeholder="Persona de contacto" name="pcontacto">
                          </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        
                        <!-- Bloque de dirección -->
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                            <input id="cdir1" type="text" class="form-control bdir" placeholder="Dirección -1-" 
                            data-mask name="direccion1">
                          </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                            <input id="cdir2" type="text" class="form-control bdir" placeholder="Dirección -2-" data-mask name="direccion2">
                          </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        <!-- /.Bloque de dirección -->
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                    <input id="ctel1" type="text" class="form-control ctel" placeholder="Teléfono" data-mask name="telefono1">
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                              <input id="ctel2" type="text" class="form-control ctel" placeholder="Teléfono" data-mask name="telefono2">
                            </div><!-- /.input group -->
                      	</div><!-- /.form group -->
                  </div><!-- /.box-body -->

                  <div class="box-footer" align="center">
                    <button type="submit" class="btn btn-primary" id="bt_reg_proveedor">Guardar</button>
                  </div>

                  <!-- Bloque de respuesta del servidor -->
                    <button type="button" id="enl_vmsj" data-toggle="modal" 
                    data-target="#ventana_mensaje" class="hidden"></button>
                    <?php include("sub-scripts/nav/mensaje_respuesta.php");?>
                  <!-- /.Bloque de respuesta del servidor -->
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
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

<?php
	/*
	* IIRG - Registro de nuevo gasto
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-compra.php" );
  include( "bd/data-documento.php" );
  include( "bd/data-proveedor.php" );
  
	checkSession( '' );
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IIRG | Registro de gastos y pagos</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- daterange picker -->
    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="plugins/datepicker/datepicker3.css">
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
    <style>
    	.input-space{
  			width:95%;
  		}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js">
    </script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>

    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
    
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script>
      $(function () {
        //Inicialización de elementos
      });
    </script>
    
    <script src="js/fn-gasto.js"></script>
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
          <?php include("sub-scripts/nav/mensajes.php"); ?>
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
  <?php
    $fecha_actual = obtenerFechaHoy();
    $lctabanco = obtenerListaCuentasBancarias( $dbh, $usuario["idUsuario"] );
  ?>
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
          
          <div id="formulario_ncompra" class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">REGISTRAR NUEVO GASTO / PAGO</h3>
              <div class="icon-color"><i class="fa fa-shopping-cart fa-2x"></i></div>
            </div><!-- /.box-header -->
            <form role="form" id="frm_ngasto" name="form_agregar_gasto">
                
                <div class="box-body">
                  <div class="form-group">
                    <select class="form-control" id="tgasto" name="tgasto">
                      <option value="0" disabled selected class="tg">Tipo de registro</option>
                      <option value="gasto" class="tg">Registro de gasto</option>
                      <option value="pago" class="tg">Registro de pago</option>
                    </select>
                  </div><!-- /.form group -->

                  <div id="selcompra" class="form-group">
                     <div class="input-group">
                        <div class="input-group-btn">
                           <button type="button" class="btn btn-primary" data-toggle="modal" 
                              data-target="#lista_compras">COMPRAS</button>
                        </div>
                        <!-- /btn-group -->
                        <input type="text" class="form-control" id="ncompra" readonly name="compra" value="">
                        <input type="hidden" class="form-control" id="idCompra" name="idCompra" value="">
                     </div>
                  </div>
                  <!-- /.form group -->
                  <!-- Modal -->
                     <?php 
                       include( "sub-scripts/tablas/tabla_compras_modal.php" );
                     ?>
                  <!-- /.Modal -->

                  <div class="form-group">
                      <div class="input-group date">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i> 
                              <label for="datepicker" class="iconlab">Fecha pago:</label>
                          </div>
                          <input type="text" class="form-control" id="fpago" name="fecha_pago" required readonly value="<?php echo $fecha_actual; ?>">
                      </div>
                  </div><!-- /.form group -->

                  <div id="bconcepto" class="form-group">
                    <!--<label for="ncontrol">Concepto</label>-->
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-quote-left"></i></div>
                        <input type="text" class="form-control" id="concepto" placeholder="Concepto" name="concepto" required>
                    </div>
                  </div><!-- /.form group -->

                  <div class="form-group">
                    <!--<label for="ncontrol">Beneficiario</label>-->
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user-circle-o"></i></div>
                        <input type="text" class="form-control" id="beneficiario" placeholder="Beneficiario" 
                        name="beneficiario" required>
                    </div>
                  </div><!-- /.form group -->

                  <div class="form-group">
                    <!--<label for="mbase">Monto</label>-->
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-circle-o"></i></div>
                        <input type="text" class="form-control" id="monto" placeholder="Monto" name="monto" required onkeypress="return isNumberKey(event)">
                    </div>
                  </div><!-- /.form group -->  
                  
                  <div id="bloc_mpagado" class="form-group">
                    <!--<label for="mbase">Monto pagado</label>-->
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-check-circle-o"></i></div>
                        <input type="text" class="form-control" id="mpagado" placeholder="Monto pagado" name="mpagado" required onkeypress="return isNumberKey(event)">
                    </div>
                  </div><!-- /.form group -->

                  <div class="form-group">
                    <select class="form-control" id="forma_pago" name="forma_pago">
                      <option value="0" disabled selected class="ofp">Forma de pago</option>
                      <option value="EF" class="ofp">Efectivo</option>
                      <option value="TR" class="ofp">Transferencia</option>
                      <option value="CH" class="ofp">Cheque</option>
                      <option value="TD" class="ofp">Tarjeta débito</option>
                      <option value="TC" class="ofp">Tarjeta crédito</option>
                    </select>
                  </div><!-- /.form group -->
                  
                  <div class="form-group">
                    <select class="form-control" id="cbanco" name="cbanco">
                      <option value="0" disabled selected class="ofp">Banco</option>
                      <?php foreach( $lctabanco as $c ) { ?>
                        <option value="<?php echo $c["dato2"]; ?>" class="ocb"><?php echo $c["dato2"]; ?></option>
                      <?php } ?>
                    </select>
                  </div><!-- /.form group -->

                  <div class="form-group">
                    <!--<label for="mbase">Num Operación</label>-->
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-wpforms"></i></div>
                        <input type="text" class="form-control" id="noper" placeholder="N° Operación" 
                        name="noper" required onkeypress="return isNumberKey(event)">
                    </div>
                  </div><!-- /.form group -->

                </div><!-- /.box-body -->

              <div class="box-footer" align="center">
                <button type="button" class="btn btn-primary original" id="bt_reg_gasto">Guardar</button>
                <button type="button" class="btn btn-primary" id="bt_reg_art_modal" style="display:none;">Guardar</button>
              </div>
            </form>
          </div><!-- /.box -->


          <!-- Bloque de respuesta del servidor -->
            <button type="button" id="enl_vmsj" data-toggle="modal" 
            data-target="#ventana_mensaje" class="_hidden"></button>
            <?php include("sub-scripts/nav/mensaje_respuesta.php");?>
          <!-- /.Bloque de respuesta del servidor -->
        </div><!--/.col (left) -->        
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

<?php
	/*
	* IIRG - Ficha de datos de cliente
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-cliente.php" );
  include( "bd/data-nota.php" );

  include( "fn/fn-documento.php" );
	checkSession( '' );
	if( isset( $_GET["c"] ) ){
		$cliente = obtenerClientePorId( $_GET["c"], $dbh );
    if( $cliente["excento"] == "excento" )  
      $exc_iva = "checked"; else $exc_iva = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | <?php echo $cliente["nombre"]?></title>
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
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
        //Datemask dd/mm/yyyy
		$("#crif").inputmask({mask: "a-99999999-9"});
		$("#ctel1").inputmask({mask: "(9999)-999.99.99"});
		$("#ctel2").inputmask({mask: "(9999)-999.99.99"});
      });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#frm_mcliente').bootstrapValidator({
                message: 'Revise el contenido del campo',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {
                        validators: { notEmpty: { message: 'Debe indicar un email' },
						emailAddress: { message: 'Debe especificar un email válido' } }
                    },
					nombre: {
                        validators: { notEmpty: { message: 'Debe indicar nombre' } }
                    },
					rif: {
                        validators: { notEmpty: { message: 'Debe indicar RIF' } }
                    }
                },
				callback: function () {
                	alert("OK");
                }
            });
        });
		
		
    </script>
    
    <script src="js/fn-clientes.js"></script>
    <style>
      .iconlab{ line-height: 0; }
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
            <div class="col-md-8">

              <div id="ficha_cliente" class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">DATOS DE CLIENTE</h3>
                    <div class="icon-color"><i class="fa fa-contao fa-2x"></i></div>
                  </div><!-- /.box-header -->           
                  
                  <div class="box-body">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                  
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Datos de cliente</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Modificar datos de cliente</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Detalles operaciones</a></li>
                    <!-- <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Más acciones <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Crear cotización</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Eliminar cliente</a></li>
                      </ul>
                    </li> -->
                    
                  </ul>
                  <div class="tab-content">                  
                    <div class="tab-pane active" id="tab_1">
                      <div><span class="txh"><b><?php echo $cliente["nombre"];?></b></span></div>
                      <div><span class="tx1"><?php echo $cliente["rif"];?></span></div>
                      <div><span class="tx1"><?php echo $cliente["direccion1"];?></span></div>
                      <div><span class="tx1"><?php echo $cliente["direccion2"];?></span></div>
                      <div class="info_tab3">
                      <div><span class="tx1"><span class="fa fa-envelope">                      
                      </span> <?php echo $cliente["email"];?></span></div>
                      <div><span class="tx1"><span class="fa fa-user">
                      </span> <?php echo $cliente["pcontacto"];?></span></div>
                      <div><span class="tx1"><span class="glyphicon glyphicon-phone-alt"></span> <?php echo $cliente["telefono1"];?></span></div>
                      <div><span class="tx1"><span class="glyphicon glyphicon-phone-alt"></span> <?php echo $cliente["telefono2"];?></span></div>
                      </div>
                    </div><!-- /.tab-pane -->
                                      
                    <div class="tab-pane" id="tab_2">
                      <form role="form" id="frm_mcliente" name="form_modificar_cliente" method="post" action="bd/data-cliente.php">
                        <input name="idCliente" type="hidden" value="<?php echo $cliente["idCliente"];?>">
                        <input name="mod_cliente" type="hidden" value="1">
                        
                        <div class="box-body">
                          <div class="form-group">
                            <!--<label for="exampleInputEmail1">Email address</label>-->
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-bookmark-o"></i>
                                  <label for="nombre" class="iconlab">Nombre:</label>
                                </div>
                                <input type="text" class="form-control" id="cnombre" placeholder="Nombre" name="nombre" 
                                required value="<?php echo $cliente["nombre"];?>">
                              </div>
                          </div><!-- /.form group -->

                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-registered"></i>
                                <label for="rif" class="iconlab">RIF:</label>
                              </div>
                              <input id="crif" type="text" class="form-control" placeholder="RIF" 
                              data-mask name="rif" value="<?php echo $cliente["rif"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                            
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-envelope-o"></i>
                                <label for="email" class="iconlab">Email:</label>
                              </div>
                              <input id="cemail" type="text" class="form-control" placeholder="Email" 
                              data-mask name="email" value="<?php echo $cliente["email"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                                <label for="pcontacto" class="iconlab">Persona de contacto:</label>
                              </div>
                              <input id="ccontacto" type="text" class="form-control" placeholder="Persona de contacto" name="pcontacto" value="<?php echo $cliente["pcontacto"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                                <label for="dir" class="iconlab">Dirección - 1 -</label>
                              </div>
                              <input id="cdir1" type="text" class="form-control bdir" placeholder="Dirección" 
                              data-mask name="direccion1" value="<?php echo $cliente["direccion1"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                                <label for="dir" class="iconlab">Dirección - 2 -</label>
                              </div>
                              <input id="cdir2" type="text" class="form-control bdir" placeholder="Dirección" 
                              data-mask name="direccion2" value="<?php echo $cliente["direccion2"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->

                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                                <label for="tel1" class="iconlab">Teléfono 1:</label>
                              </div>
                              <input id="ctel1" type="text" class="form-control" placeholder="Teléfono" 
                              data-mask name="telefono1" value="<?php echo $cliente["telefono1"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                                <label for="tel2" class="iconlab">Teléfono 2:</label>
                              </div>
                              <input id="ctel2" type="text" class="form-control" placeholder="Teléfono" 
                              data-mask name="telefono2" value="<?php echo $cliente["telefono2"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->

                          <div class="form-group">
                            <div class="input-group">
                              <div class="checkbox">
                                <label> <input type="checkbox" 
                                name="excento" <?php echo $exc_iva; ?> > Excento IVA</label>
                              </div>
                            </div>
                          </div><!-- /.form group -->
                        
                        </div><!-- /.box-body -->
      
                        <div class="box-footer" align="center">
                          <button type="submit" class="btn btn-primary" id="bt_mod_cliente">Guardar</button>
                        </div>
                      
                      </form>
                  	
                    </div>
                    <div class="tab-pane" id="tab_3">
                      <!-- Tabla operaciones cliente -->
                        <?php include("sub-scripts/tablas/tabla_doc_clientes.php"); ?>
                      <!-- /.Tabla operaciones cliente -->  
                    </div><!-- /.tab-pane -->

                    
                    </div><!-- /.tab-pane -->
                  </div><!-- /.tab-content -->
                    </div><!-- nav-tabs-custom -->

                  </div>
              </div>
                 
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
</body>
</html>

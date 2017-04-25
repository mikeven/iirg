<?php
	/*
	* IIRG - Ficha de datos de artículo
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
  include( "bd/data-forms.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-articulo.php" );
  include( "fn/fn-documento.php" );
	checkSession( '' );
	if( isset( $_GET["a"] ) ){
		$articulo = obtenerArticuloPorId( $_GET["a"], $dbh );
	}
  $unidades = obtenerUnidadesVenta( $dbh );
  $categorias = obtenerCategoriasArticulos( $dbh );
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | <?php echo $articulo["descripcion"]?></title>
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
            $('#frm_marticulo').bootstrapValidator({
                message: 'Revise el contenido del campo',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    descripcion: {
                        validators: { notEmpty: { message: 'Debe indicar descripción' } }
                    },
					          codigo: {
                        validators: { notEmpty: { message: 'Debe indicar código' } }
                    }
                },
				        callback: function () {
                	alert("OK");
                }
            });
        });
    </script>
    
    <script src="js/fn-articulos.js"></script>
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
          <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include("subforms/nav/menu_ppal.php");?>
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard <small>Version 2.0</small>
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
            <div class="col-md-8">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Datos de artículo</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Modificar datos de artículo</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Detalles operaciones</a></li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      Más acciones <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Eliminar artículo</a></li>
                    </ul>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div><span class="txh"><i class="fa fa-bookmark-o"></i>&nbsp;<b><?php echo $articulo["descripcion"];?></b></span></div>
                    <div><span class="tx1"><i class="fa fa-cube"></i>&nbsp;<?php echo $articulo["presentacion"];?></span></div>
                    <div><span class="tx1"><i class="fa fa-barcode">&nbsp;</i><?php echo $articulo["codigo"];?></span></div>
                    <div><span class="tx1"><i class="fa fa-sitemap">&nbsp;</i><?php echo $articulo["categoria"];?></span></div>
                    <div class="info_tab3">
                    </div>
                  </div><!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="tab_2">
                    <form role="form" id="frm_marticulo" name="form_modificar_articulo" action="bd/data-articulo.php" method="post">
                        <input name="mod_articulo" type="hidden" value="1">
                        <input name="idArticulo" type="hidden" value="<?php echo $articulo["idArticulo"];?>">
                        <div class="box-body">
                          <div class="form-group">
                            
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-bookmark-o"></i></div>
                                <input type="text" class="form-control" id="pdescripcion" placeholder="Descripción" name="descripcion" 
                                value="<?php echo $articulo["descripcion"];?>">
                              </div>
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                                  <input id="pcodigo" type="text" class="form-control" placeholder="Código" data-mask name="codigo" 
                                  value="<?php echo $articulo["codigo"];?>">
                              </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-cube"></i></div>
                                  <select name="presentacion" id="ppresentacion" class="form-control">
                                      <option value="0" disabled selected>Presentación</option>
                                      <?php foreach( $unidades as $u ){ $s = selop( $u["nombre"], $articulo["presentacion"] );?>
                                      <option value="<?php echo $u["nombre"] ?>" <?php echo $s;?>><?php echo $u["nombre"] ?></option>
                                      <?php } ?>
                            		  </select>
                              </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sitemap"></i></div>
                                  <select name="categoria" id="pcategoria" class="form-control">
                                      <option value="0" disabled>Categoría</option>
                                      <?php foreach( $categorias as $c ){ $s = selop( $c["nombre"], $articulo["categoria"] ); ?>
                                      <option value="<?php echo $c["idCategoria"]; ?>" <?php echo $s;?>><?php echo $c["nombre"]; ?></option>
                                      <?php } ?>
                                  </select>
                              </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                        </div><!-- /.box-body -->

                        <div class="box-footer" align="center">
                          <button type="submit" class="btn btn-primary" id="bt_reg_proveedor">Guardar</button>
                        </div>
                    </form>
                  </div><!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="tab_3">
                    <!-- Tabla operaciones artículo -->
                      <?php include("subforms/tablas/tabla_mov_articulo.php"); ?>
                    <!-- /.Tabla operaciones artículo --> 
                  </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

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
  <?php include("subforms/nav/footer.php"); ?>
  <!-- /.footer -->

  <!-- Panel de configuración -->
  <?php include("subforms/nav/panel_control.php"); ?>
  <!-- /.Panel de configuración -->

</div>
<!-- ./wrapper -->
</body>
</html>

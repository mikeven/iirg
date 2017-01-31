<?php
	/*
	* IIRG - Registro de nuevo proveedor
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-producto.php" );
	$categorias = obtenerCategoriasProductos( $dbh );
	checkSession( '' );
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Registro de productos</title>
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
      });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#frm_nproducto').bootstrapValidator({
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
		
		$( document ).ready(function() {
            $('#frm_ncategoria').bootstrapValidator({
                message: 'Revise el contenido del campo',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nombre: {
                        validators: { notEmpty: { message: 'Debe indicar nombre de categoría' } }
                    }
                },
				onSuccess: function(e, data) {
					e.preventDefault();
					reg_categoria( $('#frm_ncategoria') );
					//document.getElementById("frm_ncategoria").reset();
				}
            });
        });
    </script>
    <script src="js/fn-producto.js"></script>
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
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">AGREGAR NUEVO PRODUCTO</h3>
                  <div class="icon-color"><i class="fa fa-barcode fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_nproveedor" name="form_agregar_proveedor" action="bd/data-proveedor.php" method="post">
					<input name="reg_producto" type="hidden" value="1">
                    <div class="box-body">
                        <div class="form-group">
                        	<!--<label for="exampleInputEmail1">Email address</label>-->
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-bookmark-o"></i></div>
                              <input type="text" class="form-control" id="pdescripcion" placeholder="Descripción" name="descripcion">
                            </div>
                        </div><!-- /.form group -->
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                                <input id="pcodigo" type="text" class="form-control" placeholder="Código" data-mask name="codigo">
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        
                        <div class="form-group">
                        	<div class="input-group">
                            	<div class="input-group-addon"><i class="fa fa-dropbox"></i></div>
                              	<select name="presentacion" id="ppresentacion" class="form-control">
                                    <option value="0">Presentación</option>
                                    <option value="BLT">BLT</option>
                                    <option value="CAJ">CAJ</option>
                                    <option value="LTR">LTR</option>
                                    <option value="PAQ">PAQ</option>
                                    <option value="RES">RES</option>
                                    <option value="UND">UND</option>
                              	</select>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        
                        <div class="form-group">
                        	<div class="input-group">
                            	<div class="input-group-addon"><i class="fa fa-cube"></i></div>
                              	<select name="categoria" id="pcategoria" class="form-control">
                                    <option value="0">Categoria</option>
                                    <?php foreach( $categorias as $c ){ ?>
                                    <option value="<?php echo $c["idCategoria"]; ?>"><?php echo $c["nombre"]; ?></option>
                                    <?php } ?>
                              	</select>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        
                  </div><!-- /.box-body -->

                  <div class="box-footer" align="center">
                    <button type="submit" class="btn btn-primary" id="bt_reg_proveedor">Guardar</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">AGREGAR CATEGORÍA DE PRODUCTO</h3>
                  <div class="icon-color"><i class="fa fa-cube fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_ncategoria" name="form_agregar_categoria" method="post">
                    <div class="box-body">
                        <div class="form-group">
                        	<!--<label for="exampleInputEmail1">Email address</label>-->
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                              <input type="text" class="form-control" id="cnombre" placeholder="Nombre" name="nombre">
                            </div>
                        </div><!-- /.form group -->
                        <div class="form-group">
                        	<!--<label for="exampleInputEmail1">Email address</label>-->
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                              <input type="text" class="form-control" id="cdescripcion" placeholder="Descripción" name="descripcion">
                            </div>
                        </div><!-- /.form group -->
                  </div><!-- /.box-body -->

                  <div class="box-footer" align="center">
                    <button type="submit" class="btn btn-primary" id="bt_reg_categoria">Guardar</button>
                  </div>
                </form>
              </div><!-- /.box -->
              
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">LISTA DE CATEGORÍAS</h3>
                        <div class="icon-color"><i class="fa fa-cubes fa-2x"></i></div>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="frm_lcategorias" name="form_lista_categorias">
                    	<div class="box-body">
                            <table class="table table-condensed">
                                <tbody><tr>
                                  <th width="35%">Categoría</th>
                                  <th width="60%">Descripción</th>
                                  <th width="5%"></th>
                                </tr>
                                <?php foreach( $categorias as $c ){ ?>
                                <tr>
                                  <td>
                                    <div class="input-group input-space">
                                        <input id="<?php echo $c["idCategoria"]; ?>" type="text" 
                                        class="form-control lncat input-sm" value="<?php echo $c["nombre"]; ?>">
                                    </div><!-- /.input group -->
                        		  </td>
                                  <td>
                                    <div class="input-group input-space">
                                        <input id="<?php echo $c["idCategoria"]; ?>" type="text" 
                                        class="form-control ldcat input-sm" value="<?php echo $c["descripcion"]; ?>">
                                    </div><!-- /.input group -->
                                    </td>
                                  <td><button class="btn btn-danger">Eliminar</button></td>
                                </tr>
                                <?php } ?>
                              </tbody></table>
                          </div>    
                    </form>
                </div><!-- /.box -->
            
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

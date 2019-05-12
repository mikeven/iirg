<?php
	/*
	* IIRG - Gestión de categorías de artículos y unidades de venta
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-articulo.php" );
  	$unidades = obtenerUnidadesVenta( $dbh );
	$categorias = obtenerCategoriasArticulos( $dbh );
	checkSession( '' );
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Categorías y Unidades</title>
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
    <link rel="stylesheet" type="text/css" href="plugins/bootstrapvalidator-dist-0.5.3/dist/css/bootstrapValidator.css">
    <style>
    	.input-space{ width:95%; }
      .input-space98{ width:98%; }
      .chkupdt{ color: green; font-size:17px; } .chkupdt_e{ color: red; font-size:17px; }
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
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
      });
    </script>
    <script type="text/javascript">
      $( document ).ready(function() {
        $(".chkupdt").hide();
        $(".chkupdt_e").hide();
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


        $('#frm_nuv').bootstrapValidator({
          message: 'Revise el contenido del campo',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
              unidad: {
                  validators: { notEmpty: { message: 'Debe indicar nombre de unidad' } }
              }
          },
          onSuccess: function(e, data) {
            e.preventDefault();
            reg_unidad();
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
                  <h3 class="box-title">AGREGAR CATEGORÍA</h3>
                  <div class="icon-color"><i class="fa fa-sitemap fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_ncategoria" name="form_agregar_categoria" action="bd/data-articulo.php" method="post">
					          <input name="reg_articulo" type="hidden" value="1">
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
                                <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                                <input id="cdescripcion" type="text" class="form-control" placeholder="Descripción" name="descripcion">
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        
                    </div><!-- /.box-body -->

                    <div class="box-footer" align="center">
                      <button type="submit" class="btn btn-primary" id="bt_reg_proveedor">Guardar</button>
                    </div>
                
                </form>

              </div><!-- /.box -->

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">MODIFICAR CATEGORÍAS</h3>
                  <div class="icon-color"><i class="fa fa-sitemap fa-2x"></i></div>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                  <table class="table table-condensed" id="lista_categorias">
                      <tbody>
                          <?php $ni = 0;
                            foreach( $categorias as $ctg ){ $ni++; ?>
                              <tr id="ca<?php echo $ni; ?>">
                                <th width="20%" class="tit_tdf_i">
                                  <div class="input-group input-space">
                                    <input type="text" class="form-control lncat" id="<?php echo $ctg["idCategoria"]; ?>" 
                                    value="<?php echo $ctg["nombre"]; ?>">
                                  </div>
                                </th>
                                <th width="70%" class="tit_tdf_i">
                                  <div class="input-group input-space98">
                                    <input type="text" class="form-control ldcat" id="<?php echo $ctg["idCategoria"]; ?>" 
                                    value="<?php echo $ctg["descripcion"]; ?>">
                                  </div>
                                </th>
                                <th width="3%" class="tit_tdf">
                                  <i class="fa fa-check-square-o chkupdt" id="chk<?php echo $ctg["idCategoria"]; ?>"></i>
                                  <i class="fa fa-times chkupdt_e" id="chkce<?php echo $ctg["idCategoria"]; ?>"></i>
                                </th>
                                <th width="7%" class="tit_tdf_d">
                                  <button type="button" class="btn btn-block btn-danger erc" data-idu="<?php echo $ni; ?>">
                                    <i class='fa fa-times'></i>
                                  </button>
                                </th>
                              </tr>
                          <?php } ?>
                      </tbody>
                  </table>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->


            </div><!--/.col (left) -->
            
            <div class="col-md-6"><!--/Columna derecha -->
            	
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">AGREGAR UNIDAD DE VENTA</h3>
                  <div class="icon-color"><i class="fa fa fa-cube fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_nuv" name="form_agregar_unidad_venta" action="bd/data-articulo.php" method="post">
					          <input name="reg_unidad" type="hidden" value="1">
                    <div class="box-body">
                        <div class="form-group">
                        	<!--<label for="exampleInputEmail1">Email address</label>-->
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-cube"></i></div>
                              <input type="text" class="form-control" id="cuv" placeholder="Unidad" name="unidad" 
                              maxlength="4" onKeyUp="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div><!-- /.form group -->
                        
                    </div><!-- /.box-body -->

                    <div class="box-footer" align="center">
                      <button type="submit" class="btn btn-primary" id="bt_reg_unidad">Guardar</button>
                    </div>
                
                </form>
              </div><!-- /.box -->	

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">UNIDADES DE VENTA REGISTRADAS</h3>
                  <div class="icon-color"><i class="fa fa fa-cubes fa-2x"></i></div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-condensed" id="lista_udv">
                      <tbody>
                          <?php $ni = 0;
                            foreach( $unidades as $u ){ $ni++; ?>
                              <tr id="ru<?php echo $u["idUnidad"]; ?>">
                                <th width="90%" class="tit_tdf_i">
                                  <div class="input-group input-space98">
                                    <input type="text" class="form-control lnund" maxlength="4" id="<?php echo $u["idUnidad"]; ?>" 
                                    value="<?php echo $u["nombre"]; ?>" onKeyUp="javascript:this.value=this.value.toUpperCase();">
                                  </div>
                                </th>
                                <th width="3%" class="tit_tdf">
                                  <i class="fa fa-check-square-o chkupdt" id="chku<?php echo $u["idUnidad"]; ?>"></i>
                                  <i class="fa fa-times chkupdt_e" id="chkue<?php echo $u["idUnidad"]; ?>"></i>
                                </th>
                                <th width="7%" class="tit_tdf_d">
                                  <button type="button" class="btn btn-block btn-danger euv" data-idu="<?php echo $u["idUnidad"]; ?>">
                                    <i class='fa fa-times'></i>
                                  </button>
                                </th>
                              </tr>
                          <?php } ?>
                      </tbody>
                  </table>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->  

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

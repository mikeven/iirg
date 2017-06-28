<?php
	/*
	* IIRG - Ficha de datos de cliente
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	checkSession( '' );
	
  $usuario = obtenerUsuarioPorId( $_SESSION["user"]["idUsuario"], $dbh );
  $lbancos = obtenerListaBancos();
  $lctabanco = obtenerListaCuentasBancarias( $dbh,  $_SESSION["user"]["idUsuario"] );
  $nombre_usuario = $usuario["nombre"];
  $title = $usuario["empresa"];
  if( $usuario["empresa"] == "" ) $title = $nombre_usuario;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | <?php echo $title;?></title>
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
    
    <script src="js/fn-usuario.js"></script>
    <script src="js/fn-ui.js"></script> 
    
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
            initValid();
            $(".alert").hide();
            $(".alert").click( function(){  $(this).hide(350);  });
            $(".act_du").click( function(){  $(".alert").hide(100);  });
        });
    </script>
    
    <style>
      .iconlab{ line-height: 0; } 
      .width-usuario{ width: 50%; }
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
        <div class="col-md-10">
        
          <div id="ficha_cuenta" class="box box-primary">
            
            <div class="box-header with-border">
              <h3 class="box-title">DATOS DE CUENTA DE USUARIO</h3>
              <div class="icon-color"><i class="fa fa-barcode fa-2x"></i></div>
            </div><!-- /.box-header -->           
            
            <div class="box-body">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#dcuenta" data-toggle="tab">Datos de cuenta</a></li>
                  <li><a href="#dempresa" data-toggle="tab">Modificar datos de empresa</a></li>
                  <li><a href="#dbancos" data-toggle="tab">Cuentas bancarias</a></li>
                  <li><a href="#dusuario" data-toggle="tab">Modificar datos de usuario</a></li>
                  <li><a href="#dpassw" data-toggle="tab">Modificar contraseña</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="dcuenta">
                    <div><span class="txh"><b> <i class="fa fa-smile-o"></i>
                    <?php echo $nombre_usuario;?></b></span></div>
                    <div><span class="txh"><b> <i class="fa fa-user"></i> 
                    <?php echo $usuario["usuario"];?></b></span></div>
                    <hr>
                    <div><b><i class="fa fa-industry"></i> Empresa: </b><span class="tx1"> <?php echo $usuario["empresa"];?></span></div>
                    <div><b><i class="fa fa-black-tie"></i> Subtítulo: </b><span class="tx1"> <?php echo $usuario["subtitulo"];?></span></div>
                    <div><b><i class="fa fa-map-marker"></i> Dirección -1-: </b><span class="tx1"> <?php echo $usuario["direccion1"];?></span></div>
                    <div><b><i class="fa fa-map-marker"></i> Dirección -2-: </b><span class="tx1"> <?php echo $usuario["direccion2"];?></span></div>
                    <div><b><i class="fa fa-registered"></i> RIF: </b><span class="tx1"> <?php echo $usuario["rif"];?></span></div>
                    <div><b><i class="fa fa-phone-square"></i> Teléfonos: </b><span class="tx1"> <?php echo $usuario["telefonos"];?></span></div>
                    <div><b><i class="fa fa-at"></i> Emails: </b><span class="tx1"> <?php echo $usuario["email"];?></span></div>
                    <div><b><i class="fa fa-briefcase"></i> Vendedor: </b><span class="tx1"> <?php echo $usuario["vendedor"];?></span></div>
                  </div><!-- /.tab-pane -->
                  <!-- ................................................................................... -->
                  <div class="tab-pane" id="dempresa">
                    <form role="form" id="frm_mcuenta" name="form_modificar_cuenta" method="post">
                      <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
                      <input name="mod_empresa" type="hidden" value="1">
                      <div class="box-body">
                        <div class="form-group">
                          <!--<label for="empresa">Empresa</label>-->
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-industry"></i>
                                <label for="nombre" class="iconlab">Empresa:</label>
                              </div>
                              <input type="text" class="form-control" id="cnombre" name="empresa" 
                              required value="<?php echo $usuario["empresa"];?>">
                            </div>
                        </div><!-- /.form group -->
                        <div class="form-group">
                          <!--<label for="subtitulo">Subtítulo</label>-->
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-black-tie"></i>
                                <label for="nombre" class="iconlab">Subtítulo:</label>
                              </div>
                              <input type="text" class="form-control" id="cnombre" name="subtitulo" 
                              required value="<?php echo $usuario["subtitulo"];?>">
                            </div>
                        </div><!-- /.form group -->
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-registered"></i>
                              <label for="rif" class="iconlab">RIF:</label>
                            </div>
                            <input id="crif" type="text" class="form-control" name="rif" value="<?php echo $usuario["rif"];?>">
                          </div><!-- /.input group -->
                        </div><!-- /.form group -->
                         <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                                <label for="email" class="iconlab">Dirección -1-</label>
                              </div>
                              <input id="cemail" type="text" class="form-control" name="direccion1" 
                              value="<?php echo $usuario["direccion1"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                                <label for="email" class="iconlab">Dirección -2-</label>
                              </div>
                              <input id="cemail" type="text" class="form-control" name="direccion2" 
                              value="<?php echo $usuario["direccion2"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-phone-square"></i>
                                <label for="pcontacto" class="iconlab">Teléfonos:</label>
                              </div>
                              <input id="ccontacto" type="text" class="form-control" name="telefonos" 
                              value="<?php echo $usuario["telefonos"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-at"></i>
                                <label for="dir" class="iconlab">Email</label>
                              </div>
                              <input id="cdir1" type="text" class="form-control" name="email" value="<?php echo $usuario["email"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->

                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-briefcase"></i>
                                <label for="vendedor" class="iconlab">Vendedor</label>
                              </div>
                              <input id="clvend" type="text" class="form-control" name="vendedor" value="<?php echo $usuario["vendedor"];?>">
                            </div><!-- /.input group -->
                          </div><!-- /.form group -->
                          
                      </div><!-- /.box-body -->
    
                      <div class="box-footer" align="center">
                        <button type="submit" class="btn btn-primary act_du" id="bt_mod_cuenta">Guardar</button>
                      </div>
              	    </form>
                  </div><!-- /.tab-pane -->
                  <!-- ................................................................................... -->
                  <div class="tab-pane width-usuario" id="dbancos">
                    <form role="form" id="frn_cta_banco" name="form_agregar_banco">
                      <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
                      <div class="box-body">
                        <dt>Agregar cuenta bancaria</dt>
                        <hr>
                        <div class="form-group">
                          <select class="form-control" id="banco">
                            <option value="0" disabled selected class="lb">Banco</option>
                            <?php foreach( $lbancos as $b ) { ?>
                              <option value="<?php echo $b; ?>" class="lb"><?php echo $b; ?></option>                             
                            <?php } ?>                          
                          </select>
                        </div><!-- /.form group -->
                        
                        <div class="form-group">
                          <!--<label for="subtitulo">Subtítulo</label>-->
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-pencil-square-o"></i> </div>
                              <input type="text" class="form-control" id="bdescripcion" name="descripcion" 
                              required placeholder="Descripción" value="">
                            </div>
                        </div><!-- /.form group -->
                          
                      </div><!-- /.box-body -->
    
                      <div class="box-footer" align="center">
                        <button type="button" class="btn btn-primary act_du" id="bt_ag_ctab">Guardar</button>
                      </div>

                      <!-- Bloque de respuesta del servidor -->
                      <button type="button" id="enl_vmsj" data-toggle="modal" data-target="#ventana_mensaje" 
                      class="hidden"></button>
                      <?php include("sub-scripts/nav/mensaje_respuesta.php"); ?>
                      <!-- /.Bloque de respuesta del servidor -->

                    </form>
                    <hr>
                    <dt>Lista de cuentas registradas</dt>
                    <hr>
                    
                    <table id="lbancos_usuario" class="table table-bordered">
                      <tbody>
                        <tr><th>Banco</th><th>Descrición</th><th></th></tr>
                        <?php foreach( $lctabanco as $c ) { ?>
                          <tr id="cb<?php echo $c["idDato"];?>">
                            <th><?php echo $c["dato1"] ?></th>
                            <th><?php echo $c["dato2"] ?></th>
                            <th>
                              <button type="button" class="btn btn-block btn-danger btn-xs ecb" 
                              onclick="elimRegCA(<?php echo $c["idDato"];?>)">
                              <i class="fa fa-times"></i></button>
                            </th>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>

                  </div><!-- /.tab-pane -->
                  <!-- ................................................................................... -->
                  <div class="tab-pane" id="dusuario">
                    <form role="form" id="frm_musuario" name="form_m_usuario" method="post">
                  <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
                  <input name="mod_usuario" type="hidden" value="1">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <!--<label for="nombre">Nombre</label>-->
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-smile-o"></i>
                            <label for="nombre" class="iconlab">Nombre:</label>
                          </div>
                          <input type="text" class="form-control" id="unombre" name="nombre" 
                          value="<?php echo $usuario["nombre"];?>">
                        </div>
                    </div><!-- /.form group -->
                    
                    <div class="form-group">
                      <!--<label for="usuario">Usuario</label>-->
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                            <label for="usuario" class="iconlab">Usuario:</label>
                          </div>
                          <input type="text" class="form-control" id="cnombre" name="usuario" 
                          required value="<?php echo $usuario["usuario"];?>">
                        </div>
                    </div><!-- /.form group -->
                      
                  </div><!-- /.box-body -->

                  <div class="box-footer" align="center">
                    <button type="submit" class="btn btn-primary act_du" id="bt_mod_usuario">Guardar</button>
                  </div>
                    </form>  
                  </div><!-- /.tab-pane -->
                  <!-- ................................................................................... -->
                  <div class="tab-pane" id="dpassw">
                    <form role="form" id="frm_mpassw" name="form_m_passw" method="post" action="bd/data-usuario.php">
                  <input name="idUsuario" type="hidden" value="<?php echo $usuario["idUsuario"];?>">
                  <input name="mod_passw" type="hidden" value="1">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-lock"></i>
                          <label for="rif" class="iconlab">Password:</label>
                        </div>
                        <input id="upass1" type="password" class="form-control" name="password1" value="">
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-lock"></i>
                          <label for="email" class="iconlab">Confirmar nuevo password:</label>
                        </div>
                        <input id="upass2" type="password" class="form-control" name="password2" value="">
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                      
                  </div><!-- /.box-body -->

                  <div class="box-footer" align="center">
                    <button type="submit" class="btn btn-primary act_du" id="bt_mod_passw">Guardar</button>
                  </div>
                    </form>   
                  </div><!-- /.tab-pane -->
              
                  

                </div><!-- /.tab-content -->

              </div><!-- /.nav-tabs-custom -->
            
            </div><!-- /.box-body -->

          </div><!-- /.box-primary -->

        </div><!--/.col (left) -->
        
        <!-- right column -->
        <div class="col-md-2">
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

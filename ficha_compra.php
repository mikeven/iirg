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
	include( "bd/data-compra.php" );
  include( "bd/data-documento.php" );
  include( "bd/data-proveedor.php" );
	checkSession( '' );
	
  if( isset( $_GET["id"] ) ){
    $compra = obtenerCompraPorId( $dbh, $_GET["id"], $_SESSION["user"]["idUsuario"] );
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | <?php echo $compra["proveedor"]?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
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
            <?php if( $compra["estado"] == "creada" ) { ?>
            iniciarVentanaConfirmacion( "bt_edo_compra", "Eliminar compra" );
            <?php } ?>
            <?php if( $compra["estado"] == "eliminada" ) { ?>
            iniciarVentanaConfirmacion( "bt_edo_compra", "Recuperar compra" );
            <?php } ?>
        });
    </script>
    
    <script src="js/fn-compras.js"></script>
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
          <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
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
              <!-- Custom Tabs -->
              <div id="ficha_compra" class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">DATOS DE COMPRA</h3>
                  <div class="icon-color"><i class="fa fa-shopping-cart fa-2x"></i></div>
                </div><!-- /.box-header -->           
                <div class="box-body">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">Datos de compra</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Modificar datos de compra</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <div>
                          <span class="txh"><i class="fa fa-bookmark-o"></i>&nbsp;
                          <b>Proveedor: <?php echo $compra["proveedor"];?></b></span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa-calendar"></i>&nbsp;
                          Fecha emisión: <?php echo $compra["femision"];?></span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa-calendar"></i>&nbsp;
                          Registrada: <?php echo $compra["fregistro"];?></span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa fa-slack"></i>&nbsp;
                          Número de control: <?php echo $compra["ncontrol"];?></span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa-file-text-o"></i>&nbsp;
                          Número de factura: <?php echo $compra["nfactura"];?></span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa-file-text-o"></i>&nbsp;
                          Número de retención: <?php echo $compra["nret"];?></span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa-file-text-o"></i>&nbsp;
                          Monto base: <?php echo number_format( $compra["mbase"], 2, ",", "." );?></span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa-percent"></i>&nbsp;
                          IVA: <?php echo $compra["iva"]; ?>
                          </span>
                        </div>
                        <div><span class="tx1">
                          <i class="fa fa-percent"></i>&nbsp;
                          Retención IVA: <?php echo "(".number_format( $compra["pret"], 0, ",", "." )."%)"." ".
                          number_format( $compra["retencion"], 2, ",", "." ); ?>
                          </span>
                        </div>
                        <?php if( $compra["estado"] == "eliminada" ) { ?>
                          <hr>
                          <div><span class="tx1 text-red"><i class="fa fa-window-close"></i>&nbsp;ELIMINADA</span>
                          </div>
                        <?php } ?>
                        <hr>
                        
                        <?php if( $compra["estado"] == "creada" ) { ?>
                        <div class="box-footer" align="right">
                          <input type="hidden" id="edoaccion" value="eliminada">                          
                          <button type="button" class="btn btn-danger original btn_edo_accion" id="btn_confirmacion" 
                          data-toggle="modal" data-target="#ventana_confirmacion">Eliminar</button>
                        </div>
                        <?php } ?>

                        <?php if( $compra["estado"] == "eliminada" ) { ?>
                        <div class="box-footer" align="right">
                          <input type="hidden" id="edoaccion" value="creada">
                          <button type="button" class="btn btn-success original btn_edo_accion" id="btn_confirmacion" 
                          data-toggle="modal" data-target="#ventana_confirmacion">Recuperar</button>
                        </div>
                        <?php } ?>

                        <button type="button" id="enl_vmsj" data-toggle="modal" 
                          data-target="#ventana_mensaje" class="hidden"></button>
                        <?php
                          include("sub-scripts/nav/mensaje_respuesta.php");
                          include( "sub-scripts/nav/mensaje_confirmacion.php" );
                        ?>
                        <div class="info_tab3">
                        </div>
                      </div><!-- /.tab-pane -->
                      
                      <div class="tab-pane" id="tab_2">
                        <form role="form" id="frm_mcompra" name="form_modificar_compra">
                            <input id="idCompra" name="idCompra" type="hidden" value="<?php echo $compra["idcompra"];?>">
                            <div class="box-body">                          
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-btn">
                                       <button type="button" class="btn btn-primary" data-toggle="modal" 
                                          data-target="#lista_proveedores">PROVEEDOR</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" id="nproveedor" readonly name="nombre_proveedor" value="<?php echo $compra["proveedor"]; ?>">
                                    <input type="hidden" class="form-control" id="idProveedor" 
                                    name="idProveedor" value="<?php echo $compra["idp"]; ?>">
                                 </div>
                              </div>
                              <!-- /.form group -->
                              <!-- Modal -->
                                 <?php 
                                   include( "sub-scripts/tablas/tabla_proveedores_modal.php" );
                                 ?>
                              <!-- /.Modal -->
                              
                              <div class="form-group">
                                  <div class="input-group date">
                                      <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i> 
                                          <label for="datepicker" class="iconlab">Fecha emisión:</label>
                                      </div>
                                      <input type="text" class="form-control" id="femision" name="fecha_emision" required readonly value="<?php echo $compra["femision"]; ?>">
                                  </div>
                              </div><!-- /.form group -->
                              
                              <div class="form-group">
                                <label for="ncontrol">N° Control</label>
                                  <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa fa-slack"></i></div>
                                    <input type="text" class="form-control" id="ncontrol" placeholder="N° Control" name="ncontrol" required value="<?php echo $compra["ncontrol"]; ?>">
                                  </div>
                              </div><!-- /.form group -->
                              
                              <div class="form-group">
                                <label for="nfactura">N° Factura</label>
                                  <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa fa-slack"></i></div>
                                    <input type="text" class="form-control" id="nfactura" placeholder="N° Factura" name="nfactura" required value="<?php echo $compra["nfactura"]; ?>">
                                </div>
                              </div><!-- /.form group -->

                              <div class="form-group">
                                <label for="nfactura">N° Retención</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa fa-slack"></i></div>
                                  <input type="text" class="form-control" id="nret" placeholder="N° Retención" 
                                    name="nret" value="<?php echo $compra["nret"]; ?>">
                                </div>
                              </div><!-- /.form group -->

                              <div class="form-group">
                                <label for="mbase">Monto base</label>
                                <div class="input-group">
                                  <div class="input-group-addon">                                  
                                    <label for="datepicker" class="iconlab">BsF</label>
                                  </div>
                                  <input type="text" class="form-control" id="mbase" placeholder="Monto Base" name="mbase" required onkeypress="return isNumberKey(event)" 
                                  value="<?php echo number_format( $compra["mbase"], 2, ".", "" ); ?>">
                                </div>
                              </div><!-- /.form group -->  
                              
                              <div class="form-group">
                                <label for="iva">IVA</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-percent"></i>                          
                                  </div>
                                  <input type="text" class="form-control" id="iva" placeholder="IVA" name="iva" required onkeypress="return isNumberKey(event)" 
                                  value="<?php echo $compra["iva"]; ?>">
                                </div>
                              </div><!-- /.form group -->

                              <div class="form-group">
                                <select class="form-control" id="retencion" name="retencion">
                                  <option value="0.75" class="ori" 
                                  <?php echo selop( 0.75, $compra["vret"] );?>>Retención 75%</option>
                                  <option value="1" class="ori" 
                                  <?php echo selop( 1, $compra["vret"] );?>>Retención 100%</option>
                                </select>
                              </div><!-- /.form group -->
                                
                            </div><!-- /.box-body -->
                          <div class="box-footer" align="center">
                            <button type="button" class="btn btn-primary original" id="bt_mod_compra">Guardar</button>
                          </div>
                        </form>

                      </div><!-- /.tab-pane -->
                      
                      <div class="tab-pane" id="tab_3">
                        <!-- Tabla operaciones artículo -->
                          <?php include("sub-scripts/tablas/tabla_mov_articulo.php"); ?>
                        <!-- /.Tabla operaciones artículo --> 
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

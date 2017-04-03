<?php
	/*
	* IIRG - Registro de nueva cotización
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-articulo.php" );
	include( "bd/data-cliente.php" );
	include( "bd/data-formato.php" );
  include( "bd/data-documento.php" );
	include( "bd/data-cotizacion.php" );
  include( "bd/data-forms.php" );
	include( "fn/fn-formato.php" );
  //require_once( 'lib/FirePHPCore/fb.php' );
	
	checkSession( '' );
  if( isset( $_GET["id"] ) ){
    $idc = $_GET["id"];
    $cotizacion = obtenerCotizacionPorId( $dbh, $idc );
    $encabezado = $cotizacion["encabezado"];
    $detalle = $cotizacion["detalle"];
    $nitems = count( $detalle );
    $iva = $encabezado["iva"];
    $eiva = $iva * 100;
    $totales = obtenerTotales( $detalle, $encabezado["iva"] );
  }

  $condiciones = obtenerCondiciones( $dbh, "cotizacion" );
  $id_cond_defecto = obtenerIdCondicion( $dbh, "cotizacion", "1 días" );

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Editar cotización</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
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
    <!--<link rel="stylesheet" type="text/css" href="plugins/bootstrapvalidator-dist-0.5.3/dist/css/bootstrapValidator.css">-->
    <style>
    	.input-space{	width:95%; }
		  .itemtotal_detalle, .itemtotaldocumento{ width:95%; border:0; background:#FFF; text-align:right;}
  		.totalitem_detalle, .totalizacion{ width:100%; text-align:right; }
  		.tit_tdf_i{ text-align: left; } .tit_tdf{ text-align: center; } .tit_tdf_d{ text-align: right; }
  		.iconlab{ line-height: 0; }
  		.form-group { margin-bottom: 5px; }
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
    
	  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
    
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>
    
    <script>
      $( document ).ready(function() {
          iniciarVentanaConfirmacion( "bt_edit_cotizacion", "Editar cotización" );
      });
    </script>

    <script src="js/fn-documento.js"></script>
    <script src="js/fn-cotizacion.js"></script>
    
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
  <?php 
    /*$frt_c = obtenerFormatoPorUsuarioDocumento( $dbh, "ctz", $usuario["idUsuario"] );
    $obs = obtenerFormatoObservacionesCtz( $frt_c );*/
  ?>
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
            <div class="col-md-12">
              <!-- general form elements -->
				      <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title">EDITAR COTIZACIÓN</h3>                  
                  <div class="icon-color nuevo-reg-icono">
                    <a href="#!"><i class="fa fa-copy fa-2x"></i></a>
                  </div>
                  <div class="icon-color"><i class="fa fa fa-book fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_ecotizacion" name="form_editar_cotizacion" class="frm_documento">
                	<input id="id_cotizacion" type="hidden" value="<?php echo $idc; ?>">
                    <div class="box-body">
                    	<div class="row" id="encabezado_cotizacion">
                    		  <div class="col-md-6">
                              <div class="form-group">
                                  <div class="input-group">
                                      <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary blq_bdoc" data-toggle="modal" 
                                        data-target="#lista_clientes">CLIENTE</button>
                                      </div>
                                      <!-- /btn-group -->
                                      <input type="text" class="form-control" id="ncliente" readonly name="nombre_cliente" 
                                      value="<?php echo $encabezado["nombre"]; ?>">
                                      <input type="hidden" class="form-control" id="idCliente" 
                                      value="<?php echo $encabezado["idcliente"]; ?>">
                                      <input type="hidden" class="form-control" id="tipo" value="<?php echo $encabezado["tipo"]; ?>">
                                  </div>
                              </div><!-- /.form group -->
                              <!-- Modal -->
                              	<?php include( "subforms/tablas/tabla_clientes_modal.php" ); ?>
                              <!-- /.Modal -->
                              <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <div class="input-group date">
                                          <div class="input-group-addon">
                                              <i class="fa fa-calendar"></i> 
                                              <label for="datepicker" class="iconlab">Fecha emisión:</label>
                                          </div>
                                          <input type="text" class="form-control" id="femision" name="fecha_emision" required readonly 
                                          value="<?php echo $encabezado["femision"];?>">
                                      </div>
                                  </div><!-- /.form group -->
                              </div>
                              
                              <div class="col-md-6">
                                  <div class="form-group">
                                        <!--<label for="fcondpago" class="">Validez:</label>-->
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                            <select name="validez" id="vcondicion" class="form-control blq_bdoc">
                                                <option value="0" disabled>Validez</option>
                                                <?php foreach ( $condiciones as $c ) { 
                                                  echo opCondicion( $encabezado, $c );
                                                }?>                                                
                                            </select>
                                            <input id="condicion_defecto" type="hidden" value="<?php echo $id_cond_defecto; ?>">
                                            <input id="estado" type="hidden" value="pendiente">
                                        </div><!-- /.input group -->
                                    </div><!-- /.form group -->
                  			       </div>
                              </div>
                              
                              <div class="row"><!-- 3era fila -->
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <div class="input-group date">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-slack"></i> 
                                                  <label for="datepicker" class="iconlab">N°:</label>
                                              </div>
                                              <input type="text" class="form-control" id="ncotiz" name="numero" required readonly 
                                              value="<?php echo $encabezado["nro"]; ?>">
                                          </div>
                                      </div><!-- /.form group -->
                                  </div>
                                  <div class="col-md-8">
                                  	<div class="form-group">
                                          <!--<label for="fcondpago" class="">Validez:</label>-->
                                          <div class="input-group">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-user"></i> 
                                                  <label for="datepicker" class="iconlab">P. Contacto:</label>
                                              </div>
                                              <input type="text" class="form-control" id="cpcontacto" name="pcontacto" required 
                                              value="<?php echo $encabezado["pcontacto"]; ?>">
                                          </div><!-- /.input group -->
                                      </div><!-- /.form group -->	
                                  </div>
                              </div><!-- /.3era fila -->
                            
                            </div><!--/.columna izquierda-->
                            
                            <div class="col-md-6">
                            	<div id="articulos_cotizacion">
                                	<!--<div style="padding:11px 0 10px 0;"><span class="lead">Ítems de cotizacion</span></div>-->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-info blq_bdoc" data-toggle="modal" 
                                              data-target="#lista_articulos">ARTÍCULO</button>
                                            </div>
                                            <!-- /btn-group -->
                                            <input type="text" class="form-control" id="narticulo" readonly>
                                            <input type="hidden" id="idArticulo" value="0">
                                            <input type="hidden" id="und_art" value="0">
                                        </div>
                                    </div><!-- /.form group -->
                                    <!-- Lista de artículos en sistema -->
                                    <?php include( "subforms/tablas/tabla_articulos_modal.php" ); ?>
                                    <!-- /.Lista de artículos en sistema -->
                                    
                                    <div class="row" id="sumador_items">
                                      <div class="col-md-6">
                                      	<div class="form-group">
                                              <!--<label for="cantidad" class="">Cantidad:</label>-->
                                              <div class="input-group">
                                                  <div class="input-group-addon"><i class="fa fa-unsorted"></i></div>
                                                  <input type="text" class="form-control itemtotal" id="cantidad" name="cantidad" 
                                                  placeholder="CANT" onkeypress="return isIntegerKey(event)">
                                              </div>
                                          </div><!-- /.col -->
                                      </div><!-- /.form group -->
                                      <div class="col-md-6">
                                      	<div class="form-group">
                                              <!--<label for="punit" class="">Precio unitario:</label>-->
                                              <div class="input-group">
                                                  <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                                                  <input type="text" class="form-control itemtotal" id="punit" name="punit" 
                                                  placeholder="P.Unit" onkeypress="return isNumberKey(event)">
                                              </div>
                                          </div><!-- /.form group -->
                                      </div><!-- /.col -->
                                    
                                      <div class="col-md-6">
                                      	<div class="form-group">
                                              <!--<label for="punit" class="">Total item:</label>-->
                                              <div class="input-group">
                                                  <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                                                  <input type="text" class="form-control" id="ptotal" name="ptotal" 
                                                  placeholder="Total" value="0.00" readonly>
                                              </div>
                                          </div><!-- /.form group -->
                                      </div><!-- /.col -->
                                      <div class="col-md-6">
                                      	<button class="btn btn-block btn-success blq_bdoc" type="button" id="ag_item">Agregar</button>
                                      </div><!-- /.col -->
                                    </div><!-- /.sumador_items -->                            	
                                </div><!--/.articulos_cotizacion-->		
                            </div>
                        
                        </div><!-- /.encabezado_cotizacion -->
                        <!-- ************************************************************************************************ -->
                        <div class="row" id="division_central"><div class="col-md-12"><hr></div></div>
                        <!-- ************************************************************************************************ -->
                        <input id="tentrada" name="introduccion" type="hidden" value="<?php echo $encabezado["intro"]; ?>">
                        <div class="row" id="ficha_cotizacion">
                        	<div class="col-md-10 col-md-offset-1">
                            	
                                <div id="detalle_cotizacion">
                                    
                                    <div class="box box-primary">	
                                        <div class="box-body">
                                        	<input id="cont_item" name="contadoritems" type="hidden" value="0">
                                            <table class="table table-condensed" id="tdetalle">
                                                <tbody>
                                                    <tr>
                                                        <th width="45%" class="tit_tdf_i">Descripción</th>
                                                        <th width="10%" class="tit_tdf">Cantidad</th>
                                                        <th width="10%" class="tit_tdf">UND</th>
                                                        <th width="15%" class="tit_tdf">Precio Unit</th>
                                                        <th width="15%" class="tit_tdf">Total item</th>
                                                        <th width="5%" class="tit_tdf"> </th>
                                                    </tr>
                                                    <?php 
                                                        if( isset( $cotizacion ) ) {
                                                          $ni = 0; 
                                                          foreach( $detalle as $item ){ $ni++;
                                                            echo mostrarItemDocumento( $item, $ni );
                                                        }
                                                    }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    					
                                </div><!--/.detalle_cotizacion-->
                                
                                <div class="row" id="pie_cotizacion">
                                	<table class="table table-condensed" id="pietabla_table">
                                        <tbody>
                                            <tr>
                                                <th width="65%"></th>
                                                <th width="15%">SubTotal</th>
                                                <th width="15%">
                                                	<div id="csub_total" class="totalizacion">
                                                    	<div class="input-group">
                                                    		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                        id="subtotal" value="<?php if(isset( $cotizacion )) echo $totales["subtotal"]?>" readonly>
                                                		</div>
                                                	</div>
                                                </th>
                                                <th width="5%"></th>
                                            </tr>
                                            <tr>
                                                <th width="65%"></th>
                                                <th width="15%">IVA (<?php echo $eiva; ?>%)</th>
                                                <th width="15%">
                                                	<div id="cimpuesto" class="totalizacion">
                                                    	<div class="input-group">
                                                        	<input id="iva" name="ivap" type="hidden" value="<?php echo $iva;?>">
                                                    		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                        id="v_iva" value="<?php if(isset( $cotizacion )) echo $totales["iva"]?>" readonly>
                                                		</div>
                                                	</div></th>
                                                <th width="5%"></th>
                                            </tr>
                                            <tr>
                                                <th width="65%"></th>
                                                <th width="15%">Total</th>
                                                <th width="15%">
                                                	<div id="ctz_total" class="totalizacion">
                                                    	<div class="input-group">
                                                    		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                        id="total" value="<?php if(isset( $cotizacion )) echo $totales["total"]?>" readonly>
                                                		</div>
                                                	</div>
                                                </th>
                                                <th width="5%"></th>
                                            </tr>
                                        </tbody>
                                    </table>			
                                </div>

                                <div id="observaciones">
                                  <div class="titobs"><?php echo $encabezado["obs0"];?></div>
                                  <div class="obsctz oectz" data-vo="1"><?php echo $encabezado["obs1"];?></div>
                                  <input id="tobs1" type="hidden" class="o_oectz" 
                                  value="<?php echo $encabezado["obs1"];?>">
                                  <div class="obsctz oectz" data-vo="2"><?php echo $encabezado["obs2"];?></div>
                                  <input id="tobs2" type="hidden" class="o_oectz" 
                                  value="<?php echo $encabezado["obs2"];?>">
                                  <div class="obsctz oectz" data-vo="3"><?php echo $encabezado["obs3"];?></div>
                                  <input id="tobs3" type="hidden" class="o_oectz" 
                                  value="<?php echo $encabezado["obs3"];?>">
                                </div><!--/. observaciones -->
                            
                            </div><!--/.col-md-8-->
                        	
                        </div><!-- /.pie_cotizacion -->
                        
                        <!-- Bloque de respuesta del servidor -->
                          <?php //include("subforms/nav/mensaje_rcpf.php");?>
                          <button type="button" id="enl_vmsj" data-toggle="modal" data-target="#ventana_mensaje"></button>
                          <?php include("subforms/nav/mensaje_respuesta.php");?>
                        <!-- /.Bloque de respuesta del servidor -->
                    
                    </div><!-- /.box-body -->
                    <div class="box-footer" align="center">
                    	<button type="button" class="btn btn-primary blq_bdoc" id="btn_confirmacion" 
                      data-toggle="modal" data-target="#ventana_confirmacion">Guardar</button>
                    </div>
                    <?php 
                      include( "subforms/nav/mensaje_confirmacion.php" );
                    ?>
                </form>
              
              </div><!-- /.box -->
            
            </div><!--/.col (main) -->
            
            <!-- right column -->
          
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js'></script>
<script src="js/velocity-setup.js"></script>
</body>
</html>

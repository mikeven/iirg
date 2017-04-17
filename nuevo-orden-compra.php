<?php
	/*
	* IIRG - Registro de nueva orden de compra
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
   include( "bd/data-sistema.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-articulo.php" );
   include( "bd/data-formato.php" );
	include( "bd/data-proveedor.php" );
   include( "bd/data-documento.php" );
	include( "bd/data-orden-compra.php" );
	
	checkSession( '' );	
	
   /*if( isset( $_GET["idc"] ) ){
      $cotizacion = obtenerCotizacionPorId( $dbh, $_GET["idc"] );
      $encabezado = $cotizacion["encabezado"];
      $detalle = $cotizacion["detalle"];
      $nitems = count( $detalle );
      $iva = $encabezado["iva"];
      $eiva = $iva * 100;
      $totales = obtenerTotales( $detalle, $encabezado["iva"] );
   }*/
   
   if ( isset( $_GET["idref"] ) ){
      $id_do = $_GET["idref"];
      $orden_compra = obtenerOrdenCompraPorId( $dbh, $id_do );
      $encabezado = $orden_compra["encabezado"];
      $detalle = $orden_compra["detalle"]; 
   }  
  
  if( isset( $encabezado ) ){
      $iva = $encabezado["iva"];
      $eiva = $iva * 100;
      $totales = obtenerTotales( $detalle, $encabezado["iva"] ); //data-documento.php
  }else
  { $iva = $sisval_iva; $eiva = $iva * 100; $nitems = 0; } 
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>IIRG | Crear orden de compra</title>
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
         .input-space{
         	width:95%;
         }
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
           iniciarVentanaConfirmacion( "bt_reg_orden_compra", "Guardar orden de compra" );   
         });
      </script>
      <script src="js/fn-documento.js"></script>
      <script src="js/fn-orden-compra.js"></script>
      <script src="js/fn-articulos.js"></script>
      <script src="js/fn-ui.js"></script>
      
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
            $fecha_actual = obtenerFechaHoy();
            $num_nva_oc = obtenerProximoNumeroOrdenCompra( $dbh, $usuario["idUsuario"] );
            $frt_oc = obtenerFormatoPorUsuarioDocumento( $dbh, "odc", $usuario["idUsuario"] );
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
                           <h3 class="box-title">CREAR NUEVA ORDEN DE COMPRA</h3>
                           <div class="icon-color nuevo-reg-icono">
                             <a href="nuevo-orden-compra.php"><i class="fa fa-plus fa-2x"></i></a>
                           </div>
                           <div class="icon-color"><i class="fa fa-clipboard fa-2x"></i></div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" id="frm_nordencompra" name="form_agregar_ocompra" class="frm_documento">
                           <input id="id_orden_compra" type="hidden" value="">
                           <div class="box-body">
                              <div class="row" id="encabezado_orden_compra">
                                 
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <div class="input-group">
                                          <div class="input-group-btn">
                                             <button type="button" class="btn btn-primary" data-toggle="modal" 
                                                data-target="#lista_proveedores">PROVEEDOR</button>
                                          </div>
                                          <!-- /btn-group -->
                                          <input type="text" class="form-control" id="nproveedor" readonly name="nombre_proveedor">
                                          <input type="hidden" class="form-control" id="idProveedor" value="">
                                       </div>
                                    </div>
                                    <!-- /.form group -->
                                    <!-- Modal -->
                                       <?php 
                                         include( "subforms/tablas/tabla_proveedores_modal.php" );
                                       ?>
                                    <!-- /.Modal -->
                                    <div class="row">
                                       <div class="col-md-5">
                                          <div class="form-group">
                                             <div class="input-group date">
                                                <div class="input-group-addon">
                                                   <i class="fa fa-slack"></i> 
                                                   <label for="numero_orden_compra" class="iconlab">N°:</label>
                                                </div>
                                                <input type="text" class="form-control" id="nordencompra" 
                                                name="numero" required readonly value="<?php echo $num_nva_oc; ?>">
                                             </div>
                                          </div>
                                          <!-- /.form group -->
                                       </div><!-- ./col-md-5 -->
                                       
                                       <div class="col-md-7">
                                          <div class="form-group">
                                             <div class="input-group date">
                                                <div class="input-group-addon">
                                                   <i class="fa fa-calendar"></i> 
                                                   <label for="datepicker" class="iconlab">Fecha emisión:</label>
                                                </div>
                                                <input type="text" class="form-control" id="femision" name="fecha_emision" required readonly 
                                                   value="<?php echo $fecha_actual; ?>">
                                             </div>
                                          </div>
                                          <!-- /.col-md-7 -->
                                       </div>
                                    </div>
                                 </div><!-- /.columna izquierda -->
                                 
                                 <div class="col-md-6">
                                    <div id="articulos_orden_compra">
                                       <!--<div style="padding:11px 0 10px 0;"><span class="lead">Ítems de cotizacion</span></div>-->
                                       <div class="form-group">
                                          <div class="input-group">
                                             <div class="input-group-btn">
                                                <button type="button" class="btn btn-info" data-toggle="modal" 
                                                   data-target="#lista_articulos">ARTÍCULO</button>
                                             </div>

                                             <!-- /btn-group -->
                                             <input type="text" class="form-control" id="narticulo" readonly>
                                             <input type="hidden" id="idArticulo" value="0">
                                             <input type="hidden" id="und_art" value="0">
                                          </div>
                                       </div>
                                       <!-- /.form group -->
                                       <!-- Modal -->
                                       <?php include( "subforms/tablas/tabla_articulos_modal.php" );
                                        ?>
                                        <?php include( "subforms/forms/nuevo_articulo_modal.php" ); ?>
                                       <!-- /.Modal -->
                                       <div class="row" id="sumador_items">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <!--<label for="cantidad" class="">Cantidad:</label>-->
                                                <div class="input-group">
                                                   <div class="input-group-addon"><i class="fa fa-unsorted"></i></div>
                                                   <input type="text" class="form-control itemtotal" id="cantidad" name="cantidad" 
                                                      placeholder="CANT" onkeypress="return isIntegerKey(event)">
                                                </div>
                                             </div>
                                             <!-- /.col -->
                                          </div>
                                          <!-- /.form group -->
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <!--<label for="punit" class="">Precio unitario:</label>-->
                                                <div class="input-group">
                                                   <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                                                   <input type="text" class="form-control itemtotal" id="punit" name="punit" 
                                                      placeholder="P.Unit" onkeypress="return isNumberKey(event)">
                                                </div>
                                             </div>
                                             <!-- /.form group -->
                                          </div>
                                          <!-- /.col -->
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <!--<label for="punit" class="">Total item:</label>-->
                                                <div class="input-group">
                                                   <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                                                   <input type="text" class="form-control" id="ptotal" name="ptotal" 
                                                      placeholder="Total" value="0.00" readonly>
                                                </div>
                                             </div><!-- /.form group -->
                                          </div>
                                          <!-- /.col -->
                                          <div class="col-md-6">
                                             <button class="btn btn-block btn-success" type="button" id="ag_item">Agregar</button>
                                          </div>
                                          <!-- /.col -->
                                       </div><!-- /.sumador_items -->                            	
                                    </div><!--/.articulos_cotizacion-->		
                                 </div><!-- /.columna derecha -->
                              
                              </div><!-- /.encabezado_orden_compra -->
                              <!-- ************************************************************************************************ -->
                              <div class="row" id="division_cntral">
                                 <div class="col-md-12">
                                    <hr>
                                 </div>
                              </div>
                              <!-- ************************************************************************************************ -->
                              <input id="tentrada" name="introduccion" type="hidden" value="<?php echo $frt_oc["entrada"];?>">
                              <div class="row" id="contenido_pedido">
                                 <div class="col-md-10 col-md-offset-1">
                                    <div id="detalle_orden_compra">
                                       <div class="box box-primary">
                                          <div class="box-body">
                                             <input id="cont_item" name="contadoritems" type="hidden" value="<?php echo $nitems?>">
                                             <table class="table table-condensed" id="tdetalle">
                                                <tbody>
                                                   <tr>
                                                      <th width="45%" class="tit_tdf_i">Descripción</th>
                                                      <th width="10%" class="tit_tdf">Cantidad</th>
                                                      <th width="10%" class="tit_tdf">UND</th>
                                                      <th width="15%" class="tit_tdf">Precio Unit</th>
                                                      <th width="15%" class="tit_tdf">Total item</th>
                                                      <th width="5%" class="tit_tdf"></th>
                                                   </tr>
                                                   <?php 
                                                      if( isset( $detalle ) ) {
                                                        $ni = 0; 
                                                        foreach( $detalle as $item ){ $ni++;
                                                          echo mostrarItemDocumento( $item, $ni );
                                                        }
                                                      }?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                    <!--/.detalle_orden_compra-->
                                    <div class="row" id="pie_orden_compra">
                                       <table class="table table-condensed" id="pietabla_table">
                                          <tbody>
                                             <tr>
                                                <th width="65%"></th>
                                                <th width="15%">SubTotal</th>
                                                <th width="15%">
                                                   <div id="oc_sub_total" class="totalizacion">
                                                      <div class="input-group">
                                                         <input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                            id="subtotal" value="<?php if(isset( $encabezado )) echo $totales["subtotal"]?>" readonly>
                                                      </div>
                                                   </div>
                                                </th>
                                                <th width="5%"></th>
                                             </tr>
                                             <tr>
                                                <th width="65%"></th>
                                                <th width="15%">IVA (<?php echo $eiva; ?>%)</th>
                                                <th width="15%">
                                                   <div id="impuesto" class="totalizacion">
                                                      <div class="input-group">
                                                         <input id="iva" name="iva_doc" type="hidden" value="<?php echo $iva;?>">
                                                         <input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                            id="v_iva" value="<?php if(isset( $encabezado )) echo $totales["iva"]?>" readonly>
                                                      </div>
                                                   </div>
                                                </th>
                                                <th width="5%"></th>
                                             </tr>
                                             <tr>
                                                <th width="65%"></th>
                                                <th width="15%">Total</th>
                                                <th width="15%">
                                                   <div id="oc_total" class="totalizacion">
                                                      <div class="input-group">
                                                         <input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                            id="total" value="<?php if(isset( $encabezado )) echo $totales["total"]?>" readonly>
                                                      </div>
                                                   </div>
                                                </th>
                                                <th width="5%"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                    
                                 <div id="observaciones">
                                    <div class="titobs"><?php echo $frt_oc["titulo_obs"];?></div>
                                    <input id="tobs0" type="hidden" value="<?php echo $frt_oc["titulo_obs"];?>">
                                    <div class="obsctz"><?php echo $frt_oc["obs1"];?>
                                      <input id="tobs1" type="hidden" value="<?php echo $frt_oc["obs1"];?>">
                                    </div>
                                    <div class="obsctz"><?php echo $frt_oc["obs2"];?>
                                      <input id="tobs2" type="hidden" value="<?php echo $frt_oc["obs2"];?>">
                                    </div>
                                    <div class="obsctz"><?php echo $frt_oc["obs3"];?>
                                      <input id="tobs3" type="hidden" value="<?php echo $frt_oc["obs3"];?>">
                                    </div>
                                  </div>

                                 </div>
                                 <!--/.col-md-8-->
                              </div>
                              <!-- /.pie_ordencompra -->
                              
                              <!-- Bloque de respuesta del servidor -->
                                 <button type="button" id="enl_vmsj" data-toggle="modal" 
                                 data-target="#ventana_mensaje" class="hidden"></button>
                                 <?php include("subforms/nav/mensaje_respuesta.php");?>
                              <!-- /.Bloque de respuesta del servidor -->
                           </div>
                           <!-- /.box-body -->
                           <div class="box-footer" align="center">
                              <button type="button" class="btn btn-primary" id="btn_confirmacion" data-toggle="modal" 
                                 data-target="#ventana_confirmacion">Guardar</button>
                           </div>
                           <?php 
                              include( "subforms/nav/mensaje_confirmacion.php" );
                           ?>
                        </form>
                     </div>
                     <!-- /.box -->
                  </div>
                  <!--/.col (main) -->
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
   </body>
</html>
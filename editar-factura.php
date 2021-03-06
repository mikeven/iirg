<?php
	/*
	* IIRG - Registro de nueva factura
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
  include( "bd/data-sistema.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-articulo.php" );
	include( "bd/data-cliente.php" );
	include( "bd/data-documento.php" );
	include( "bd/data-cotizacion.php" );
	include( "bd/data-factura.php" );
  include( "bd/data-forms.php" );
	include( "bd/data-formato.php" );
	
  checkSession( '' );
	
  if( isset( $_GET["id"] ) ){
    //Datos de factura a editar:
    $idf        = $_GET["id"];
    $factura    = obtenerFacturaPorId( $dbh, $_GET["id"] );
    $encabezado = $factura["encabezado"];
    $detalle    = $factura["detalle"];
    $nitems     = count( $detalle );
    $iva        = $encabezado["iva"];
    $eiva       = $iva * 100;
    $totales    = obtenerTotales( $detalle, $encabezado["iva"] );
    if( $encabezado["idc"] && $encabezado["idc"] != "" ){
      $ctz_asoc   = obtenerCotizacionPorId( $dbh, $encabezado["idc"] );
      $ctz_encab  = $ctz_asoc["encabezado"];
    }
    
  }
  else{  
  }
  $fac_obs = false;
  if( isset( $encabezado["obs0"] ) && isset( $encabezado["obs1"]) 
     && isset( $encabezado["obs2"] ) && isset( $encabezado["obs3"] ) ){
      $fac_obs = true;
  }
  $v_iva = $sisval_iva; $ev_iva = $v_iva * 100;
  $v_iva2 = $sisval_iva2; $ev_iva2 = $v_iva2 * 100;
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Editar factura</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="css/ionicons.css">
    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
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
    #enl_vmsj{ display: none; }
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
          iniciarVentanaConfirmacion( "bt_edit_factura", "Editar factura" );
      });
    </script>
    <script src="js/fn-documento.js"></script>
    <script src="js/fn-factura.js"></script>
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
  <?php
    $condiciones = obtenerCondiciones( $dbh, "factura", $usuario["idUsuario"] );
    $id_cond_defecto = obtenerIdCondicion( $dbh, "factura", "CONTADO" );

  ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include("sub-scripts/nav/menu_ppal.php");?>
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include("sub-scripts/nav/contenido-cabecera.php"); ?>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
				      <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title">EDITAR FACTURA</h3>
                  <div class="icon-color nuevo-reg-icono">
                    <a href="nuevo-factura.php"><i class="fa fa-plus fa-2x"></i></a>
                  </div>
                  <div class="icon-color"><i class="fa fa-file-text-o fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_efactura" name="form_editar_factura" class="frm_documento">
                	<input id="id_documento" type="hidden" value="<?php echo $idf; ?>">
                    <div class="box-body">
                    	<div class="row" id="encabezado_factura">
                    		<div class="col-md-6">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                      <!--<div class="input-group-btn">
                                        <button type="button" class="btn btn-primary blq_bdoc" data-toggle="modal" 
                                        data-target="#lista_pedidos" id="blpedidos">PEDIDO</button>
                                      </div> -->
                                      <!-- /btn-group -->
                                      <div class="input-group-addon">
                                          <i class="fa fa-slack"></i> 
                                          <label for="datepicker" class="iconlab">N° Ctz:</label>
                                      </div>
                                      <input type="text" class="form-control" id="fcotizacion" readonly 
                                      name="cotizacion" value="<?php if( isset( $ctz_encab ) ) echo $ctz_encab["nro"]." / Fecha: ".$ctz_encab["femision"];?>">
                                      <input type="hidden" class="form-control" id="idCotizacion" value="<?php if( isset($encabezado) ) echo $encabezado["idc"]?>">
                                    </div>
                                </div><!-- /.form group -->
                              </div><!-- /.col6 -->

                              <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-slack"></i> 
                                        <label for="oc" class="iconlab">O/C:</label>
                                      </div>
                                      <input type="text" class="form-control" id="fordc" name="orden_compra" 
                                      value="<?php echo $encabezado["oc"]; ?>">
                                    </div>
                                </div><!-- /.form group -->
                              </div><!-- /.col6 -->
                            </div><!-- /.row -->
                            
                            <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary blq_bdoc" data-toggle="modal" 
                                    data-target="#lista_clientes" <?php if( isset( $ctz_encab ) ) //echo "disabled";?>>CLIENTE</button>
                                  </div>
                                  <!-- /btn-group -->
                                  <input type="text" class="form-control" id="ncliente" readonly name="nombre_cliente" 
                                  value="<?php if( isset( $encabezado ) ) echo $encabezado["nombre"]?>">
                                  <input type="hidden" class="form-control" id="idCliente" 
                                  value="<?php if( isset( $encabezado ) ) echo $encabezado["idcliente"]?>">
                            	</div>
                            </div><!-- /.form group -->
                            <!-- Modal -->
                            	<?php 
                                //include( "sub-scripts/tablas/tabla_cotizaciones_modal.php" );
                                include( "sub-scripts/tablas/tabla_clientes_modal.php" );
                              ?>
                            <!-- /.Modal -->
                                <div class="row">
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <div class="input-group date">
                                          <div class="input-group-addon">
                                              <!-- <i class="fa fa-slack"></i> --> 
                                              <label for="datepicker" class="iconlab">N°:</label>
                                          </div>
                                          <input type="text" class="form-control" id="ndocumento" name="numero" required readonly 
                                          value="<?php echo $encabezado["nro"]; ?>">
                                      </div>
                                  </div><!-- /.form group -->
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                    <div class="input-group date">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i> 
                                        <label for="datepicker" class="iconlab"></label>
                                      </div>
                                      <input type="text" class="form-control" id="femision" name="fecha_emision" required readonly 
                                        value="<?php echo $encabezado["femision"]; ?>">
                                    </div>
                                  </div><!-- /.form group -->
                              </div><!-- /.col -->

                              <div class="col-md-5">
                                  <div class="form-group">
                                        <!--<label for="fcondpago" class="">Validez:</label>-->
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                            <select name="validez" id="vcondicion" class="form-control">
                                                <option value="0" disabled>Validez</option>
                                                <?php foreach ( $condiciones as $c ) {
                                                  $encabezado["cprev"] = 1; 
                                                  echo opCondicion( $encabezado, $c );    //data-forms.php
                                                }?>                                                
                                            </select>
                                            <input id="condicion_defecto" type="hidden" 
                                            value="<?php echo $id_cond_defecto; ?>">
                                            <input id="estado" type="hidden" 
                                            value="<?php echo $encabezado["estado"];?>">
                                        </div><!-- /.input group -->
                                    </div><!-- /.form group -->
                              </div><!-- /.col -->
                            
                            </div><!--/.row-->
                            
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
                                    <!-- Modal -->
                                        <?php include( "sub-scripts/tablas/tabla_articulos_modal.php" ); ?>
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
                                              <input type="hidden" id="icomision" value="0.00">
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
                        
                        <div id="testing"></div>
                        </div><!-- /.encabezado_factura -->
                        <!-- ************************************************************************************************ -->
                        <div class="row" id="division_cntral"><div class="col-md-12"><hr></div></div>
                        <!-- ************************************************************************************************ -->
                        <input id="tentrada" name="introduccion" type="hidden" value="<?php echo $encabezado["intro"];;?>">
                          <div class="row" id="contenido_factura">
                          	<div class="col-md-10 col-md-offset-1">
                                  
                                  <div id="detalle_factura">
                                      <div class="box box-primary">	
                                          <div class="box-body">
                                          	<input id="cont_item" name="contador_items" type="hidden" value="<?php echo $nitems?>">
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
                                                      if( isset( $encabezado ) ) {
                                                        $ni = 0; 
                                                        foreach( $detalle as $item ){ $ni++;
                                                          echo mostrarItemDocumento( $item, $ni );
                                                      }
                                                    }?>
                                                </tbody>
                                            </table>
                                          </div>
                                      </div>
                                      					
                                  </div><!--/.detalle_factura-->
                                  
                                  <div class="row" id="pie_factura">
                                  	<table class="table table-condensed" id="pietabla_table">
                                          <tbody>
                                              <tr>
                                                  <th width="65%"></th>
                                                  <th width="15%">SubTotal</th>
                                                  <th width="15%">
                                                  	<div id="fsub_total" class="totalizacion">
                                                      	<div class="input-group">
                                                      		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                              id="subtotal" value="<?php if(isset( $factura )) echo $totales["subtotal"]?>" readonly>
                                                  		</div>
                                                  	</div>
                                                  </th>
                                                  <th width="5%"></th>
                                              </tr>
                                              <tr>
                                                  <th width="65%"></th>
                                                  <th width="15%">
                                                    <select name="sel_valor_iva" id="sviva" class="form-control slo">
                                                      <option value="0.00" 
                                                      <?php echo selop( $iva, "0.00" );?>>
                                                      <?php echo "0.00";?> %</option>
                                                      <option value="<?php echo $v_iva;?>" 
                                                      <?php echo selop( $iva, $v_iva );?>><?php echo $ev_iva;?> %</option>
                                                      <option value="<?php echo $v_iva2;?>" 
                                                      <?php echo selop( $iva, $v_iva2 );?>><?php echo $ev_iva2;?> %</option>
                                                    </select>
                                                  </th>
                                                  <th width="15%">
                                                  	<div id="impuesto" class="totalizacion">
                                                      	<div class="input-group">
                                                          	<input id="iva" name="ivap" type="hidden" value="<?php echo $iva;?>">
                                                      		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                              id="v_iva" value="<?php if(isset( $factura )) echo $totales["iva"]?>" readonly>
                                                          <input id="iva_orig" type="hidden" value="<?php echo $iva;?>">
                                                  		</div>
                                                  	</div></th>
                                                  <th width="5%"></th>
                                              </tr>
                                              <tr>
                                                  <th width="65%"></th>
                                                  <th width="15%">Total</th>
                                                  <th width="15%">
                                                  	  <div id="fac_total" class="totalizacion">
                                                      	<div class="input-group">
                                                      		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                              id="total" value="<?php if(isset( $factura )) echo $totales["total"]?>" readonly>
                                                  		</div>
                                                  	</div>
                                                  </th>
                                                  <th width="5%"></th>
                                              </tr>
                                          </tbody>
                                      </table>			
                                  </div>
                                  <?php if( $fac_obs ){ ?>
                                  <div id="observaciones">
                                    <div class="titobs"><?php echo $encabezado["obs0"];?></div>
                                    <div class="obsctz"><?php echo $encabezado["obs1"];?></div>
                                    <div class="obsctz"><?php echo $encabezado["obs2"];?></div>
                                    <div class="obsctz"><?php echo $encabezado["obs3"];?></div>
                                  </div>
                                  <?php } ?>
                              </div><!--/.col-md-8-->
                          	
                          </div><!-- /.pie_factura -->

                          <!-- Bloque de respuesta del servidor -->
                          <button type="button" id="enl_vmsj" data-toggle="modal" 
                          data-target="#ventana_mensaje"></button>
                          <?php include("sub-scripts/nav/mensaje_respuesta.php");?>
                          <!-- /.Bloque de respuesta del servidor -->

                    </div><!-- /.box-body -->
					          
                    <div class="box-footer" align="center">
                    	<button type="button" class="btn btn-primary" id="btn_confirmacion" data-toggle="modal" 
                      data-target="#ventana_confirmacion">Guardar</button>
                    </div>
                    <?php 
                      include( "sub-scripts/nav/mensaje_confirmacion.php" );
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
  <?php include("sub-scripts/nav/footer.php"); ?>
  <!-- /.footer -->

  <!-- Panel de configuración -->
  <?php include("sub-scripts/nav/panel_control.php"); ?>
  <!-- /.Panel de configuración -->

</div>
<!-- ./wrapper -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js'></script>
<script src="js/velocity-setup.js"></script>
</body>
</html>

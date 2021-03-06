<?php
	/*
	* IIRG - Registro de nueva nota
  * Formatos para nota de entrega, nota de crédito, nota de débito
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
  include( "bd/data-factura.php" );
	include( "bd/data-nota.php" );
  include( "bd/data-forms.php" );
  include( "bd/data-formato.php" );
  include( "fn/fn-documento.php" );

  checkSession( '' );
	
  if( isset( $_GET["idf"] ) ){
    $factura = obtenerFacturaPorId( $dbh, $_GET["idf"] );
    $encabezado = $factura["encabezado"];
    $encabezado_factura = $encabezado;
    $encabezado["data-fac"] = $encabezado_factura["nombre"].
                              " - Fact N° ".$encabezado_factura["nro"]." ".
                              " ($encabezado_factura[femision])";
    $detalle = $factura["detalle"];
    $nitems = count( $detalle );
    $totales = obtenerTotales( $detalle, $encabezado_factura["iva"] );
  }

  if ( isset( $_GET["idref"] ) ){
    $id_do = $_GET["idref"];
    $tn = obtenerTipoNotaPorId( $dbh, $id_do );
    $nota = obtenerNotaPorId( $dbh, $id_do, $tn );
    $encabezado = $nota["encabezado"];
    $detalle = $nota["detalle"];

    if( $tn != "nota_entrega" ){
      $factura = obtenerFacturaPorId( $dbh, $encabezado["idfactura"] );
      $encabezado_factura = $factura["encabezado"];
      $encabezado["data-fac"] = $encabezado["nombre"].
                              " - Fact N° ".$encabezado_factura["nro"]." ".
                              " ($encabezado[femision])";
    }
    
    if( $encabezado["tipo_concepto"] == "Ajuste global" )
      $totales = obtenerTotalesFijos( $encabezado );                    //data-documento.php
    else
      $totales = obtenerTotales( $detalle, $encabezado["iva"] );        //data-documento.php
  }    
  
  if( isset( $encabezado ) ){
    $iva = $encabezado["iva"];
    $eiva = $iva * 100;
  }
  else
    { $iva = $sisval_iva; $eiva = $iva * 100; $nitems = 0; }

  if( isset( $_GET["t"] ) ){
      $tn = $_GET["t"];
  }	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IIRG | Crear nueva nota</title>
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
      .input-space{ width:95%; }
  		.itemtotal_detalle, .itemtotaldocumento{ width:95%; border:0; background:#FFF; text-align:right;}
  		.totalitem_detalle, .totalizacion{ width:100%; text-align:right; }
  		.tit_tdf_i{ text-align: left; } .tit_tdf{ text-align: center; } .tit_tdf_d{ text-align: right; }
  		.iconlab{ line-height: 0; }
  		.form-group { margin-bottom: 5px; }
      .nti{ padding: 25px 0;}
      #cnc{ width: 90%; }
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
        <?php if( isset( $tn ) ) { ?>
          obtenerNumeroNota( '<?php echo $tn?>');
          <?php 
            if ( isset( $_GET["idref"] ) )
              if( $encabezado["tipo_concepto"] == "Ajuste global" ) { ?>
                $("#tdetalle").fadeOut(200); $("#subtotal").removeAttr("readonly");
          <?php } ?>
          asignarOpcionesConcepto( '<?php echo $tn; ?>' );
        <?php } ?>
        iniciarVentanaConfirmacion( "bt_reg_nota", "Guardar nota" );   
      });
    </script>
    <script src="js/fn-documento.js"></script>
    <script src="js/fn-nota.js"></script>
    <script src="js/fn-articulos.js"></script>
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
    $fecha_actual = obtenerFechaHoy();
    if( isset( $_GET["idf"] ) ){
      $num_nvanota = obtenerProximoNumeroNota( $dbh, $tn, $usuario["idUsuario"] );
      $frt_f = obtenerFormatoPorUsuarioDocumento( $dbh, docBD( $tn ), $usuario["idUsuario"] );
    }
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
            <div class="col-md-12">
              <!-- general form elements -->
				<div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title">CREAR NUEVA NOTA</h3>
                  <div class="icon-color nuevo-reg-icono">
                    <a href="nuevo-nota.php"><i class="fa fa-plus fa-2x"></i></a>
                  </div>
                  <div class="icon-color"><i class="fa fa-sticky-note-o fa-2x"></i></div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frm_nnota" name="form_agregar_nota" class="frm_documento">
                	<input name="reg_nota" type="hidden" value="1">
                    <div class="box-body">
                    	<div class="row" id="encabezado_nota">
                    		<div class="col-md-6">
                            <div class="row">
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <select class="form-control" id="tnota">
                                      <option value="0" disabled selected class="nti">Tipo de Nota</option>
                                      <option value="nota_entrega" class="nti" 
                                      <?php if(isset($tn)) echo selop("nota_entrega", $tn );?>>Nota de Entrega</option>
                                      <option value="nota_credito" class="nti" 
                                      <?php if(isset($tn)) echo selop("nota_credito", $tn );?>>Nota de Crédito</option>
                                      <option value="nota_debito" class="nti" 
                                      <?php if(isset($tn)) echo selop("nota_debito", $tn );?>>Nota de Débito</option>
                                    </select>
                                    <input type="hidden" id="tipofte" value="<?php if(isset( $encabezado )) echo $tn; ?>">

                                    <input id="estado" type="hidden" value="pendiente">
                                  </div><!-- /.form group -->
                                </div><!-- /.col6 -->
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-slack"></i> 
                                        <label for="nfac" class="iconlab">N° Fact:</label>
                                      </div>
                                      <input type="text" class="form-control" id="nFactura" name="num_factura" 
                                      value="<?php if(isset( $encabezado_factura )) echo $encabezado_factura["nro"]; ?>" readonly>
                                    </div>
                                  </div><!-- /.form group -->
                                </div><!-- /.col6 -->
                              
                              </div><!-- /.row -->
                              <div class="form-group bloque_nota" id="bloquen_clientes">
                                  <div class="input-group">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-primary blq_bdoc" data-toggle="modal" data-target="#lista_clientes">CLIENTE</button>
                                    </div>
                                    <!-- /btn-group -->
                            <input type="text" class="form-control" id="ncliente" readonly name="nombre_cliente" 
                            value="<?php if( isset( $encabezado ) ) echo $encabezado["nombre"]; ?>">
                              	</div>
                              </div><!-- /.form group -->
                              
                              <div class="form-group bloque_nota" id="bloquen_facturas">
                                <div class="input-group">
                                  <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary blq_bdoc" data-toggle="modal" data-target="#lista_facturas">FACTURA</button>
                                  </div>
                                  <!-- /btn-group -->
                                  <input type="text" class="form-control" id="ndatafac" readonly name="data_factura" 
                                  value="<?php if( isset( $factura ) ) echo $encabezado["data-fac"]; ?>">
                                  <input type="hidden" class="form-control" id="idFactura" 
                                  value="<?php if( isset( $factura ) ) echo $encabezado["idf"]; ?>">
                                </div>
                              </div><!-- /.form group -->

                              <input type="hidden" class="form-control" id="idCliente" 
                              value="<?php if( isset($encabezado) ) echo $encabezado["idcliente"]; ?>">
                              <!-- Modal -->
                              	<?php 
                                  include( "sub-scripts/tablas/tabla_clientes_modal.php" );
                                  include( "sub-scripts/tablas/tabla_facturas_modal.php" );
                                ?>
                              <!-- /.Modal -->
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-slack"></i> 
                                                <label for="numero_nota" class="iconlab">N°:</label>
                                                </div>
                                                <input type="text" class="form-control" 
                                                id="ndocumento" name="numero" 
                                                required readonly value="<?php if( isset($num_nvanota) ) echo $num_nvanota; ?>">
                                        <input type="hidden" id="vcondicion" value="">
                                        <input type="hidden" id="condicion_defecto" 
                                        data-condicion="" value="">
                                            </div>
                                        </div><!-- /.form group -->
                                    </div>
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
                                    </div><!-- /.form group -->
                                	</div>
                                </div>
                            
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
                                    <?php include( "sub-scripts/forms/nuevo_articulo_modal.php" ); ?>
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
                        
                        </div><!-- /.encabezado_nota -->
                        <!-- ************************************************************************************************ -->
                        <div class="row" id="division_central"><div class="col-md-12"><hr></div></div>
                        <!-- ************************************************************************************************ -->
                        <input id="tentrada" name="introduccion" type="hidden" value="">
                          <div class="row" id="contenido_nota">
                          	<div class="col-md-10 col-md-offset-1">
                              	
                                  <div id="detalle_nota">
                                      
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
                                      					
                                  </div><!--/.detalle_nota-->
                                  
                                  <div class="row" id="pie_nota">
                                  	<table class="table table-condensed" id="pietabla_table">
                                          <tbody>
                                              <tr>
                                                  <th width="65%"></th>
                                                  <th width="15%">SubTotal</th>
                                                  <th width="15%">
                                                  	<div id="sub_total" class="totalizacion">
                                                      	<div class="input-group">
                                                      		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                              id="subtotal" value="<?php if(isset( $encabezado )) echo $totales["subtotal"]?>" readonly>
                                                  		</div>
                                                  	</div>
                                                  </th>
                                                  <th width="5%"></th>
                                              </tr>
                                              <tr>
                                                  <th width="65%">
                                                    <?php if( isset( $factura ) ) {?>
                                                      <div id="bloque_concepto">
                                                        <div class="form-group">
                                                          <!--<label for="obs2">obs2</label>-->
                                                          <div class="input-group">
                                                            <div class="input-group-btn">
                                                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                                                              aria-expanded="false">Concepto <span class="fa fa-caret-down"></span></button>
                                                                <ul class="dropdown-menu">
                                                                  <li><a href="#!" class="ocn" id="on1" data-val=""></a></li>
                                                                  <li><a href="#!" class="ocn" id="on2" data-val=""></a></li>
                                                                  <li><a href="#!" class="ocn" id="on3" data-val=""></a></li>
                                                                </ul>
                                                            </div><!-- /btn-group -->
                                                            <input type="text" class="form-control" name="concepto" id="cnc" 
                                                            value="<?php if ( isset( $encabezado["concepto"] ) ) echo $encabezado["concepto"]; ?>"> 
                                                            <input type="hidden" name="tipo_concepto" id="tconcepto" 
                                                            value="<?php if ( isset( $encabezado["tipo_concepto"] ) ) echo $encabezado["tipo_concepto"]; ?>">
                                                          </div>                                        
                                                        </div><!-- /.form group -->
                                                        <div id="etq_concepto"></div> 
                                                      </div> <!-- /.bloque_concepto -->
                                                    <?php } ?>
                                                  </th>
                                                  <th width="15%" >
                                                    <div class="iva_valor">
                                                      IVA <span id="labiva"> (<?php echo $eiva; ?>%) </span>
                                                    </div>
                                                  </th>
                                                  <th width="15%">
                                                	<div id="impuesto" class="totalizacion iva_valor">
                                                    	<div class="input-group">
                                                        <input id="iva" name="iva_doc" type="hidden" value="<?php echo $iva;?>">
                                                    		<input type="text" class="form-control itemtotaldocumento totalizacion" id="v_iva" value="<?php if(isset( $encabezado )) echo $totales["iva"]?>" readonly>
                                                        <input id="iva_orig" type="hidden" value="<?php echo $iva;?>">
                                                		  </div>
                                                  	</div>
                                                  </th>
                                                  <th width="5%"> </th>
                                              </tr>
                                              <tr>
                                                  <th width="65%"></th>
                                                  <th width="15%">Total</th>
                                                  <th width="15%">
                                                  	  <div id="fac_total" class="totalizacion">
                                                      	<div class="input-group">
                                                      		<input type="text" class="form-control itemtotaldocumento totalizacion" 
                                                              id="total" value="<?php if(isset( $encabezado )) echo $totales["total"]?>" readonly>
                                                  		  </div>
                                                  	  </div>
                                                      <input id="mototalnota" name="totaln" type="hidden" 
                                                        value="<?php if(isset( $encabezado )) echo $totales["total"]?>">
                                                  </th>
                                                  <th width="5%"></th>
                                              </tr>
                                          </tbody>
                                      </table>			
                                  </div>
                                  
                                  <div id="observaciones">
                                    <div class="titobs">
                                      <div id="t_tobs_notas"><?php if( isset( $frt_f ) ) echo $frt_f["titulo_obs"];?></div>
                                      <input id="tobs0" type="hidden" value="<?php if( isset( $frt_f ) ) echo $frt_f["titulo_obs"];?>">
                                    </div>
                                    <div class="obsctz">
                                      <div id="tx0b1"><?php if( isset( $frt_f ) ) echo $frt_f["obs1"];?></div>
                                      <input id="tobs1" type="hidden" value="<?php if( isset( $frt_f ) ) echo $frt_f["obs1"];?>">
                                    </div>
                                    <div class="obsctz">
                                      <div id="tx0b2"><?php if( isset( $frt_f ) ) echo $frt_f["obs2"];?></div>
                                      <input id="tobs2" type="hidden" value="<?php if( isset( $frt_f ) ) echo $frt_f["obs2"];?>">
                                    </div>
                                    <div class="obsctz">
                                      <div id="tx0b3"><?php if( isset( $frt_f ) ) echo $frt_f["obs3"];?></div>
                                      <input id="tobs3" type="hidden" value="<?php if( isset( $frt_f ) ) echo $frt_f["obs3"];?>">
                                    </div>
                                  </div><!--/. observaciones -->
                              
                              </div><!--/.col-md-8-->
                          	
                          </div><!-- /.pie_factura -->
                        
                          <!-- Bloque de respuesta del servidor -->
                            <button type="button" id="enl_vmsj" data-toggle="modal" 
                            data-target="#ventana_mensaje" class="hidden"></button>
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
<?php if( isset($_GET["idf"]) ) {?>
  <script>
    $( document ).ready(function() {
      $("#bloquen_facturas").show(300);
      asignarOpcionesConcepto( $("#tipofte").val() );
    });
  </script>
<?php } ?>
<!-- ./wrapper -->
  <script src='js/velocity/velocity.min.js'></script>
  <script src='js/velocity/velocity.ui.min.js'></script>
  <script src="js/velocity-setup.js"></script>
</body>
<?php if( isset( $factura ) ) { ?>
  <script>
    $( document ).ready(function() { $("#bloquen_facturas").show(); });
  </script>   
<?php } ?>
<?php if( isset( $nota ) && $tn == "nota_entrega" ) { ?>
  <script>
    $( document ).ready(function() { $("#bloquen_clientes").show(); });
  </script>   
<?php } ?>

</html>

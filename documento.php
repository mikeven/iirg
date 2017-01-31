<?php
	/*
	* IIRG - Visualización de documento
	* 
	*/
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/bd.php" );
	include( "bd/data-usuario.php" );
	include( "bd/data-pedido.php" );
	include( "bd/data-articulo.php" );
	include( "bd/data-factura.php" );
	include( "bd/data-nota.php" );
	include( "bd/data-formato.php" );
	include( "bd/data-cotizacion.php" );
	include( "fn/fn-formato.php" );
	include( "fn/fn-documento.php" );

	checkSession( '' );
	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $tdocumento." Nro. ".$encabezado["nro"];?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

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
    <style>
    	#lin1{ font-size:22px; } #lin2{ font-size:18px; } .membrete3{ font-size:16px; }
      .tit_tdf_i{ text-align: left; } .tit_tdf{ text-align: center; } .tit_tdf_d{ text-align: right; }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
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
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
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
        $frt = obtenerFormatoPorUsuarioDocumento( $dbh, $ftdd, $usuario["idUsuario"] );
        $titulo_obs = $frt["titulo_obs"];
      ?>
      <!-- Left side column. contains the logo and sidebar -->
	     <?php include( "subforms/nav/menu_ppal.php" );?>
      <!-- Left side column. contains the logo and sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $tdocumento." #".$encabezado["nro"]; ?>
          </h1>
          <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Invoice</li>
          </ol> -->
        </section>

        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <!--<div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> AdminLTE, Inc.
                <small class="pull-right">Date: 2/10/2014</small>
              </h2>
            </div>
          </div>-->
          <!-- info row -->
            <?php if($tdd != "fac") { ?>
            <div class="row invoice-info" id="membrete">
                <div class="col-sm-2 invoice-col"></div><!-- /.col -->
                <div class="col-sm-8 invoice-col" align="center">
                    <div id="lin1">INSUMOS INFORMÁTICOS R & G, C.A.</div>
                    <div id="lin2">Suministros para Computación y Papelería</div>
                    <div id="lin3" class="membrete3">Calle Este 16, Sordo a Peláez, Residencias Sorpe, P.B. Local 1</div>
                    <div id="lin4" class="membrete3">Parroquia Santa Rosalía - Caracas</div>
                    <div id="lin5" class="membrete3">Telefonos (0212) 545.6529 / 395-5955 / Telefax: 5424137 CEL. 0416-624-4269</div>
                    <div id="lin6" class="membrete3">email: insumos_rg@cantv.net    /   rginsumosinformaticos@gmail.com</div>
                </div><!-- /.col -->
                <div class="col-sm-2 invoice-col"></div><!-- /.col -->
          	</div><!-- /.row -->
			      <?php }?>
            <div class="row invoice-info" id="encabezado" style="margin:20px 0;">
                <div class="col-sm-4 invoice-col" id="dcliente">
                    <div id="dc_nombre">Señores</div>
                    <div id="dc_nombre"><?php echo $encabezado["nombre"]?></div>
                    <?php if( $tdd == "fac" ) { ?>
                      <div id="dc_dir1"><?php echo $encabezado["dir1"]?></div>
                      <div id="dc_dir2"><?php echo $encabezado["dir2"]?></div>
                      <div id="dc_ciudad">Ciudad: Caracas</div>
                    <?php } ?>
                    <?php if($tdd == "ctz") { ?>
                      <div id="dc_pcontacto"> Attn <?php echo $encabezado["pcontacto"]?></div>
                    <?php } ?>
                </div><!-- /.col -->
                <div class="col-sm-5 invoice-col"> </div><!-- /.col -->
                
                <div class="col-sm-3 invoice-col" id="ddocumento">
                    
                    <div id="dctz_numero"><?php echo $tdocumento." N°:   ".$encabezado["nro"];?></div>
                    <div id="dctz_fecha">Fecha: &nbsp;<?php echo $encabezado["femision"];?></div>
                    
                    <?php if( ( isset( $tipo_n ) ) && ( $tipo_n != "nota_entrega" ) ) { ?>
                      <div id="dnfac">Fact N° <?php echo $encabezado["nfact"]; ?></div>
                    <?php } ?>
                    
                    <?php if($tdd == "ctz") { ?>
                      <div id="dctz_tlf">Vendedor: Nidia</div>
                    <?php } ?>
                    
                    <?php if($tdd == "fac") { ?>
                      <div id="dctz_tlf">Fecha vencimiento: <?php echo ""; ?></div>
                      <div id="dctz_tlf">Orden de compra: <?php echo $encabezado["oc"]; ?></div>
                    <?php } ?>
                
                </div><!-- /.col -->
                
            </div><!-- /.row -->
          
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="tit_tdf_i">Descripción</th>
                    <th class="tit_tdf">Cant</th>
                    <th class="tit_tdf">UND</th>
                    <th class="tit_tdf">Precio Unitario</th>
                    <th class="tit_tdf">Total ítem</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach( $detalle_d as $item ) { ?>
                  <tr>
                    <td class="tit_tdf_i"><?php echo $item["descripcion"];?></td>
                    <td class="tit_tdf"><?php echo $item["cantidad"];?></td>
                    <td class="tit_tdf"><?php echo $item["und"];?></td>
                    <td align="center"><?php echo $item["punit"];?></td>
                    <td align="center"><?php echo $item["ptotal"];?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <!-- Observaciones -->
            <div class="col-xs-6">
              <p class="lead"><?php echo $titulo_obs;?></p>
                <div><?php echo $obs1; ?></div>
                <div><?php echo $obs2; ?></div>
                <div><?php echo $obs3; ?></div>  
              </p>
            </div><!-- /.col -->
            
            <div class="col-xs-6">
              <?php if($tdd != "sctz") { ?>
                <p class="lead">Totales</p>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Subtotal:</th>
                      <td class="tit_tdf_d"><?php echo $totales["subtotal"]; ?></td>
                    </tr>
                    <tr>
                      <th>IVA (<?php echo $eiva; ?>%)</th>
                      <td class="tit_tdf_d"><?php echo $totales["iva"]; ?></td>
                    </tr>
                    <tr>
                      <th>Total:</th>
                      <td class="tit_tdf_d"><?php echo $totales["total"]; ?></td>
                    </tr>
                  </table>
                </div>
              <?php } ?>
            </div><!-- /.col -->
          
          </div><!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="<?php echo $enlace_imp; ?>" class="btn btn-app" target="_blank"><i class="fa fa-print fa-2x"></i> Imprimir</a>
              <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
            </div>
          </div>

        </section><!-- /.content -->
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
      

      <!-- /footer -->
      <?php include("subforms/nav/footer.php"); ?>
      <!-- /.footer -->


      <!-- Panel de configuración -->
      <?php include("subforms/nav/panel_control.php"); ?>
      <!-- /.Panel de configuración -->
  
    </div><!-- ./wrapper -->

  </body>
</html>

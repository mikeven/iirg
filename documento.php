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
  include( "bd/data-orden-compra.php" );
	include( "bd/data-articulo.php" );
	include( "bd/data-factura.php" );
	include( "bd/data-nota.php" );
  include( "bd/data-documento.php" );
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
    <title><?php echo $tdocumento." Nro. ".$encabezado["nro"]; //fn-documento.php ?></title>
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
         folder instead of download

         ing all of them to reduce the load. -->
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
    <script src="js/fn-hoja-documento.js"></script>
    <style>
    	#lin1{ font-size:22px; } #lin2{ font-size:18px; } .membrete3{ font-size:16px; }
      .tit_tdf_i{ text-align: left; } .tit_tdf{ text-align: center; } .tit_tdf_d{ text-align: right; }
      #bloque_documento{ padding: 8px 15px; margin: 10px 3px 10px 15px !important; } 
      .page-header{ padding-bottom: 20px; }
      .rojo{ color: #d73925;} .amarillo{ color: #f39c12;} .verde{ color: #00a65a;} 
      .azul{ color: #0073b7; } .gris{ color: #666;}
      #bloque_data_documento{ margin: 10px 3px 10px 10px !important; width: 21.7% !important; }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
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
              <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
            </ul>
          </div>
        </nav>
      </header>
      <?php 
        $cta = obtenerUsuarioPorId( $usuario["idUsuario"], $dbh );
        $frt = obtenerFormatoPorUsuarioDocumento( $dbh, $ftdd, $usuario["idUsuario"] );
        $titulo_obs = $encabezado["obs0"];
        $enlace_imp = "impresion.php?tipo_documento=$tdd&id=$id&idu=$usuario[idUsuario]";
        $enlace_edc = enlaceEdicion( $tdd, $id );           //fn-documento.php
        $iconoi = iconoEstado( $encabezado["estado"] );     //fn-documento.php 
        //print_r($encabezado);
      ?>
      <!-- Left side column. contains the logo and sidebar -->
	     <?php include( "subforms/nav/menu_ppal.php" );?>
      <!-- Left side column. contains the logo and sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div>
        <section class="content-header">
          <h1><?php echo $tdocumento." #".$encabezado["nro"]; ?></h1>         
          <input name="iddocumento" id="id_documento" type="hidden" value="<?php echo $id; ?>">
        </section></div>

        <!-- Main content -->
        <section id="bloque_documento" class="invoice col-sm-9">
          <!-- Bloque opciones -->
          <div class="row">
            <div class="col-xs-12">
              <!-- <h2 class="page-header"></h2> -->
            </div>
          </div><!-- /.Bloque opciones -->
          
          <!-- info row -->
            <?php if( $tdd != "fac_x" ) { ?>
            <div class="row invoice-info" id="membrete">
                <div class="col-sm-2 invoice-col"></div><!-- /.col -->
                <div class="col-sm-8 invoice-col" align="center">
                    <div id="lin1"><?php echo $frt["enc1"]?></div>
                    <div id="lin2"><?php echo $frt["enc2"]?></div>
                    <div id="lin3" class="membrete3"><?php echo $frt["enc3"]?></div>
                    <div id="lin4" class="membrete3"><?php echo $frt["enc4"]?></div>
                    <div id="lin5" class="membrete3"><?php echo $frt["enc5"]?></div>
                    <div id="lin6" class="membrete3"><?php echo $frt["enc6"]?></div>
                </div><!-- /.col -->
                <div class="col-sm-2 invoice-col"></div><!-- /.col -->
          	</div><!-- /.row -->
			      <?php } ?>
            
            <div class="row invoice-info" id="encabezado" style="margin:20px 0;">
              <div class="col-sm-4 invoice-col" id="dcliente">
                  <div id="dc_nombre">Señores</div>
                  <div id="dc_nombre"><?php echo $encabezado["nombre"]?></div>
                  <?php if( ( $tdd == "fac" ) || ( $tdd == "odc" ) || ( $tdd == "sctz" ) ) { ?>
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
                  <div id="dctz_fecha">Fecha Emisión: &nbsp;<?php echo $encabezado["femision"];?></div>
                  
                  <?php if( ( isset( $tipo_n ) ) && ( $tipo_n != "nota_entrega" ) ) { ?>
                    <div id="dnfac">Fact N° <?php echo $encabezado["nfact"]; ?></div>
                  <?php } ?>
                  
                  <?php if($tdd == "ctz") { ?>
                    <div id="dctz_tlf">Vendedor: <?php echo $cta["vendedor"]; ?></div>
                  <?php } ?>
                  
                  <?php if($tdd == "fac") { ?>
                    <div id="dctz_tlf">Fecha vencimiento: <?php echo ""; ?></div>
                    <div id="dctz_tlf">N° Orden Compra: <?php echo $encabezado["oc"]; ?></div>
                  <?php } ?>
              
              </div><!-- /.col -->
              
            </div><!-- /.row -->
            
            <!-- Texto introductorio -->
            <div class="row">
              <div class="col-xs-12" id="texto_introductorio">
                <p class="tentrada"><?php echo $encabezado["intro"]; ?></p>
              </div> 
            </div><!-- /.Texto introductorio -->

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
                      <th class="tit_tdf">Total Bsf</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach( $detalle_d as $item ) { ?>
                    <tr>
                      <td class="tit_tdf_i"><?php echo $item["descripcion"];?></td>
                      <td class="tit_tdf"><?php echo $item["cantidad"];?></td>
                      <td class="tit_tdf"><?php echo $item["und"];?></td>
                      <td align="right"><?php echo number_format( $item["punit"], 2, ",", "." );?></td>
                      <td align="right"><?php echo number_format( $item["ptotal"], 2, ",", "." );?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">

              <!-- Observaciones -->
              <div class="col-xs-6">
                
                <?php if( $tdd == "nota" ) { ?>
                  <!-- Concepto -->
                  <div id="concepto_nota"><?php echo $encabezado["concepto"]; ?></div>
                  <!-- /.Concepto -->
                <?php } ?>

                  <div><?php echo $titulo_obs;?></div>
                  <div><?php echo $obs1; ?></div>
                  <div><?php echo $obs2; ?></div>
                  <div><?php echo $obs3; ?></div>  
                </p>
            
              </div><!-- /.col -->
            
              <div class="col-xs-6">
                <?php if($tdd != "sctz") { ?>
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td class="tit_tdf_d"><?php echo number_format( $totales["subtotal"], 2, ",", "." ); ?></td>
                      </tr>
                      <tr>
                        <th>IVA (<?php echo $eiva; ?>%)</th>
                        <td class="tit_tdf_d"><?php echo number_format( $totales["iva"], 2, ",", "." ); ?></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td class="tit_tdf_d"><?php echo number_format( $totales["total"], 2, ",", "." ); ?></td>
                      </tr>
                    </table>
                  </div>
                <?php } ?>
              </div><!-- /.col -->
          
            </div><!-- /.row -->

            <!-- Pie de documento (no para impresión) -->
            <div class="row no-print">
              <div class="col-xs-12">
                <a href="<?php echo $enlace_imp; ?>" class="btn btn-app" target="_blank">
                  <i class="fa fa-print fa-2x"></i> Imprimir
                </a>
              </div>
            </div>
            <!-- Pie de documento (no para impresión) -->
            <?php 
              include( "subforms/nav/mensaje_confirmacion_anulacion.php" );
            ?>
        </section><!-- /.content -->
        
        <section id="bloque_data_documento" class="col-sm-2 invoice">
          <h2 class="page-header">
            <div id="destado">
              <i class="fa <?php echo $iconoi["icono"]." ".$iconoi["color"]; ?>"></i> 
              <?php echo $encabezado["estado"]; ?>
            </div>
          </h2>
          <?php echo fechasDocumento( $encabezado ); ?>
          
          <div id="btn_opciones" class="btn-group pull-right">
            <button type="button" class="btn btn-info">Opciones</button>
            <button type="button" class="btn btn-info dropdown-toggle" 
            data-toggle="dropdown" aria-expanded="true">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="<?php echo $enlace_edc; ?>"><i class="fa fa-edit"></i> Editar</a></li>
              <li><a href="#"><i class="fa fa-copy"></i> Copiar</a></li>
              <li><a href="#"><i class="fa fa-send-o"></i> Enviar por email</a></li>
              <?php if ( esAnulable( $tdd, $encabezado ) ) { ?>
              <li class="divider"></li>
              <li>
                <a href="#!" data-toggle="modal" data-target="#ventana_anular">
                <i class="fa fa-ban"></i> Anular </a>
              </li>
              <?php } ?>
            </ul>
          </div>  

        </section>
        
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

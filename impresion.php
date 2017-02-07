<?php
  /*
  * IIRG - Visualización previa de impresión
  * 
  */
  session_start();
  ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-usuario.php" );
  include( "bd/data-pedido.php" );
  include( "bd/data-articulo.php" );
  include( "bd/data-factura.php" );
  include( "bd/data-documento.php" );
  include( "bd/data-orden-compra.php" );
  include( "bd/data-cotizacion.php" );
  include( "bd/data-nota.php" );
  
  checkSession( '' );
  
  if( isset( $_GET["tipo_documento"] ) && ( isset( $_GET["id"] ) ) ){
    $id = $_GET["id"];
    $tdd = $_GET["tipo_documento"]; 

    if( $tdd == "ctz" ){
      $documento = obtenerCotizacionPorId( $dbh, $id );
      $tdocumento = "Cotización";
    }
    if( $tdd == "sctz" ){
      $documento = obtenerSolicitudCotizacionPorId( $dbh, $id );
      $tdocumento = "Solicitud de Cotización"; $ftdd = $tdd;
    }      
    if( $tdd == "ped" ){
      $documento = obtenerPedidoPorId( $dbh, $id );
      $tdocumento = "Pedido";
    }
    if( $tdd == "odc" ){
      $documento = obtenerOrdenCompraPorId( $dbh, $id );
      $tdocumento = "Orden de compra";
    }
    if( $tdd == "fac" ){
      $documento = obtenerFacturaPorId( $dbh, $id );
      $tdocumento = "Factura";
    }
    if( $tdd == "nota" ){
      $tipo_n = obtenerTipoNotaPorId( $dbh, $id );
      $documento = obtenerNotaPorId( $dbh, $id, $tipo_n );
      $encabezado = $documento["encabezado"];
      $tdocumento = etiquetaNota( $tipo_n );

      $t_concepto = $encabezado["tipo_concepto"];
      $detalle_d = $documento["detalle"];

      $tdocumento = etiquetaNota( $tipo_n );
      $ftdd = $tipo_n;
      if( $t_concepto != "Ajuste global" )
          $totales = obtenerTotales( $detalle_d, $encabezado["iva"] );
        else
          $totales = obtenerTotalesFijos( $encabezado );
    }
    
    $encabezado = $documento["encabezado"];
    $detalle_d = $documento["detalle"];
    
    for( $iobs = 1; $iobs <= 3; $iobs++ ){ 
      $obs[$iobs] = $encabezado["obs$iobs"]; 
    }
    $eiva = $encabezado["iva"] * 100;
    
    if( $tdd != "nota" ) //Los totales se calculan para todos los documentos excepto las notas
        $totales = obtenerTotales( $detalle_d, $encabezado["iva"] );
  }
  else{

  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $tdocumento." Nro. ".$encabezado["nro"];?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    .table-imp-det th{
      text-align:center !important;
      border: 1px solid #ddd;
    }
  </style>
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- info row -->
          <?php if($tdd != "fac") { ?>
          <div class="row" id="membrete">
              <div class="col-sm-2"></div><!-- /.col -->
              <div class="col-sm-8" align="center">
                  <div id="lin1">INSUMOS INFORMÁTICOS R & G, C.A.</div>
                  <div id="lin2">Suministros para Computación y Papelería</div>
                  <div id="lin3" class="membrete3">Calle Este 16, Sordo a Peláez, Residencias Sorpe, P.B. Local 1</div>
                  <div id="lin4" class="membrete3">Parroquia Santa Rosalía - Caracas</div>
                  <div id="lin5" class="membrete3">Telefonos (0212) 545.6529 / 395-5955 / Telefax: 5424137 CEL. 0416-624-4269</div>
                  <div id="lin6" class="membrete3">email: insumos_rg@cantv.net    /   rginsumosinformaticos@gmail.com</div>
              </div><!-- /.col -->
              <div class="col-sm-2"></div><!-- /.col -->
          </div><!-- /.row -->
          <?php }?>
          <div class="row invoice-info" id="encabezado" style="margin:20px 0;">
              <div class="col-sm-4 invoice-col" id="dcliente">
                  <div id="dc_nombre">Señores</div>
                  <div id="dc_nombre"><?php echo $encabezado["nombre"]?></div>
                  <div id="dc_nombre"><?php echo $encabezado["dir1"]?></div>
                  <div id="dc_nombre"><?php echo $encabezado["dir2"]?></div>
                  <div id="dc_nombre">Ciudad: Caracas</div>
              </div><!-- /.col -->
              
              <div class="col-sm-2 invoice-col"> </div><!-- /.col -->
              
              <div class="col-sm-3 col-xs-push-1 invoice-col" id="dcotizacion">
                  <div id="dctz_numero"><?php echo $tdocumento.":   ".$encabezado["nro"];?></div>
                  <div id="dctz_fecha">Fecha: &nbsp;<?php echo $encabezado["femision"];?></div>
                  <?php if($tdd == "ctz") { ?>
                    <div id="dctz_tlf">Vendedor: Nidia</div>
                  <?php } ?>
                  <?php if($tdd == "fac") { ?>
                    <div id="dctz_tlf">Fecha vencimiento: <?php echo ""; ?></div>
                    <div id="dctz_tlf">Orden de compra: <?php echo $encabezado["oc"]; ?></div>
                  <?php } ?>
              </div><!-- /.col -->
              
          </div><!-- /.row -->
          
          <div class="row">
            <div class="col-xs-12" id="texto_introductorio">
              <p class="tentrada"><?php echo $encabezado["intro"]; ?></p>
            </div> 
          </div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-imp-det">
                <thead>
                  <tr>
                    <th align="center">Descripción</th>
                    <th align="center">Cant</th>
                    <th align="center">UND</th>
                    <th align="center">Precio Unitario</th>
                    <th align="center">Total ítem</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach( $detalle_d as $item ) { ?>
                  <tr>
                    <td class="tit_tdf_i" align="left"><?php echo $item["descripcion"];?></td>
                    <td class="tit_tdf" align="center"><?php echo $item["cantidad"];?></td>
                    <td class="tit_tdf" align="center"><?php echo $item["und"];?></td>
                    <td class="tit_tdf" align="right"><?php echo number_format( $item["punit"], 2, ",", "" );?></td>
                    <td class="tit_tdf" align="right"><?php echo number_format( $item["ptotal"], 2, ",", "" );?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <!-- Bloque de observaciones -->
            <div class="col-xs-6">
              <p class="lead"><?php echo $encabezado["obs0"]; ?></p>
                <div><?php echo $obs[1]; ?></div>
                <div><?php echo $obs[2]; ?></div>
                <div><?php echo $obs[3]; ?></div>  
              </p>
            </div>
            <!-- /.<!-- Bloque de observaciones -->

            <div class="col-xs-6">
              <p class="lead">Totales</p>
              <div class="table-responsive" style="float:right;">
                <table class="table">
                  <tr>
                    <th style="width:75%">Subtotal:</th>
                    <td class="tit_tdf_d" align="right"><?php echo $totales["subtotal"]; ?></td>
                  </tr>
                  <tr>
                    <th>IVA (<?php echo $eiva; ?>%)</th>
                    <td class="tit_tdf_d" align="right"><?php echo $totales["iva"]; ?></td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td class="tit_tdf_d" align="right"><?php echo $totales["total"]; ?></td>
                  </tr>
                </table>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>

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
  include( "bd/data-cotizacion.php" );

  checkSession( '' );
  
  if( isset( $_GET["tipo_documento"] ) && ( isset( $_GET["id"] ) ) ){
    $id = $_GET["id"];
    $tdd = $_GET["tipo_documento"]; 

    if( $tdd == "ctz" ){
      $documento = obtenerCotizacionPorId( $dbh, $id );
      $encabezado = $documento["encabezado"];
      $obs1 = $encabezado["obs1"];
      $obs2 = "Validez: ".$encabezado["validez"];
      $detalle_d = $documento["detalle"];
      $tdocumento = "Cotización";
    }
    if( $tdd == "ped" ){
      $documento = obtenerPedidoPorId( $dbh, $id );
      $encabezado = $documento["encabezado"];
      $detalle_d = $documento["detalle"];
      $obs1 = $encabezado["obs1"];
      $obs2 = $encabezado["obs2"];
      $tdocumento = "Pedido";
    }
    if( $tdd == "fac" ){
      $documento = obtenerFacturaPorId( $dbh, $id );
      $encabezado = $documento["encabezado"];
      $detalle_d = $documento["detalle"];
      $obs1 = $encabezado["obs1"];
      $obs2 = $encabezado["obs2"];
      $tdocumento = "Factura";
    }
    $eiva = $encabezado["iva"] * 100;
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
  <title>AdminLTE 2 | Invoice</title>
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
                <div class="col-sm-4 invoice-col"> </div><!-- /.col -->
                
                <div class="col-sm-3 col-xs-push-2 invoice-col" id="dcotizacion">
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
                    <td align="right"><?php echo $item["punit"];?></td>
                    <td align="right"><?php echo ($item["ptotal"]);?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <!-- Bloque de observaciones -->
            <div class="col-xs-6">
              <p class="lead">Observaciones:</p>
                <div><?php echo $obs1; ?></div>
                <div><?php echo $obs2; ?></div>  
              </p>
            </div>
            <!-- /.<!-- Bloque de observaciones -->

            <div class="col-xs-6">
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
            </div><!-- /.col -->
          </div><!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>

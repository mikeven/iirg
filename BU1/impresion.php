<?php
  /*
  * IIRG - Visualización previa de impresión
  * 
  */
  session_start();
  ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-usuario.php" );
  include( "bd/data-formato.php" );
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
    $ftdd = $tdd;

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
      $tdocumento = etiquetaNota( $tipo_n, "etiqueta" );

      $t_concepto = $encabezado["tipo_concepto"];
      $detalle_d = $documento["detalle"];

      $tdocumento = etiquetaNota( $tipo_n, "etiqueta" );
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
  
  if( isset( $_GET["idu"] ) ){
    $idusuario = $_GET["idu"];
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
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">

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

    #encabezado{
      margin: 20px 0;
      <?php if($tdd == "fac") { ?>
        margin: 14% 0 20px 0;  
      <?php } ?>
    }

    #pie_documento{
      width: 100%;
      position: fixed;
      bottom: 0;
      margin-bottom: 4%;
    }

    #detalle_doc{
      width: 100%;
    }

    .table>tbody>tr>td, table>tbody>tr>th{
      line-height: 0.7 !important;
    }

    .table>thead>tr>th{
      border: 0 !important;
    }

    #tabla_detalle_doc>tbody>tr>td{
      border: 0; 
    }

    #tabla_detalle_doc>tbody{
      padding: 12px 0 0 0; 
    }

    #bordeado_doble{
      height: 5px;
      border-top: 1px dashed #000;
      border-bottom: 1px dashed #000; 
    }

    #dcliente{ width: 50% }
    #dmed{ width: 12%; }
    #dcotizacion{ width: 30%; }

    .tobsdoc{font-size: 16px;}

  </style>
</head>
  <?php 
    $frt = obtenerFormatoPorUsuarioDocumento( $dbh, $ftdd, $idusuario );
  ?>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- info row -->
          <?php if($tdd != "fac") { ?>
          <div class="row" id="membrete">
              <div class="col-sm-2"></div><!-- /.col -->
              <div class="col-sm-8" align="center">
                  <div id="lin1"><?php echo $frt["enc1"]?></div>
                    <div id="lin2"><?php echo $frt["enc2"]?></div>
                    <div id="lin3" class="membrete3"><?php echo $frt["enc3"]?></div>
                    <div id="lin4" class="membrete3"><?php echo $frt["enc4"]?></div>
                    <div id="lin5" class="membrete3"><?php echo $frt["enc5"]?></div>
                    <div id="lin6" class="membrete3"><?php echo $frt["enc6"]?></div>
              </div><!-- /.col -->
              <div class="col-sm-2"></div><!-- /.col -->
          </div><!-- /.row -->
          <?php }?>
          <div class="row" id="encabezado">
              <div class="col-sm-6 invoice-col" id="dcliente">
                  <div id="dc_nombre"><?php echo $encabezado["nombre"]?></div>
                  <div id="dc_nombre"><?php echo $encabezado["dir1"]?></div>
                  <div id="dc_nombre"><?php echo $encabezado["dir2"]?></div>
                  <div id="dc_nombre"><?php echo $encabezado["rif"]?></div>
              </div><!-- /.col -->
              
              <div id="dmed" class="col-sm-3 invoice-col"> </div><!-- /.col -->
              
              <div class="col-sm-4 col-xs-push-1 invoice-col" id="dcotizacion">
                  
                  <table width="100%" border="0">
                    <tr>
                      <td width="65%">
                        <div id="dctz_numero">
                          <?php echo "N° de ".$tdocumento.":";?>
                        </div>
                      </td>
                      <td width="35%">
                        <div id="dctz_numero_val">
                          <?php echo $encabezado["nro"]; ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div id="dctz_numero">
                          Fecha Emisión:
                        </div>
                      </td>
                      <td>
                        <div id="dctz_numero">
                          <?php echo $encabezado["femision"];?>
                        </div>
                      </td>
                    </tr>
                    <?php if($tdd == "ctz") { ?>
                    <tr>
                      <td>
                          <div id="dctz_tlf">Vendedor:</div>
                      </td>
                      <td>
                        <?php if($tdd == "ctz") { ?><div id="dctz_tlf">Nidia</div><?php } ?>
                      </td>
                    </tr>
                    <?php } ?>
                    <?php if($tdd == "fac") { ?>
                    <tr>
                      <td><div id="dctz_tlf">Fecha Vencimiento:</div></td>
                      <td><?php echo $encabezado["fvencimiento"]; ?></td>
                    </tr>
                    <tr>
                      <td><div id="dctz_tlf">Condición de Pago</div></td>
                      <td><?php echo $encabezado["validez"]; ?></td>
                    </tr>
                    <tr>
                      <td><div id="dctz_tlf">N° Orden Compra:</div></td>
                      <td><?php echo $encabezado["oc"]; ?></td>
                    </tr>
                    <?php } ?>
                  </table>

              </div><!-- /.col -->
              
          </div><!-- /.row -->
          
          <!-- Texto introductorio -->
          <div class="row">
            <div class="col-xs-12" id="texto_introductorio">
              <p class="tentrada"><?php echo $encabezado["intro"]; ?></p>
            </div> 
          </div><!-- /.Texto introductorio -->

          <!-- Table row -->
          <div class="row" id="detalle_doc">
            <div class="col-xs-12 table-responsive">
              <table id="tabla_detalle_doc" class="table">
                <thead>
                  <tr>
                    <th align="center">Descripción</th>
                    <th align="center">Cant</th>
                    <th align="center">UND</th>
                    <th align="center">Precio Unitario</th>
                    <th align="center">Total BsF.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5" align="left" class=""><div id="bordeado_doble"></div></td>
                  </tr>
                  <?php foreach( $detalle_d as $item ) { ?>
                  <tr>
                    <td class="tit_tdf_i" align="left"><?php echo $item["descripcion"];?></td>
                    <td class="tit_tdf" align="center"><?php echo $item["cantidad"];?></td>
                    <td class="tit_tdf" align="center"><?php echo $item["und"];?></td>
                    <td class="tit_tdf" align="right"><?php echo number_format( $item["punit"], 2, ",", "." );?></td>
                    <td class="tit_tdf" align="right"><?php echo number_format( $item["ptotal"], 2, ",", "." );?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div id="pie_documento" class="row pie_documento" >
            
            <!-- Bloque de observaciones -->
            <div class="col-xs-6">
              <div class="tobsdoc"><?php echo $encabezado["obs0"]; ?></div>
                <div><?php echo $obs[1]; ?></div>
                <div><?php echo $obs[2]; ?></div>
                <div><?php echo $obs[3]; ?></div>  
              </p>
            </div>
            <!-- /.<!-- Bloque de observaciones -->

            <div class="col-xs-6">
              <div class="table-responsive" style="float:right;">
                <table class="table">
                  <tr>
                    <th style="width:75%">Subtotal:</th>
                    <td class="tit_tdf_d" align="right"><?php echo number_format( $totales["subtotal"], 2, ",", "." ); ?></td>
                  </tr>
                  <tr>
                    <th>IVA (<?php echo $eiva; ?>%)</th>
                    <td class="tit_tdf_d" align="right"><?php echo number_format( $totales["iva"], 2, ",", "." ); ?></td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td class="tit_tdf_d" align="right"><?php echo number_format( $totales["total"], 2, ",", "." ); ?></td>
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

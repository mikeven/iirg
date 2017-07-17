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
    $ftdd = $tdd; $tipo_n = "";

    if( $tdd == "ctz" ){
      $documento = obtenerCotizacionPorId( $dbh, $id );
      $tdocumento = "Cotización";
    }
    if( $tdd == "sctz" ){
      $documento = obtenerSolicitudCotizacionPorId( $dbh, $id );
      $tdocumento = "Solicitud de Cotización";
    }      
    if( $tdd == "odc" ){
      $documento = obtenerOrdenCompraPorId( $dbh, $id );
      $tdocumento = "Ord. de compra";
    }
    if( $tdd == "fac" ){
      $documento = obtenerFacturaPorId( $dbh, $id );
      $tdocumento = "Factura";
    }
    if( $tdd == "nota" ){

      $tipo_n = obtenerTipoNotaPorId( $dbh, $id );
      $documento = obtenerNotaPorId( $dbh, $id, $tipo_n );
      $encabezado = $documento["encabezado"];
      $tdocumento = etiquetaNota( $tipo_n, "etiqueta" ); //data-nota.php

      $t_concepto = $encabezado["tipo_concepto"];
      $c_concepto = $encabezado["concepto"];
      $detalle_d = $documento["detalle"];

      $tdocumento = etiquetaNota( $tipo_n, "etiqueta" ); //data-nota.php
      $ftdd = docBD( $tipo_n );                          //data-formato.php
      
      if ( $tipo_n != "nota_entrega" ){
        $factura_nota = obtenerFacturaPorId( $dbh, $encabezado["idfactura"] );
        $nfact_nota = $factura_nota["encabezado"]["nro"];  
      }

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
  /*========================================================*/
  function tieneEncabezado( $tdd, $tn ){
    //Determina si un documento lleva el encabezado configurado en el formato
    $tiene = true;

    if( $tdd == "fac" ) 
        $tiene = false;
    if( ( $tdd == "nota" ) && ( $tn != "nota_entrega" ) ) 
      $tiene = false;

    return $tiene;
  }
  /*========================================================*/
  $tencabezado = tieneEncabezado( $tdd, $tipo_n );

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
    body{
    	font-size: 14px !important;
    }

    .table-imp-det th{
      text-align:center !important;
      border: 1px solid #ddd;
    }

    #encabezado{
      margin: 20px 0;
      <?php if( !$tencabezado ) { ?>
        margin: 15% 0 10px 0;  
      <?php } ?>
    }

    #pie_documento{
      width: 100%;
      position: fixed;
      bottom: 0;
      margin-bottom: 8%;
      font-size: 12px !important;
    }

    #tabla_detalle_doc{
      width: 100% !important;
    }

    #tabla_detalle_doc>tbody{
    	font-size: 12px !important;
      /*width: 100%;*/
    }
	
    #ddocumento_der table>tbody>tr>td{
      border: 0; 
    }
    <?php if( $tdd == "fac" ) { ?>
      .destacado{ font-size: 18px; }
    <?php } ?>
    
    .destacado2{ font-size: 13px; }
    
    .table>tbody>tr>td, table>tbody>tr>th{
      <?php if( $tdd == "fac" ) { ?>
        line-height: 0.3 !important;
      <?php } ?>
    }

    .table>thead>tr>th{
      border: 0 !important;
    }

    #tabla_detalle_doc>tbody>tr>td{
      border: 0; 
    }

    #tabla_detalle_doc>thead{
      vertical-align: bottom; 
    }

    #tabla_detalle_doc>tbody{
      padding: 0px 0 0 0; 
    }

    #bordeado_doble{
      height: 5px;
      margin: 6px 0;
      border-top: 1px dashed #000;
      border-bottom: 1px dashed #000; 
    }

    #dcliente{ width: 50% }
    #dmed{ width: 1%; }
    #ddocumento_der{ width: 35%; }

    .tobsdoc{font-size: 16px; }
    .uline{ text-decoration: underline; }

    .enc_ai{ text-align: left; }
    .enc_ac{ text-align: center; }
    .enc_ad{ text-align: right; }

    #totalizacion{
    	padding-right: 0px !important;
    }

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
          
          <div class="row" id="membrete">
            <div class="col-sm-2"></div><!-- /.col -->
            <div class="col-sm-8" align="center">
              
              <div id="lin1"> <?php echo $frt["enc1"]; ?> </div>
              <div id="lin2"> <?php echo $frt["enc2"]; ?> </div>
              <div id="lin3" class="membrete3"> <?php echo $frt["enc3"]; ?> </div>
              <div id="lin4" class="membrete3"> <?php echo $frt["enc4"]; ?> </div>
              <div id="lin5" class="membrete3"> <?php echo $frt["enc5"]; ?> </div>
              <div id="lin6" class="membrete3"> <?php echo $frt["enc6"]; ?> </div>

            </div>
            <div class="col-sm-2"></div><!-- /.col -->
          </div><!-- /.row -->
          
          <div class="row" id="encabezado">
              <div class="col-sm-6 invoice-col" id="dcliente">
                  <div id="dc_nombre"><?php echo $encabezado["nombre"]?></div>
                  <div id="dc_dir1"><?php echo $encabezado["dir1"]?></div>
                  <div id="dc_dir2"><?php echo $encabezado["dir2"]?></div>
                  <div id="dc_rif"><?php echo "Rif ".$encabezado["rif"]?></div>
                  <?php if( ( $tdd == "nota" ) || ( $tdd == "fac" ) ) { ?>
                    <div id="dc_telf">
                      <?php echo "Telf.: ".$encabezado["tlf1"]." - ".$encabezado["tlf2"]?>
                    </div>  
                  <?php } ?>
                  <?php if( $tdd == "ctz" ) { ?>
                    <div id="dc_pcontacto"> Attn <?php echo $encabezado["pcontacto"]?></div>
                  <?php } ?>  
              </div><!-- /.col -->
              
              <div id="dmed" class="col-sm-2 invoice-col"> </div><!-- /.col -->
              
              <!-- Datos documento -->
              <?php include("sub-scripts/impresion/datos_documento.php");?>
              <!-- /.Datos documento -->
              
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
              <table id="tabla_detalle_doc" class="table_x">
                <thead>
                  <tr>
                    <th class="enc_ac" width="55%">DESCRIPCIÓN</th>
                    <th class="enc_ac" width="10%">CANT</th>
                    <th class="enc_ac" width="10%">UND</th>
                    <th class="enc_ad" width="10%">PRECIO <br>UNITARIO</th>
                    <th class="enc_ad" width="15%">TOTAL BSF.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5" align="left" class="divisor"><div id="bordeado_doble"></div></td>
                  </tr>
                  <?php foreach( $detalle_d as $item ) { ?>
                  <tr>
                    <td class="tit_tdf_i" align="left"><?php echo $item["descripcion"];?></td>
                    <td class="tit_tdf" align="center"><?php echo $item["cantidad"];?></td>
                    <td class="tit_tdf" align="center"><?php echo $item["und"];?></td>
                    <td class="tit_tdf" align="right">
                      <?php echo number_format( $item["punit"], 2, ",", "." );?>
                    </td>
                    <td class="tit_tdf" align="right">
                      <?php echo number_format( $item["ptotal"], 2, ",", "." );?>
                    </td>
                  </tr>
                  <?php } //end: foreach ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Pie de documento -->
          <?php include("sub-scripts/impresion/pie.php");?>
          <!-- /.Pie de documento -->

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>

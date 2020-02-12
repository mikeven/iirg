<?php
  /*
  * IIRG - Visualización previa de impresión
  * 
  */
  session_start();
  ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-usuario.php" );
  include( "bd/data-sistema.php" );
  include( "bd/data-compra.php" );
  
  checkSession( '' );
  
  if( isset( $_GET["idr"] ) ){
    $idr = $_GET["idr"];
    $usuario = obtenerUsuarioPorId( $_SESSION["user"]["idUsuario"], $dbh );
   
    if( isset( $_GET["idu"] ) ){
      $idu = $_GET["idu"];
    } else  $idu = $usuario["idUsuario"];

    $compra = obtenerCompraPorId( $dbh, $idr, $idu );
    
    if( $compra ){

      $m_iva = $compra["mbase"] * ( $compra["iva"] / 100 );
      $total_c = $compra["mbase"] + $m_iva;
      $fecha_doc = $compra["femision"];
      
      $fecha_ret = $compra["fretencion"];
      $data_fr = explode( '/', $fecha_ret );
      $periodo_f = "Año: ".$data_fr[2]."  /Mes: ".$data_fr[1];

    }

  }  
  /*========================================================*/
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo "Retención Nro. $compra[nret]";?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">

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

    #firmaysello{
      margin-top: 65px;
    }

    #fecha_entrega{
      margin-top: 30px;
    }

    #texto_introductorio{
      margin-top: 30px;
    }

    #lin1, #lin2 {
      font-size: 16px;
      font-weight: bolder;
      text-transform: uppercase;
    }
    .dato_enc{ font-weight: bolder; }

    #lin3{ font-size: 16px; }

    .lin_firma{ border-bottom: 1px solid #000; margin-bottom: 5px; }
    .btop{ border-top: 1px solid #000 !important; }

    #tabla_detalle_doc{
      width: 100% !important;
      font-size: 10px;
    }

    #tabla_detalle_doc>tbody{
    	font-size: 12px !important;
      /*width: 100%;*/
    }
    
    .table>tbody>tr>td, table>tbody>tr>th{
       line-height: 0.3 !important;
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

    #bordeado_simple{
      height: 5px;
      margin: 6px 0;
      border-bottom: 1px solid #000; 
    }

    #dcliente{ width: 55% }
    #dmed{ width: 1%; }
    

    .enc_ai{ text-align: left; }
    .enc_ac{ text-align: center; }
    .enc_ad{ text-align: right; }

    #totalizacion{
    	padding-right: 0px !important;
    }

  </style>
</head>
  <?php 
    //$frt = obtenerFormatoPorUsuarioDocumento( $dbh, $ftdd, $idusuario );
  ?>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- info row -->
          
          <div class="row" id="membrete">
            
            <div class="col-sm-12" align="center">
              
              <div id="lin1"><?php echo $usuario["empresa"]; ?></div>
              <div id="lin2"> RIF N° <?php echo $usuario["rif"]; ?> </div>
              <div id="lin3"> COMPROBANTE DE RETENCIÓN DEL IMPUESTO AL VALOR AGREGADO </div>

            </div>
            
          </div><!-- /.row -->

          <!-- Texto introductorio -->
          <div class="row">
            <div class="col-xs-12" id="texto_introductorio">
              <p class="tentrada" align="center">(Ley IVA Art. 11 Gaceta Oficial 6.152 Extraordinario: "Serán responsables del pago del impuesto, en calidad de agentes de retención, quienes por sus <br>funciones públicas o por razón de sus actividades privadas intervengan en operaciones gravadas con el impuesto establecido en esta Ley")</p>
            </div> 
          </div><!-- /.Texto introductorio -->
          
          <div class="row" id="encabezado">
              
              <div class="col-sm-6 invoice-col" id="dcliente">
                  <div><span class="dato_enc">Ciudad: </span>Caracas</div>
                  <div><span class="dato_enc">Fecha de Emisión: </span>
                  <?php echo $fecha_ret; ?></div>
                  <div align="center" class="dato_enc">DATOS DEL AGENTE DE RETENCIÓN</div>
                  <div>
                    <span class="dato_enc">Nombre o Razón Social: </span>
                    <?php echo $usuario["empresa"]; ?>
                  </div>
                  <div><span class="dato_enc">N° R.I.F.: </span><?php echo $usuario["rif"]; ?></div>
                  <div><span class="dato_enc">N° N.I.T.:</span></div>
                  <div><span class="dato_enc">Dirección: </span>
                    <?php echo $usuario["direccion1"]; ?></div>
                  <div><span class="dato_enc">Teléfonos: </span>
                    <?php echo $usuario["telefonos"]; ?></div>
                    
              </div><!-- /.col -->
              <div class="col-sm-6 invoice-col" id="dbeneficiario">
                  <div>
                    <span class="dato_enc">N° Comprobante: </span>
                    <?php echo $compra["nret"];?>
                  </div>
                  <div><span class="dato_enc">Período fiscal: </span>
                  <?php echo $periodo_f; ?></div>
                  <div align="center" class="dato_enc">DATOS DEL BENEFICIARIO</div>
                  <div>
                    <span class="dato_enc">Nombre o Razón Social: </span>
                    <?php echo $compra["proveedor"]; ?>
                  </div>
                  <div>
                    <span class="dato_enc">N° R.I.F.:</span>
                    <?php echo $compra["rif_p"]; ?>
                  </div>
                  <div><span class="dato_enc">N° N.I.T.:</span></div>
                  <div>
                    <span class="dato_enc">Dirección: </span>
                    <?php echo $compra["dir1"]." ".$compra["dir2"]; ?>
                  </div>
                  <div><span class="dato_enc">Teléfonos: </span></div>
                    
              </div><!-- /.col -->
              
          </div><!-- /.row -->
          
          <!-- Títulos tabla -->
          <div align="center" class="row">
            <div class="col-sm-6">
              <p class="dato_enc">DATOS DE LA RETENCIÓN</p>
            </div>
            <div class="col-sm-6">
              <p class="dato_enc">COMPRAS INTERNAS O IMPORTACIONES</p>
            </div> 
          </div><!-- /.Títulos tabla -->

          <!-- Tabla de datos de retención -->
          <div class="row" id="detalle_doc">
            <div class="col-sm-12 table-responsive">
              <table id="tabla_detalle_doc" class="table">
                <thead>
                  <tr>
                    <th class="enc_ac" width="1%">N°</th>
                    <th class="enc_ac" >Fecha Doc.</th>
                    <th class="enc_ac" >N° Factura</th>
                    <th class="enc_ac" width="10%">N° Control</th>
                    <th class="enc_ac" >N° N.Débito</th>
                    <th class="enc_ac" >N° N.Crédito</th>
                    <th class="enc_ac" >Tipo transacción</th>
                    <th class="enc_ac" >N° Fact Afectada</th>
                    <th class="enc_ac" >Total Factura o Nota Débito</th>
                    <th class="enc_ac" >Sin derecho a crédito</th>
                    <th class="enc_ac" >Base imponible</th>
                    <th class="enc_ac" >% Alic.</th>
                    <th class="enc_ac" >Impuesto Causado</th>
                    <th class="enc_ac" >Impuesto Retenido</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="hidden">
                    <td colspan="5" align="left" class="divisor">
                      <div id="bordeado_simple"></div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td class="tit_tdf_i" align="left">1</td>
                    <td class="tit_tdf" align="center"><?php echo $compra["femision"]?></td>
                    <td class="tit_tdf" align="center"><?php echo $compra["nfactura"]?></td>
                    <td class="tit_tdf" align="center"><?php echo $compra["ncontrol"]?></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="right">01 Registro</td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="center">
                      <?php echo number_format( $total_c, 2, ",", "." ); ?>
                    </td>
                    <td class="tit_tdf" align="right">0,00</td>
                    <td class="tit_tdf" align="right">
                      <?php echo number_format( $compra["mbase"], 2, ",", "." );?>
                    </td>
                    <td class="tit_tdf" align="center">
                      <?php echo number_format( $compra["iva"], 2, ",", "." );?>
                    </td>
                    <td class="tit_tdf" align="right">
                      <?php echo number_format( $m_iva, 2, ",", "." );?>
                    </td>
                    <td class="tit_tdf" align="right">
                      <?php echo number_format( $compra["retencion"], 2, ",", "." );?>
                    </td>
                  </tr>

                  <tr>
                    <td class="tit_tdf_i" align="left"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="right"></td>
                  </tr>

                  <tr>
                    <td class="tit_tdf_i" align="left"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="center"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf" align="right"></td>
                    <td class="tit_tdf btop" align="center">
                      <?php echo number_format( $total_c, 2, ",", "." ); ?>
                    </td>
                    <td class="tit_tdf btop" align="right">0,00</td>
                    <td class="tit_tdf btop" align="right">
                      <?php echo number_format( $compra["mbase"], 2, ",", "." );?>
                    </td>
                    <td><!-- Alic IVA--></td>
                    <td class="tit_tdf btop" align="right">
                      <?php echo number_format( $m_iva, 2, ",", "." );?>
                    </td>
                    <td class="tit_tdf btop" align="right">
                      <?php echo number_format( $compra["retencion"], 2, ",", "." );?>
                    </td>
                  </tr>
                  
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div id="firmaysello" class="row" align="center">
            <div class="col-sm-12">
              <div class="lin_firma" style="width: 300px;"></div>
              <div class="tentrada">Firma y Sello Agente de Retención</div>
              <div class="tentrada">RIF N° <?php echo $usuario["rif"]; ?></div>
            </div>
          </div><!-- /.Firma y sello -->

          <div id="fecha_entrega" class="row">
            <div class="col-sm-12">
              <div class="tentrada">Fecha de entrega: 
              <div class="lin_firma" style="width: 150px; margin-left: 110px;"></div></div>
            </div>
          </div><!-- /.Fecha de entrega -->

          <!-- Pie de documento -->
          <?php //include("sub-scripts/impresion/pie.php");?>
          <!-- /.Pie de documento -->

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>

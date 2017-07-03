<?php
  /*
  * IIRG - Visualización previa de impresión
  * 
  */
  session_start();
  ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-usuario.php" );
  include( "bd/data-reporte.php" );
  
  checkSession( '' );
  
  if( isset( $_GET["idu"] ) ){
    $idusuario = $_GET["idu"];
  }
  /*========================================================*/
  
  

  /*========================================================*/
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

    #encabezado{
      margin: 20px 0;
      <?php if( !$tencabezado ) { ?>
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
    #dmed{ width: 1%; }
    #ddocumento_der{ width: 35%; }

    .tobsdoc{font-size: 16px; }
    .uline{ text-decoration: underline; }

  </style>
</head>
  <?php 
    $frt = obtenerFormatoPorUsuarioDocumento( $dbh, $ftdd, $idusuario );
  ?>
<body onload="window.print();">
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">



    </section>
    <!-- /.content -->
  </div>
<!-- ./wrapper -->
</body>
</html>

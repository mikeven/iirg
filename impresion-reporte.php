<?php
  /*
  * IIRG - Visualización de impresión de reportes
  * 
  */
  session_start();
  ini_set( 'display_errors', 1 );
  include( "bd/bd.php" );
  include( "bd/data-usuario.php" );
  include( "fn/fn-reportes.php" );
  
  checkSession( '' );
  /*========================================================*/
  if( isset( $_GET["idr"] ) ){
    $idr = $_GET["idr"];

    if( isset( $_GET["idu"] ) ) 
      $idu = $_GET["idu"];

    
    if( isset( $_GET["f1"] ) && isset( $_GET["f2"] ) ){
      $fini = $_GET["f1"]; $ffin = $_GET["f2"];
      $ff1 = cambiarFormatoFecha( $dbh, $fini );
      $ff2 = cambiarFormatoFecha( $dbh, $ffin );           
    }
  }
  $usuario = obtenerUsuarioPorId( $_SESSION["user"]["idUsuario"], $dbh ); 
  /*========================================================*/
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $idr;?></title>
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
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

  <!-- jQuery 2.1.4 -->
  <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>

  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
  <!-- date-range-picker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- page script -->
  <script src="js/fn-reportes.js"></script>
  
  <style>
    .table-imp-det th{
      text-align:center !important;
      border: 1px solid #ddd;
    }

    #encabezado{
      margin: 40px 0;
    }

    #titulo_reporte{
      font-size: 24px;
    }

    #detalle_doc{
      width: 100%;
    }

    .table > tbody > tr > td, table > tbody > tr > th{
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
  
<body onload="r()">
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <input id="idr" type="hidden" value="<?php echo $idr; ?>">
      <input id="fini" type="hidden" value="<?php echo $fini; ?>">
      <input id="ffin" type="hidden" value="<?php echo $ffin; ?>">
      <input id="idu_sesion" type="hidden" value="<?php echo $idu; ?>">
        
        <div class="row" id="encabezado">
          <div class="col-sm-1"></div><!-- /.col -->
          <div class="col-sm-10" align="center">
            
            <div id="lin1"> <?php echo $usuario["empresa"]; ?> </div>
            <div id="lin2" class="membrete3"> <?php echo $usuario["subtitulo"]; ?> </div>
            <div id="lin3"> <?php echo $usuario["rif"]; ?> </div>
            <div id="lin4" class="membrete3"> <?php echo $usuario["direccion1"]." ".$usuario["direccion2"]; ?> </div>
            <div id="lin5" class="membrete3"> <?php echo $usuario["telefonos"]; ?> </div>
            <div id="lin6" class="membrete3"> <?php echo $usuario["email"]; ?> </div>

          </div>
          <div class="col-sm-1"></div><!-- /.col -->

        </div><!-- /.row -->
        
        <div class="row" id="titulo_reporte" align="center">
          <span><?php echo tituloReporte( $idr )." ".$ff1." - ".$ff2; ?></span>
        </div>

        <div class="row" id="membrete">
          <div class="col-sm-2"></div><!-- /.col -->
          <div class="col-sm-8" align="center">
            
            <table id="tabla_reporte" class="table table-hover">
              <thead>
                
              </thead>
              <tbody>
                
              </tbody>
            </table>

          </div>
          <div class="col-sm-2"></div><!-- /.col -->
          
        </div><!-- /.row -->



      
    </section>
    <!-- /.content -->
  </div>
<!-- ./wrapper -->
</body>
</html>

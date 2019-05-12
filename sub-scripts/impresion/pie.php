<div id="pie_documento" class="row pie_documento">

  <!-- Bloque de observaciones -->
  <div class="col-xs-8">
    <?php if( $tdd == "nota" ) { ?>
      <div class="tconcepto"><?php echo $c_concepto; ?> </div>
    <?php } ?>  
      <?php if( $tdd == "ctz" ) { ?>
        <div class="tobsdoc uline"><b> <?php echo $encabezado["obs0"]; ?> </b></div>
      <?php } else { ?>
        <div class="tobsdoc"><?php echo $encabezado["obs0"]; ?></div>
      <?php } ?>  
      <div><?php echo $obs[1]; ?></div>
      <div><?php if( $obs[2] != "" ) echo $obs[2]; else echo "<br><br>";?></div>
      <div><?php echo $obs[3]; ?></div>  
  </div>
  <!-- /.Bloque de observaciones -->

  <!-- Totalización -->
  <?php if( $tipo_n != "nota_entrega" ){ ?>
  <div id="totalizacion" class="col-xs-4">
    <div class="table-responsive" style="float:right;">
      <table class="table_">
        <tr>
          <th style="width:75%">Subtotal BsS:</th>
          <td class="tit_tdf_d" align="right">
          <?php echo number_format( $totales["subtotal"], 2, ",", "." ); ?></td>
        </tr>
        <tr>
          <th>IVA (<?php echo $eiva; ?>%)</th>
          <td class="tit_tdf_d" align="right">
          <?php echo number_format( $totales["iva"], 2, ",", "." ); ?></td>
        </tr>
        <tr class="destacado2">
          <th>Total BsS.:</th>
          <td class="tit_tdf_d" align="right">
          <b><?php echo number_format( $totales["total"], 2, ",", "." ); ?></td></b>
        </tr>
        <tr class="destacado2 hidden">
          <th>Total BsS:</th>
          <td class="tit_tdf_d" align="right">
          <b><?php echo number_format( $totales["total_s"], 2, ",", "." ); ?></td></b>
        </tr>
      </table>
    </div>
  </div><!-- /.col:Totalización -->
  <?php } ?>
</div><!-- /.row: Pie de documento -->
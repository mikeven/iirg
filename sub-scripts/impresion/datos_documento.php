<div class="col-sm-4 col-xs-push-1 invoice-col" id="ddocumento_der">          
  
  <table width="100%" border="0" class="table">
    <tr class="destacado">
      <td width="70%">
        <div id="doc_numero_et">
          <b><?php echo "N° de ".$tdocumento.":";?></b>
        </div>
      </td>
      <td width="30%" style="vertical-align:bottom;">
        <div id="doc_numero_val">
          <b><?php echo $encabezado["nro"]; ?></b>
        </div>
      </td>
    </tr>
    
    <tr>
      <td>
        <div id="doc_femision_et">
          Fecha Emisión:
        </div>
      </td>
      <td>
        <div id="doc_femision_val">
          <?php echo $encabezado["femision"]; ?>
        </div>
      </td>
    </tr>

    <?php if( ( $tdd == "nota" ) && ( $tipo_n != "nota_entrega" ) ) { ?>
    <tr>
      <td>
        <div id="doc_femision_et">
          N° Factura:
        </div>
      </td>
      <td>
        <div id="doc_femision_val">
          <?php echo $nfact_nota;?>
        </div>
      </td>
    </tr>
    <?php } ?>

    <?php if($tdd == "ctz") { ?>
    <tr>
      <td>
          <div id="doc_vend_et">Vendedor:</div>
      </td>
      <td>
        <?php if($tdd == "ctz") { ?><div id="doc_vend_val">Nidia</div><?php } ?>
      </td>
    </tr>
    <?php } ?>
    <?php if($tdd == "fac") { ?>
    <tr>
      <td><div id="doc_fvenc">Fecha Vencimiento:</div></td>
      <td><?php echo $encabezado["fvencimiento"]; ?></td>
    </tr>
    <tr>
      <td><div id="doc_cond">Condición de Pago</div></td>
      <td><?php echo $encabezado["condicion"]; ?></td>
    </tr>
    <tr>
      <td><div id="doc_noc">N° Orden Compra:</div></td>
      <td><?php echo $encabezado["oc"]; ?></td>
    </tr>
    <?php } ?>
    <?php if($tdd == "fpro") { ?>
      <tr>
        <td><div id="doc_noc">N° Orden Compra:</div></td>
        <td><?php echo $encabezado["oc"]; ?></td>
      </tr>
    <?php } ?>
  </table>

</div><!-- /.col -->
<div class="modal fade" id="calculopvp" tabindex="-1" role="dialog" aria-labelledby="myModalLabelPVP">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelPVP">Cálculo PVP</h4>
      </div>
      <div class="modal-body">
        <form id="frm_calculopvp">
          <div class="box-body">
            <div class="form-group">
              <!--<label for="exampleInputEmail1">Email address</label>-->
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                  <input type="text" class="form-control calc_pvp" id="costo_base" 
                  placeholder="Costo base" name="costo_base" 
                  data-err="#err_desc" style="width: 25%;" 
                  onkeypress="return isNumberKey(event)">
                </div>
            </div><!-- /.form group -->
            <div class="form-group">
              <!--<label for="exampleInputEmail1">Email address</label>-->
                <div class="input-group">
                  <div class="input-group-addon">%</div>
                  <input type="text" class="form-control calc_pvp" id="pganancia_estimada" 
                  placeholder="Porcentaje ganancia estimada" name="pganancia_estimada" data-err="#err_desc" style="width: 25%;" onkeypress="return isNumberKey(event)">
                </div>
            </div><!-- /.form group -->
            <div class="form-group">
              <!--<label for="exampleInputEmail1">Email address</label>-->
                <div class="input-group">
                  <div class="input-group-addon">%</i></div>
                  <input type="text" class="form-control calc_pvp" id="pcomision" 
                  placeholder="% Comisión de venta" 
                  name="pcomision" style="width: 25%;" 
                  onkeypress="return isNumberKey(event)">
                </div>
            </div><!-- /.form group -->
            
            <input id="pdebito_bancario" type="hidden" value="<?php echo $sisval_db; ?>">
            <input id="pdif_retencion" type="hidden" value="<?php echo $sisval_dr; ?>">
            <input id="val_piva" type="hidden" value="<?php echo $iva; ?>">
            
            <table id="tabla_calculo_pv" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Costo + IVA</th>
                  <th>Débito B.</th>
                  <th>% VAR</th>
                  <th>P/V</th>
                  <th>% IVA</th>
                  <th>Total Venta</th>
                  <th>Ganancia</th>
                  <th>%G</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th><span id="r_cmasiva"></span></th>
                  <th><span id="r_db"></span></th>
                  <th><span id="r_pvar"></span></th>
                  <th><span id="r_pv"></span></th>
                  <th><span id="r_piva"></span></th>
                  <th><span id="r_tv"></span></th>
                  <th><span id="r_ganancia"></span></th>
                  <th><span id="r_pgegan"></span></th>
                </tr>
              </tbody>
            </table>

            <table id="tabla_calculo_pv_comision" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Comisión de venta</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th><span id="r_comision"></span></th>
                </tr>
              </tbody>
            </table>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="xmodalcalculopv" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-4">
           
              <table>
                  <tr>
                      <td>Tasa Cambio Dia</td>
                      <td><input  class="form-control" readonly="true" value="<?php echo TasaCambio::TasaDia($dia) ?>" name="tasacambio" id="tasacambio"></td>
                  </tr>
                  <tr>
                      <td>Tasa Cambio Promedio</td>
                      <td><input  class="form-control" readonly="true"  value="<?php echo TasaCambio::TasaPromedio() ?>" name="tasacambiop" id="tasacambiop"></td>
                  </tr>
                  
              </table>
            </div>
            <div class="col-lg-2">            
             <a target="_blank" href="<?php echo url_for('concilia_todo/reporte?dia='.$dia) ?>" class="btn  btn-sm btn-dark  btn-block" > <i class="flaticon2-printer"></i>Reporte </a>
             <br>
             <a target="_blank" href="<?php echo url_for('concilia_todo/reporteEx?dia='.$dia)  ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>            
            </div>
        </div>
    <div class="row">
                                    <div class="col-md-5" style="padding-top:1px; padding-bottom: 15px; font-weight: bold">Valor Actual</div>
                                    <div class="col-md-6"><input class="form-control" style="background-color:#F9FBFE ;" readonly="true" value="<?php echo Parametro::formato($prestamo->getValorActual(), false); ?>" name="valoractual" id="valoractual"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5" style="padding-top:1px; padding-bottom: 15px; font-weight: bold">Tasa Cambio Dia</div>
                                    <div class="col-md-6"><input class="form-control"  style="background-color:#F9FBFE ;" readonly="true" value="<?php echo $tasa; ?>" name="tasacambio" id="tasacambio"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5" style="padding-top:1px; padding-bottom: 15px; font-weight: bold">% Interes</div>
                                    <div class="col-md-6"><input class="form-control" style="background-color:#F9FBFE ;" readonly="true" value="<?php echo $prestamo->getTasaInteres(); ?>" name="intere" id="intere"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5" style="padding-top:1px; padding-bottom: 15px; font-weight: bold">Fecha Ult.</div>
                                    <div class="col-md-6"><input class="form-control" style="background-color:#F9FBFE ;" readonly="true" value="<?php echo $prestamo->getUltimo(); ?>" name="fechaPag" id="fechaPag"></div>
                                </div>
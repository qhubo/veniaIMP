<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>

<form action="<?php echo url_for($modulo . '/index?fecha=' . $fecha) ?>" method="get">
    <div class="kt-portlet kt-portlet--responsive-mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="flaticon2-list-3"></i>
                </span>
                <h3 class="kt-portlet__head-title kt-font-brand"> Libro Balance
                    <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seleccione la fecha del reporte</small>
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <input onchange="this.form.submit()" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="fecha" value="<?php echo $fecha; ?>" id="fecha">

                <a target="_blank" href="<?php echo url_for('libro_balance/reporte') ?>" class="btn  btn-sm btn-warning" > <i class="flaticon2-printer"></i>Resumido </a>

                <a target="_blank" href="<?php echo url_for('libro_balance/reporte') ?>?d=1" class="btn  btn-sm btn-success" > <i class="flaticon2-printer"></i>Detallado </a>
            </div>
        </div>
        <div class="kt-portlet__body">

                     <div class="row" style="padding-top:15px">
                <div class="col-md-10">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  active " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_contentxx" role="tab" aria-selected="false">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 
                            </a>
                        </li>
                        <li class="nav-item">
<!--                            <a class="nav-link   " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_contentxx" role="tab" aria-selected="false">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i> Declara
                            </a>-->
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" >
                <div class="tab-pane active  " id="kt_portlet_base_demo_2_3_tab_contentxx" role="tabpanel">
            <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
                <?php $bandera = ''; ?>
                <?php $banderatotal = false; ?>
                <?php $TOTAL = 0; ?>
                <?php $CONTEO = 0; ?>

                <?php foreach ($registros as $data) { ?>          
                    <?php $Lista = LibroAgrupadoDetalleQuery::create()
                            ->orderByCuentaContable("Asc")
                            ->filterByLibroAgrupadoId($data->getId())->find(); ?>
                    <?php if ($bandera <> $data->getGrupo()) { ?>
                        <?php $bandera = $data->getGrupo(); ?>
                        <?php $can = 0; ?>

                        <?php $maxi = LibroAgrupadoQuery::create()->filterByGrupo($bandera)->count(); ?>
                        <div class="row">
                            <div class="col-lg-8"><font size="+1"> <strong><?php echo $bandera; ?></strong> </font> </div>
                        </div>
                    <?php } ?>
                    <?php $can++; ?>
                    <?php $SALDO = $data->getSaldo($fechafin); ?>
                    <?php if ($data->getAbs()) { ?>
                        <?php $SALDO = abs($SALDO); ?>
                    <?php } ?>
                    <?php $nombre = strtoupper(substr(rtrim($data->getNombre()), -9)); ?> 
                    <?php if ($nombre == 'EJERCICIO') { ?>
                        <?php $SALDO = $resultado; ?>
                    <?php } ?>
                    <!--                Resultado del Ejercicio-->

                    <?php $TOTAL = $TOTAL + $SALDO; ?>
                    <div class="card ">
                        <div class="card-header" style="padding-top:0px !important; padding-bottom:0px !important;" id="faqHeading<?php echo $data->getId(); ?>">
                          <div class="card-title collapsed text-dark"  style="padding-top:0px !important; padding-bottom:0px !important;" data-toggle="collapse" data-target="#faq<?php echo $data->getId(); ?>" aria-expanded="false" aria-controls="faq<?php echo $data->getId(); ?>" role="button">
                                <table class="table" >
                                    <tr>
                                        <td width="20%"> <?php echo $data->getNombre(); ?></td>
                                        <?php if (!$data->getHaber()) { ?>
                                            <td style="text-align: right"  width="10%"><?php  echo Parametro::formato($SALDO, true); ?></td>
                                            <td style="text-align: right" width="10%"></td>
                                        <?php } else { ?>
                                            <td style="text-align: right" width="10%"></td>
                                            <td style="text-align: right" width="10%"><?php echo Parametro::formato($SALDO, true); ?></td>

                                        <?php } ?>
                                        <td width="30%"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div id="faq<?php echo $data->getId(); ?>" class="collapse" aria-labelledby="faqHeading<?php echo $data->getId(); ?>" data-parent="#faq">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-8">
                                        <table class="table">
                                            <?php $x=0; ?>
                                            <?php foreach ($Lista as $reg) { ?>
                                                <?php //$fechafin= date("Y-m-d",strtotime($fechafin."+ 1 days")); ?>
                                                <?php $saldo = CuentaErpContablePeer::getSaldoFecha($fechafin, $reg->getCuentaContable(), false); ?>
                                           
                                            <?php //if ($saldo >0 ) { ?>
                                            <?php $x++; ?>
                                            <tr>
                                                    <td><?php //echo $x; ?>  <strong><?php echo $reg->getCuentaContable(); ?></strong> </td>
                                                    <td><?php echo $reg->getDescripcion(); ?></td>
                                                    <td style="text-align: right"><?php echo Parametro::formato($saldo, false); ?></td>
                                                </tr>
                                            <?php //} ?>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($can == $maxi) { ?>
                        <?php $TOTALFINAL = $TOTAL; ?>
                        <div class="row" style=" padding-top: 2px; margin-top: 2px; padding-bottom: 2px;">
                            <div class="col-lg-2"></div>  
                            <div class="col-lg-4"> <strong>TOTAL</strong>  </div>
                            <div class="col-lg-2"  style="text-align: right;  border-bottom: 0.2px solid #5E80B4;font-size:12px; "><STRONG><?php echo Parametro::formato($TOTAL, true); ?> </div>
                        </div>
                        <?php $CONTEO++; ?>
                        <?php if ($CONTEO == 1) { ?>
                            <?php $TOTAL1 = $TOTAL; ?>
                        <?php } ?>
                        <?php if ($CONTEO == 2) { ?>
                            <?php $TOTAL2 = $TOTAL; ?>
                        <?php } ?>

                        <?php if ($CONTEO == 3) { ?>
                            <?php $TOTAL3 = $TOTAL; ?>
                        <?php } ?>
                        <?php if ($CONTEO == 4) { ?>
                            <?php $TOTAL4 = $TOTAL; ?>
                        <?php } ?>
                        <?php if ($CONTEO == 2) { ?>
                            <div class="row" style="background-color:#F8F5F0;padding-top: 2px;padding-bottom: 2px;">
                                <div class="col-lg-2"></div>  
                                <div class="col-lg-4"> <strong>TOTAL ACTIVO</strong>  </div><?php $totalBloque1 = $TOTAL1 + $TOTAL2; ?>
                                <div class="col-lg-2" style="text-align: right; font-size:16px;"><STRONG><?php echo Parametro::formato($TOTAL1 + $TOTAL2, true); ?> </div>
                            </div>
                        <?php } ?>

                        <?php if ($CONTEO == 4) { ?>
                            <div class="row" style="background-color:#F8F5F0;padding-top: 2px;padding-bottom: 2px;">
                                <div class="col-lg-2"></div>  
                                <div class="col-lg-4"> <strong>TOTAL PASIVO</strong>  </div>
                                <div class="col-lg-2" style="text-align: right; font-size:16px;"><STRONG><?php echo Parametro::formato($TOTAL3 + $TOTAL4, true); ?> </div>
                            </div>
                            <!--                        <div class="row" style="background-color:#F8F5F0;padding-top: 2px;padding-bottom: 2px;">
                                                            <div class="col-lg-2"></div>  
                                                            <div class="col-lg-4"> <strong>PÉRDIDA DEL EJERCICIO</strong>  </div>
                                                            <div class="col-lg-2" style="text-align: right;"><STRONG><?php //echo Parametro::formato($TOTAL3 + $TOTAL4, true);  ?> </div>
                                                        </div>-->
                        <?php } ?>


                        <?php $TOTAL = 0; ?>

                    <?php } ?>
                <?php } ?>

                <div class="row" style="background-color:#F8F5F0;padding-top: 2px;padding-bottom: 2px;">
                    <div class="col-lg-2"></div>  
                    <div class="col-lg-4"> <strong>TOTAL </strong>  </div><?php $totalBloque2 = $TOTAL3 + $TOTAL4 + ($resultado*-1) + $TOTALFINAL; ?>
                    <div class="col-lg-2" style="text-align: right; font-size:16px;"><STRONG><?php echo Parametro::formato($TOTAL3 + $TOTAL4 + ($resultado*-1) + $TOTALFINAL, true); ?> </div>
                </div>
            </div>
                    
                      <div class="row" style="background-color:#FAF9DB;padding-top: 2px;padding-bottom: 2px;">
                    <div class="col-lg-3"></div>  
                    <div class="col-lg-4"> <strong>DIFERENCIA </strong>  </div><?php $DIFENRENCIA= $totalBloque2 -$totalBloque1; ?>
                    <div class="col-lg-2" style="text-align: right; font-size:16px;"><STRONG><?php echo Parametro::formato($DIFENRENCIA, FALSE); ?> </div>
                </div>
            </div>
                     </div>
              
                    <div class="row" style="padding-top:10px">
                          <div class="col-lg-1"></div>  
                    <div class="col-lg-2"> <strong>DECLARA </strong>  </div> 
<div class="col-lg-6">
                    
                    <textarea rows="5" cols="30" class="form-control noEditorMce" name="observa" id="observa" spellcheck="false"><?php echo $observaciones; ?></textarea>
</div>                    
</div>
               
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script ty pe="text/javascript">
        $(document).ready(function () {
            $("#observa").on('change', function () {
                var val = $("#observa").val();

                $.get('<?php echo url_for("libro_balance/observa") ?>', {val: val}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
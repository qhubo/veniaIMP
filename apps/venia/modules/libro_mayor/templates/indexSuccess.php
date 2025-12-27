<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?test=' . $test), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Libro Mayor
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-body">      
            <div class="row">
                <label class="col-lg-1 control-label right bold Bold " > Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right ">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right " style="text-align:right; align-content: right">Tipo  </label>
                <div class="col-lg-2 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                    <?php echo $form['tipo'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tipo']->renderError() ?>  
                    </span>
                </div>






            </div>


            <div class="row" style="padding-top:10px">



                <label class="col-lg-1 control-label right ">Cuenta  </label>
                <div class="col-lg-4 <?php if ($form['cuenta_contable']->hasError()) echo "has-error" ?>">
                    <?php echo $form['cuenta_contable'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['cuenta_contable']->renderError() ?>  
                    </span>
                </div>

                <label class="col-lg-1 control-label right " style="text-align:right; align-content: right">Filtro </label>
                <div class="col-lg-2 <?php if ($form['filtro']->hasError()) echo "has-error" ?>">
                    <?php echo $form['filtro'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['filtro']->renderError() ?>  
                    </span>
                </div>


            </div>

            <div class="row" style="padding-top:2px">
                <label class="col-lg-1 control-label right ">Cuenta  </label>
                <div class="col-lg-4 <?php if ($form['cuenta_contable2']->hasError()) echo "has-error" ?>">
                    <?php echo $form['cuenta_contable2'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['cuenta_contable2']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>

                <div class="col-lg-1"></div>
                <div class="col-lg-2">
                    <a target="_blank" href="<?php echo url_for('libro_mayor/reportePdf') ?>" class="btn  btn-sm btn-secondary btn-info btn-block" > <i class="flaticon2-printer"></i> Pdf </a>
                </div>
                <div class="col-lg-1">
                    <a target="_blank" href="<?php echo url_for('libro_mayor/reporte') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
                </div>
            </div>
            <!--            <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable3']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable3'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable3']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable4']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable4'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable4']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable5']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable5'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable5']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable6']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable6'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable6']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable7']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable7'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable7']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable8']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable8'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable8']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                        
                            <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable9']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable9'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable9']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                            <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable10']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable10'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable10']->renderError() ?>  
                                </span>
                            </div>
                        </div>
                            <div class="row" style="padding-top:2px">
                                <label class="col-lg-1 control-label right ">Cuenta  </label>
                            <div class="col-lg-4 <?php if ($form['cuenta_contable11']->hasError()) echo "has-error" ?>">
            <?php echo $form['cuenta_contable11'] ?>           
                                <span class="help-block form-error"> 
            <?php echo $form['cuenta_contable11']->renderError() ?>  
                                </span>
                            </div>
                        </div>-->

            <div class="row" style="padding-top:10px" >

                <div class="col-lg-6"></div>


            </div>

            <?php $litasp[] = 0; ?>

            <div class="row">
                <div class="col-lg-9"><br></div>
            </div>
            <div class="table-scrollable">
                <table class="table  " >
                    <?php if ($cuentas) { ?>
                        <?php foreach ($cuentas as $cuenta) { ?>
                            <?php $datosCuenta = $listaDatos[$cuenta]; ?>
                            <tr style="background-color:#ebedf2">
                                <th align="center"  width="80px">Partida</th>
                                <th align="center"   width="100px">Fecha</th>
                                <th  align="center"> Cuenta</th>
                                <th align="center" >Detalle </th>
                                <th align="center" >Descripción </th>

                                <th  align="center" width="100px"> Debe</th>
                                <th  align="center" width="100px" > Haber</th>
                                <th  align="center" width="130px" > Saldo</th>
                            </tr>
                            <?php $saldo = CuentaErpContablePeer::getSaldoFecha($fechaInicial, $cuenta); ?>
                            <tr>
                                <td colspan='3'></td>
                                <td>Saldo Inicial</td>
                                <td></td>
                                <td></td>
                                <td  style="text-align:right"><?php echo Parametro::formato($saldo, true); ?></td>
                            </tr>   

                            <?php foreach ($datosCuenta as $dato) { ?>

                                <?php $saldo = $saldo + $dato['debe'] - $dato['haber']; ?>
                                <tr <?php if (!$dato['confirmada']) { ?>  style="background-color: #ffffbf"  <?php } ?>>
                                    <td> 
                                        <?php if (!$dato['confirmada']) { ?> 
                                            <a href="<?php echo url_for("libro_mayor/confirma?id=" . $dato['par']) ?>" class="btn   btn-small"  data-toggle="modal" data-target="#ajaxmodalCon<?php echo $dato['par']; ?>">   
                                                <?php $litasp[] = $dato['par']; ?>
                                            <?php } ?>

                                            <?php echo $dato['numero'] ?>
                                            <?php if (!$dato['confirmada']) { ?> </a>
                                        <?php } ?>


                                    </td>
                                    <td  style="text-align:center"><?php echo $dato['fecha'] ?></td>
                                    <td><?php echo $cuenta ?><?php //echo $dato['movi'];   ?></td>
                                    <td><?php echo $dato['tipo'] ?></td>
                                    <td><?php echo $dato['detalle'] ?></td>
                                    <td  style="text-align:right"><?php echo Parametro::formato($dato['debe'], true) ?></td>
                                    <td  style="text-align:right"><?php echo Parametro::formato($dato['haber'], true) ?></td>
                                    <td  style="text-align:right"><?php echo Parametro::formato($saldo, true); ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="7"><hr></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>

<?php for ($i = 1; $i <= 10; $i++) { ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#mostrar<?php echo $i; ?>').click(function () {
                var valor = $("#marca<?php echo $i; ?>").val();


                if (valor == 1) {
                    $('#div_1_<?php echo $i; ?>').show();
                    $('#divc_1_<?php echo $i; ?>').show();
                }
                if (valor == 2) {
                    $('#div_2_<?php echo $i; ?>').show();
                    $('#divc_2_<?php echo $i; ?>').show();
                }
                if (valor == 3) {
                    $('#div_3_<?php echo $i; ?>').show();
                    $('#divc_3_<?php echo $i; ?>').show();
                }
                if (valor == 4) {
                    $('#div_4_<?php echo $i; ?>').show();
                    $('#divc_4_<?php echo $i; ?>').show();
                }
                if (valor == 5) {
                    $('#div_5_<?php echo $i; ?>').show();
                    $('#divc_5_<?php echo $i; ?>').show();
                }


                if (valor == 6) {
                    $('#div_6_<?php echo $i; ?>').show();
                    $('#divc_6_<?php echo $i; ?>').show();
                }
                if (valor == 7) {
                    $('#div_7_<?php echo $i; ?>').show();
                    $('#divc_7_<?php echo $i; ?>').show();
                }
                if (valor == 8) {
                    $('#div_8_<?php echo $i; ?>').show();
                    $('#divc_8_<?php echo $i; ?>').show();
                }
                if (valor == 9) {
                    $('#div_9_<?php echo $i; ?>').show();
                    $('#divc_9_<?php echo $i; ?>').show();
                }
                if (valor == 10) {
                    $('#div_10_<?php echo $i; ?>').show();
                    $('#divc_10_<?php echo $i; ?>').show();
                }


                if (parseFloat(valor) < 10) {
                    var resultado = parseFloat(valor) + 1;
                    $("#marca<?php echo $i; ?>").val(resultado);
                    $("#btoculta<?php echo $i; ?>").show();
                }

            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#ocultar<?php echo $i; ?>').click(function () {
                var valor = $("#marca<?php echo $i; ?>").val();

                //           alert(valor);
                if (valor == 1) {
                    $('#div_1_<?php echo $i; ?>').hide();
                    $('#divc_1_<?php echo $i; ?>').hide();
                }
                if (valor == 2) {
                    $('#div_1_<?php echo $i; ?>').hide();
                    $('#divc_1_<?php echo $i; ?>').hide();
                }
                if (valor == 3) {
                    $('#div_2_<?php echo $i; ?>').hide();
                    $('#divc_2_<?php echo $i; ?>').hide();
                }
                if (valor == 4) {
                    $('#div_3_<?php echo $i; ?>').hide();
                    $('#divc_3_<?php echo $i; ?>').hide();
                }
                if (valor == 5) {
                    $('#div_4_<?php echo $i; ?>').hide();
                    $('#divc_4_<?php echo $i; ?>').hide();
                }

                if (valor == 6) {
                    $('#div_5_<?php echo $i; ?>').hide();
                    $('#divc_5_<?php echo $i; ?>').hide();
                }
                if (valor == 7) {
                    $('#div_6_<?php echo $i; ?>').hide();
                    $('#divc_6_<?php echo $i; ?>').hide();
                }
                if (valor == 8) {
                    $('#div_7_<?php echo $i; ?>').hide();
                    $('#divc_7_<?php echo $i; ?>').hide();
                }
                if (valor == 9) {
                    $('#div_8_<?php echo $i; ?>').hide();
                    $('#divc_8_<?php echo $i; ?>').hide();
                }
                if (valor == 10) {
                    $('#div_9_<?php echo $i; ?>').hide();
                    $('#divc_9_<?php echo $i; ?>').hide();
                }





                if (valor > 1) {
                    var resultado = parseFloat(valor) - 1;
                    $("#marca<?php echo $i; ?>").val(resultado);
                }

                if (valor == 2) {
                    $("#btoculta<?php echo $i; ?>").hide();
                }
            });
        });
    </script>

<?php } ?>

<?php
$pendientes = PartidaQuery::create()
        ->filterById($litasp, Criteria::IN)
        ->find();
?>

<?php foreach ($pendientes as $data) { ?>
    <div class="modal fade" xstyle="width:900px"  id="ajaxmodalP<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" xstyle="width:900px" role="document">
            <div class="modal-content" xstyle="width:750px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>


    <div class="modal fade" xstyle="width:900px"  id="ajaxmodalCon<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" xstyle="width:900px" role="document">
            <div class="modal-content" xstyle="width:750px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Confirmar <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<?php } ?>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
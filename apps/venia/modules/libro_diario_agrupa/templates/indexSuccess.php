<?php $modulo = $sf_params->get('module'); ?>
<?php $tab = 1; ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Libro Diario
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas &nbsp;&nbsp;&nbsp;utiliza  la opción agrupar para procesar un mes y agruparlo</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-body"> 

            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_3_1_tab_content" role="tab" aria-selected="false">
                                Consulta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_2_tab_content" role="tab" aria-selected="false">
                                Agrupar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_1_tab_content" role="tabpanel">


                    <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
                    <?php echo $form->renderHiddenFields() ?>

                    <div class="row" style="padding-top:25px">
                        <div class="col-lg-1" style="text-align:right"> Fecha </div>
                        <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                            <?php echo $form['fechaInicio'] ?>           
                            <span class="help-block form-error"> 
                                <?php echo $form['fechaInicio']->renderError() ?>  
                            </span>
                        </div>
                        <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                            <?php echo $form['fechaFin'] ?>           
                            <span class="help-block form-error"> 
                                <?php echo $form['fechaFin']->renderError() ?>  
                            </span>
                        </div>
                        <div class="col-lg-1">
                            <button class="btn green btn-sm btn-outline" type="submit">
                                <i class="fa fa-search "></i>
                                Buscar
                            </button>
                        </div>
                        <div class="col-lg-1">Folio Inicial</div>
                        <div class="col-lg-1">
                            <input class="form-control" placeholder="0" onkeypress="validate(event)" xtype="number" step="any" type="text" name="folio" id="folio">

                        </div>
                        <div class="col-lg-1">
                            <a target="_blank" href="<?php echo url_for($modulo . '/reportePdf') ?>" class="btn  btn-sm btn-secondary btn-info btn-block" > <i class="flaticon2-printer"></i> Pdf </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9"><br></div>
                    </div>
                    <?php echo '</form>'; ?>
                </div>
                <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_2_tab_content" role="tabpanel">

                    <?php echo $forma->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
                    <?php echo $forma->renderHiddenFields() ?>
                    <div class="row">
                        <div class="col-lg-1" style="text-align:right"> Fecha </div>
                        <div class="col-lg-2 <?php if ($forma['mes_inicio']->hasError()) echo "has-error" ?>">
                            <?php echo $forma['mes_inicio'] ?>           
                            <span class="help-block form-error"> 
                                <?php echo $forma['mes_inicio']->renderError() ?>  
                            </span>
                        </div>
                        <div class="col-lg-2 <?php if ($forma['anio_inicio']->hasError()) echo "has-error" ?>">
                            <?php echo $forma['anio_inicio'] ?>           
                            <span class="help-block form-error"> 
                                <?php echo $forma['anio_inicio']->renderError() ?>  
                            </span>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn green btn-sm btn-outline" type="submit">
                                <i class="flaticon2-check-mark "></i>
                                Agrupar
                            </button>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-9"><br></div>
                    </div>
                    <?php echo '</form>'; ?>


                </div>




            </div>


            <div class="table-scrollable">
                <table class="table  " >

                    <tr style="background-color:#ebedf2">
                        <th align="center"  width="80px">Partida</th>
                        <th align="center"   width="100px">Fecha</th>
                        <th  align="center"> Cuenta</th>
                        <th align="center" >Descripción </th>
                        <th  align="center" width="100px"> Debe</th>
                        <th  align="center" width="100px" > Haber</th>
                        <th  align="center"> </th>

                    </tr>

                    <?php $bandera = 0; ?>
                    <?php $total1 = 0; ?>
                    <?php $total2 = 0; ?> 
                    <?php $cantida = 0; ?>
                    <?php foreach ($operaciones as $registro) { ?>

                        <?php if ($bandera <> $registro->getPartidaAgrupaId()) { ?>
                            <?php if ($total1 > 0) { ?>

                                <tr >
                                    <td style="text-align: center"  colspan="4"><strong>Totales</strong></td>
                                    <td  style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total1); ?></strong></td>
                                    <td style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total2); ?></strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="7"> </td>
                                </tr>
                                <tr style="background-color:#ebedf2">
                                    <th align="center"  width="80px">Partida</th>
                                    <th align="center"   width="100px">Fecha</th>
                                    <th  align="center"> Cuenta</th>
                                    <th align="center" >Descripción </th>
                                    <th  align="center" width="100px"> Debe</th>
                                    <th  align="center" width="100px" > Haber</th>
                                    <th  align="center" > </th>

                                </tr>
                            <?php } ?>                            
                        <?php } ?>
                        <tr>
                            <td><?php //echo $cantida. " --".count($operaciones);   ?><?php echo $registro->getPartidaAgrupa()->getCodigo(); ?></td>
                            <td  style="text-align: center"><?php echo $registro->getPartidaAgrupa()->getFechaContable('d/m/Y'); ?></td>
                            <td><?php echo $registro->getCuentaContable(); ?></td>
                            <td><?php echo $registro->getDetalle(); ?></td>
                            <td style="text-align: right"><?php echo Parametro::formato($registro->getDebe()); ?></td>
                            <td style="text-align: right"><?php echo Parametro::formato($registro->getHaber()); ?></td>
                            <td> <font size="-1"><?php echo $registro->getPartidaAgrupa()->getDetalle(); ?>&nbsp;<?php //echo $registro->getPartida()->getCodigo();   ?></font></td>
                        </tr>
                        <?php if ($bandera <> $registro->getPartidaAgrupaId()) { ?>
                            <?php $bandera = $registro->getPartidaAgrupaId(); ?>
                            <?php $total1 = 0; ?>
                            <?php $total2 = 0; ?> 
                        <?php } ?>
                        <?php $total1 = $registro->getDebe() + $total1; ?>
                        <?php $total2 = $registro->getHaber() + $total2; ?> 
                    <?php } ?>
                    <tr style="">
                        <td style="text-align: center"  colspan="4"><strong>Totales</strong></td>
                        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total1); ?></strong></td>
                        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total2); ?></strong></td>
                        <td></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>




<script>
    function validate<?php echo $id ?>(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#folio").on('change', function () {
            var id = $("#folio").val();
            $.get('<?php echo url_for("proceso/folio") ?>', {id: id}, function (response) {
                $("#total").html(response);
            });



        });

    });
</script>
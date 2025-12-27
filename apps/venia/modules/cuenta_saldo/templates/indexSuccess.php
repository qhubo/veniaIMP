<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Saldo de Cuentas
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-body">      
            <div class="row">
                <label class="col-lg-1 control-label right "> Inicio </label>
                <div class="col-lg-2 <?php if ($form['mes_inicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['mes_inicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['mes_inicio']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-2 <?php if ($form['anio_inicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['anio_inicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['anio_inicio']->renderError() ?>  
                    </span>
                </div>


            </div>
            <div class="row">
                <label class="col-lg-1 control-label right "> Fin </label>
                <div class="col-lg-2 <?php if ($form['mes_fin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['mes_fin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['mes_fin']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-2 <?php if ($form['anio_fin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['anio_fin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['anio_fin']->renderError() ?>  
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
                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
            <div class="row" style="padding-top:15px">
                <div class="col-md-10">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  active " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Cuenta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link   " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i> Agrupado
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10"> </div>                        

                <div class="col-lg-2">
                    <a target="_blank" href="<?php echo url_for('cuenta_saldo/excel') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte</a>
                </div>
            </div>
            <div class="tab-content" >
                <div class="tab-pane active  " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                    <!--                    <div class="row">
                                            <div class="col-lg-10"> </div>                        
                                   
                                              <div class="col-lg-2">
                                         <a target="_blank" href="<?php echo url_for('cuenta_saldo/reporte') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Csv Cuentas</a>
                              </div>
                                                 </div>-->
                    <?php include_partial($modulo . '/detalle', array('resultado' => $resultado, 'periodos' => $periodos)) ?>
                </div>
                <div class="tab-pane  " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">


                    <div class="row" style="padding-top:10px">
                        <div class="col-lg-12">
                            <table class="table table-bordered  dataTable table-condensed flip-content" >
                                <thead class="flip-content">
                                    <tr class="active">
                                        <th  align="center"><font size="-1"> Cuenta</font></th>
                                        <th  align="center"><font size="-1"> Saldo Inicial</font></th>
                                        <?php foreach ($periodos as $Perido) { ?>
                                            <td><font size="-1"><?php echo $Perido['detalle']; ?></font> </td>
                                        <?php } ?>
                                        <th  align="center"><font size="-1"> Total</font></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $grantotales =0; ?>
                                    <?php if ($resumen) { ?>
                                        <?php foreach ($resumen as $key => $regi) { ?>
                                            <tr>
                                                <td><font size="-1"><strong> <?php echo $key; ?></strong>  </font> </td>
                                                <?php $inicial = 0; ?>
                                                <?php $total = 0; ?>
                                                <?php foreach ($regi as $deta) { ?>
                                                    <?php $inicial = $inicial + $deta['inicial']; ?>
                                                    <?php $total = $total + $deta['total']; ?>
                                                <?php } ?>
                                                 <?php $grantotales =$total+$grantotales; ?>
                                                <?php $valorPe = 0; ?>
                                                <td style="text-align: right"><font size="-2"><?php echo Parametro::formato($inicial, false); ?></font> </td>
                                                <?php foreach ($periodos as $Perido) { ?>
                                                    <td style="text-align: right">
                                                        <?php $valorPe = 0; ?>
                                                        <?php foreach ($regi as $deta) { ?>
                                                            <?php $valorPe = $valorPe + $deta[$Perido['periodo']]; ?>
                                                            <?php // echo $deta[$Perido['periodo']]."<br>" ?>
                                                        <?php } ?>


                                                        <font size="-2">
                                                        <?php //echo $Perido['periodo'];   ?>

                                                        <?php echo Parametro::formato($valorPe, false);
                                                        ; ?></font> </td>
        <?php } ?>
                                                <td style="text-align: right"><font size="-2"><?php echo Parametro::formato($total, false); ?></font> </td>
                                            </tr>
                                        <?php } ?>
<?php } ?>
                                </tbody>
<!--                                <tfoot>
                                    <tr>
                                        <td>Totales</td>
                                        <td style="text-align: right"><font size="-2"><?php echo Parametro::formato($grantotales, false); ?></font> </td>
                                    </tr>
                                    
                                </tfoot>-->
                            </table>
                        </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo '</form>'; ?>


<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>

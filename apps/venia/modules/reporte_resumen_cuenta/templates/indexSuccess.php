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
            <h3 class="kt-portlet__head-title kt-font-info"> Resumen Cuentas Agrupado
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

            </div>

            <div class="row" style="padding-top:10px">
                <label class="col-lg-1 control-label right ">Cuenta  </label>
                <div class="col-lg-4 <?php if ($form['cuenta_contable']->hasError()) echo "has-error" ?>">
                    <?php echo $form['cuenta_contable'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['cuenta_contable']->renderError() ?>  
                    </span>
                </div>
            </div>

            <div class="row" style="padding-top:2px; padding-bottom: 10px">
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
                <div class="col-lg-1">
                    <a target="_blank" href="<?php echo url_for('reporte_resumen_cuenta/reporte') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
                </div>
            </div>


            <div class="table-scrollable">
                <table class="table" >

                    <tr style="background-color:#ebedf2">
                        <th  align="center"> Cuenta</th>
                        <th align="center" >Descripción </th>
                        <th  align="center" > 01</th>
                        <th  align="center" > 02</th>
                        <th  align="center" > 03</th>
                        <th  align="center" > 04</th>
                        <th  align="center" > 05</th>
                        <th  align="center" > 06</th>
                        <th  align="center" > 07</th>
                        <th  align="center" > 08</th>
                        <th  align="center" > 09</th>
                        <th  align="center" > 10</th>
                        <th  align="center" > 11</th>
                        <th  align="center" > 12</th>
                        <th>Total</th>
                    </tr>

                    <?php foreach ($listaDoPrefi as $regi) { ?>
                        <tr>
                            <td><?php echo $regi['prefijo']; ?></td>
                            <td><?php echo $regi['nombre']; ?></td>
                            <?php $total = 0; ?>  
                                <?php foreach ($regi['cuentas'] as $detalle) { ?>
                                  
                                <?php $valor = CuentaErpContablePeer::saldo($inicio, $fin, $detalle); ?>
                                <?php $total = $total + $valor; ?>
                                <td style="text-align:right"><?php echo Parametro::formato($valor, false); ?></td>
                            <?php } ?>
                                <th style="text-align:right"><?php echo Parametro::formato($total, true); ?></th>
                   
                        </tr>


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
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
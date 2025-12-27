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
            <h3 class="kt-portlet__head-title kt-font-info"> Saldo de movimientos
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de periodo y cuentas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-body">      
            <div class="row">
                <label class="col-lg-1 control-label right "> Mes </label>
                <div class="col-lg-2 <?php if ($form['mes']->hasError()) echo "has-error" ?>">
                    <?php echo $form['mes'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['mes']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-2 <?php if ($form['anio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['anio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['anio']->renderError() ?>  
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

            <div class="row" style="padding-top:10px">
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
                
                <div class="col-lg-1"> </div>
                
                               <div class="col-lg-1">
                     <a target="_blank" href="<?php echo url_for( $modulo.'/reporte')  ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
          </div>
                
            </div>


            <div class="row" style="padding-top:10px">
                <div class="col-lg-12">
                    <table class="table table-bordered  dataTable table-condensed flip-content" >
                        <thead class="flip-content">
                            <tr class="active">
                                <td>Período</td>
                                <th  align="center"><font size="-1"> Cuenta</font></th>
                                <th  align="center"><font size="-1">Descripción</font></th>
                                <th  align="center"><font size="-1"> Saldo Inicial</font></th>
                                <td>Debe</td>
                                <td>Haber</td>
                                <th  align="center"><font size="-1"> Total</font></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resumen) { ?>
                                <?php foreach ($resumen as $key => $regi) { ?>
                                    <tr>
                                        <td style="text-align:center"><?php echo $periodo; ?></td>
                                        <td><strong> <?php echo $key; ?></strong>  </td>
                                        <td><?php echo $regi['nombre']; ?></td>
                                        <td style="text-align: right"><?php echo Parametro::formato($regi['inicial'],false); ?></td>
                                        <td style="text-align: right"><?php echo Parametro::formato($regi['debe'],false); ?></td>
                                        <td style="text-align: right"><?php echo Parametro::formato($regi['haber'],false); ?></td>
                                        <td  style="text-align: right"><?php echo Parametro::formato($regi['saldo'],false); ?></td>
                                    </tr>
                                <?php } ?>  
                            <?php } ?>
                        </tbody>
                    </table>
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

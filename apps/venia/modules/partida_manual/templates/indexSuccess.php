<?php $modulo = $sf_params->get('module'); ?>
<?php $tab =1; ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?edit=' . $edit), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Ingreso de Partida
                <small>&nbsp;&nbsp;&nbsp;completa la información solicitada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
<!--        <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-secondary btn-hover-brand" > <i class="flaticon-download-1"></i> Archivo Modelo Carga  </a>
   -->
        </div>
    </div>
    <div class="kt-portlet__body">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Ingreso
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 3) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Bitácora
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                <div class="form-body">
                    <div class="row">
                        <label class="col-lg-1 control-label right "> Inicio </label>
                        <div class="col-lg-2 <?php if ($form['fecha']->hasError()) echo "has-error" ?>">
                            <?php echo $form['fecha'] ?>
                            <span class="help-block form-error">
                                <?php echo $form['fecha']->renderError() ?>
                            </span>
                        </div>
                        <div class="col-lg-2"></div>
                        <label class="col-lg-1 control-label right "> Numero </label>
                        <div class="col-lg-1 <?php if ($form['numero']->hasError()) echo "has-error" ?>">
                            <?php echo $form['numero'] ?>
                            <span class="help-block form-error">
                                <?php echo $form['numero']->renderError() ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-1 control-label right "> Detalle </label>
                        <div class="col-lg-6 <?php if ($form['detalle']->hasError()) echo "has-error" ?>">
                            <?php echo $form['detalle'] ?>
                            <span class="help-block form-error">
                                <?php echo $form['detalle']->renderError() ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><br></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <?php include_partial($modulo . '/tabla', array('edit' => $edit, 'valor1' => $valor1, 'valor2' => $valor2, 'borra' => $borra, 'partida' => $partida, 'modulo' => $modulo, 'detalle' => $detalle, 'form' => $form)) ?>    
                        </div>
                        <div class="col-lg-4">
                          
            
                            
                            <?php include_partial($modulo . '/confirma', array('partida' => $partida, 'modulo' => $modulo)) ?>     
                        </div>
                    </div>


                </div>
            </div>
               <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
                            
                            <?php include_partial($modulo . '/lista', array('operaciones' => $operaciones,'modulo' => $modulo)) ?>     
               
                </div>
        </div>



    </div>
</div>

<?php echo "</form>"; ?>

<?php include_partial($modulo . '/script', array('edit' => $edit, 'partida' => $partida, 'modulo' => $modulo)) ?>   


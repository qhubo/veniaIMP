<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-bell-4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Detalle de Valores   Activo<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Verifica la información  </small>
            </h3>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    
    											

    
    

    <div class="kt-portlet__body">
  <div class="row">
            <div class="col-lg-4"><strong>Codigo </strong></div>
            <div class="col-lg-8"><?php echo $activo->getCodigo(); ?></div>
        </div>
          <div class="row">
          <div class="col-lg-4"><strong>Account</strong></div>
          <div class="col-lg-8"><?php echo $activo->getCuentaContable(); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Account Name</strong></div>
            <div class="col-lg-8"><?php echo $activo->getCuentaErpContable()->getNombre(); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Description</strong></div>
            <div class="col-lg-6" ><?php echo $activo->getDetalle(); ?> </div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Adquisition Date</strong></div>
            <div class="col-lg-6" style="text-align: center"><?php echo $activo->getFechaAdquision('d/m/Y'); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Ending Date</strong></div>
            <div class="col-lg-6" style="text-align: center"><?php echo $activo->getFechaFinal(); ?></div>
        </div>
                <div class="row">
            <div class="col-lg-4"><strong>Life Years</strong></div>
            <div class="col-lg-6" style="text-align: right"><?php echo $activo->getAnioUtil(); ?></div>
        </div>

        <div class="row">
            <div class="col-lg-4"><strong>Book Value</strong></div>
            <div class="col-lg-6" style="text-align: right"><?php echo Parametro::formato($activo->getValorLibro()); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>% Depreciation</strong></div>
            <div class="col-lg-6" style="text-align: right"><?php echo $activo->getPorcentaje() ?> % </div>
        </div>
    <div class="row">
            <div class="col-lg-4"><strong>Annual Depreciation</strong></div>
            <div class="col-lg-6" style="text-align: right"><?php echo Parametro::formato($activo->getDepreAnual()) ?> </div>
        </div>
    <div class="row">
            <div class="col-lg-4"><strong>Monthly Depreciation</strong></div>
            <div class="col-lg-6" style="text-align: right"><?php echo Parametro::formato($activo->getDepreMensual()) ?> </div>
        </div>





        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row" >
            <div class="col-lg-5" style="background-size: contain; background-image: url(./assets/media//bg/300.jpg); padding-top: 3px;padding-bottom: 3px"></div>
            <div class="col-lg-3" style="padding-top: 3px;padding-bottom: 3px">                <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary btn-hover-brand">Cancelar</button>
            </div>
        </div>
    </div>

</div>

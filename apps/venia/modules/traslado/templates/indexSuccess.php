<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-refresh-button kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                LISTADO DE TRASLADOS PENDIENTES CONFIRMAR<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procesa la devolución seleccionada  (Confirmar / Rechazar)
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
                 
      <a href="<?php echo url_for($modulo . '/nuevo') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-plus"></i> NUEVO </a>
 
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>

  
        <?php include_partial($modulo . '/listado', array('modulo' => $modulo, 'registros' => $registros)) ?>
    </div>
</div>





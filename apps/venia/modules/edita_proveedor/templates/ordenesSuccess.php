<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-shopping-cart kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                LISTADO DE ORDENES DE COMPRA<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procesa la orden de compra seleccionada  (Confirmar / Rechazar)
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
       <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">

        
        <?php include_partial('consulta_orden_proveedor/listado', array('registros' => $registros)) ?>  

    </div>
</div>






          


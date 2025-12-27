<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-refresh-button kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                LISTADO DE SOLICITUDES DEPOSITOS PENDIENTES CONFIRMAR<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procesa la operación seleccionada  (Confirmar / Rechazar)
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
         </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
  
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Confirmar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 2) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historial
                </a>
            </li>
        </ul>
        
               <div class="tab-content" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_1_tab_content" role="tabpanel">

        <?php include_partial($modulo.'/listado', array('modulo'=>$modulo, 'registros' => $registros)) ?>
            </div>
                      <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                   <?php include_partial($modulo . '/consulta', array('modulo' => $modulo, 'boletas' => $boletas, 'form' => $form)) ?> 

                      </div>
                   
                   
               </div>
    </div>
</div>





<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">Listado de Pago  Con cheque
                <small>&nbsp;&nbsp;&nbsp; Selecciona los pagos para crear el cheque&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">




        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>
            <div class="portlet-body">

                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Devoluciones | Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php if ($tab == 2) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Otros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($tab == 3) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
                <div class="tab-content" >
                    <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_1_tab_content" role="tabpanel">
                 <?php include_partial($modulo.'/listadoDevolucion', array('registros' => $devoluciones,'solicitudes'=>$solicitudes)) ?>  
                    </div>                    
                    <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                        <?php include_partial($modulo . '/listado', array('modulo' => $modulo, 'gastos' => $gastos, 'ordenes' => $ordenes)) ?> 
                    </div>
                    <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
                        <?php include_partial($modulo . '/consulta', array('modulo' => $modulo, 'cheques' => $cheques, 'form' => $form)) ?> 


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




  <?php if ($partidaPen) { ?>
        
     
            <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
                <div class="modal-lg"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php include_partial('proceso/partidaCambia', array('partidaPen' => $partidaPen)) ?>  
                        </div>
                    </div>
                </div>
            </div>
            <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <?php foreach ($partidaPen->getListDetalle() as $cta) { ?>
                <script>
                    $(document).ready(function () {
                        $("#cuenta<?php echo $cta; ?>").select2({
                            dropdownParent: $("#ajaxmodalPartida")
                        });
                    });
                </script>
            <?php } ?>
            <script>
                $(document).ready(function () {
                    $("#ajaxmodalPartida").modal();
                });
            </script>
        <?php } ?>

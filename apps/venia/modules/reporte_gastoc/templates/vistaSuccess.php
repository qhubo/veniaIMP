<?php $tab = 1; ?>
<?php $tabSelec = sfContext::getInstance()->getUser()->getAttribute('tab', null, 'seguridad'); ?>
<?php if ($tabSelec) { ?>
    <?php $tab = 6; ?>
<?php } ?>

<?php $gasto=$orden; ?>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-interface-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Gasto  <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Información del documento&nbsp;&nbsp; </small>
            </h3>
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getId(); ?>  </strong> </font> <?php } ?>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <?php $tab =1; ?>
    <div class="kt-portlet__body">
        
          <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content<?php echo $gasto->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Detalle
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content<?php echo $gasto->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Contable
                  </a>
            </li>
        </ul>

        <div class="tab-content" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content<?php echo $gasto->getId(); ?>" role="tabpanel">
                <div class="table-scrollable">
           <?php include_partial($modulo . '/fichaVer', array('orden' => $orden, 'lista'=>$lista)) ?>  
      
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content<?php echo $gasto->getId(); ?>" role="tabpanel">
                <div class="table-scrollable">
                    <?php include_partial('proceso/partida', array('id' => $orden->getPartidaNo())) ?>  
                    <?php //include_partial('reporte_partida/pendiente', array('tiendas'=>$tiendas,'modulo'=>$modulo,'operaciones' => $pendientes)) ?> 
                </div>
            </div>

        </div>
        
      
        
        
        <div class="row">
            <div class="col-lg-8"> </div>
            <div class="col-lg-4">
<!--                <a target="_blank" href="<?php //echo url_for('reporte/gasto?token=' . $orden->getToken()) ?>" class="btn btn-block btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a>-->
            </div>
        </div>
         <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
            </div>
    </div>
</div>



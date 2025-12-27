<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-sort-down kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                ORDEN DE COMPRA <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Información&nbsp;&nbsp;  </small>
            </h3>
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <?php $tab = 1; ?>
    <div class="kt-portlet__body">

        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_conten<?php echo $orden->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Informativo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_conten<?php echo $orden->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Contable
                </a>
            </li>
        </ul>


        <div class="tab-content" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_conten<?php echo $orden->getId(); ?>" role="tabpanel">
                <?php include_partial($modulo . '/fichaVer', array('orden' => $orden)) ?>  
                <?Php $tipoDocumento = "OrdenCompra"; ?>
                <?php include_partial('soporte/valorCampoVista', array('tipoDocumento' => $tipoDocumento, 'idDoc' => $orden->getId())) ?> 
                <?php include_partial($modulo . '/fichalistaVer', array('orden' => $orden, 'lista' => $lista)) ?> 
            </div>
             <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_conten<?php echo $orden->getId(); ?>" role="tabpanel">
                 <div class="table-scrollable" style="padding-bottom:13px;">
                    <?php if ($orden->getPartidaNo()) { ?>
                    <?php include_partial('proceso/partida', array('id' => $orden->getPartidaNo())) ?>  
                    <?php } ?>
                  <?php $pagos = OrdenProveedorPagoQuery::create()->filterByOrdenProveedorId($orden->getId())->find(); ?>
                          <?Php foreach ($pagos as $pago) { ?>
                    <?php include_partial('proceso/partida', array('id' => $pago->getPartidaNo())) ?>  

                    <?php $partidas[] = $pago->getPartidaNo(); ?>
                <?php } ?>
                    <?php //include_partial('reporte_partida/pendiente', array('tiendas'=>$tiendas,'modulo'=>$modulo,'operaciones' => $pendientes)) ?> 
                </div>
            </div>

        </div>





        <div class="row" >
            <div class="col-lg-6" style="background-size: contain; background-image: url(./assets/media//bg/300.jpg); padding-top: 3px;padding-bottom: 3px"></div>
            <div class="col-lg-3">                <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary btn-hover-brand">Cancelar</button>
            </div>
            <div class="col-lg-3 " style="background-size: contain; background-image: url(./assets/media//bg/300.jpg);  padding-top: 3px;padding-bottom: 3px">
                <a target="_blank" href="<?php echo url_for('reporte/ordenCompra?token=' . $orden->getToken()) ?>" class="btn btn-block btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
            </div>
        </div>
    </div>
</div>

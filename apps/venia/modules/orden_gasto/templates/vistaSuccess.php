


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
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-6"><h3><?php echo $orden->getProveedor(); ?> </h3></div>
            
        </div>

      <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content<?php echo $lin; ?><?php echo $orden->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Informativo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content<?php echo $lin; ?><?php echo $orden->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Contable
                  </a>
            </li>
                     <li class="nav-item">
                <a class="nav-link <?php if ($tab == 3) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_4_tab_content<?php echo $lin; ?><?php echo $orden->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Detalle Gasto Caja
                  </a>
            </li>
        </ul>


  

        
        
                <div class="tab-content" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content<?php echo $lin; ?><?php echo $orden->getId(); ?>" role="tabpanel">
              
        <?php include_partial($modulo . '/fichaVer', array('orden' => $orden)) ?>  

           <?php include_partial($modulo . '/fichalistaVer', array('orden' => $orden, 'lista' => $lista)) ?> 
         
            </div>
            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content<?php echo $lin; ?><?php echo $orden->getId(); ?>" role="tabpanel">
                <div class="table-scrollable">
                    <?php if ($orden->getPartidaNo()) { ?>
                    <?php include_partial('proceso/partida', array('id' => $orden->getPartidaNo())) ?>  
                    <?php } ?>
                  <?php $pagos = GastoPagoQuery::create()->filterByGastoId($orden->getId())->find(); ?>
                          <?Php foreach ($pagos as $pago) { ?>
                    <?php include_partial('proceso/partida', array('id' => $pago->getPartidaNo())) ?>  

                    <?php $partidas[] = $pago->getPartidaNo(); ?>
                <?php } ?>
                    <?php //include_partial('reporte_partida/pendiente', array('tiendas'=>$tiendas,'modulo'=>$modulo,'operaciones' => $pendientes)) ?> 
                </div>
            </div>
 <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_4_tab_content<?php echo $lin; ?><?php echo $orden->getId(); ?>" role="tabpanel">

     <div class="row">
         <div class="col-md-12">
        <table class="table table-striped- table-bordered table-hover no-footer dtr-inlin " width="100%">

            <tr class="active">
                <td>Fecha</td> 
      <td><strong>Proveedor</strong></td>
                <td><strong>Serie</strong></td>
                <td><strong>Factura</strong></td>
                <td>Valor</td> 
            </tr>
            
            <?php foreach($lineas as $deg) { ?>
          <?php if ($deg->getId() == $lin) { ?>
            <tr style="background-color:#FFCC00">
                <td style="text-align:center"><strong> <?php echo $deg->getFecha(); ?></strong></td>
        <td><?php echo $deg->getProveedor()->getNombre(); ?></td>
                <td><strong><?php echo $deg->getSerie(); ?></strong></td>
                <td><strong><?php echo $deg->getFactura(); ?></strong></td>
                <td style="text-align:right"><strong><?php echo Parametro::formato($deg->getValor(),false); ?></strong></td>
            </tr>
           <?php } ?>
 
          <?php if ($deg->getId() <> $lin) { ?>
            <tr>
                <td style="text-align:center"><?php echo $deg->getFecha(); ?></td>
                <td><?php echo $deg->getProveedor()->getNombre(); ?></td>
                <td><?php echo $deg->getSerie(); ?></td>
                <td><?php echo $deg->getFactura(); ?></td>
                <td style="text-align:right"><?php echo Parametro::formato($deg->getValor(),false); ?></td>
            </tr>
           <?php } ?>
  
           <?php } ?>
     </table>
         </div>
     </div>
 </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4"> </div>
            <div class="col-lg-4">          <a target="_blank" href="<?php echo url_for('reporte/gasto?token=' . $orden->getToken()) ?>" class="btn btn-block btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a></div>
            <div class="col-lg-4">            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>    </div>

        </div>





    </div>
</div>



<?php $tab = 1; ?>


<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-interface-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Devolucion  <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
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
            <div class="col-lg-6"><h3><?php echo $orden->getNombre(); ?> </h3>   </div>
            <div class="col-lg-2">(<?php echo $orden->getEstatus(); ?>) </div>            
        </div>

      <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content<?php echo $orden->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Detalle
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content<?php echo $orden->getId(); ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Contable
                  </a>
            </li>
        </ul>

  

        
        
                <div class="tab-content" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content<?php echo $orden->getId(); ?>" role="tabpanel">
                <div class="row">
                  <table class="table table-bordered  ">
                         <tr>
        <th align="center" width="80px"><span class="kt-font-success">Fecha</span></th>
        <td width="30%">        <?php echo $orden->getFecha() ?>  </td>
        <th align="center" width="80px"><span class="kt-font-success">Usuario</span></th>
        <td width="30%">        <?php echo $orden->getUsuarioCreo() ?>   </td>
    </tr>
    <tr>
        <th align="center" width="80px"><span class="kt-font-success">Ref. Factura </span></th>
        <td width="30%">        <?php echo $orden->getReferenciaFactura() ?>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Cheque </span></th>
        <td width="30%">    <?php echo $orden->getChequeNo(); ?> </td>
    </tr>
    <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Concepto </span></th>
        <td colspan="3">    <?php echo $orden->getConcepto(); ?> </td>
    </tr> 
    
 
     <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Medio Pago </span></th>
        <td width="30%">        <?php echo $orden->getPagoMedio() ?>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Valor</span></th>
         <td width="30%" style="text-align:right">    <?php echo Parametro::formato($orden->getValor()); ?> </td>
    </tr>
         <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Producto </span></th>
        <td width="30%">   <?php echo $orden->getProducto()->getCodigoSku(); ?>       <?php echo $orden->getProducto()->getNombre(); ?>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Cantidad</span></th>
         <td width="30%" style="text-align:right">    <?php echo $orden->getCantidad(); ?> </td>
    </tr>
    
    
<!--                          <tr>
        <th align="center" width="80px"><span class="kt-font-success">Fecha Autorizo</span></th>
        <td width="30%">        <?php echo $orden->getFechaConfirmo() ?>  </td>
        <th align="center" width="80px"><span class="kt-font-success">Usuario Autorizo</span></th>
        <td width="30%">        <?php echo $orden->getUsuarioConfirmo() ?>   </td>
    </tr>
    
     <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Descripcion </span></th>
        <td colspan="3">    <?php echo $orden->getDescripcion(); ?> </td>
    </tr> -->
</table>
                    
                    
            
  
         
            </div>
            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content<?php echo $orden->getId(); ?>" role="tabpanel">

                <?php if ($orden->getPartidaNo()){ ?>
 <?php include_partial('proceso/partida', array('id' => $orden->getPartidaNo())) ?>
                <?php } ?>
        </div>
        
   



    </div>
</div>



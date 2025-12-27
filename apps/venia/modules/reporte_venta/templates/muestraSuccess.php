<?php $modulo = $sf_params->get('module'); ?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-green-sharp">
            <i class="fa fa-shopping-cart font-green-sharp"></i>
            <span class="caption-subject  font-green-sharp ">Detalle de la operación  </span>&nbsp;&nbsp;&nbsp;
            <span class="label  label-info uppercase "><?php echo $operacion->getCodigoFactura() ?> </span>
  <!--            <span class="caption-helper"> Detalle de la operación realizada </span>-->
        </div>
        <div class="inputs">
<!--    <a class="btn  btn-info" href="<?php echo url_for($modulo . '/index') ?>" ><i class="fa fa-hand-o-left"></i> Retornar </a>
            -->
        </div>
    </div>
    <div class="portlet-body">
        <?php $modulo = $sf_params->get('module'); ?>
        <div class="kt-portlet kt-portlet--responsive-mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon-more-v2 kt-font-success"></i>
                    </span>
                    <h3 class="kt-portlet__head-title kt-font-brand">
                        Detalle de operación    
                        <small></small>
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                </div>
            </div>

  <?php include_partial('reporte_venta/detalle', array('operacion' => $operacion,'detalle'=>$detalle, 'pagos'=>$pagos)) ?>  
         
            <?php $operacionPago = OperacionPagoQuery::create()->orderById('Desc')->filterByOperacionId($operacion->getId())->findOne(); ?>
            <div class="modal-footer">
                <?php if ($operacionPago) { ?>
                 <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $operacionPago->getId()) ?>" class="btn  btn-sm btn-dark " target = "_blank">
             <i class="flaticon2-printer"></i>  Recibo <?php echo $operacionPago->getCodigo(); ?>
   </a>
                <?php } ?>
                
                <?php $cotiza= OrdenCotizacionQuery::create()->findOneByCodigo($operacion->getCodigo()); ?>
                <?php if ($cotiza){ ?>
                <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token='.$cotiza->getToken()) ?>" class="btn btn-secondary btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
                <?php } ?>
                <button type="button" data-dismiss="modal" class="btn dark btn-dark">Cancelar</button>

            </div>
        </div>
    </div>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-checking kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success"> Ubicación de Producto
                <small>&nbsp;&nbsp;&nbsp; Detalle de Producto  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-2" style="font-weight: bold; font-size: 16px;"> Codigo</div>
            <div class="col-lg-4" style=" font-size: 16px;"><input class="form-control" disabled="" value=" <?php echo $producto->getCodigoSku(); ?>" ></div>
            <div class="col-lg-2" style="font-weight: bold; font-size: 16px;"> Existencia</div>
            <div class="col-lg-2" style=" font-size: 16px;"><input class="form-control" disabled="" value=" <?php echo $producto->getExistencia(); ?>" ></div>
        </div>
        <div class="row" style="padding-top: 10px;">
            <div class="col-lg-1"></div>
            <div class="col-lg-2" style="font-weight: bold; font-size: 16px;"> Nombre</div>
            <div class="col-lg-6" style=" font-size: 16px;"><input class="form-control" disabled="" value=" <?php echo $producto->getNombre(); ?>" ></div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12" style="padding-right: 100px; padding-left: 100px;">
            <table class="table table-bordered ">
                <tr>
                    <th>Tienda</th>
                    <th>Ubicacion</th>
                    <th>Cantidad</th>      
                    <th>Transito</th>      
                </tr>
                <?php $bodegas = ProductoExistenciaQuery::create()->filterByProductoId($producto->getId())->filterByCantidad(0, criteria::GREATER_THAN)->find(); ?>
                <?php foreach ($bodegas as $bode) { ?>
                    <?php $ubicaciones = ProductoUbicacionQuery::create()->filterByTiendaId($bode->getTiendaId())->filterByCantidad(0, criteria::GREATER_THAN)->filterByProductoId($producto->getId())->find(); ?>
                    <?php $cano = 0; ?>
                    <?php foreach ($ubicaciones as $registr) { ?>
                        <?php $cano++; ?>
                        <tr>
                        <td style="text-align:right;  font-size:14px; color:#0924A9 "><?php echo $registr->getTienda()->getNombre(); ?> </td>
                                <td style="">&nbsp;&nbsp;&nbsp;<?php echo $registr->getUbicacion(); ?>&nbsp;&nbsp;&nbsp;</td>
                                <td style="text-align:right;"><?php echo $registr->getCantidad(); ?>&nbsp;&nbsp;&nbsp;</td>
                                <td style="text-align:right;"><?php echo $registr->getTransito(); ?>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                
                    <?php } ?>
                <?php } ?> 


            </table>
        </div>
    </div>
</div>
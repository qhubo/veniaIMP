<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">Listado de Pedidos a Facturar
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>


    <div class="tab-content" >

        <div class="kt-portlet__body">
            <table class="table table-bordered " >
                <tr>
                    <th>Factura</th>
                    <th>Usuario</th>                    
                    <th>RUC / Nit</th>
                    <th>Cliente</th>
                    <th>Observaciones</th>
                    <th>Productos</th>
                    <th>Valor Total </th>
                    <th>Finalizar</th> 
                </tr>
                <?php foreach ($registros as $dete) { ?>
                <?php if ($dete->getTotalProductos() >0) { ?>
                    <tr>
                        <td>

                            <?php echo $dete->getCodigo(); ?>
                            </a>

                        </td>
                        <td><?php echo $dete->getUsuario(); ?></td>
                        <td><?php echo $dete->getNit(); ?></td>
                        <td><?php echo $dete->getCliente()->getCodigo(); ?> <?php echo $dete->getCliente()->getNombre(); ?> </td>
                        <td><?php echo $dete->getComentario(); ?></td>
                        <td>
                            <a target="_blank" href="<?php echo url_for('reporte/empaque?id=' . $dete->getId()) ?>" class="btn btn-block btn-sm btn-warning" > 
                                Productos    <?php echo $dete->getTotalProductos(); ?>
                            </a>
                            <a target="_blank" href="<?php echo url_for('reporte_excel/empaque?id=' . $dete->getId()) ?>" class="btn btn-block  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Empaque </a>


                        </td>
                        <td style="text-align: right;">
                            <a class="btn btn-block  btn-sm " data-toggle="modal" href="#staticPP<?php echo $dete->getId() ?>">
                                <?php echo Parametro::formato($dete->getValorTotal()); ?>
                            </a>
                        </td>
                        <td>
                        <?php   $ordenCoti= OrdenCotizacionEmpaqueQuery::create()->findOneByOrdenEmpaque($dete->getId()); ?>    
                            <?php if (!$ordenCoti) { ?>
                            <a href="<?php echo url_for('pedido_factura/nueva?codigo=' . $dete->getCodigo()) ?>" class="btn btn-block btn-sm btn-dark btn-secondary" > Facturar  >> </a>
                            <?php } else { ?>
                            Facturandose con empaque <?php echo $ordenCoti->getOrdenCotizacion()->getCodigo(); ?>

                            <?php } ?>
      <a target="_blank" href="<?php echo url_for('reporte/preFactura?id=' . $dete->getId()) ?>" class="btn btn-block btn-sm btn-info" > 
             <i class="flaticon2-printer"></i>   PreFacturar </a>
                       
                        
                        </td>


                    </tr>
     <?php } ?>
                <?php } ?>

            </table>
        </div>
    </div>
</div>

<?php foreach ($registros as $lista) { ?>

    <div id="staticPP<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <li class="fa fa-cogs"></li>
                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Listado Producto</span>
                </div>
                <div class="modal-body">
                    <?php
                    $pendientes = OperacionDetalleQuery::create()
                            ->filterByOperacionId($lista->getId())
                            ->find();
                    ?>
                    <table style="width: 100% " class="table-bordered table">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                        <?Php $total = 0; ?>
                        <?php foreach ($pendientes as $reg) { ?>
                            <?Php $total = $total + $reg->getValorTotal() ?>
                            <tr>
                                <td><?php echo $reg->getDetalle(); ?></td>
                                <td style=" text-align: right;"><?php echo $reg->getCantidad(); ?></td>
                                <td style=" text-align: right;"><?php echo $reg->getValorTotal(); ?></td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div> 
<?php } ?>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<?php if ($operacion) { ?>
    <div id="ajaxmodalFactura" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <?php include_partial('soporte/avisos') ?>
                <?php $val = explode('-', $operacion->getFaceFirma()) ?>
                <?php $numero = "FACTURA"; // $val[0]; ?>
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Factura <?php echo $operacion->getCodigoFactura(); ?>   </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-6" style="text-align:right; font-weight: bold;">  Factura </div>
                        <div class="col-lg-2">
                            <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $operacion->getCodigo()) ?>" class="btn btn-block btn-sm btn-info " target = "_blank">
                                <?php echo $numero; ?>
                            </a>
                        </div>
                        <div class="col-lg-2"><a target="_blank" href="<?php echo url_for('reporte_excel/factura?id=' . $operacion->getId()) ?>" class="btn btn-block  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte </a>
                        </div>
                    </div>


                    <?php if ($operacion->getFaceError() <> "") { ?>
                        <?php echo $operacion->getFaceError(); ?>
                        <a href="<?php echo url_for('reporte_venta/reenviar?id=' . $operacion->getId()) ?>" class="btn btn-secondary btn-dark btn-sm" > <i class="flaticon-refresh"></i>Reenviar</a>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



<script>
    $(document).ready(function () {
        $("#ajaxmodalFactura").modal();

    });
</script>


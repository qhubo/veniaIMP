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
                <tr>
                    <td>
                           <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token='.$dete->getToken()) ?>" class="btn btn-sm btn-warning" > 
      <i class="flaticon2-printer"></i><?php echo $dete->getCodigo(); ?>
                               </a>
                        
                    </td>
                    <td><?php echo $dete->getUsuario(); ?></td>
                    <td><?php echo $dete->getNit(); ?></td>
                    <td><?php echo $dete->getCliente()->getCodigo(); ?> <?php echo $dete->getCliente()->getNombre();  ?> </td>
                    <td><?php echo $dete->getObservaciones(); ?></td>
                    <td>
                          <a class="btn btn-block  btn-sm " data-toggle="modal" href="#staticPP<?php echo $dete->getId() ?>">
                            <?php echo $dete->getTotalProductos(); ?>
             </a>
                    
                    </td>
                    <td style="text-align: right;"><?php echo Parametro::formato($dete->getValorTotal()); ?></td>
                    <td> <a href="<?php echo url_for('pedido_factura/nueva?codigo=' . $dete->getCodigo()) ?>" class="btn btn-sm btn-dark btn-secondary" > Facturar  >> </a></td>
   
                    
                </tr>
                
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
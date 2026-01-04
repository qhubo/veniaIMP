<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">Listado de Pedidos
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for('orden_cotizacion/nueva') ?>" class="btn btn-block btn-small btn-success btn-secondary" >  <i class="flaticon2-plus"></i> Nuevo Pedido </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link  active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Pedidos en Proceso </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?php echo url_for('bodega_confirmo/muestra') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
        </div>
    </div>
                <div class="tab-content" >

    <div class="kt-portlet__body">
        <table class="table table-bordered " >
            <tr>
                <th>Orden</th>
                <th>Usuario</th>                    
                <th>RUC / Nit</th>
                <th>Cliente</th>
                <th>Observaciones</th>
                <th>Productos</th>
                <th>Valor Total </th>
                <th>Confirmar</th>
                <th>Editar</th>
            </tr>
            <?php foreach ($detalles as $reg) { ?>
           
            <?php $orden=$reg->getOrdenCotizacion(); ?>
              <?php
            //    $pendientes = OrdenCotizacionDetalleQuery::create()
            //            ->filterByVerificado(false)
            //            ->filterByOrdenCotizacionId($reg->getOrdenCotizacionId())
            //            ->count();
                ?>
                <?php //if ($pendientes == 0) { ?>
                    <tr>
                        <td>
                               <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token='.$orden->getToken()) ?>" class="btn btn-sm btn-warning" > 
      <i class="flaticon2-printer"></i><?php echo $reg->getOrdenCotizacion()->getCodigo(); ?>
                               </a>

                        </td>
                        <td><?php echo $reg->getOrdenCotizacion()->getUsuario(); ?>
                        <?php if ($reg->getOrdenCotizacion()->getVendedorId()) { ?>
                            <br><strong><?php echo ($reg->getOrdenCotizacion()->getVendedor()->getNombre()); ?></strong>
                        <?php } ?>
                        
                        </td>
                        <td><?php echo $reg->getOrdenCotizacion()->getNit(); ?></td>
                        <td> <?php if ($reg->getOrdenCotizacion()->getClienteId()) { echo $reg->getOrdenCotizacion()->getCliente()->getCodigoCli(); } ?> 
                            <BR>
              <?php echo $reg->getOrdenCotizacion()->getNombre(); ?></td>

                        <td style="width:300px;">
                   
                            <textarea rows="3"  class="form-control" name="observaciones<?php echo $reg->getId(); ?>" id="observaciones<?php echo $reg->getId(); ?>"><?php echo $reg->getOrdenCotizacion()->getComentario(); ?></textarea></td>
                        <td style="text-align: right; font-size: +2">
     <a class="btn btn-block  btn-sm " data-toggle="modal" href="#staticPP<?php echo $reg->getId() ?>">
                            <?php echo $reg->getCantidadTotal(); ?>
             </a>

                        </td>
                        <td style="text-align: right; font-size: +2">
                       

                                <?php echo Parametro::formato($reg->getOrdenCotizacion()->getValorTotal()); ?>
                        
                        </td>             


                        <td>
            <?php //if ($pendientes ==0)  { ?>    
                            <a class="btn btn-block btn-sm btn-info" data-toggle="modal" href="#static<?php echo $reg->getId() ?>"><i class="flaticon2-check-mark"></i>CONFIRMAR</a>
            <?php // } else { ?>
            <a class="btn btn-sm btn-danger btn-block" data-toggle="modal" href="#staticB<?php echo $reg->getOrdenCotizacionId() ?>">  Rechazar</a>
                        
            <?Php // } ?>
                        </td>                     
                        <td> <a href="<?php echo url_for('orden_cotizacion/nueva?codigo=' . $reg->getOrdenCotizacion()->getCodigo()) ?>" class="btn btn-sm btn-dark btn-secondary" > Editar  </a></td>
                    </tr>
                <?php // } ?>
            <?php } ?>

        </table>
    </div>
                </div>
</div>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php foreach ($detalles as $lista) { ?>



        <div id="staticB<?php echo $lista->getOrdenCotizacionId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> <strong> Confirma Rechazar </strong> 
                            <span class="caption-subject font-green bold uppercase"> 
                                <?php echo $lista->getOrdenCotizacion()->getCodigo() ?>
                            </span> ?
                        </p>
                    </div>
                    <?php $token = md5($lista->getOrdenCotizacion()->getCodigo()); ?>
                    <div class="modal-footer">
                        <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/eliminaOR?token=' . $token . '&id=' . $lista->getOrdenCotizacionId()) ?>" >
                            <i class="fa fa-trash-o "></i> Confirmar </a> 
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                    </div>

                </div>
            </div>
        </div> 

    <script type="text/javascript">
        $(document).ready(function () {
            $("#observaciones<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getOrdenCotizacionId(); ?>;
                var val = $("#observaciones<?php echo $lista->getId(); ?>").val();
           //     alert (id);
             //      alert (val);
                $.get('<?php echo url_for("lista_cobro/comentario") ?>', {id: id, val: val}, function (response) {
                });
            });
        });
    </script>
    <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p> 
                        <strong>Cliente</strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $lista->getOrdenCotizacion()->getNombre() ?>
                        </span> 
                    </p>

                    <p> Confirma Procesar Documento
                        <strong>Pedido</strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $lista->getOrdenCotizacion()->getCodigo() ?>
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn  btn-success " href="<?php echo url_for('pedido_pendiente/confirmar?id=' . $lista->getOrdenCotizacion()->getId() . "&token=" . sha1($lista->getOrdenCotizacion()->getCodigo())) ?>" >
                        <i class="flaticon2-lock "></i> Confirmar </a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div> 

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
                    $pendientes = OrdenCotizacionDetalleQuery::create()
                            ->filterByOrdenCotizacionId($lista->getOrdenCotizacionId())
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
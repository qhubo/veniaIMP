<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                LISTADO DE <?php echo $titulo; ?><small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin"  width="100%">
            <thead >
                <tr class="active">
                    <th  style="width: 60px;" align="center"><span class="kt-font-success"># </span></th>
                    <th  align="center"><span class="kt-font-success">Titulo </span></th>
                    <th  align="center"><span class="kt-font-success">Usuario</span></th>
<th align="center">
    <span class="kt-font-success">Pedidos</span>
</th>
                    <th  style="width: 220px;"  align="center"><span class="kt-font-success"> Editar </span></th>
                    <th  style="width: 60px;"  align="center"><span class="kt-font-success"> Eliminar </span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $data) { ?>
                    <?php $lista = $data; ?>
                    <tr>
                        <td><?php echo $data->getId(); ?></td>
                        <td><?php echo $data->getTitulo() ?></td>
                        <td><?php echo $data->getUsuario() ?></td>
                        <td>

    <?php
    $pedidos = ListaEmpaqueUnidaDetalleQuery::create()
        ->filterByListaEmpaqueUnidaId($data->getId())
        ->orderByCodigo()
        ->find();
    ?>

    <?php if (count($pedidos)) { ?>

        <ul style="padding-left:18px; margin-bottom:0;">

            <?php foreach ($pedidos as $pedido) { ?>

                <li>
                    <?php echo $pedido->getCodigo(); ?>
                </li>

            <?php } ?>

        </ul>

    <?php } else { ?>

        <span class="text-muted">
            Sin pedidos
        </span>

    <?php } ?>

</td>
                        <td> <a class="btn btn-primary btn-sm btn-block" data-toggle="modal"  href="#modalCotizaciones<?php echo $data->getId(); ?>">  <i class="fa fa-list"></i>  Agregar Pedidos </a></td>
                        <td>
                            <a class="btn btn-sm btn-block btn-danger" data-toggle="modal" href="#static<?php echo $data->getId() ?>"> <i class="fa fa-trash"></i>                            </a>
                        </td>
                    </tr>
                <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <p> Confirma Eliminar 
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $lista->getId() ?>
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = md5($lista->getId()); ?>
                            <div class="modal-footer">
                                <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                    <i class="fa fa-trash-o "></i> Confirmar </a> 
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>
                            </div>
                        </div>
                    </div>
                </div> 
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php foreach ($registros as $data) { ?>

    <div id="modalCotizaciones<?php echo $data->getId(); ?>" class="modal fade"  tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="post" action="<?php echo url_for('lista_unida/guardarCotizaciones') ?>">
                <input type="hidden"  name="lista_empaque_unida_id" value="<?php echo $data->getId(); ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Seleccionar Cotizaciones
                        </h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50"></th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $detalles = OrdenCotizacionDetalleQuery::create()->filterByConfirmado(true)
                                                ->filterByProductoId(null, Criteria::NOT_EQUAL)->useOrdenCotizacionQuery()
                                                ->filterByEstatus('Confirmada')->endUse()
                                                ->groupBy('OrdenCotizacionDetalle.OrdenCotizacionId')->find();
                                ?>
                                <?php
                                $seleccionadas = ListaEmpaqueUnidaDetalleQuery::create()
                                        ->filterByListaEmpaqueUnidaId($data->getId())
                                        ->select('Codigo')
                                        ->find()
                                        ->toArray();
                                ?>

    <?php foreach ($detalles as $registr): ?>
        <?php $cotizacion = $registr->getOrdenCotizacion(); ?>


                                    <tr>
                                        <td align="center">
                                            <input  type="checkbox"  name="cotizacion[]" value="<?php echo $cotizacion->getCodigo(); ?>" <?php echo in_array($cotizacion->getCodigo(), $seleccionadas) ? 'checked="checked"' : ''; ?> >

                                        </td>
                                        <td><?php echo $cotizacion->getCodigo(); ?></td>
                                        <td>
        <?php echo $cotizacion->getNombre(); ?>
                                        </td>
                                    </tr>
    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Guardar
                        </button>
                        <button type="button" data-dismiss="modal"
                                class="btn btn-secondary">
                            Cancelar
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
<?php } ?>
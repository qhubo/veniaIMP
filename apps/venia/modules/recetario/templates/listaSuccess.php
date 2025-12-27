<script src='/assets/global/plugins/jquery.min.js'></script>
<style>
    .btn i {
        padding-right: 0.2rem !important;
    }

    .btn-block+.btn-block {
        margin-top: 0 !important;
    }
</style>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Receta Médica
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>

            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo url_for('recetario/nueva') ?>">

                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Nueva Receta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="portlet-body">
                <?php echo $form->renderFormTag(url_for('recetario/lista'), array('class' => '')) ?>
                <?php echo $form->renderHiddenFields() ?>

                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-2">Seleccione el rango de fecha</div>
                    <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                        <?php echo $form['fechaInicio'] ?>
                        <span class="help-block form-error">
                            <?php echo $form['fechaInicio']->renderError() ?>
                        </span>
                    </div>
                    <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                        <?php echo $form['fechaFin'] ?>
                        <span class="help-block form-error">
                            <?php echo $form['fechaFin']->renderError() ?>
                        </span>
                    </div>

                </div>

                <?php echo "</form>"; ?>
                <hr />


                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <div style="text-align:center; align-content: right;"> Fecha</div>
                                </th>
                                <th>Cliente</th>
                                <th style="width:150px;">Detalle</th>
                                <th style="width:150px;">Reporte</th>
                                <th style="width:150px;">Procesar</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            <?php foreach ($recetario as $fila) : ?>
                                <tr>
                                    <td>
                                        <div style="text-align:center; align-content: right;">
                                            <?php echo $fila->getFecha('d/m/Y'); ?>
                                        </div>
                                    </td>
                                    <td><?php echo $fila->getCliente()->getNombre() ?></td>
                                    <td>
                                        <button class="btn  btn-sm btn-block btn-success button_plus" id="button_plus_<?php echo $contador ?>" onclick="mostrar_fila(<?php echo $contador ?>)">
                                            <i class="fa fa-eye"></i>Detalle
                                        </button>
                                        <button class="btn btn-success btn-sm btn-block button_minus" style="display: none;" id="button_minus_<?php echo $contador ?>" onclick="ocultar_fila(<?php echo $contador ?>)">
                                            <i class="fa fa-eye-slash"></i>Ocultar
                                        </button>
                                    </td>
                                    <td align="center">
                                        <a target="_blank" class="btn btn-sm btn-block btn-warning" href="<?php echo url_for('recetario/imprimir') . "?id=" . $fila->getId() ?>"><i class="fa fa-print"></i> Receta</a>
                                    </td>
                                    <td>
                                                              <a class="btn btn-block  btn-sm btn-xs btn-danger" data-toggle="modal" href="#static<?php echo $fila->getId() ?>"><i class="flaticon-signs"></i> Venta  </a>
  
                                    </td>
                                </tr>
                                <tr class="row_tabla" id="row_<?php echo $contador ?>" style="display: none;">
                                    <td colspan="5">
                                        <div clsas="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Producto/Servicio</th>
                                                        <th>Dosis</th>
                                                        <th>Frecuencia</th>
                                                        <th>Observaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $detalles =  RecetarioDetalleQuery::create()
                                                        ->filterByRecetarioId($fila->getId())
                                                        ->leftJoinProducto()
                                                        ->select(array('Producto.Nombre', 'TipoDetalle', 'Servicio', 'Dosis', 'Frecuencia', 'Observaciones'))
                                                        ->find(); ?>
                                                    <?php $contador_det = 1; ?>
                                                    <?php foreach ($detalles as $detalle) : ?>
                                                        <tr>
                                                            <td><?php echo $contador_det ?></td>
                                                            <td><?php echo $detalle['TipoDetalle'] == "Producto" ? $detalle['Producto.Nombre'] : $detalle['Servicio']  ?></td>
                                                            <td><?php echo $detalle['Dosis'] ?></td>
                                                            <td><?php echo $detalle['Frecuencia'] ?></td>
                                                            <td><?php echo $detalle['Observaciones'] ?></td>
                                                        </tr>
                                                        <?php $contador_det++; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <?php $contador++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

 <?php foreach ($recetario as $lista) : ?>
                <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmación de Proceso</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de enviar receta 
                                    <span class="caption-subject font-green bold uppercase"> 
                                        # <?php echo $lista->getId() ?> para venta
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = md5($lista->getId()); ?>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn btn-info  " href="<?php echo url_for('orden_cotizacion/receta?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                    <i class="fa flaticon2-check-mark "></i> Confirmar</a> 
                            </div>
                        </div>
                    </div>
                </div>
     <?php endforeach; ?>


<script>
    function mostrar_fila(contador) {
        $(".button_plus").show();
        $(".button_minus").hide();
        $(".row_tabla").hide();
        $("#row_" + contador).show();
        $("#button_plus_" + contador).hide();
        $("#button_minus_" + contador).show();
    }

    function ocultar_fila(contador) {
        $(".row_tabla").hide();
        $("#button_plus_" + contador).show();
        $("#button_minus_" + contador).hide();
    }
</script>
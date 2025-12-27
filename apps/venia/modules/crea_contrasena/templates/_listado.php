<div class="kt-portlet__body">
        <table class="table table-striped- table-bordered table-hover table-checkable XXdataTable no-footer dtr-inlin XXkt-datatable" id="html_table" width="100%">
            <thead >
                <tr class="active">
                    <th  align="center"><span class="kt-font-success">Tipo </span></th>
                    <th  align="center"><span class="kt-font-success">Documento </span></th>
                    <th  align="center"><span class="kt-font-success"> Proveedor</span></th>
                    <th  align="center"><span class="kt-font-success"> Fecha</span></th>
                    <th  align="center"><span class="kt-font-success"> Crédito</span></th>
                    <th  align="center"><span class="kt-font-success"> Detalle</span></th>
                    <th  align="center"><span class="kt-font-success">Sub Total </span></th>
                    <th  align="center"><span class="kt-font-success"> Valor ISR </span></th>
                    <th  align="center"><span class="kt-font-success"> Valor Total </span></th>
                </tr>
            </thead>
            <tbody>
                <?PHp $total = 0; ?>
                <?php $can=0; ?>
                <?php foreach ($registros as $deta) { ?>
                 <?php $can++; ?>
                    <?php $total = $total + ($deta->getValorTotal() - $deta->getValorPagado()); ?>
                    <tr>
                        <td><?php echo $deta->getSerie(); ?></td>
                        <td><?php echo $deta->getDocumento(); ?></td>
                        <td><?php echo $deta->getProveedor()->getNombre(); ?></td>
                        <td><?php echo $deta->getFecha('d/m/Y'); ?></td>
                        <td style="text-align: right"><?php echo $deta->getDias(); ?> Días</td>
                        <td><?php echo $deta->getDetalle(); ?></td>
                        <td style="text-align: right" ><?php echo Parametro::formato($deta->getValorSubTotal()); ?></td>
                        <td style="text-align: right" > <?php echo Parametro::formato($deta->getValorImpuesto()); ?></td>
                        <td style="text-align: right" ><?php echo Parametro::formato($deta->getValorTotal()); ?></td>                      
                    </tr>
                <?php } ?>

            </tbody>
        </table>
<?php if ($can >0) { ?>
        <div class="row">
            <div class="col-lg-9"></div>
            <div class="col-lg-2">
                <a class="btn btn-block  btn-xs btn-info" data-toggle="modal" href="#staticC">Confirmar </a>
            </div>
        </div>
<?php } ?>
    </div>
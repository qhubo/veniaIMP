

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">Detalle de la Cierre  <?php echo $operacion->getId() ?> 
                <small></small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php echo $operacion->getFechaCalendario('d/m/Y'); ?>
        </div>
    </div>
    <div class="kt-portlet__body">

        <h4>DETALLE  VALORES  CAJA</h4>         
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr class="success">
                    <td  > Medio</td>
                    <td  >Documento</td>

                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($pagos as $data) { ?>
                    <?php $total = $total + $data->getValor(); ?>
                    <tr>

                        <td><?php echo $data->getMedioPago(); ?></td>
                        <td>
                            <?php echo $data->getBanco(); ?>
                            <?php echo $data->getDocumento(); ?>
                        </td>

                        <td align="right" ><div align="right"><?php echo number_format($data->getValor(), 2); ?></div></td>

                    </tr>
                <?php } ?>


                <tr class="active">
                    <th colspan="2">Total Caja</th>
                    <th align="right" ><div align="right"><?php echo number_format($total, 2); ?></div></th>

                </tr>
            </tbody>
        </table>     


        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn dark btn-dark">Cancelar</button>

        </div>
    </div>
</div>
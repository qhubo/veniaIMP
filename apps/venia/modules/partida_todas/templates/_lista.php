<table class="table table-bordered  dataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">

            <th align="center" >Fecha</th>
            <th align="center" >Usuario</th>
            <th  align="center"> Tipo</th>
            <th align="center" width="30px"> Código</th>
            <th  align="center"> Valor</th>


        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($operaciones as $lista) { ?>
            <tr>

                <td><?php echo $lista->getFechaContable('d/m/Y'); ?></td>
                <td><?php echo $lista->getUsuario(); ?></td>
                <td><?php echo $lista->getTipo(); ?></td>
                <td>
                    <a href="<?php echo url_for("reporte_partida/partida?id=" . $lista->getId()) ?>" class="btn btn-block btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId(); ?>">  <?php echo $lista->getCodigo(); ?>    </a>


                </td>
                <td style="text-align: right"><?php echo Parametro::formato($lista->getValor()); ?></td>
            </tr>
        <?php } ?>
    </tbody>

</table>



<?php foreach ($operaciones as $data) { ?>
<?php //if ( $data->getOrdenProveedorId()) { ?>
    <div class="modal fade" xstyle="width:900px"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" xstyle="width:900px" role="document">
            <div class="modal-content" xstyle="width:750px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php // } ?>

<?php } ?>
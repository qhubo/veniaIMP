<?php $ruta = "/uploads/devoluciones/"; ?>      

<div class="row">
    <div class="col-lg-10">  </div>
    <div class="col-lg-2">				
        <br>
    </div>
</div>
<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin "  width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success"> Fecha</span></th>
            <th  align="center"><span class="kt-font-success"> Banco</span></th>
            <th  align="center"><span class="kt-font-success"> No. Boleta  <br> Fecha </span></th>
            <th  align="center"><span class="kt-font-success"> Tienda <br> Vendedor </span></th>
            <th  align="center"><span class="kt-font-success"> Total   </span></th>
            <th  align="center"><span class="kt-font-success"> Cliente  </span></th>
     
            <th  align="center"><span class="kt-font-success"> Confirmar </span></th>
            <th  align="center"><span class="kt-font-success"> Rechazar </span></th>
            <th  align="center"><span class="kt-font-success"> Usuario </span></th>
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
        <?php foreach ($registros as $data) { ?>
            <?php $conta++; ?>
            <tr >
                <td><?php echo $data->getCodigo(); ?></td>
                <td style="text-align: center"><?php echo $data->getCreatedAt('d/m/Y H:i'); ?></td>
                <td style="text-align: center"><?php echo $data->getBanco(); ?></td>
                <td style="text-align: center"><?php echo $data->getBoleta(); ?> <br>
                <?php echo $data->getFechaDeposito('d/m/Y'); ?>
                </td>
                
                <td style="text-align: center"><?php echo $data->getTienda(); ?> <br> <?php echo $data->getVendedor(); ?></td>
                <td style="text-align: right"><?php echo Parametro::formato($data->getTotal(),true); ?></td>
           
                <td style="text-align: center"><?php echo $data->getCliente(); ?></td>

                <td><a href="<?php echo url_for("proceso/confirma?tipo=boleta&token=" . $data->getCodigo()) ?>" class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#ajaxmodalCONFIRMA<?php echo $data->getId(); ?>"> <li class="fa flaticon2-checkmark"></li>    </a></td>
                <td><a href="<?php echo url_for("proceso/rechaza?tipo=boleta&token=" . $data->getCodigo()) ?>" class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#ajaxmodalRECHAZA<?php echo $data->getId(); ?>"> <li class="fa flaticon2-cancel"></li>    </a></td>
                <td><?php echo $data->getCreatedBy(); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>





<?php foreach ($registros as $data) { ?>


    <div class="modal fade"  id="ajaxmodalCONFIRMA<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Proceso Confirmación  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <div class="modal fade"  id="ajaxmodalRECHAZA<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Proceso Rechazo <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php } ?>





<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


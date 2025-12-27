        
<div class="row">
    <div class="col-lg-10">  </div>
    <div class="col-lg-2">				
        <br>
    </div>
</div>
<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin "  width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success">Código </span></th>
            <th  align="center"><span class="kt-font-success"> Fecha</span></th>
  
            <th  align="center"><span class="kt-font-success"> Cliente</span></th>
            <th  align="center"><span class="kt-font-success"> Estatus </span></th>
            <th  align="center"><span class="kt-font-success"> Comentario </span></th>
            <th  align="center"><span class="kt-font-success"> Valor  </span></th>
            <th  align="center"><span class="kt-font-success"> Detalle </span></th>
            <th  align="center"><span class="kt-font-success"> Usuario </span></th>
          
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
        <?php foreach ($registros as $data) { ?>
            <?php $conta++; ?>
            <tr >
                <td><?php echo $data->getCodigo(); ?></td>
                <td style="text-align: center"><?php echo $data->getFecha('d/m/Y H:i'); ?></td>
                   <td><?php echo $data->getNombre(); ?></td>
                <td><?php echo $data->getEstatus(); ?></td>
         <td><?php echo $data->getComentario(); ?></td>
            
                  <th style="text-align: right" ><?php echo Parametro::formato($data->getValorTotal()); ?></th>
                     
     
                <td>

                     <a href="<?php echo url_for("orden_cotizacion/vista?token=" . $data->getToken()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $data->getId(); ?>"> <li class="fa flaticon-more-v2"></li>    </a>



                </td>
                <td><?php echo $data->getUsuario(); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php foreach ($registros as $data) { ?>

    <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Cotización  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php } ?>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
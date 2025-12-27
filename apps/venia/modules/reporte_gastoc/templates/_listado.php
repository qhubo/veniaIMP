        
<div class="row">
    <div class="col-lg-10">  </div>
    <div class="col-lg-2"><br>				
<!--        <div class="kt-input-icon kt-input-icon--left">
            <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
            <span class="kt-input-icon__icon kt-input-icon__icon--left">
                <span><i class="la la-search"></i></span>
            </span>
        </div>-->
    </div>
</div>
<table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success">Código </span></th>
            <th  align="center"><span class="kt-font-success"> Fecha</span></th>
            <th  align="center"><span class="kt-font-success"> Usuario</span></th>
            <th  align="center"><span class="kt-font-success"> Tienda</span></th>
      
            <th  align="center"><span class="kt-font-success"> Concepto </span></th>
                   <th  align="center"><span class="kt-font-success">Sub Total </span></th>
                    <th  align="center"><span class="kt-font-success"> Valor ISR </span></th>
            <th  align="center"><span class="kt-font-success"> Valor Total </span></th>
      
            <th  align="center"><span class="kt-font-success"> Detalle </span></th>
         <th  align="center"><span class="kt-font-success">Usuario </span></th>
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
  
                    <?php foreach ($registrosCaja as $data) { ?>
            <?php $conta++; ?>
            <tr >
                <td><?php echo $data->getId(); ?></td>
                <td style="text-align: center"><?php echo $data->getFecha('d/m/Y H:i'); ?></td>
                <td><?php echo $data->getUsuario(); ?></td>
                <td><?php echo $data->getTienda(); ?></td>
          
                <td><?php echo $data->getConcepto(); ?></td>
                <td style="text-align: right" ><div style="text-align:right"> <?php echo Parametro::formato($data->getValor()); ?></div></td>
                <td style="text-align: right" ><div style="text-align:right"> <?php echo Parametro::formato($data->getValorImpuesto()); ?></div></td>
                <td style="text-align: right" ><div style="text-align:right"> <?php echo Parametro::formato($data->getValor()-$data->getValorImpuesto()); ?></div></td>

                <td>

                    <a href="<?php echo url_for("reporte_gastoc/vista?id=" . $data->getId()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodalv<?php echo $data->getId(); ?>"> <li class="fa flaticon-more-v2"></li>    </a>



                </td>
                <td><?php echo $data->getUsuario(); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>



<?php foreach ($registrosCaja as $data) { ?>

    <div class="modal fade"  id="ajaxmodalv<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Carga Gasto <?php echo $data->getId(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php } ?>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
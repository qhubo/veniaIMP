        
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
            <th  align="center"><span class="kt-font-success"> Proveedor </span></th>
            <th  align="center"><span class="kt-font-success"> Documento</span></th>
            <th  align="center"><span class="kt-font-success"> Concepto </span></th>
            <th  align="center"><span class="kt-font-success">Valor </span></th>
            <th  align="center"><span class="kt-font-success">Banco  </span></th>
            <th  align="center"><span class="kt-font-success"> Medio Pago </span></th>
            <th  align="center"><span class="kt-font-success">Documento Pago  </span></th>
            <th  align="center"><span class="kt-font-success"> </span></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
        <?php foreach ($registros as $reg) { ?>
            <?php $data = $reg->getGasto(); ?>
            <?php $conta++; ?>
            <tr >
                <td><?php echo $reg->getCodigo(); ?></td>
                <td style="text-align: center"><?php echo $reg->getFecha('d/m/Y '); ?></td>
                <td><?php echo $data->getUsuario(); ?></td>
                <td><?php echo $data->getProveedor(); ?></td>
                <td><?php echo $data->getTipoDocumento(); ?> <?php echo $data->getDocumento(); ?></td>
                <td><?php echo $data->getConcepto(); ?></td>
                <td style="text-align: right" ><div style="text-align:right"> <?php echo Parametro::formato($reg->getValorTotal()); ?></div></td>
                <td style="text-align: right" ><?php echo $reg->getBanco(); ?></td>
                <td style="text-align: right" ><?php echo $reg->getTipoPago(); ?></td>
                <td style="text-align: right" ><?php echo $reg->getDocumento(); ?></td>
                <td>
                    <a href="<?php echo url_for("orden_gasto/vista?token=" . $data->getToken()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $data->getId(); ?>"> <li class="fa flaticon-more-v2"></li>    </a>
                </td>
                <td>

                    <a href="<?php echo url_for("proceso/rechaza?tipo=pago&token=" . $reg->getId()) ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ajaxmodalRECHAZA<?php echo $data->getId(); ?>"> <li class="fa flaticon2-cancel"></li>    </a>
    <!--                           <a class="btn   btn-sm btn-danger" data-toggle="modal" href="#static<?php echo $reg->getId() ?>"><i class="fa fa-trash"></i>  </a>
                    -->
                </td>      
            </tr>
        <?php } ?>

    </tbody>
</table>


<?php foreach ($registros as $reg) { ?>
    <?php $data = $reg->getGasto(); ?>

    <div class="modal fade"  id="ajaxmodalRECHAZA<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Anulación de Gasto  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Gasto  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="static<?php echo $reg->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <li class="fa fa-cogs"></li>
                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Anular Pago</span>
                </div>
                <div class="modal-body">
                    <p> Esta seguro de eliminar Pago
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $reg->getCodigo() ?>
                        </span> ?
                    </p>
                </div>
                <?php $token = md5($reg->getCodigo()); ?>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    <a class="btn  btn-danger " href="<?php echo url_for('pagos_realizado/eliminar?id=' . $reg->getId()) ?>" >
                        <i class="fa fa-trash-o "></i> Confirmar</a> 
                </div>
            </div>
        </div>
    </div>

<?php } ?>



<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
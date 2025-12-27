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
            <th  align="center"><span class="kt-font-success"> Nombre</span></th>
            <th  align="center"><span class="kt-font-success"> Documentos </span></th>
            <th  align="center"><span class="kt-font-success"> Concepto </span></th>
            <th  align="center"><span class="kt-font-success"> Medio Pago </span></th>
            <th  align="center"><span class="kt-font-success"> Valor  </span></th>
            <th  align="center"><span class="kt-font-success"> Retenido  </span></th>
            <th  align="center"><span class="kt-font-success" width='90px'> Archivo </span></th>
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
                <td>
                      <a class="btn btn-outline  btn-sm  btn-outline "  href="<?php echo url_for("orden_devolucion/vista?id=" . $data->getId()) ?>" data-toggle="modal" data-target="#ajaxmodal<?php echo $data->getId(); ?>">
                        <?php echo $data->getCodigo(); ?>
                    </a>
                </td>
                <td style="text-align: center"><?php echo $data->getFecha('d/m/Y'); ?></td>
                <td><?php echo $data->getNombre(); ?></td>
                <td>
                    <strong>Ref. Nota:</strong> <?php echo $data->getReferenciaNota(); ?><br>
                    <strong>Ref. Factura: </strong> <?php echo $data->getReferenciaFactura(); ?>
                    <?php echo $data->getFechaFactura('d/m/Y'); ?>
                    <br>
                
                </td>
                <td><?php echo $data->getConcepto(); ?>
             
                
                </td>
                <td><?php echo $data->getPagoMedio(); ?></td>

                <th style="text-align: right" >
                    <font size="-1"><?php echo Parametro::formato($data->getValor()); ?></font>
                </th>

                <td style="text-align: right"><?php echo $data->getPorcentajeRetenie(); ?>%</td>
                <td style="content-align:center; text-align: center" width='90px'>

                    <?php echo ParametroPeer::is_imagen($ruta, $data->getArchivo()); ?>
                    <?php if ($data->getArchivo2()) { ?>
                        <div style="padding-top:5px" >
                            <?php echo ParametroPeer::is_imagen($ruta, $data->getArchivo2()); ?>
                        </div>
                    <?php } ?>
                </td>


                <td><a href="<?php echo url_for("proceso/confirma?tipo=ordendevolucion&token=" . $data->getToken()) ?>" class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#ajaxmodalCONFIRMA<?php echo $data->getId(); ?>"> <li class="fa flaticon2-checkmark"></li>    </a></td>
                <td><a href="<?php echo url_for("proceso/rechaza?tipo=ordendevolucion&token=" . $data->getToken()) ?>" class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#ajaxmodalRECHAZA<?php echo $data->getId(); ?>"> <li class="fa flaticon2-cancel"></li>    </a></td>
                <td><?php echo $data->getUsuarioCreo(); ?></td>
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
                    <h4 class="modal-title" id="myModalLabel6">Detalle Compra  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

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
                    <h4 class="modal-title" id="myModalLabel6">Detalle Compra  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php } ?>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


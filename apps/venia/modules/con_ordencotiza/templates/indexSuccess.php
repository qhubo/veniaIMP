<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-bag kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                LISTADO DE COTIZACIONES PENDIENTES DE APROBAR<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procesa la cotización seleccionada  (Confirmar / Rechazar)
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">

        <!--              <div class="row">
                        <div class="col-lg-10">  </div>
                        <div class="col-lg-2">				
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>-->
        <table class="table table-striped- table-bordered table-hover table-checkable XXdataTable no-footer dtr-inlin XXkt-datatable" id="html_table" width="100%">
            <thead >
                <tr class="active">
                    <th  align="center"><span class="kt-font-success">Código </span></th>
                    <th  align="center"><span class="kt-font-success"> Fecha</span></th>
                    <th  align="center"><span class="kt-font-success"> Usuario</span></th>
                    <th  align="center"><span class="kt-font-success"> Cliente </span></th>
                    <th  align="center"><span class="kt-font-success"> Comentario </span></th>
                    <th  align="center"><span class="kt-font-success"> Valor </span></th>

                    <th  align="center"><span class="kt-font-success"> Detalle </span></th>
                    <th  align="center"><span class="kt-font-success"> Confirmar </span></th>
                    <th  align="center"><span class="kt-font-success"> Rechazar </span></th>
                </tr>
            </thead>
            <tbody>
                <?php $conta = 0; ?>
                <?php foreach ($registros as $data) { ?>
                    <?php $conta++; ?>
                    <tr <?php if ($conta % 2 == 0) { ?> style="background-color:  #F3F7FE" <?php } ?> >
                        <td><?php echo $data->getCodigo(); ?></td>
                        <td style="text-align: center"><?php echo $data->getFecha('d/m/Y H:i'); ?></td>
                        <td><?php echo $data->getUsuario(); ?></td>
                        <td><?php echo $data->getNombre(); ?></td>
                        <td><?php echo $data->getComentario(); ?></td>
                        <th style="text-align: right" ><?php echo Parametro::formato($data->getValorTotal()); ?></th>
                        <td>
                            <div class="row">
                                <div class="col-lg-10">
                                    <?php echo html_entity_decode($data->getLineas()); ?>

                                </div>
                                <div class="col-lg-2">
                                    <a href="<?php echo url_for("orden_cotizacion/vista?token=" . $data->getToken()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $data->getId(); ?>"> <li class="fa flaticon2-search"></li>    </a>

                                </div>

                            </div>

                        </td>
                        <td><a href="<?php echo url_for("proceso/confirma?tipo=ordencotizacion&token=" . $data->getToken()) ?>" class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#ajaxmodalCONFIRMA<?php echo $data->getId(); ?>"> <li class="fa flaticon2-checkmark"></li>    </a></td>
                        <td><a href="<?php echo url_for("proceso/rechaza?tipo=ordencotizacion&token=" . $data->getToken()) ?>" class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#ajaxmodalRECHAZA<?php echo $data->getId(); ?>"> <li class="fa flaticon2-cancel"></li>    </a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>






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
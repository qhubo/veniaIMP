<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                LISTADO DE <?php echo $titulo; ?><small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin "  width="100%">
            <thead >
                <tr class="active">
                    <th  align="center"><span class="kt-font-success">Código </span></th>
                    <th  align="center"><span class="kt-font-success"> Fecha Inicio </span></th>

                    <th  align="center"><span class="kt-font-success">  Nombre</span></th>
                    <th  align="center"><span class="kt-font-success"> Observarciones</span></th>
                    <th  align="center"><span class="kt-font-success"> Valor </span></th>
                    <th  align="center"><span class="kt-font-success"> Interes </span></th>

                    <th  align="center"><span class="kt-font-success"> Editar </span></th>
                    <th  align="center"><span class="kt-font-success"> Eliminar </span></th>
                    <th  align="center"><span class="kt-font-success"> Pago </span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $data) { ?>
                    <?php $lista = $data; ?>
                    <tr>
                        <td><?php echo $data->getCodigo(); ?></td>
                        <td><?php echo $data->getFechaInicio('d/m/Y') ?></td>
                        <td><?php echo $data->getNombre() ?></td>
                        <td><?php echo $data->getObservaciones(); ?></td>
                        <td style="text-align:right"><?php echo Parametro::formato($data->getValor(), 2); ?></td>
                        <td style="text-align:right"> %   <?php echo Parametro::formato($data->getTasaInteres(), false); ?></td>
                   
                    
                        <td>    
                            <a class="btn btn-info btn-sm btn-block flaticon-edit-1"  href="<?php echo url_for($modulo . '/muestra?id=' . $data->getId()) ?>" ><li class="fa fa-picture-o"></li>Editar &nbsp;</a> 
                        </td>
                        <td>
                            <a class="btn btn-sm btn-block btn-danger" data-toggle="modal" href="#static<?php echo $data->getId() ?>">
                                <i class="fa fa-trash"></i>  
                            </a>
                        </td>
                                 <td>    
                            <a class="btn btn-warning btn-sm btn-block "  href="<?php echo url_for($modulo . '/pago?id=' . $data->getId()) ?>" ><li class="fa fa-money-check"></li> Grabar Operación &nbsp;</a> 
                        </td>

                    </tr>

                <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <p> Confirma Eliminar 
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $lista->getCodigo() ?>
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = md5($lista->getId()); ?>
                            <div class="modal-footer">
                                <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                    <i class="fa fa-trash-o "></i> Confirmar </a> 
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                            </div>

                        </div>
                    </div>
                </div> 
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
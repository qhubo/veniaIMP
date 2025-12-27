<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                LISTADO DE TIENDAS<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; listado de Tiendas
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
        <div class="row">
            <div class="col-lg-10">  </div>
            <div class="col-lg-2">				
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>
        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
            <thead >
                <tr class="active">
                    <th  align="center"><span class="kt-font-success">Código </span></th>
                    <th  align="center"><span class="kt-font-success"> Establecimiento</span></th>
                    <th  align="center"><span class="kt-font-success"> Nombre </span></th>
                    <th  align="center"><span class="kt-font-success"> Telefono </span></th>
                    <th  align="center"><span class="kt-font-success"> Dirección </span></th>
                    <th  align="center"><span class="kt-font-success"> Editar </span></th>
                    <th  align="center"><span class="kt-font-success"> Eliminar </span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Proveedores as $lista) { ?>
                    <tr>


                        <td><?php echo $lista->getCodigo() ?>  </td>
                        <td>  <font size="-1"><?php echo $lista->getCodigoEstablecimiento() ?></font>  </td>
                        <td>  <font size="-1"><?php echo $lista->getNombre() ?></font>  </td>
                        <td>  <font size="-1"><?php echo $lista->getTelefono() ?> <?php //echo $lista->getTelefonoSecundario()  ?> </font>  </td>
                        <td><font size="-2"> <?php echo $lista->getDireccionCompleta() ?> </font> </td>
                        <td>
                            <a class="btn  btn-info"  href="<?php echo url_for($modulo . '/muestra?id=' . $lista->getId()) ?>" ><i class="fa fa-pencil"></i> Editar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
                        </td>
                        <td>
                            <a class="btn btn-xs btn-danger" data-toggle="modal" href="#static<?php echo $lista->getId() ?>"><i class="fa fa-trash"></i>  Eliminar </a>
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
                            <?php $token = md5($lista->getCodigo()); ?>
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




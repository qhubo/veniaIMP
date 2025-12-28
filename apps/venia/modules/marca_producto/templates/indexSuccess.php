<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-list-1 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
Listado de Marcas de Producto
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> NUEVO </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">				
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                </div>
            </div>

            <!--begin: Datatable -->
            <table class="kt-datatable" xid="html_table" xwidth="100%">
                <thead >
                    <tr >
                        <th width="100px" align="center"><span class="kt-font-info"> Codigo</span>  </th>
                        <th  width="50px"  align="center"><span class="kt-font-info">Nombre</span></th>
                        <th  width="300px" align="center"><span class="kt-font-info">Activo</span></th>
                        <th  align="center">Acciones</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($marcas as $registro) { ?>
                    <?Php $lista  =$registro; ?>
                        <tr>
                           
                            <td><?php echo $registro->getCodigo(); ?></td>
                            <td><?php echo $registro->getNombre(); ?></td>
                            <td><?php if ($registro->getActivo()) { ?> <i class="fa fa-check"></i> <?php } ?></td>

                            <td>
                                <a class="btn btn-info btn-sm btn-block flaticon-more"  href="<?php echo url_for($modulo . '/muestra?id=' . $registro->getId()) ?>" ><i class="flaticon-edit-1"></i> Editar</a>
                                <br>
                                <a class="btn btn-sm btn-block btn-danger" data-toggle="modal" href="#static<?php echo $registro->getId() ?>"><i class="fa fa-trash"></i>  Eliminar </a>

                            </td>
                        </tr>
                                <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
                    <div class="modal-body">
                        <p> Esta seguro de eliminar Grupo Código
                            <span class="caption-subject font-green bold uppercase"> 
                                <?php echo $lista->getCodigo() ?>
                            </span> ?
                        </p>
                    </div>
                    <?php $token = md5($lista->getCodigo()); ?>
                    <div class="modal-footer">
                        <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                            <i class="fa fa-trash-o "></i> Confirmar</a> 
                                   <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
       
                    </div>
         
                </div>
            </div>
        </div> 
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--<script>
    var KTAppOptions = {"colors": {"state": {"brand": "#591df1", "light": "#ffffff", "dark": "#282a3c", "primary": "#5867dd", "success": "#34bfa3", "info": "#36a3f7", "warning": "#ffb822", "danger": "#fd3995"}, "base": {"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"], "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]}}};
</script>-->
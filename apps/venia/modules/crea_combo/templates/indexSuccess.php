<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                COMBOS DE PRODUCTO <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> puedes crear un nuevo combo </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> NUEVO </a>

        </div>
    </div>


    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-10">
                <?php if (count($combos) >0) { ?>
                <h3> Combos creados <strong><?php echo count($combos) ?></strong></h3>
             
                <?php } else { ?>
                   <h3> Crea tu primer combo</h3>
                <?php  } ?>
            </div>
            <div class="col-lg-2">				
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>
     <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
            <thead >
                <tr class="active">
<!--                    <th align="center" width="35px"></th>-->
                    <th  align="center"> <span class="kt-font-success">Codigo Sku</span></th>
                    <th  align="center"><span class="kt-font-success">Nombre</span></th>
                    <th  align="center"><span class="kt-font-success">Activo</span></th>
      
                    <th  align="center"><span class="kt-font-success"> Precio</span></th>
       
                    <th><font size="-2">Acción</font></th>
                      <th><font size="-2">Eliminar</font></th>

                </tr>
            </thead>
            <tbody>
                <?php if ($combos) { ?>
                    <?php foreach ($combos as $lista) { ?>
                        <tr>
<!--                     <td>  <img src="<?php echo $lista->getImagen() ?>" width="75px" ></td>-->
                    <td><?php echo $lista->getCodigoSku() ?></td>
                    <td><font size="-1"> <?php echo $lista->getNombre(); ?></font> 
                        <br>
                        <font size="-2"> <?php echo $lista->getDescripcion(); ?></font> 
                    </td>
                    <td style="text-align:center"> <div align="center"> <font size="-1"> <?php if ($lista->getActivo()) { ?><li class="fa fa-check  font-green-jungle"></li> <?php } ?> </font></div>  </td>
                    <td> <font size="-1"> <?php echo number_format($lista->getPrecio(), 2); ?></font> 
                   <?php if ($lista->getPrecioVariable()) { ?> <font size="-2"> *Precio Variable </font> <?php } ?> 
                    </td>
                 
                    <td>
                        <a class="btn btn-info btn-sm btn-block flaticon-edit-1"  href="<?php echo url_for($modulo . '/muestra?id=' . $lista->getId()) ?>" ><li class="fa fa-picture-o"></li> Editar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
<!--                        <br>
                        <a class="btn  btn btn-success btn-block "  target="_blank"  href="<?php echo url_for($modulo . '/reporte?id=' . $lista->getId()) ?>" > Reporte  <i class="fa fa-print"></i></a>-->
                    </td>        
                    <td> 
                        <a class="btn btn-sm btn-block btn-danger" data-toggle="modal" href="#static<?php echo $lista->getId() ?>"><i class="fa fa-trash"></i>  </a>
                    </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>

<script src="./assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
<?php if ($combos) { ?>

    <?php foreach ($combos as $lista) { ?>

        <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmación Eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> Esta seguro de eliminar Producto Código
                            <span class="caption-subject font-green bold uppercase"> 
                                <?php echo $lista->getCodigoSku() ?>
                            </span> ?
                        </p>
                    </div>
                    <?php $token = md5($lista->getCodigoSku()); ?>
                    <div class="modal-footer">
                        <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                            <i class="fa fa-trash-o "></i> Confirmar</a> 
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>

                    </div>

                </div>
            </div>
        </div> 
    <?php } ?>
<?php } ?>


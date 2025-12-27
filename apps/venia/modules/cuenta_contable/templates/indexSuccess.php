<?php $modulo = $sf_params->get('module'); ?>
<?php $tab = 1; ?>
<?php if ($datos) { ?>
    <?php $tab = 2; ?>
<?php } ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Cuentas Contables <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Listado de cuentas </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn-sm btn-info" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
        </div>
    </div>




    <div class="kt-portlet__body">
        <div class="row">
            
              <div class="col-lg-10">
    
        
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
        
            <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Tipo </div>
         <div class="col-lg-1 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
              <div class="col-lg-2">Grupo </div>
         <div class="col-lg-2 <?php if ($form['grupo']->hasError()) echo "has-error" ?>">
                <?php echo $form['grupo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['grupo']->renderError() ?>  
                </span>
            </div>
        </div>
             <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Nombre </div>
         <div class="col-lg-5 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
                <?php echo $form['nombre'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombre']->renderError() ?>  
                </span>
            </div>
        </div>
             <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Cuenta </div>
         <div class="col-lg-5 <?php if ($form['cuenta']->hasError()) echo "has-error" ?>">
                <?php echo $form['cuenta'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['cuenta']->renderError() ?>  
                </span>
            </div>
                 <div class="col-lg-2">
                     
                     <?php if ($id) { ?>
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                    <span> Actualizar  </span>
                </button>
                     <?php } else {  ?>
                             <button class="btn btn-primary " type="submit">
                    <i class="fa fa-plus "></i>
                    <span> Crear </span>
                </button>
                     <?php } ?>
            </div>
        </div>        
        
        <?php echo '</form>'; ?>
              </div>
            <div class="col-lg-2">
                       <a href="<?php echo url_for("carga/index?tipo=pago") ?>" class="btn btn-dark" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa flaticon-upload"></li> Importar archivo   </a>
   
              
            </div>
            </div>

        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Listado

                </a>
            </li>
            <?php if ($datos) { ?>
                <li class="nav-item">
                    <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_2_2_tab_content" role="tab" aria-selected="false">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i> 
                        Cargar Información
                    </a>
                </li>

            <?php } ?>
        </ul> <br>
        <br>
        <div class="tab-content">
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">

               <div class="row">
                <div class="col-lg-9">  </div>
                <div class="col-lg-1">
                                <?php if (count($cuentas) >10) { ?>
                
                     <a href="<?php echo url_for($modulo . '/reporteModelo') ?>" class="btn-sm btn-warning" > <li class="fa flaticon-file"></li> Listado  </a>
                                <?php } ?>
                </div>
                <div class="col-lg-2">				
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                </div>
            </div> 
<table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
            <thead>
                <tr class="active">

                            <th  width="50px"   align="center"><span class="kt-font-info"> Tipo</span></th>
                            <th width="80px"    align="center"><span class="kt-font-info"> Grupo</span></th>
                            <th   align="center"><span class="kt-font-info"> Cuenta</span></th>
                            <th   align="center"><span class="kt-font-info"> Nombre</span></th>
                            <th  width="20px" align="center"><span class="kt-font-success"> Editar </span></th>
                            <th  width="20px" align="center"><span class="kt-font-success"> Eliminar </span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cuentas as $registro) { ?>
                            <?php $lista = $registro; ?>
                            <tr>
                                <td><?Php echo $registro->getTipo() ?></td>
                                <td><?Php echo $registro->getCampo() ?></td>
                                <td><?Php echo $registro->getCuentaContable() ?></td>
                                <td><?Php echo $registro->getNombre() ?></td>
                                <td>    
                                    <a class="btn btn-info btn-sm  flaticon-edit-1"  href="<?php echo url_for($modulo . '/index?id=' . $registro->getId()) ?>" ><li class="fa fa-picture-o"></li></a> 
                                </td>
                                <td>
                                    <a class="btn btn-sm  btn-danger" data-toggle="modal" href="#static<?php echo $registro->getId() ?>">
                                        <i class="fa fa-trash"></i>  
                                    </a>
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
                                                <strong>  <?php echo $lista->getCuentaContable() ?> </strong>
                                                 <?php echo $lista->getNombre() ?>
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
          
                <?php if (count($cuentas) >10) { ?>
                
                    <div class="row">
        <div class="col-lg-10">        </div>
        <div class="col-lg-2">    
            
               <a class="btn btn-sm  btn-danger" data-toggle="modal" href="#staticVE">
                                        <i class="fa fa-trash"></i>  Eliminar
                                    </a>
          </div>
    </div>
                <?php } ?>
                
            </div>

            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_2_tab_content" role="tabpanel">

                <table class="table table-striped- table-bordered table-hover "  width="100%">
                    <thead>
                        <tr class="active">

                            <th   align="center"><span class="kt-font-info"> Tipo</span></th>
                            <th   align="center"><span class="kt-font-info"> Grupo</span></th>
                            <th   align="center"><span class="kt-font-info"> Cuenta</span></th>
                            <th   align="center"><span class="kt-font-info"> Nombre</span></th>
                            <th   align="center"><span class="kt-font-info"> Mensaje</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($datos) { ?>
                            <?php foreach ($datos as $registro) { ?>
                                <tr>
                                    <td><?php echo $registro['TIPO'] ?></td>
                                    <td><?php echo $registro['GRUPO'] ?></td>
                                    <td><?php echo $registro['CUENTA'] ?></td>
                                    <td><?php echo $registro['NOMBRE'] ?></td>
                                    <td><?php if ($registro['VALIDO']) { ?><li class="fa fa-check"></li><?php } ?>

                            <font <?php if (!$registro['VALIDO']) { ?> color="red" <?php } ?> size="-2"> <?php echo $registro['MENSAJE'] ?></font></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td>     
                                <a href="<?php echo url_for("cuenta_contable/procesa") ?>" class="btn btn-success" > <li class="fa fa-check"></li> Procesar   </a>
                            </td>
                        </tr> 
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>


<div id="staticVE" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p> Confirma Eliminar Todas las Cuentas
                                            <span class="caption-subject font-green bold uppercase"> 
                                                <strong> Esta seguro de eliminar todos los registros </strong>
                                            </span> ?
                                        </p>
                                    </div>
                                    <?php $token = md5('axa'); ?>
                                    <div class="modal-footer">
                                        <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/eliminaCompleto?token=' . $token . '&id=' ) ?>" >
                                            <i class="fa fa-trash-o "></i> Confirmar </a> 
                                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                                    </div>

                                </div>
                            </div>
                        </div> 

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
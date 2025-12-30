<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-danger"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                LISTADO DE CLIENTES<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Utiliza el boton buscar para encontrar tus resultados
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
       <?php echo $form->renderFormTag(url_for('edita_cliente/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        
                <div class="form-body"> 
                    
                         <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-2 control-label right ">Busqueda (Nombre, Nit, Codigo)  </label>
                <div class="col-lg-4 <?php if ($form['nombrebuscar']->hasError()) echo "has-error" ?>">
                    <?php echo $form['nombrebuscar'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['nombrebuscar']->renderError() ?>  
                    </span>
                </div>
            </div>
                    
                    
<div class="row" style="padding-bottom: 5px;">
 <div class="col-lg-1"> </div> 
    <div  class="col-lg-2">
        País     
    </div>
    <div class="col-lg-4   <?php if ($form['pais']->hasError()) echo "has-error" ?>">
        <?php echo $form['pais'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['pais']->renderError() ?>       
        </span>
    </div>


</div> 

            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-2 control-label right ">Provincia  </label>
                <div class="col-lg-4 <?php if ($form['departamento']->hasError()) echo "has-error" ?>">
                    <?php echo $form['departamento'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['departamento']->renderError() ?>  
                    </span>
                </div>
                      <div class="col-lg-1">  </div>
                <div class="col-lg-2">
                    <button class="btn btn-info btn-block " type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>

     
        </div>
        
         <?php echo '</form>'; ?>
        
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
                    <th  align="center"><span class="kt-font-success">RUC/ Nit</span></th>
                    <th  align="center"><span class="kt-font-success"> Nombre </span></th>
                    <th  align="center"><span class="kt-font-success"> Pais </span></th>
                    <th  align="center"><span class="kt-font-success"> Telefono </span></th>
                    <th  align="center"><span class="kt-font-success"> Dirección </span></th>
                    <th  align="center"><span class="kt-font-success"> Editar </span></th>
                         <th  align="center"><span class="kt-font-success"> Reporte </span></th>
                       <th  align="center"><span class="kt-font-success"> Eliminar </span></th>
                </tr>
            </thead>
            <tbody>
                        <?php foreach ($Proveedores as $lista) { ?>
                            <tr>

                           
                                <td><?php echo $lista->getCodigo() ?>  </td>
                                <td>  <font size="-1"><?php echo $lista->getNit() ?></font>  </td>
                                <td>  <font size="-1"><?php echo $lista->getNombre() ?></font>  </td>
                                  <td>  <font size="-1"><?php echo $lista->getPais() ?></font>  </td>
                                <td>  <font size="-1"><?php echo $lista->getTelefono() ?> <?php //echo $lista->getTelefonoSecundario() ?> </font>  </td>
                                <td><font size="-2"> <?php echo $lista->getDireccionCompleta() ?> </font> </td>
                                <td>
                                    <a class="btn  btn-info"  href="<?php echo url_for($modulo . '/muestra?id=' . $lista->getId()) ?>" ><i class="fa fa-pencil"></i> Editar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
                                </td>
                                <td>
                                     <a class="btn btn-sm btn-block  green-jungle btn-block btn-outline"  target="_blank"  href="<?php echo url_for($modulo.'/reporte?id='.$lista->getId()) ?>" >
                            <i class="fa fa-print "></i>
                            Reporte
                        </a>
                                    
                              
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

 

   <script>
$(document).ready(function () {

    $("#consulta_pais").on("change", function () {

        let $municipio = $("#consulta_departamento");
        $municipio.empty().prop("disabled", true);

        $.getJSON(
            '<?php echo url_for("soporte/dptoPais") ?>?id=' + $(this).val(),
            function (data) {

                $.each(data, function (k, v) {

                    if (k === "") {
                        // opción [Seleccione Municipio]
                        $municipio.append(
                            '<option value="" selected disabled>' + v + '</option>'
                        );
                    } else {
                        $municipio.append(
                            '<option value="' + k + '">' + v + '</option>'
                        );
                    }
                });

                // activar select después de cargar
                $municipio.prop("disabled", false);
            }
        );
    });

});
</script>

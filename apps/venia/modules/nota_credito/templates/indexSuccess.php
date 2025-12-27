<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Nota de Crédito Proveedor
                <small>&nbsp;&nbsp;&nbsp; Ingresa una nuevo nota  y/o visualiza por un rango de fechas  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/nueva') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">


            <div class="col-lg-1 control-label right "> Inicio </div>
            <div class="col-lg-3 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>



            <div class="col-lg-1 control-label right ">Fin  </div>
            <div class="col-lg-3 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>



            <div class="col-lg-2">
                <button class="btn btn-small btn-outline-success" type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
            </div>

            <!--            <div class="col-lg-1">
                            <a class="btn btn-sm btn-outline-warning "   href="#<?php echo url_for('reporte/corteCaja') ?>"  target="_blank">
                                <li class="fa fa-print"></li> Reporte
                            </a>
                        </div>-->
        </div>

        <?php echo '</form>' ?>
        <div class="row">

            <div class="col-lg-12">   
                <BR> <BR>
            </div>
        </div>

       

                <div class="row">
                    <div class="col-lg-12">
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
<!--                        <table class="kt-datatable table-condensed flip-content" id="html_table" width="100%">-->
                        <table class="kt-datatable  table table-bordered  xdataTable table-condensed flip-content" id="html_table" width="100%" >
                            <thead>
                                <tr class="info">
                                    <th>Codigo </th>
                                    <th>Fecha</th>
                                    <th>Nombre</th>
                                    <th>Valor </th>
                                    <th>Documento </th>
                                    <th>Usuario</th>
                                    <th>Detalle</th>
                                    <th>Concepto</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($operaciones as $registro) { ?>
                                    <tr>
                                        <td><?php echo $registro->getCodigo(); ?></td>
                                        <td><?php echo $registro->getFecha('d/m/Y'); ?></td>
                                        <td><?php echo $registro->getNombre(); ?></td>
                                        <td style="text-align: right; align-content: right">
                                            <div align="right" style="align-content:right;">
                                                <?php echo Parametro::formato($registro->getValorTotal(), true); ?>
                                            </div>
                                        </td>
                                        <td><?php echo $registro->getDocumento(); ?></td>
                                        <td><?php echo $registro->getUsuario(); ?></td> 
                                        <td>
          <a href="<?php echo url_for("nota_credito/vista?id=" . $registro->getId()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $registro->getId(); ?>"> <li class="fa flaticon-more-v2"></li>    </a>

                                       </td>
                                        <td><?php echo $registro->getConcepto(); ?></td> 
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>      
               </div>      
        
        
        
 <?php foreach ($operaciones as $data) { ?>

    <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Nota  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php } ?>

    </div>
</div>

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  

<?php if ($partidaPen) { ?>
    <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include_partial('proceso/partidaModifica', array('partidaPen' => $partidaPen)) ?>  
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($partidaPen->getListDetalle() as $cta) { ?>
        <script>
            $(document).ready(function () {
                $("#cuenta<?php echo $cta; ?>").select2({
                    dropdownParent: $("#ajaxmodalPartida")
                });
            });
        </script>
    <?php } ?>
    <script>
        $(document).ready(function () {
            $("#ajaxmodalPartida").modal();
        });
    </script>
<?php } ?>

    

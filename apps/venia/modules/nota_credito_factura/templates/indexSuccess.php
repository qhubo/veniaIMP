<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Nota de Crédito Factura
                <small>&nbsp;&nbsp;&nbsp; Ingresa una nuevo nota  y/o visualiza por un rango de fechas  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
           <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link   active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Busqueda Factura
                        </a>
                    </li>
               
                    <li class="nav-item">
                        <a class="nav-link   " href="<?php echo url_for($modulo . '/historial') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
        
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">
            <div class="col-lg-2 control-label right "> Inicio </div>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1 control-label right ">Fin  </div>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row" style="padding-top:5px;">
            <div class="col-lg-2 control-label right "> Busca por Nombre Nit </div>
            <div class="col-lg-5 <?php if ($form['busqueda']->hasError()) echo "has-error" ?>">
                <?php echo $form['busqueda'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['busqueda']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-small btn-outline-success" type="submit">   <i class="fa fa-search "></i> Buscar</button>
            </div>
        </div>
        <?php echo '</form>' ?>
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
        <table class="kt-datatable  table table-bordered  xdataTable table-condensed flip-content" id="html_table" width="100%" >
            <thead>
                <tr class="info">
                    <th>Factura </th>
                    <th>Codigo </th>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Valor </th>
                    <th>Detalle</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($operaciones as $registro) { ?>
              
                    <tr>
                        <td>
                            <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $registro->getCodigo()) ?>" class="btn btn-block btn-xs btn-info " target = "_blank">
                                <?php echo $registro->getFaceNumeroFactura(); ?>
                            </a>
                        </td>     
                        <td>
                            <a class="btn  btn-warning "   href="<?php echo url_for('reporte_venta/muestra?id=' . $registro->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $registro->getId() ?>">
                                <?php echo $registro->getCodigo(); ?>
                            </a>
                        </td>
                        <td><?php echo $registro->getFecha('d/m/Y'); ?></td>
                        <td><?php echo $registro->getNombre(); ?></td>
                        <td style="text-align: right; align-content: right">
                            <div align="right" style="align-content:right;">
                                <?php echo Parametro::formato($registro->getValorTotal(), true); ?>
                            </div>
                        </td>
                        <td>
                            <?php if ($registro->getNota() <> "") { ?>
                            <span style="text-align:center; font-weight: bold;">         <?php echo $registro->getNota(); ?>  </span>
                            
                  
                            <?php } else { ?>
                               <a href="<?php echo url_for($modulo . '/nueva?id=' . $registro->getId()) ?>" class="btn btn-dark btn-secondary" > 
                                <i class="flaticon-list-3"></i> Procesar </a>
                           
                            <?php } ?>
                        </td> 
                        <td><?php echo $registro->getUsuario(); ?></td>
                        <td></td>                                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<?php if ($operacion) { ?>
    <div id="ajaxmodalFactura" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <?php include_partial('soporte/avisos') ?>
                <?php $val = explode('-', $operacion->getFaceFirma()) ?>
                <?php $numero = $val[0]; ?>
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">NOTA CREDITO <?php echo $notaCredito->getCodigo(); ?>   </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-6" style="text-align:right; font-weight: bold;">
                            Nota
                        </div>
                        <div class="col-lg-2">
                            <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $operacion->getCodigo()) ?>" class="btn btn-block btn-xs btn-info " target = "_blank">
                              <?php echo $operacion->getAnulaFaceNumeroFactura(); ?> 
                            </a>
                        </div>
                    </div>


                    <?php if ($operacion->getFaceError() <> "") { ?>
                    <font color="red">    <?php echo $operacion->getFaceError(); ?> </font>
                        <a href="<?php echo url_for($modulo.'/reenviar?id=' . $operacion->getId()) ?>" class="btn btn-secondary btn-dark btn-sm" > <i class="flaticon-refresh"></i>Reenviar</a>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php foreach ($operaciones as $reg) { ?>
    <?php $lista = $reg; ?>    
    <div class="modal fade" id="ajaxmodal<?php echo $reg->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 750px">
            <div class="modal-content" style=" width: 750px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Detalle de Operación</h4>
                </div>
            </div>
        </div>
    </div> 

<?php } ?>

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

<?php } ?>
<script>
    $(document).ready(function () {
        $("#ajaxmodalPartida").modal();
        $("#ajaxmodalFactura").modal();

    });
</script>


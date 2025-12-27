<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')      ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $muestrabusqueda = sfContext::getInstance()->getUser()->getAttribute('muestrabusqueda', null, 'busqueda'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-tag  kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                SALIDA DE INVENTARIO <small>   Filtra por rango de fechas  <strong>  </strong>    </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
            <li class="nav-item">
                <a class="nav-link   " href="<?php echo url_for($modulo . '/index') ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i> Ingreso Salida 
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link   active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historial
                </a>
            </li>
        </ul>
  <?php echo $form->renderFormTag(url_for($modulo . '/historial?id=1'), array('class' => 'form-horizontal"')) ?>
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
                            <th>Tienda</th>
                            <th>Documento </th>
                            <th>Observaciones</th>
                            <th>Reporte</th>
                            <th>Creación</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($operaciones as $regi) { ?>
                        <tr>
                            <td><?php echo $regi->getCodigo(); ?></td>
                            <td><?php echo $regi->getFechaDocumento('d/m/Y'); ?></td>
                            <td><?php echo $regi->getTienda()->getNombre(); ?></td>
                            <td><?php echo $regi->getNumeroDocumento(); ?></td>
                            <td><?php echo $regi->getObservaciones(); ?></td>
                            <td>
                                    <a target="_blank" href="<?php echo url_for($modulo.'/reportePdf?id=' . $regi->getId()) ?>" class="btn  btn-small btn-warning " target = "_blank">
                   <li class="fa fa-print"></li> Reporte      
                       </a>
                                
                            </td>
                            <td><?php echo $regi->getUpdatedAt('d/m/Y H:i'); ?> <?php echo $regi->getCreatedBy(); ?> </td>       

                        </tr>
                            
                            <?php } ?>
                    </tbody>
                </table>
            </div>
           </div>
    </div>
</div>
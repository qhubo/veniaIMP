<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')     ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $muestrabusqueda = sfContext::getInstance()->getUser()->getAttribute('muestrabusqueda', null, 'busqueda'); ?>
<?php $linea = unserialize(sfContext::getInstance()->getUser()->getAttribute('cargaSalida', null, 'busqueda')); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-tag  kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                SALIDA DE INVENTARIO <small>   Selecciona el motivo y salida de inventario  <strong>  </strong>    </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-dark" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        
                   <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link   active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Ingreso Salida
                        </a>
                    </li>
               
                    <li class="nav-item">
                        <a class="nav-link   " href="<?php echo url_for($modulo . '/historial') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
        
        
        <?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-2 control-label right ">TIENDA  </label>
            <div class="col-lg-4 <?php if ($form['tienda']->hasError()) echo "has-error" ?>">
                <?php echo $form['tienda'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tienda']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-2">Fecha</div>
                 <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row" style="padding-top: 10px;">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-2 control-label right ">OBSERVACIONES  </label>
            <div class="col-lg-9 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div>

          
        </div>

 
       <div class="row" style="padding-top: 10px;">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-2 control-label right ">DOCUMENTO  </label>
            <div class="col-lg-4 <?php if ($form['documento']->hasError()) echo "has-error" ?>">
                <?php echo $form['documento'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['documento']->renderError() ?>  
                </span>
            </div>
            <?php if (!$salida) { ?>
            <div class="col-lg-3">
                <button class="btn btn-block btn-success " type="submit">
                    <i class="fa fa-save "></i>
                    INICIAR
                </button>
            </div>
            <?php } ?>
        </div>

<?php if ($salida) { ?>
     <div class="row" style="padding-top: 10px; padding-bottom: 20px;">
            <div class="col-lg-7"> </div>
            <div class="col-lg-3">
                <button class="btn btn-block btn-success " type="submit">
                    <i class="fa fa-save "></i>
                    ACTUALIZAR
                </button>
            </div>
            
                        <div class="col-lg-2"> 
                        
                        <a href="<?php echo url_for("carga/index?tipo=salida") ?>" class="btn btn-warning btn-hover-brand" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa fa-cloud-download"></li> Importar archivo   </a>

                        </div>
        </div>
<?php } ?>        
        
        <?php echo '</form>'; ?>
        
        <?php include_partial($modulo.'/detalle', array( 'modulo'=>$modulo, 'linea' => $linea )) ?>


    </div>          

</div>






<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px">
        <div class="modal-content" style=" width: 700px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
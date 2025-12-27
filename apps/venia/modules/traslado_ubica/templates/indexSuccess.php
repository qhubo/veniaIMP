<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $muestrabusqueda = sfContext::getInstance()->getUser()->getAttribute('muestrabusqueda', null, 'busqueda'); ?>
<?php $linea = unserialize(sfContext::getInstance()->getUser()->getAttribute('carga', null, 'busqueda')); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-tag  kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                Traslado de Ubicación <small>     <strong> </strong>    </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
             <a href="<?php echo url_for('actualiza_inventario_ubica/reporteF') ?>" class="btn btn-dark" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
 
        </div>
    </div>
    <div class="kt-portlet__body">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
            <li class="nav-item">
                <a class="nav-link   active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Traslado Producto Ubicacion
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
        <div class="row" style="padding-top: 5px;">
            <label class="col-lg-2 control-label right ">TIENDA </label>
            <div class="col-lg-5 <?php if ($form['tienda_id']->hasError()) echo "has-error" ?>">
                <?php echo $form['tienda_id'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tienda_id']->renderError() ?>  
                </span>
            </div>          
        </div>
        <div class="row" style="padding-top: 5px;">
            <label class="col-lg-2 control-label right ">OBSERVACIONES  </label>
            <div class="col-lg-5 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div> 
               <div class="col-lg-2">
                <button class="btn btn-success " type="submit">
                    <i class="fa fa-plus "></i>Actualizar</button>
            </div>
        </div>
          <?php echo '</form>'; ?>
            <div class="row">
                <div class="col-lg-12" style="padding-top:4px; padding-bottom: 4px;"><hr> </div>

            </div>
        
                <?php if ($trasladoBu) { ?> 
            <div class="row">
                <div class="col-lg-4" style="background-color:#D7EBF5;">
                    <h3>Buscador</h3>

                    <?php include_partial('busca/buscaTraslado', array('movi' => $trasladoBu->getId())) ?>  
                </div>
                <div class="col-lg-8">
                    <h3>Listado de Producto</h3>
                    <?php include_partial($modulo . '/lista', array('bodegas'=>$bodegas, 'id' => $trasladoBu->getId(), 'listado' => $listado)) ?>      
                </div>
            </div>
        <?php } ?>
    
    </div>
</div>


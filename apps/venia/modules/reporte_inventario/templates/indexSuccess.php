<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
 <?php      $tipoPrecios = ListaPrecioQuery::create()->orderByNombre()->filterByActivo(true)->find(); ?>
 <script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Existencia de  Productos
            <small>&nbsp;&nbsp;&nbsp; puedes filtrar tu busqueda&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
            <div class="kt-portlet__head-toolbar">
                    <?php echo $form['nombrebuscar'] ?> 
        </div>
    </div>
  <div class="kt-portlet__body">
        <div class="form-body">
            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::tipo(); ?>  </label>
                <div class="col-lg-4 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                    <?php echo $form['tipo'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tipo']->renderError() ?>  
                    </span>
                </div>

         
            </div>
                <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-1 control-label right ">Proveedor </label>
                <div class="col-lg-4 <?php if ($form['proveedor']->hasError()) echo "has-error" ?>">
                    <?php echo $form['proveedor'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['proveedor']->renderError() ?>  
                    </span>
                </div>
           
            </div>
            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-1 control-label right ">Tipo Filtro  </label>
                <div class="col-lg-4 <?php if ($form['tipo_filtro']->hasError()) echo "has-error" ?>">
                    <?php echo $form['tipo_filtro'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tipo_filtro']->renderError() ?>  
                    </span>
                </div>
           
                  <div class="col-lg-2">
                 <button class="btn green btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
                         </div>
            </div>






        <div class="row">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right ">Bodega </label>
            <div class="col-lg-4 <?php if ($form['bodega']->hasError()) echo "has-error" ?>">
                <?php echo $form['bodega'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['bodega']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1">


            </div>

                   <div class="col-lg-2">
                          <a class="btn  btn btn-info  "  target="_blank"  href="<?php echo url_for($modulo . '/reporte') ?>" ><i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;  <i class="fa fa-print"></i></a>
                </div>
            
                <div class="col-lg-2">
                          <a class="btn  btn btn-warning  "  target="_blank"  href="<?php echo url_for($modulo . '/reporteCBMExcel') ?>" ><i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;CMB  <i class="fa fa-print"></i></a>
                </div>
                <!-- Exportar -->


                  
        </div>

<?php echo '</form>'; ?>

     <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Listado
                        </a>
                    </li>
          
                    
             

                </ul>
            </div>
        </div>
            
                    </div>    <div class="kt-portlet__body">

            <div class="tab-content">
                <div class="tab-pane active" id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                        <?php include_partial($modulo . '/listado', array('bodegaId'=>$bodegaId,  'modulo' => $modulo, 'filtro'=>$filtro, 'productos'=>$productos, 'bodegas' => $bodegas)) ?>
     
                </div>
                <div class="tab-pane   " id="kt_portlet_base_demo_2_2_tab_content" role="tabpanel">
                        <?php //include_partial($modulo . '/listadoVence', array( 'modulo' => $modulo, 'productosVence'=>$productosVence, 'bodegas' => $bodegas)) ?>
       
                </div>

            </div>
            
            
        </div>
    </div>
</div>


<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
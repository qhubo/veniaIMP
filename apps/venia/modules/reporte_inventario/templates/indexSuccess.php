<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

 
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
                <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::marca(); ?>  </label>
                <div class="col-lg-4 <?php if ($form['marca']->hasError()) echo "has-error" ?>">
                    <?php echo $form['marca'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['marca']->renderError() ?>  
                    </span>
                </div>
           
            </div>


<!--        <div class="row">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::modelo(); ?>  </label>
            <div class="col-lg-4 <?php if ($form['modelo']->hasError()) echo "has-error" ?>">
                <?php echo $form['modelo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['modelo']->renderError() ?>  
                </span>
            </div>
        </div>-->



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
            <div class="col-lg-1">
                <button class="btn btn-sm btn-success btn-outline" type="submit">
                    <i class="fa fa-search "></i>Buscar
                </button>
            </div>
                   <div class="col-lg-2">
                          <a class="btn  btn grey-cascade  btn-block "  target="_blank"  href="<?php echo url_for($modulo . '/reporte') ?>" ><i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;  <i class="fa fa-print"></i></a>
                </div>
            
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
          
<!--                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#kt_portlet_base_demo_2_2_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>Con Vencimiento
                            </a>
                        </li>-->
             

                </ul>
            </div>
        </div>
            
                    </div>    <div class="kt-portlet__body">

            <div class="tab-content">
                <div class="tab-pane active" id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                        <?php include_partial($modulo . '/listado', array( 'listaPrecio' =>$listaPrecio, 'modulo' => $modulo, 'productos'=>$productos, 'bodegas' => $bodegas)) ?>
     
                </div>
                <div class="tab-pane   " id="kt_portlet_base_demo_2_2_tab_content" role="tabpanel">
                        <?php //include_partial($modulo . '/listadoVence', array( 'modulo' => $modulo, 'productosVence'=>$productosVence, 'bodegas' => $bodegas)) ?>
       
                </div>

            </div>
            
            
        </div>
    </div>
</div>

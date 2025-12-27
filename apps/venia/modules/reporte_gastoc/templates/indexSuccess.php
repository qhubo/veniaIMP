
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Ingreso de gastos varios <small> FIltre por un rango de fecha para obtener la información </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for('carga_gasto/reporte') ?>" class="btn btn-secondary btn-hover-brand" > <i class="flaticon-download-1"></i> Archivo Modelo Carga  </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        
               <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link "  href="<?php echo url_for('carga_gasto/index') ?>" >
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Ingreso
                        </a>
                    </li>
                      <li class="nav-item">
                           <a class="nav-link   active " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                        
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
        
        
        <?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo.'/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
             <div class="row">

           
                <div class="col-lg-1 control-label right "> Inicio </div>
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
                 
             

                <div class="col-lg-2">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
                
                  <div class="col-lg-2">
     
        </div>
            </div>
        <?php echo "</form>"; ?>
        <?php include_partial($modulo.'/listado', array('registrosCaja'=>$registrosCaja)) ?>  


        
    </div>
</div>
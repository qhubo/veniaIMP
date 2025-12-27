
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-zig-zag-line-sign kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                HISTORIAL DE   PRODUCTOS ASIGNANDOS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Listado de los productos asignados a vendedor
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4"> 
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                    <li class="nav-item">

                        <a class="nav-link "  href="<?php echo url_for($modulo . '/index') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Ingreso
                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link   active" data-toggle="tab" href="#kt_portlet_base_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
            </div>            
        </div>
        <?php echo $form->renderFormTag(url_for($modulo.'/historial?id=1'), array('class' => 'form-horizontal"')) ?>
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
        
        <?php include_partial($modulo.'/listado', array('registros' => $registros)) ?>  

    </div>
</div>
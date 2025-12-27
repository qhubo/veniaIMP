<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-shopping-cart kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
             REPORTE DE ORDENES DE COMPRA<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Filtra por rango de fechas
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
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
                 
             
    <div class="col-lg-2 <?php if ($form['usuario']->hasError()) echo "has-error" ?>">
                <?php echo $form['usuario'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['usuario']->renderError() ?>  
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






          


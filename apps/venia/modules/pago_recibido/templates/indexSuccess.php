<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-add-label-button kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                REPORTE DE PAGOS RECIBIDOS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Filtra por rangos de fechas
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">        </div>
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
                   <div class="col-lg-1 control-label right ">Vendedor  </div>
                <div class="col-lg-3 <?php if ($form['vendedor']->hasError()) echo "has-error" ?>">
                    <?php echo $form['vendedor'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['vendedor']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-1">
                    <button class="btn btn-sm btn-outline-success" type="submit">
                        <i class="fa fa-search "></i>
                        Buscar
                    </button>
                </div>
                
     
            </div>
        
        <div class="row" style="padding-top:10px;">
                <div class="col-lg-1 control-label right "> Factura </div>
                <div class="col-lg-2 <?php if ($form['busqueda']->hasError()) echo "has-error" ?>">
                    <?php echo $form['busqueda'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['busqueda']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-1 control-label right ">Cliente  </div>
                <div class="col-lg-2 <?php if ($form['cliente']->hasError()) echo "has-error" ?>">
                    <?php echo $form['cliente'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['cliente']->renderError() ?>  
                    </span>
                </div>
                    <div class="col-lg-1 control-label right ">Medio Pago  </div>
                <div class="col-lg-2 <?php if ($form['medio_pago']->hasError()) echo "has-error" ?>">
                    <?php echo $form['medio_pago'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['medio_pago']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-1">
                     <a target="_blank" href="<?php echo url_for( $modulo.'/reporteExcel')  ?>" class="btn  btn-sm  btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
          </div>
            </div>
        <?php echo "</form>"; ?>
        
        <?php include_partial($modulo.'/listado', array('registros' => $registros)) ?>  

    </div>
</div>






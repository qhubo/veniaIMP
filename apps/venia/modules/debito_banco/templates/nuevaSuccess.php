<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-tabs kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                 Débito Bancario <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Completa la Información solicitada </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <?php echo $form->renderFormTag(url_for($modulo . '/nueva'), array('class' => 'form-horizontal"')) ?>
    <?php echo $form->renderHiddenFields() ?>
    <div class="kt-portlet__body">

        <div class="row">
            <div class="col-lg-2">Medio Pago</div>
            <div class="col-lg-4 <?php if ($form['medio_pago']->hasError()) echo "has-error" ?>">
                <?php echo $form['medio_pago'] ?>    
                <font size="-2"> *Check  Aplica movimiento banco </font>
                <span class="help-block form-error"> 
                    <?php echo $form['medio_pago']->renderError() ?>  
                </span>
            </div>
              <div class="col-lg-1">Monto</div>
            <div class="col-lg-2 <?php if ($form['monto']->hasError()) echo "has-error" ?>">
                <?php echo $form['monto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['monto']->renderError() ?>  
                </span>
            </div>
        </div>
        
         <div class="row">
            <div class="col-lg-12"><hr></div>
        </div>

        <div class="row">
            <div class="col-lg-2">Banco </div>
            <div class="col-lg-3 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
                <?php echo $form['banco'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['banco']->renderError() ?>  
                </span>
            </div>
         
        </div>
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row">
            <div class="col-lg-2">Fecha Movimiento</div>
            <div class="col-lg-2 <?php if ($form['fecha_movimiento']->hasError()) echo "has-error" ?>">
                <?php echo $form['fecha_movimiento'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fecha_movimiento']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1">Referencia</div>
            <div class="col-lg-2 <?php if ($form['referencia']->hasError()) echo "has-error" ?>">
                <?php echo $form['referencia'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['referencia']->renderError() ?>  
                </span>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row">
          
            <div class="col-lg-2">Observaciones</div>
            <div class="col-lg-5 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1"></div> 
            <div class="col-lg-2"> 
                <br>
                <button class="btn btn-primary btn-sm " type="submit">
                    <i class="fa fa-save "></i> Guardar
                </button>
            </div>

        </div>
        
            <div class="row">
          
            <div class="col-lg-2">Archivo</div>
            <div class="col-lg-5 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
                <?php echo $form['archivo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['archivo']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1"></div> 
          

        </div>
        
        

        <div class="row">
            <div class="col-lg-8">  </div>
           
        </div>


    </div>
    <?php echo '</form>' ?>
</div>
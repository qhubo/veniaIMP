<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php if ($registro) { ?>  Editar Campo Usuario <?php echo $registro->getCodigo(); ?> <?php } else { ?>
                    Nuevo Campo Usuario
                <?php } ?>
                <small>  &nbsp;&nbsp;&nbsp;&nbsp; Completa la información solicitada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php if ($registro) { ?>
                <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
            <?php } ?>
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-1"> </div>
        </div>
              <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Tipo Documento </div>
         <div class="col-lg-5 <?php if ($form['tipo_documento']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo_documento'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo_documento']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1">Orden </div>
             <div class="col-lg-1"><?php echo $form['orden'] ?>  </div>
        </div>
             <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Nombre </div>
         <div class="col-lg-5 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
                <?php echo $form['nombre'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombre']->renderError() ?>  
                </span>
            </div>
        </div>
        
             <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Típo Campo </div>
         <div class="col-lg-5 <?php if ($form['tipo_campo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo_campo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo_campo']->renderError() ?>  
                </span>
            </div>
        </div>
                    <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Valores </div>
         <div class="col-lg-5 <?php if ($form['valores']->hasError()) echo "has-error" ?>">
             <font size="-1">Crea la selección de lista con valores separados por coma </font>
                <?php echo $form['valores'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['valores']->renderError() ?>  
                </span>
            </div>
        </div>
        
 
        
    
        
        <div class="row">
  <div class="col-lg-1"> </div>
            <div class="col-lg-2">Tíenda </div>
         <div class="col-lg-2 <?php if ($form['tiendaId']->hasError()) echo "has-error" ?>">
                <?php echo $form['tiendaId'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tiendaId']->renderError() ?>  
                </span>
            </div>
       
            <label class="col-lg-1 control-label font-blue-steel right ">Requerido</label>
            <div class="col-lg-1 <?php if ($form['activo']->hasError()) echo "has-error" ?>">
                <?php echo $form['requerido'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['requerido']->renderError() ?>  
                </span>
            </div>
   
            
            <label class="col-lg-1 control-label font-blue-steel right ">Activo</label>
            <div class="col-lg-1 <?php if ($form['activo']->hasError()) echo "has-error" ?>">
                <?php echo $form['activo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['activo']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i> Aceptar 
                </button>
            </div>
        </div>

    </div>
</div>
<?php echo '</form>'; ?>




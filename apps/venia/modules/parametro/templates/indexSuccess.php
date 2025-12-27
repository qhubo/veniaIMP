<?php $modulo = $sf_params->get('module'); ?>
     <link href="./assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />

        <link href="./assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Editar                 <small>  &nbsp;&nbsp;&nbsp;&nbsp; Parametros generales</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">
            <div class="col-lg-1"> </div>
        </div>

        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Usuario Correo </div>
            <div class="col-lg-5 <?php if ($form['usuario_correo']->hasError()) echo "has-error" ?>">
                <?php echo $form['usuario_correo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['usuario_correo']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><hr> </div>
        </div>

                <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Smtp Correo </div>
            <div class="col-lg-5 <?php if ($form['smtp_correo']->hasError()) echo "has-error" ?>">
                <?php echo $form['smtp_correo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['smtp_correo']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><hr> </div>
        </div>

                <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Clave Correo </div>
            <div class="col-lg-5 <?php if ($form['clave_correo']->hasError()) echo "has-error" ?>">
                <?php echo $form['clave_correo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['clave_correo']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><hr> </div>
        </div>

                <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Puerto Correo </div>
            <div class="col-lg-5 <?php if ($form['puerto_correo']->hasError()) echo "has-error" ?>">
                <?php echo $form['puerto_correo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['puerto_correo']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><hr> </div>
        </div>
    <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Mensaje Bienvenida</div>
            <div class="col-lg-8 <?php if ($form['mensaje']->hasError()) echo "has-error" ?>">
                <?php echo $form['mensaje'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['mensaje']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10"></div>
            <div class="col-lg-2">               <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                     Aceptar
                </button>
            </div>
            
        </div>
        <?php echo '</form>'; ?>
    </div>
</div>





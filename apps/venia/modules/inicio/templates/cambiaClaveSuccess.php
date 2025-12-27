

<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-settings kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
               Cambio de Contraseña
                
               <strong><?php echo $usuario->getUsuario() ?> </strong>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
                                    <a href="<?php echo url_for('inicio/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">

            <?php echo $form->renderFormTag(url_for('inicio/cambiaClave?id=' . $id), array('class' => 'form')) ?>
        <?php echo $form->renderHiddenFields() ?>
    
         <div class="row">
            <div class="col-lg-1"> </div>
            <label class="col-lg-2 control-label">Contraseña Actual:<span class="required"> * </span>                                                                   </label>
            <div class="col-lg-3 <?php if ($form['clave_anterior']->hasError()) echo "has-error" ?>">
                <?php echo $form['clave_anterior'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['clave_anterior']->renderError() ?>  
                </span>
            </div>              
          </div>
        
           <div class="row">
            <div class="col-lg-1"> </div>
            <label class="col-lg-2 control-label">Nueva Contraseña:<span class="required"> * </span>                                                                   </label>
            <div class="col-lg-3 <?php if ($form['clave']->hasError()) echo "has-error" ?>">
                <?php echo $form['clave'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['clave']->renderError() ?>  
                </span>
            </div>              
          </div>
        
        
        <div class="row">
            <div class="col-lg-1"> <BR></div>
        </div>
            <div class="row">    
              


                <div class="col-lg-6"> </div>

                <div class="col-lg-3">
             
                    <button class="btn btn-primary " type="submit">
                        <i class="fa fa-save "></i>
                        <span>Actualizar</span>
                    </button>
                </div>
                <div class="col-lg-1"> </div>
                   <div class="col-lg-2">
                    </div>
            </div>
            <?php echo '</form>'; ?>
    </div>

</div>

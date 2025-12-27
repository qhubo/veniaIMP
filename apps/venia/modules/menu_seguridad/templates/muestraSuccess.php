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
                <?php if ($registro) { ?>  Editar  Menú<?php  echo $registro->getId(); ?> <?php } else { ?>
                    Nuevo  Menú
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
            <div class="col-lg-2">Título </div>
         <div class="col-lg-5 <?php if ($form['descripcion']->hasError()) echo "has-error" ?>">
                <?php echo $form['descripcion'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['descripcion']->renderError() ?>  
                </span>
            </div>
        </div>
               <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Modulo </div>
         <div class="col-lg-5 <?php if ($form['modulo']->hasError()) echo "has-error" ?>">
                <?php echo $form['modulo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['modulo']->renderError() ?>  
                </span>
            </div>
        </div>
        
                   <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Superior </div>
         <div class="col-lg-5 <?php if ($form['superior']->hasError()) echo "has-error" ?>">
                <?php echo $form['superior'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['superior']->renderError() ?>  
                </span>
            </div>
        </div>
                      <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Icono</div>
         <div class="col-lg-3 <?php if ($form['icono']->hasError()) echo "has-error" ?>">
                <?php echo $form['icono'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['icono']->renderError() ?>  
                </span>
            </div>
        </div>
     
                 <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Orden</div>
         <div class="col-lg-3 <?php if ($form['orden']->hasError()) echo "has-error" ?>">
                <?php echo $form['orden'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['orden']->renderError() ?>  
                </span>
            </div>
        </div>
     
        <div class="row">
            <div class="col-lg-4"> </div>
                  <div class="col-lg-1"> </div>
            <div class="col-lg-1">Sub Menu</div>
               <?php echo $form['submenu'] ?>    
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                    <span> Aceptar  </span>
                </button>
            </div>
        </div>

    </div>
</div>
<?php echo '</form>'; ?>




<?php $modulo = $sf_params->get('module'); ?>
<?php $muestra=true; ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-medal kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                <?php if ($marca) { ?>
                    <?php if (($marca->getDescripcion() =='RECETA') or ($marca->getDescripcion() =='COMBO')) { ?>
<?php $muestra=false; ?>
                    <?php } ?>
                            
                    <?php echo $marca->getCodigo() ?> <small> <?php echo $marca->getDescripcion() ?> &nbsp;&nbsp;&nbsp;&nbsp;</small>
                <?php } else { ?>
                    <i class="flaticon2-plus"></i>  Nuevo Grupo     
                <?Php } ?>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form')) ?>
        <?php echo $form->renderHiddenFields() ?>

        <?php if ($marca) { ?>

            <?php if ($marca->getImagen()) { ?>
                <div class="row">
                    <div class="col-lg-1"> </div>  
                    <div class="col-lg-2"> 
                        <img src="<?php echo $marca->getImagen() ?>"  width="150px">
                    </div>
            
                    <div class="col-lg-2">Quitar Imagen </div>  
                    <div class="col-lg-1">    <?php echo $form['limpia'] ?>  </div>
                </div>

                <div class="row">
                    <div class="col-lg-11"><br> </div>  
                </div>
            <?php } ?>
        <?php } ?>

        
        <div class="row" <?php if (!$muestra) { ?> style=" visibility: hidden;"  <?php } ?>>
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label">Nombre</label>
            <div class="col-lg-6 <?php if ($form['descripcion']->hasError()) echo "has-error" ?>">
                <?php echo $form['descripcion'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['descripcion']->renderError() ?>  
                </span>
            </div>
        </div>
            <div class="row">    
                <div class="col-lg-12"><br></div>
            </div>
        
        
    
        
           <div class="row" <?php if (!$muestra) { ?> style=" visibility: hidden;"  <?php } ?>>
            <div class="col-lg-1"> </div>        
            <label class="col-lg-2 control-label">Cuenta Contable</label>
            <div class="col-lg-5 <?php if ($form['cuenta_contable']->hasError()) echo "has-error" ?>">
                <?php echo $form['cuenta_contable'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['cuenta_contable']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        
        
        
            <div class="row" <?php if (!$muestra) { ?> style=" visibility: hidden;"  <?php } ?>>    
            <div class="col-lg-1"></div>
            <div class="col-lg-1 ">Activo </div>
            <div class="col-lg-1 <?php if ($form['activo']->hasError()) echo "has-error" ?>">
                <?php echo $form['activo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['activo']->renderError() ?>  
                </span>
            </div>
                <div class="col-lg-1 ">Venta</div>
            <div class="col-lg-1 <?php if ($form['venta']->hasError()) echo "has-error" ?>">
                <?php echo $form['venta'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['venta']->renderError() ?>  
                </span>
            </div>
                
            <div class="col-lg-1 "> </div>
         
        </div>
  


    <div class="row">    
        <div class="col-lg-2"></div>
        <div class="col-lg-1 ">Imagen </div>

        <div class="col-lg-3 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
            <?php echo $form['archivo'] ?>           
            <span class="help-block form-error"> 
                <?php echo $form['archivo']->renderError() ?>  
            </span>
        </div>
    </div>

        
        
        
    <div class="row">    
        <div class="col-lg-8"></div>

        <div class="col-lg-2">
            <button class="btn btn-primary " type="submit">
                <i class="fa fa-save "></i>
                <span>Actualizar</span>
            </button>
        </div>
    </div>
    <?php echo '</form>'; ?>
    <br><br>        <br><br>
</div>
</div> 
<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
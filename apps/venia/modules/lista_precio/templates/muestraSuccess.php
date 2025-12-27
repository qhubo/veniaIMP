<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php if ($registro) { ?>  Editar  Vendedor <?php echo $registro->getCodigo(); ?> <?php } else { ?>
                   Nuevo  Vendedor
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

  
                 <div class="row"  style="padding-bottom:10px;">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Codigo </div>
         <div class="col-lg-2 <?php if ($form['codigo']->hasError()) echo "has-error" ?>">
                <?php echo $form['codigo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['codigo']->renderError() ?>  
                </span>
            </div>
        </div>
        
 
        <div class="row" style="padding-bottom:8px;">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Nombre </div>
         <div class="col-lg-4 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
                <?php echo $form['nombre'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombre']->renderError() ?>  
                </span>
            </div>
        </div>
        
            

        

            <div class="row"  style="padding-bottom:8px;">
                 <div class="col-lg-1"> </div>
            <label class="col-lg-1 control-label font-blue-steel right ">Activo</label>
            <div class="col-lg-1 <?php if ($form['activo']->hasError()) echo "has-error" ?>">
                <?php echo $form['activo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['activo']->renderError() ?>  
                </span>
            </div>
             <div class="col-lg-1"> </div>
            <div class="col-lg-2">
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                    <span> Aceptar  </span>
                </button>
            </div>
        </div>

    </div>
<!--    <div class="row"> 
        <FONT COLOR="RED">    <h5>*  PENDIENTE DEFINIR CUENTAS TRANSITORIAS CHEQUES BANCOS</h5> </FONT>
    </div>-->
</div>
<?php echo '</form>'; ?>



<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
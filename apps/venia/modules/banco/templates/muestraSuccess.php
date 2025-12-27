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
                <?php if ($registro) { ?>  Editar <?php echo $registro->getCodigo(); ?> <?php } else { ?>
                    Nuevo Banco
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
            <div class="col-lg-2">Entidad Banco </div>
         <div class="col-lg-5 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
                <?php echo $form['banco'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['banco']->renderError() ?>  
                </span>
            </div>
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
            <div class="col-lg-2">Típo </div>
         <div class="col-lg-5 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
        </div>
                    <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">No Cuenta Banco </div>
         <div class="col-lg-5 <?php if ($form['cuenta']->hasError()) echo "has-error" ?>">
                <?php echo $form['cuenta'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['cuenta']->renderError() ?>  
                </span>
            </div>
        </div>
        
                           <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Observaciones</div>
         <div class="col-lg-5 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div>
        </div>
        
                               <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Cuenta Contable</div>
         <div class="col-lg-5 <?php if ($form['cuenta_contable']->hasError()) echo "has-error" ?>">
                <?php echo $form['cuenta_contable'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['cuenta_contable']->renderError() ?>  
                </span>
            </div>
        </div>
        
    
        
        <div class="row">
            <div class="col-lg-3"> </div>
            
                      <label class="col-lg-1 control-label font-blue-steel right ">Dolares</label>
            <div class="col-lg-1 <?php if ($form['dolares']->hasError()) echo "has-error" ?>">
                <?php echo $form['dolares'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['dolares']->renderError() ?>  
                </span>
            </div>
                      
                      
                 <label class="col-lg-1 control-label font-blue-steel right ">Pago Cheque</label>
            <div class="col-lg-1 <?php if ($form['pago_cheque']->hasError()) echo "has-error" ?>">
                <?php echo $form['pago_cheque'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['pago_cheque']->renderError() ?>  
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
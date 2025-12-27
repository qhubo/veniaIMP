
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
                <?php if ($registro) { ?>  Editar Medio Pago <?php echo $registro->getCodigo(); ?> <?php } else { ?>
                    Nuevo  Medio Pago
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
            <div class="col-lg-2">Nombre </div>
         <div class="col-lg-5 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
             
             
   
                <?php echo $form['nombre'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombre']->renderError() ?>  
                </span>
            </div>
        </div>
        
             <div class="row">
                 <div class="col-lg-12"><br> </div>
             </div>
        
             <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Orden </div>
         <div class="col-lg-1 <?php if ($form['orden']->hasError()) echo "has-error" ?>">
                <?php echo $form['orden'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['orden']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1" style="text-align:right">Aplica Venta </div>
         <div class="col-lg-1 <?php if ($form['pos']->hasError()) echo "has-error" ?>">
                <?php echo $form['pos'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['pos']->renderError() ?>  
                </span>
            </div>
            
               <div class="col-lg-2" style="text-align:right">Aplica Movimiento Banco </div>
         <div class="col-lg-1 <?php if ($form['aplica_mov_banco']->hasError()) echo "has-error" ?>">
                <?php echo $form['aplica_mov_banco'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['aplica_mov_banco']->renderError() ?>  
                </span>
            </div>
        </div>
   
         <div class="row">
                 <div class="col-lg-12"><br> </div>
             </div>
        
      <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Banco</div>
         <div class="col-lg-3 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
                <?php echo $form['banco'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['banco']->renderError() ?>  
                </span>
             <font size="-1"> Concilia este  banco al momento de la venta  </font>
            </div>
            
                         <div class="col-lg-2 " style="text-align:right" >Solicita Banco al ingresar la  venta</div>
            <div class="col-lg-1 <?php if ($form['pide_banco']->hasError()) echo "has-error" ?>">
                <?php echo $form['pide_banco'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['pide_banco']->renderError() ?>  
                </span>
            </div>
        </div>
          <div class="row">
            <div class="col-lg-12"> <br> </div>
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
            <div class="col-lg-12"> <br> </div>
        </div>
        
           <div class="row">
                     <div class="col-lg-1"> </div>
                          <label class="col-lg-2 control-label font-blue-steel right ">Pago Proveedor</label>
            <div class="col-lg-1 <?php if ($form['pago_proveedor']->hasError()) echo "has-error" ?>">
                <?php echo $form['pago_proveedor'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['pago_proveedor']->renderError() ?>  
                </span>
            </div>
             
       
 
                     <label class="col-lg-1 control-label font-blue-steel right ">Aplica ISR</label>
            <div class="col-lg-1 <?php if ($form['retiene_isr']->hasError()) echo "has-error" ?>">
                <?php echo $form['retiene_isr'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['retiene_isr']->renderError() ?>  
                </span>
            </div>
                     <div class="col-lg-1"> </div>
             <div class="col-lg-1 " style="text-align:right" >Activo</div>
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
</div>
<?php echo '</form>'; ?>

<!--<div class="row">
           <div class="col-lg-7"> </div>  
           <div class="col-lg-3">          <select class='mi-selector' name='marcas'>
    <option value=''>Seleccionar una marca</option>
    <option value='audi'>Audi</option>
    <option value='bmw'>BMW</option>
    <option value='citroen'>Citroen</option>
    <option value='fiat'>Fiat</option>
    <option value='ford'>Ford</option>
    <option value='honda'>Honda</option>
    <option value='hyundai'>Hyundai</option>
    <option value='kia'>Kia</option>
    <option value='mazda'>Mazda</option>
</select> 
           
           </div>
</div>-->



<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
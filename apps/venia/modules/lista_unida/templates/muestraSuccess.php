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
                <?php if ($registro) { ?>  Editar <?php echo $registro->getId(); ?> <?php } else { ?>
                    Nuevo Lista Unida
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
            <div class="col-lg-2">Titulo </div>
         <div class="col-lg-5 <?php if ($form['titulo']->hasError()) echo "has-error" ?>">
                <?php echo $form['titulo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['titulo']->renderError() ?>  
                </span>
            </div>
        </div>
        

    
        
        <div class="row">
            <div class="col-lg-6"> </div>
            
      
                      
                      
   
            <div class="col-lg-2"></div>
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



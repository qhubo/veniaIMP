
<?php $modulo = $sf_params->get("module"); ?>
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list "></i>Cambio de clave        </div>
 <div class="actions">
            <a class="btn  btn-success" href="<?php echo url_for($modulo . '/index') ?>" ><i class="fa fa-hand-o-left"></i> Retornar </a>

        </div>
    </div>



    <div class="portlet-body form">
        <?php //include_partial("soporte/avisos"); ?>
          <?php echo $form->renderFormTag(url_for($modulo . "/cambioClave"), array("class" => "form vform form-horizontal",)); ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">
                         <div class="col-md-1"></div>
                         <div class="col-md-1">  <span class="caption-subject  sbold font-green uppercase">Usuario</span></div>
                         <div class="col-md-4"> <strong> <?php echo $usuariodescripcion->getUsuario() ?> </strong> </div>
        </div>
           <div class="row">
            <div class="col-md-5"><br></div>
        </div>
   
            <div class="row">
                <div class="col-md-1"> </div>        
                <label class="col-md-2 control-label right ">Nueva Clave </label>
                <div class="col-md-4 <?php if ($form['nueva']->hasError()) echo "has-error" ?>">
                    <?php echo $form['nueva'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['nueva']->renderError() ?>  
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1"> </div>        
                <label class="col-md-2 control-label right ">Verificacion </label>
                <div class="col-md-4 <?php if ($form['verifica']->hasError()) echo "has-error" ?>">
                    <?php echo $form['verifica'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['verifica']->renderError() ?>  
                    </span>
                </div>
            </div>
        
             <div class="row">
            <div class="col-md-5"></div>
             <div class="col-md-1">
                    <button class="btn btn-primary btn-icon-primary btn-icon-block btn-icon-blockleft" type="submit">
                         <i class="fa fa-check"></i>
                 <span> Confirmar</span>
                </button> 
             </div>
            
                            </div>
        <div class="row">
            <div class="col-md-5"><br></div>
        </div>
        </div>
          <?php echo "</FORM>"; ?>
      </div>

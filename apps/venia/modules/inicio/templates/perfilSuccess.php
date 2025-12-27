<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/perfil'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>



<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
Editar Perfil

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

            <a href="<?php echo url_for('inicio/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <div class="kt-portlet__body">


        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-5">

                <div class="panel-heading">
                    <font size="+2">   Usuario       <b> <?php echo $usuario->getUsuario(); ?> </b> </font>
                </div>

            </div>
        </div>

        <div class="row">
               <div class="col-lg-9">
               
                  <div class="row">
            <div class="col-lg-1"> </div>   
            <label class="col-lg-2 control-label font-blue-steel right ">Nombre Completo <font color="#E08283" size="-2">*</font>  </label>
            <div class="col-lg-4 <?php if ($form['primer_nombre']->hasError()) echo "has-error" ?>">
                <?php echo $form['primer_nombre'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['primer_nombre']->renderError() ?>  
                </span>
            </div>
        
        </div>


        <div class="row">
            <div class="col-lg-12"><br> </div>
        </div>

                    <div class="row">
            <div class="col-lg-1"> </div>

            <label class="col-lg-2 control-label font-blue-steel right ">Foto </label>
            <div class="col-lg-4 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
                <?php echo $form['archivo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['archivo']->renderError() ?>  
                </span>
            </div>
                    </div>
                   
                    <div class="row">
            <div class="col-lg-12"><br> </div>
        </div>

                   
        <div class="row">
            <div class="col-lg-1"> </div>

            <label class="col-lg-2 control-label font-blue-steel right ">Correo  </label>
            <div class="col-lg-4 <?php if ($form['correo']->hasError()) echo "has-error" ?>">
                <?php echo $form['correo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['correo']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-1"></div>


            <div class="col-lg-2" style="content-align:right">
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                    <span> Aceptar  </span>
                </button>
            </div>
        </div>
               </div> 
               <div class="col-lg-3">
                   
                          <?php if ($usuario->getImagen()) { ?>
                   <img  width="200px" xclass="kt-hidden-" alt="Pic" src="<?php echo "/uploads/milclient/" . $usuario->getImagen(); ?>" />
                <?Php } else { ?>
                   <img width="200px" xclass="kt-hidden-" alt="Pic" src="/images/avatar2.png" />
                <?Php } ?>

                   
               </div>
        </div>
        
     

    </div>
</div>
<?php echo '</form>'; ?>





<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<link href="./assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />

<link href="./assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php if ($registro) { ?>  Editar Formato cheque <?php // echo $registro->getCodigo(); ?> <?php } else { ?>
                    Nuevo Formato Cheque
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
            <div class="col-lg-3 <?php if ($form['titulo']->hasError()) echo "has-error" ?>">
                <?php echo $form['titulo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['titulo']->renderError() ?>  
                </span>
            </div>
     
            <div class="col-lg-1">Banco </div>
            <div class="col-lg-3 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
                <?php echo $form['banco'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['banco']->renderError() ?>  
                </span>
            </div>  

        </div>
        
        
        
        


       

           <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2"></div>
               <div class="col-lg-1">Ancho
               <?php echo $form['ancho'] ?>           
            </div>
                <div class="col-lg-1">Alto
               <?php echo $form['alto'] ?>           
            </div>
 <div class="col-lg-1"> </div>
            <div class="col-lg-2">Margen Superior
               <?php echo $form['margen_superior'] ?>           
            </div>
                <div class="col-lg-2">Margen Izquierda
               <?php echo $form['margen_izquierdo'] ?>           
            </div>
        </div>
           <div class="row">
              <div class="col-lg-12"><br> </div>
          </div>
                <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Tipo Negociable </div>
            <div class="col-lg-3 <?php if ($form['tipo_negociable']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo_negociable'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo_negociable']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-5"> 
                <font size="-1">

                <ul>
                    <li><strong>No Negociable</strong> Imprimira siempre No negociable</li>
                    <li><strong>Negociable</strong> Sin leyenda No negociable</li>
                    <li><strong>Ambas</strong> Aparece No negociable y se puede desactivar</li>
                </ul>
                </font>
            </div>
        </div>

       
        
        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-10 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
               <?php echo $form['observaciones'] ?>           
            </div>
            <div class="col-lg-1">
                <STRONG>Comodines</STRONG>
                %FECHA%
                %VALOR%
                %VALOR_LETRAS%
                %BENEFICIARIO%
                %NEGOCIABLE%
                %MOTIVO%
                %CORRELATIVO% 
                   %PARTIDA% 
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12"><br></div>
            
        </div>
        

        <div class="row">
            <div class="col-lg-1"> </div>
                        <div class="col-lg-2">Correlativo </div>
                        
                         <div class="col-lg-2 <?php if ($form['correlativo']->hasError()) echo "has-error" ?>">
                <?php echo $form['correlativo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['correlativo']->renderError() ?>  
                </span>
            </div> 
            <label class="col-lg-1 control-label font-blue-steel right ">Activo</label>
            <div class="col-lg-1 <?php if ($form['activo']->hasError()) echo "has-error" ?>">
                <?php echo $form['activo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['activo']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-2">
                <button class="btn btn-block btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                  Aceptar  
                </button>
            </div>
                  <div class="col-lg-1">
                 <a target="_blank" href="<?php echo url_for('formato_cheque/reporte?id='.$id) ?>" class="btn  btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
                  </div>
        </div>

    </div>
</div>
<?php echo '</form>'; ?>
   

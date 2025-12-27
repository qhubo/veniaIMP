<?php $modulo = $sf_params->get('module'); ?>
<?php if ($edit >0 ) { ?>
<?php echo $form->renderFormTag(url_for($modulo . '/partidaNueva?edit='.$edit), array('class' => 'form-horizontal"')) ?>
<?php } else  { ?>
<?php echo $form->renderFormTag(url_for($modulo . '/partidaNueva?id='.$id), array('class' => 'form-horizontal"')) ?>

<?php } ?>
<?php echo $form->renderHiddenFields() ?>
<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Modificación de Partida
                <small>&nbsp;&nbsp;&nbsp;completa la información solicitada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
       <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra?id='.$id) ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-body">
            <div class="row">
                <label class="col-lg-1 control-label right "> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fecha']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fecha'] ?>
                    <span class="help-block form-error">
                        <?php echo $form['fecha']->renderError() ?>
                    </span>
                </div>
                <div class="col-lg-2"></div>
                <label class="col-lg-1 control-label right "> Numero </label>
                <div class="col-lg-1 <?php if ($form['numero']->hasError()) echo "has-error" ?>">
                    <?php echo $form['numero'] ?>
                    <span class="help-block form-error">
                        <?php echo $form['numero']->renderError() ?>
                    </span>
                </div>
            </div>
            <div class="row">
                <label class="col-lg-1 control-label right "> Detalle </label>
                <div class="col-lg-6 <?php if ($form['detalle']->hasError()) echo "has-error" ?>">
                    <?php echo $form['detalle'] ?>
                    <span class="help-block form-error">
                        <?php echo $form['detalle']->renderError() ?>
                    </span>
                </div>
            </div>
            
                  <div class="row">
                <label class="col-lg-1 control-label right "> Valor </label>
                <div class="col-lg-6 "><font size="+2"><?php echo Parametro::formato(abs($debito->getValor())); ?> </font>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><br></div>
            </div>
            <div class="row">
                <div class="col-lg-8">
               <?php include_partial($modulo . '/tabla', array('edit'=>$edit, 'valor1'=>$valor1,'valor2'=>$valor2, 'borra'=>$borra,'partida'=>$partida,'modulo'=>$modulo,'detalle'=>$detalle,'form'=>$form)) ?>    
                </div>
                <div class="col-lg-4">
                  <?php include_partial($modulo . '/confirma', array('partida'=>$partida,'modulo'=>$modulo)) ?>     
                </div>
            </div>


        </div>

    </div>
</div>

<?php echo "</form>"; ?>

 <?php include_partial($modulo . '/script', array('edit'=>$edit, 'partida'=>$partida,'modulo'=>$modulo)) ?>   
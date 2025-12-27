<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-warning-sign kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Anular Operación <?php echo $operacion->getCodigoFactura(); ?>
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
    </div>
    <?php $modulo = $sf_params->get('module'); ?>
    <?php echo $form->renderFormTag(url_for($modulo . '/anula?id=' . $id), array('class' => 'form-horizontal"')) ?>
    <?php echo $form->renderHiddenFields() ?>
  <div class="kt-portlet__body">

        <div class="row">
            <div class="col-lg-1"></div>
            <label class="col-lg-2 control-label font-blue-steel right ">Motivo</label>
            <div class="col-lg-6 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <br>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <button class="btn btn-info   " type="submit">
                    <i class="fa fa-check "></i>
                    Confirmar
                </button>
            </div>
            <div class="col-lg-2">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
            </div>
        </div>
    </div>
</div>
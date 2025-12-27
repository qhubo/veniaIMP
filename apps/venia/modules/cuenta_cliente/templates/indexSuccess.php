<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for('reporte_venta/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-clipboard kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success"> Estado Cuenta Cliente
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y cliente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar"></div>
    </div>
    <div class="kt-portlet__body">

        <div class="form-body">      
            <div class="row">              
                <label class="col-lg-1 control-label right " style="text-align:right"> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right " style="text-align:right">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>

                <div class="col-lg-2">
                    <?php echo $form['cliente'] ?> 
                </div>

                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
<?php echo '</form>'; ?>


<div class="row">

    <div class="col-lg-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">



                </div>
            </div>
        </div>
    </div>
</div>





<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
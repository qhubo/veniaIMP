<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                NUEVA NOTA  DE CRÉDITO FACTURA <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Completa la Información solicitada </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-1" style="font-weight:bold;"> Referencia</div>
            <div class="col-lg-2" style="padding-bottom:5px;"> <input class="form-control" readonly="" disabled="" value="<?php echo $operacion->getCodigo(); ?>" > </div>
            <div class="col-lg-1" style="font-weight:bold;"> Fecha</div>
            <div class="col-lg-2" style="padding-bottom:5px;"> <input class="form-control" readonly="" disabled="" value="<?php echo $operacion->getFecha('d/m/Y'); ?>" > </div>

        </div>

        <div class="row">
            <div class="col-lg-1" style="font-weight:bold;"> Factura</div>
            <div class="col-lg-4" style="padding-bottom:5px;"> <input class="form-control" readonly="" disabled="" value="<?php echo $operacion->getFaceSerieFactura(); ?>   <?php echo $operacion->getFaceNumeroFactura(); ?>" > </div>
        </div>
        <div class="row">
            <div class="col-lg-1" style="font-weight:bold;"> Nombre</div>
            <div class="col-lg-4" style="padding-bottom:5px;"> <input class="form-control" readonly="" disabled="" value="<?php echo $operacion->getNombre(); ?>   <?php echo $operacion->getFaceNumeroFactura(); ?>" > </div>

            <div class="col-lg-1" style="font-weight:bold;"> Valor <input type="hidden" value="<?php echo $operacion->getValorTotal(); ?>" id="tota" name="tota"> </div>
            <div class="col-lg-2" style="font-size:18px; font-weight: bold; padding-bottom:5px; "> <?php echo Parametro::formato($operacion->getValorTotal()); ?> </div>
        </div>

        <?php echo $form->renderFormTag(url_for($modulo . '/nueva?id=' . $operacion->getId()), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>

           <div class="row" style="padding-top:5px;">
            <div class="col-lg-2 control-label right ">Observaciones </div>
            <div class="col-lg-5 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div>
           </div>
          <div class="row" style="padding-top:5px; padding-bottom:5px;">
            <div class="col-lg-2 control-label right ">Valor Nota </div>
            <div class="col-lg-2 <?php if ($form['valor']->hasError()) echo "has-error" ?>">
                <?php echo $form['valor'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['valor']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-2">
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                  Crear Nota
                </button>
            </div>
        </div>
        <?php echo '</form>'; ?>

        <?php include_partial($modulo . '/detalle', array('operacion' => $operacion, 'detalle' => $detalle, 'pagos' => $pagos)) ?>  
    </div>
</div>


<script>
    $(document).ready(function() {
  $('#consulta_valor').on('change', function() {
    var maximo = parseFloat($('#tota').val());
    var valor = parseFloat($(this).val());

    if (valor > maximo) {

      $(this).val(maximo); // Limpia el campo
      $(this).focus();
    }
  });
});
    </script>

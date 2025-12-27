<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                NUEVA NOTA  DE CRÉDITO PROVEEDOR <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Completa la Información solicitada </small>
            </h3>

        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    
    
    <?php echo $form->renderFormTag(url_for($modulo.'/nueva?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
     <div class="kt-portlet__body">
      <div class="row">
            <div class="col-lg-1"> </div>
        </div>
  
          <div class="row prov"  id="prov"  >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Proveedor </div>
            <div class="col-lg-5 <?php if ($form['proveedor_id']->hasError()) echo "has-error" ?>">
                <?php echo $form['proveedor_id'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['proveedor_id']->renderError() ?>  
                </span>
            </div>
        </div>
        
          <div class="row prov"  id="prov"  >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Tipo Documento </div>
            <div class="col-lg-5 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
        </div>
        
    

        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Documento </div>
            <div class="col-lg-2 <?php if ($form['referencia_factura']->hasError()) echo "has-error" ?>">
                <?php echo $form['referencia_factura'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['referencia_factura']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1">Valor Total </div>
            <div class="col-lg-2 <?php if ($form['valor']->hasError()) echo "has-error" ?>">
                <?php echo $form['valor'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['valor']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Concepto</div>
            <div class="col-lg-5 <?php if ($form['concepto']->hasError()) echo "has-error" ?>">
                <?php echo $form['concepto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['concepto']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1"> </div>
            <label class="col-lg-2 control-label font-blue-steel right "> Aplica Iva</label>
            <div class="col-lg-1 <?php if ($form['aplica_iva']->hasError()) echo "has-error" ?>">
               <?php echo $form['aplica_iva'] ?>
                <span class="help-block form-error"> 
                    <?php echo $form['aplica_iva']->renderError() ?>  
                </span>
            </div>

        </div>

<!--                <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Archivo</div>
            <div class="col-lg-5 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
                <?php echo $form['archivo'] ?>       
                <span class="help-block form-error"> 
                    <?php echo $form['archivo']->renderError() ?>  
                </span>
            </div>
        </div>-->
        
        <div class="row">
            <div class="col-lg-7"> </div>
            <div class="col-lg-2">
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                    <span> Aceptar  </span>
                </button>
            </div>


        </div>


    <?php echo '</form>'; ?>
     </div>
</div>



    <script>
        jQuery(document).ready(function ($) {
            $(document).ready(function () {
                $('.mi-selector').select2();
            });
        });
    </script>


    <script>
        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);

            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }
    </script>
    
    
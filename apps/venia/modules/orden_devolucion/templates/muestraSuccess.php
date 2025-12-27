<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $tip = sfContext::getInstance()->getUser()->getAttribute('tipodevolu', null, 'seguridad'); ?>
<?php if (trim($tip) == "") { ?>
    <?php $tip = "Cliente"; ?>
<?php } ?>
<?php
$tipoUsua = sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad');
$obligatorio = true; ?>


<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-fast-back kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Crear  Devolución
                <small>  &nbsp;&nbsp;&nbsp;&nbsp; Completa la información solicitada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
<?php if ($sol > 0) { ?>
                <a href="<?php echo url_for('solicitud_devolucion/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
            <?php } else { ?>
                <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
            <?php } ?>            
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-1"> </div>
        </div>
        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Tipo </div>
            <div class="col-lg-5 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
<?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row prov"  id="prov" <?php if ($tip != "Proveedor") { ?> style="display:none;" <?Php } ?> >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Proveedor </div>
            <div class="col-lg-5 <?php if ($form['proveedor_id']->hasError()) echo "has-error" ?>">
<?php echo $form['proveedor_id'] ?>           
                <span class="help-block form-error"> 
                <?php echo $form['proveedor_id']->renderError() ?>  
                </span>
            </div>
        </div>


        <div class="row  clie" id="clie"  <?php if ($tip == "Proveedor") { ?> style="display:none;" <?Php } ?> >
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
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Referencia Factura </div>
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
            <div class="col-lg-2"> Medio Pago</div>
            <div class="col-lg-2 <?php if ($form['medio']->hasError()) echo "has-error" ?>">
<?php echo $form['medio'] ?>           
                <span class="help-block form-error"> 
                <?php echo $form['medio']->renderError() ?>  
                </span>
            </div>
<?php if ($obligatorio) { ?>
<!--                <div class="col-lg-1"> Vendedor</div>
                <div class="col-lg-2 <?php if ($form['vendedor']->hasError()) echo "has-error" ?>">
    <?php echo $form['vendedor'] ?>           
                    <span class="help-block form-error"> 
                    <?php echo $form['vendedor']->renderError() ?>  
                    </span>
                </div>-->
<?php } ?>
        </div>

        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Motivo</div>
            <div class="col-lg-5 <?php if ($form['concepto']->hasError()) echo "has-error" ?>">
<?php echo $form['concepto'] ?>           
                <span class="help-block form-error"> 
                <?php echo $form['concepto']->renderError() ?>  
                </span>
            </div>
        </div>




        <div class="row">
            <div class="col-lg-1"> </div>

            <label class="col-lg-2 control-label font-blue-steel right "> Retención</label>
            <div class="col-lg-1 <?php if ($form['porcentaje_retenie']->hasError()) echo "has-error" ?>">
    <div style="width: 100%">
                        <div style="float: left; width: 80%" class="">
                     <?php echo $form['porcentaje_retenie'] ?>
                        </div>
                        <div style="float: left; font-weight: bold; width: 20%; padding-left: 3px; padding-top: 10px">%</div>
                    </div>
                <span class="help-block form-error"> 
                <?php echo $form['porcentaje_retenie']->renderError() ?>  
                </span>
                
                
            
            </div>
           
            
            <?php if ($obligatorio) { ?>
            <div class="col-lg-2" style="align:right; text-align: right"> Fecha Factura</div>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
<?php } ?>
        </div>
            
  

        <div class="row" style="padding-top:8px;">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Archivo</div>
            <div class="col-lg-5 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
<?php echo $form['archivo'] ?>       
                <span class="help-block form-error"> 
                <?php echo $form['archivo']->renderError() ?>  
                </span>
            </div>
        </div>
<?php if ($obligatorio) { ?>
            <div class="row" style="padding-top:10px; padding-bottom: 8px;">
                <div class="col-lg-1"> </div>
                <div class="col-lg-2">Archivo</div>
                <div class="col-lg-5 <?php if ($form['archivo2']->hasError()) echo "has-error" ?>">
    <?php echo $form['archivo2'] ?>       
                    <span class="help-block form-error"> 
                    <?php echo $form['archivo2']->renderError() ?>  
                    </span>
                </div>
            </div>
<?php } ?>

  
            <div class="row">
                <div class="col-lg-1"> </div>
                <div class="col-lg-2"> Producto</div>
                <div class="col-lg-4 <?php if ($form['no_hollander']->hasError()) echo "has-error" ?>">
                    <?php echo $form['no_hollander'] ?>   
                      
                    <span class="help-block form-error"> 
                    <?php echo $form['no_hollander']->renderError() ?>  
                    </span>
                </div>

<!--                <div class="col-lg-1"> Stock</div>
                <div class="col-lg-2 <?php if ($form['no_stock']->hasError()) echo "has-error" ?>">
    <?php echo $form['no_stock'] ?>           
                    <span class="help-block form-error"> 
                    <?php echo $form['no_stock']->renderError() ?>  
                    </span>
                </div>-->
            </div>

<!--            <div class="row">
                <div class="col-lg-1"> </div>
                <div class="col-lg-2">Referencia Nota </div>
                <div class="col-lg-2 <?php if ($form['referencia_nota']->hasError()) echo "has-error" ?>">
    <?php echo $form['referencia_nota'] ?>           
                    <span class="help-block form-error"> 
                    <?php echo $form['referencia_nota']->renderError() ?>  
                    </span>
                </div>
            </div>-->



        <div class="row">
            
               <div class="col-lg-1"> </div>
                <div class="col-lg-2"> Cantidad</div>
                <div class="col-lg-2 <?php if ($form['cantidad']->hasError()) echo "has-error" ?>">
                    <?php echo $form['cantidad'] ?>   
                      
                    <span class="help-block form-error"> 
                    <?php echo $form['cantidad']->renderError() ?>  
                    </span>
                </div>
            
            <div class="col-lg-2"> </div>
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


<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_tipo").on('change', function () {
            var val = $("#consulta_tipo").val();

            $.get('<?php echo url_for("orden_devolucion/tipo") ?>', {val: val}, function (response) {
            });

            if (val == 'Proveedor') {
                $('#prov').slideToggle(250);
                $('#clie').hide();
            } else {
                $('#clie').slideToggle(250);
                $('#prov').hide();
            }
        });

    });
</script>


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


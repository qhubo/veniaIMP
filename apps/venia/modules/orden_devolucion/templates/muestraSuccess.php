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
$obligatorio = true;
?>

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
              <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
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
                <span class="help-block form-error"> <?php echo $form['tipo']->renderError() ?></span>
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

        <div class="row cli" id="cli"  <?php if ($tip == "Proveedor") { ?> style="display:none;" <?Php } ?>  >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Cliente </div>
            <div class="col-lg-5 <?php if ($form['cliente_id']->hasError()) echo "has-error" ?>">
                    <?php echo $form['cliente_id'] ?>           
                <span class="help-block form-error"> 
<?php echo $form['cliente_id']->renderError() ?>  
                </span>
            </div>
        </div>


                 <div class="row" style="padding-top: 3px;" >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Nombre </div>
            <div class="col-lg-5 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
                    <?php echo $form['nombre'] ?>           
                <span class="help-block form-error"> 
<?php echo $form['nombre']->renderError() ?>  
                </span>
            </div>
        </div>
                 <div class="row" style="padding-top: 3px;" >
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

            <div class="row" style="padding-top: 3px;" >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2"> Medio Pago</div>
            <div class="col-lg-2 <?php if ($form['medio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['medio'] ?>           
                <span class="help-block form-error"> 
<?php echo $form['medio']->renderError() ?>  
                </span>
            </div>

        </div>

                <div class="row" style="padding-top: 3px;" >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">Motivo</div>
            <div class="col-lg-5 <?php if ($form['concepto']->hasError()) echo "has-error" ?>">
                    <?php echo $form['concepto'] ?>           
                <span class="help-block form-error"> 
<?php echo $form['concepto']->renderError() ?>  
                </span>
            </div>
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


            <div class="row" style="padding-top: 3px;" >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2"> Producto</div>
            <div class="col-lg-4 <?php if ($form['no_hollander']->hasError()) echo "has-error" ?>">
<?php echo $form['no_hollander'] ?>   

                <span class="help-block form-error"> 
<?php echo $form['no_hollander']->renderError() ?>  
                </span>
            </div>
        </div>
            <div class="row" style="padding-top: 3px;" >
                <div class="col-lg-1"> </div>
                <div class="col-lg-2"> Cantidad</div>
                <div class="col-lg-1 <?php if ($form['cantidad']->hasError()) echo "has-error" ?>">
<?php echo $form['cantidad'] ?>   
                    <span class="help-block form-error">
<?php echo $form['cantidad']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-3" style="padding-top:10px;">
                        
                        
                        <label style="font-size:16px; font-weight:bold; cursor:pointer;">
    <input type="checkbox" name="consulta[retorna_inventario]" id="consulta_retorna_inventario"
           style="width:20px; height:20px; transform: scale(1.3); margin-right:8px;">
    Retorna al Inventario
</label>
                        
                        </div>
        



            </div>
        
        
            <div class="row" style="padding-top: 3px;" >
            <div class="col-lg-1"> </div>
            <div class="col-lg-2"> Tienda Ingresa</div>
            <div class="col-lg-4 <?php if ($form['tienda_id']->hasError()) echo "has-error" ?>">
               <?php echo $form['tienda_id'] ?>   

      <span class="help-block form-error"> <?php echo $form['tienda_id']->renderError() ?>   </span>
            </div>
                        
        </div>

          <div class="row">
              <div class="col-lg-7"></div>
           <div class="col-lg-3">
                    <button class="btn btn-primary btn-sm " type="submit">
                        <i class="fa fa-save "></i>    Aceptar 
                    </button>
                </div>
              </div>
        
        </div>

</div>

<?php echo '</form>'; ?>


    <script>
$(document).ready(function () {

    // =========================
    // INICIALIZAR SELECT2
    // =========================
    $('.mi-selector').select2();

    // =========================
    // REFERENCIAS
    // =========================
    const $tipo = $("#consulta_tipo");
    const $cliente = $('#consulta_cliente_id');
    const $proveedor = $('#consulta_proveedor_id');
    const $nombre = $('#consulta_nombre');

    const $check = $('#consulta_retorna_inventario');
    const $tienda = $('#consulta_tienda_id');
    const $rowTienda = $tienda.closest('.row');

    const $btn = $('button[type="submit"]');

    // =========================
    // CAMBIO TIPO (Cliente/Proveedor)
    // =========================
    function toggleTipo() {
        var val = $tipo.val();

        if (val == 'Proveedor') {
            $('#prov').show();
            $('#cli').hide();

            $cliente.val(null).trigger('change');

        } else {
            $('#cli').show();
            $('#prov').hide();

            $proveedor.val(null).trigger('change');
        }

        $nombre.val('');
    }

    // =========================
    // CONTROL BOTÓN
    // =========================
    function validarBoton() {

        if ($check.is(':checked')) {

            // requiere tienda
            if (!$tienda.val()) {
                $btn.prop('disabled', true).css('opacity', '0.6');
            } else {
                $btn.prop('disabled', false).css('opacity', '1');
            }

        } else {
            $btn.prop('disabled', false).css('opacity', '1');
        }
    }

    // =========================
    // MOSTRAR / OCULTAR TIENDA
    // =========================
    function toggleInventario() {

        if ($check.is(':checked')) {
            $rowTienda.show();
        } else {
            $rowTienda.hide();
            $tienda.val('');
        }

        validarBoton();
    }

    // =========================
    // EVENTOS
    // =========================

    // Tipo
    $tipo.on('change', function () {
        toggleTipo();
    });

    // Cliente
    $cliente.on('select2:select', function (e) {

        var data = e.params.data;

        $proveedor.val(null).trigger('change');
        $nombre.val(data.text);
    });

    // Proveedor
    $proveedor.on('select2:select', function (e) {

        var data = e.params.data;

        $cliente.val(null).trigger('change');
        $nombre.val(data.text);
    });

    // Checkbox inventario
    $check.on('change', function () {
        toggleInventario();
    });

    // Cambio tienda
    $tienda.on('change', function () {
        validarBoton();
    });

    // =========================
    // INICIO
    // =========================
    toggleTipo();
    toggleInventario();

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


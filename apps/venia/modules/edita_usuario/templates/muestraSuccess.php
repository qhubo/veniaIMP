<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-user-1"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php if ($usuario) { ?>
                <?php echo $usuario->getUsuario() ?> <small> Editar Usuario &nbsp;&nbsp;&nbsp;&nbsp;</small>
                <?php } else {  ?>
                CREAR NUEVO USUARIO
                <?php } ?>
                
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
               <a href="<?php echo url_for($modulo.'/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
       <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-1"> </div>
        </div>
        <?php include_partial('edita_usuario/cliente', array( 'id'=>$id, 'usuario' => $usuario, 'form' => $form)) ?>
        <div class="row">
            <div class="col-lg-7"> </div>
             <label class="col-lg-1 control-label font-blue-steel right ">Activo</label>
             <div class="col-lg-2">
                 <?php echo $form['activo']; ?>
             </div>
  
            <div class="col-lg-2">
                <button class="btn-block btn-success btn " type="submit">
                    <i class="fa fa-save "></i>
                    Grabar
                </button>
            </div>
        </div>

    </div>
</div>
<?php echo '</form>'; ?>





<script>
    $(document).ready(function () {
        $("#consulta_empresa").on('change', function () {
            //    alert('cambio');
            $("#consulta_bodega").empty();
            $.getJSON('<?php echo url_for("soporte/empresaTienda") ?>?id=' + $("#consulta_empresa").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#consulta_bodega").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
        });
    });
</script>
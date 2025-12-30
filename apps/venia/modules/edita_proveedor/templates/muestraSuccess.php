<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $registro=$proveedor; ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php if ($registro) { ?>  Editar <?php echo $registro->getCodigo(); ?> <?php } else { ?>
                    Nuevo Proveedor
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

                <?php include_partial('edita_proveedor/crea', array('id' => $id, 'modulo' => $modulo, 'proveedor' => $proveedor, 'form' => $form)) ?>
                <?php //include_partial('edita_proveedor/detalle', array('texto'=>$texto, 'id' => $id, 'modulo' => $modulo, 'proveedor' => $proveedor, 'form' => $form)) ?>

        <div class="row" style="padding-top:15px;">

                <div class="col-lg-7"></div>
                <div class="col-lg-3">
                    <button class="btn btn-primary " type="submit">
                        <i class="fa fa-save"></i>
                        Guardar
                    </button>
                </div>
            </div>
            <?php echo '</form>' ?>
        </div>
    </div>



<script>
    $(document).ready(function () {
        $("#consulta_departamento").on('change', function () {
            $("#consulta_municipio").empty();
            $.getJSON('<?php echo url_for("soporte/dptoMunicipio") ?>?id=' + $("#consulta_departamento").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#consulta_municipio").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
        });
    });
</script>


<script>
$(document).ready(function () {

    $("#consulta_departamento").on("change", function () {

        let $municipio = $("#consulta_municipio");
        $municipio.empty().prop("disabled", true);

        $.getJSON(
            '<?php echo url_for("soporte/dptoMunicipio") ?>?id=' + $(this).val(),
            function (data) {

                $.each(data, function (k, v) {

                    if (k === "") {
                        // opción [Seleccione Municipio]
                        $municipio.append(
                            '<option value="" selected disabled>' + v + '</option>'
                        );
                    } else {
                        $municipio.append(
                            '<option value="' + k + '">' + v + '</option>'
                        );
                    }
                });

                // activar select luego de cargar
                $municipio.prop("disabled", false);
            }
        );
    });

});
</script>


<script>
$(document).ready(function () {

    $("#consulta_pais").on("change", function () {

        let $municipio = $("#consulta_departamento");
        $municipio.empty().prop("disabled", true);

        $.getJSON(
            '<?php echo url_for("soporte/dptoPais") ?>?id=' + $(this).val(),
            function (data) {

                $.each(data, function (k, v) {

                    if (k === "") {
                        // opción [Seleccione Municipio]
                        $municipio.append(
                            '<option value="" selected disabled>' + v + '</option>'
                        );
                    } else {
                        $municipio.append(
                            '<option value="' + k + '">' + v + '</option>'
                        );
                    }
                });

                // activar select después de cargar
                $municipio.prop("disabled", false);
            }
        );
    });

});
</script>



<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>

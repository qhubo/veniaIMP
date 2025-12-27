<?php $modulo = $sf_params->get('module'); ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
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
                <?php if ($registro) { ?>  Editar Tienda <?php echo $registro->getCodigo(); ?> <?php } else { ?>
                    Nueva Tienda
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

                <?php include_partial('edita_tienda/crea', array('id' => $id, 'modulo' => $modulo, 'proveedor' => $proveedor, 'form' => $form)) ?>
                <?php //include_partial('edita_proveedor/detalle', array('texto'=>$texto, 'id' => $id, 'modulo' => $modulo, 'proveedor' => $proveedor, 'form' => $form)) ?>

        
<div class="row" style="background-color: whitesmoke">
       <div class="col-lg-2  ">Nit</div>
    <div class="col-lg-4">
        <?php echo $form['nit'] ?>   
     </div>
    <div class="col-lg-1  ">Fel  usuario</div>
    <div class="col-lg-4">
        <?php echo $form['feel_usuario'] ?>           
      </div>
  
   
</div>

<div class="row">
    <div class="col-lg-2  ">Fel  Token</div>
    <div class="col-lg-4">
        <?php echo $form['feel_token'] ?>           
      </div>
    <div class="col-lg-1  ">Fel Llave</div>
    <div class="col-lg-4">
        <?php echo $form['feel_llave'] ?>   
     </div>   
</div>

        
            <div class="row">

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

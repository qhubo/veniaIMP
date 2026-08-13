<?php $modulo = $sf_params->get('module'); ?>

<script src="/assets/global/plugins/jquery.min.js"></script>
<script src="/assets/global/plugins/select2.min.js"></script>

<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="kt-portlet kt-portlet--responsive-mobile">

    <div class="kt-portlet__head">

        <div class="kt-portlet__head-label">

            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>

            <h3 class="kt-portlet__head-title kt-font-info">

                Productos por Marca de Vehículo

                <small>
                    &nbsp;&nbsp;
                    Consulta de productos compatibles
                </small>

            </h3>

        </div>

    </div>


    <div class="kt-portlet__body">

        <div class="row">

            <div class="col-lg-1"></div>

            <label class="col-lg-2 control-label">
                Marca Vehículo
            </label>

            <div class="col-lg-5">

                <?php echo $form['marcaVehiculo']; ?>

                <?php echo $form['marcaVehiculo']->renderError(); ?>

            </div>

            <div class="col-lg-2">

                <button
                    class="btn green btn-outline"
                    type="submit">

                    <i class="fa fa-search"></i>

                    Buscar

                </button>

            </div>
            <div class="col-lg-2">

    <a
       class="btn btn-block  btn-sm  " style="background-color:#04AA6D; color:white"
        target="_blank"
        href="<?php echo url_for($modulo . '/reporte') ?>">

        <i class="fa fa-file-excel-o"></i>
        Exportar Excel

    </a>

</div>

        </div>


        <div class="row" style="padding-top:10px;">

            <div class="col-lg-1"></div>

            <label class="col-lg-2 control-label">
                Producto
            </label>

            <div class="col-lg-5">

                <?php echo $form['producto']; ?>

                <?php echo $form['producto']->renderError(); ?>

            </div>

        </div>

    </div>

</div>

<?php echo '</form>'; ?>


<div class="kt-portlet">

    <div class="kt-portlet__head">

        <div class="kt-portlet__head-label">

            <h3 class="kt-portlet__head-title">

                Resultado

                <small>
                    &nbsp;&nbsp;
                    <?php echo number_format($total); ?> productos
                </small>

            </h3>

        </div>

    </div>


    <div class="kt-portlet__body">

        <?php include_partial(
                $modulo . '/listado',
                array(
                    'productos' => $productos,
                    'marcasVehiculo' => $marcasVehiculo
                )
        ); ?>

    </div>

</div>


<script>

$(document).ready(function () {

    $('.mi-selector').select2({
        width: '100%',
        allowClear: true
    });

});

</script>
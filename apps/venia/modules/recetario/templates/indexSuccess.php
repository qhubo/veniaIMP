<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Manejo de recetario
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-warning btn-lg btn-block" href="<?php echo url_for('recetario/nueva') ?>">Nueva Receta</a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-success btn-lg btn-block" href="<?php echo url_for('recetario/lista') ?>">Lista de Recetas</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
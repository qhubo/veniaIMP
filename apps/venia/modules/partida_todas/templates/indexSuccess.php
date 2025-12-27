<?php $modulo = $sf_params->get('module'); ?>
<?php $tab = 1; ?>
<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Ingreso de partidas
                <small>&nbsp;&nbsp;&nbsp;completa la información solicitada &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-secondary btn-hover-brand" > <i class="flaticon-download-1"></i> Archivo Modelo Carga  </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">

            
            <?php include_partial($modulo . '/confirma', array( 'modulo' => $modulo)) ?>     



        </div>



    </div>
</div>

<?php echo "</form>"; ?>

<?php include_partial($modulo . '/script', array(  'modulo' => $modulo)) ?>   


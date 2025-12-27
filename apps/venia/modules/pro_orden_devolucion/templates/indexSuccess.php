<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-refresh-button kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                LISTADO DE DEVOLUCIONES PENDIENTES CONFIRMAR<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procesa la devolución seleccionada  (Confirmar / Rechazar)
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>

        <?php include_partial($modulo . '/listado', array('modulo' => $modulo, 'registros' => $registros)) ?>
    </div>
</div>








<?php if ($partidaPen) { ?>
    <?php $devo = OrdenDevolucionQuery::create()->findOneByPartidaNo($partidaPen->getId()); ?>
    <?php $Modfica = false; ?>
    <?php if ($devo) { ?>
        <?php if ($devo->getProveedorId()) { ?>
            <?php $Modfica = true; ?>

        <?php } ?>
    <?php } ?>
    <?php $Modfica = true; ?>

    <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($Modfica) { ?>       


                        <?php include_partial('proceso/partidaModifica', array('partidaPen' => $partidaPen)) ?>
                    <?php } else { ?>
                        <?php include_partial('proceso/partidaCambia', array('partidaPen' => $partidaPen)) ?>  

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <?php foreach ($partidaPen->getListDetalle() as $cta) { ?>
        <script>
            $(document).ready(function () {
                $("#cuenta<?php echo $cta; ?>").select2({
                    dropdownParent: $("#ajaxmodalPartida")
                });
            });
        </script>
    <?php } ?>
    <script>
        $(document).ready(function () {
            $("#ajaxmodalPartida").modal();
        });
    </script>
<?php } ?>



<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-signs  kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Caja
                <small>  &nbsp;&nbsp;&nbsp;&nbsp; Procede a ingresar el pago</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-6" >
                <div class="row" style="padding-top:3PX; padding-bottom:3PX; ;">
                    <div class="col-lg-2"><strong> <font size="+1">Código</font></strong></div>
                    <div class="col-lg-4"><font size="+1"><?php echo $operacion->getCodigo(); ?></font></div>
                    <div class="col-lg-2"><strong><font size="+1">Nit</font></strong></div>
                    <div class="col-lg-4"><font size="+1"><?php echo $operacion->getNit(); ?></font></div>
                </div>

                <div class="row">
                    <div class="col-lg-2"><br></div>
                </div>

                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link    " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active " data-toggle="tab" href="#kt_portlet_base_demo_3_4_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Pagos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link   " data-toggle="tab" href="#kt_portlet_base_demo_3_5_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Contable
                        </a>
                    </li>
                </ul>

                <div class="tab-content"    >
                    <div class="tab-pane    " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">

                        <?php include_partial('reporte_venta/detalle', array('operacion' => $operacion, 'detalle' => $detalle, 'pagos' => $pagos)) ?>  

                    </div>
                    <div class="tab-pane     active" id="kt_portlet_base_demo_3_4_tab_content" role="tabpanel">
                        <?php include_partial('cuenta_por_cobrar/detallePago', array('prefechado' => $prefechado, 'operacion' => $operacion, 'detalle' => $detalle, 'pagos' => $pagos)) ?>  

                    </div>
                    <div class="tab-pane  " id="kt_portlet_base_demo_3_5_tab_content" role="tabpanel">

                        <div class="row">
                            <div class="col-lg-6"><br><br><br><br></div> 
                        </div>
                        <?php $partidas[] = 0; ?>
                        <?Php foreach ($pagos as $pago) { ?>
                            <?php if ($pago->getPartidaNo()) { ?>
                                <div class="row">
                                    <?php include_partial('proceso/partida', array('id' => $pago->getPartidaNo())) ?>  
                                </div>
                                <?php $partidas[] = $pago->getPartidaNo(); ?>
                            <?php } ?>
                        <?php } ?>

                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="row" style="padding-top:3PX;  padding-bottom:3PX;  ">
                    <div class="col-lg-2"><strong> <font size="+1">Cliente</font></strong></div>
                    <div class="col-lg-6"><font size="+1"><?php echo $operacion->getCliente()->getNombre(); ?></font></div>
                </div>
                <?php include_partial($modulo . '/pago', array('prefechado' => $prefechado, 'operacion' => $operacion, 'form' => $form)) ?>  
            </div>

        </div>

    </div>

</div>



<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<?php $partidaPen = PartidaQuery::create()->filterById($partidas, Criteria::IN)->filterByConfirmada(false)->orderById('Asc')->findOne(); ?>
<?php if ($partidaQ) { ?>
    <?php $partidaPen = $partidaQ; ?>
<?php } ?>
<?php if ($partidaPen) { ?>
    <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include_partial('proceso/partidaCambia', array('partidaPen' => $partidaPen)) ?>  
                </div>
            </div>
        </div>
    </div>

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







<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_tipo_pago").on('change', function () {
              $("#consulta_valor").val(0).prop("readonly", false);
            var val = $("#consulta_tipo_pago").val();
            $('#consulta_no_documento').val('');
            val = val.replace(/\s+/g, '').toUpperCase();
            $('#consulta_comision').show();
            $('#labelcomi').show();
            if (val == "CHEQUEPREFECHADO") {
                $('#labelcomi').hide();
                $('#consulta_comision').hide();
            }

        });
    });
</script>
<script type="text/javascript">
$(document).ready(function () {

    function verificarTipoPago() {
        var tipopago = $("#consulta_tipo_pago").val();
        tipopago = tipopago.replace(/\s+/g, '').toUpperCase();

        if (tipopago === "NOTACREDITO") {
            var documento = $("#consulta_no_documento").val().trim();
            var id = <?php echo $operacion->getId(); ?>;

            // Bloquear el campo antes de la consulta
            $("#consulta_valor").prop("readonly", true).val("");

            // Llamada AJAX para obtener el valor
            $.get('<?php echo url_for("cuenta_por_cobrar/nota") ?>', { id: id, documento: documento }, function (response) {
                $('#consulta_valor').val(response); // .prop("disabled", true);
            });
        } else {
            // Si no es NOTACREDITO, desbloquear
            $("#consulta_valor").prop("readonly", false);
        }
    }

    // Ejecutar cuando cambie el tipo de pago o el número de documento
    $("#consulta_tipo_pago, #consulta_no_documento").on('change', verificarTipoPago);

    // Ejecutar al cargar por si ya viene con valor
    verificarTipoPago();
});
</script>
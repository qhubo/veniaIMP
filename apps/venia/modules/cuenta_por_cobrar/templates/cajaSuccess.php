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
            $('#consulta_valor').val(0);
            $('#consulta_vuelto').val(0);
            $('#consulta_comision').val(0);
            val = val.replace(/\s+/g, '').toUpperCase();
            $('#consulta_comision').show();
            $('#labelcomi').show();
            $('#panelcomi').show();
            $('#panelvuelto').show();
            $('#labelvuelto').show();
            if (val == "CHEQUEPREFECHADO") {
                $('#labelcomi').hide();
                $('#consulta_comision').hide();
                $('#panelcomi').hide();
                $('#panelvuelto').hide();
                $('#labelvuelto').hide();
            }
            if (val == "NOTACREDITO") {
                $('#labelcomi').hide();
                $('#consulta_comision').hide();
                $('#panelcomi').hide();
                $('#panelvuelto').hide();
                $('#labelvuelto').hide();
            }
            if (val == "NOTADEBITO") {
                $('#labelcomi').hide();
                $('#consulta_comision').hide();
                $('#panelcomi').hide();
                $('#panelvuelto').hide();
                $('#labelvuelto').hide();
            }
            if (val == "VUELTO") {
                $('#labelcomi').hide();
                $('#consulta_comision').hide();
                $('#panelcomi').hide();
                $('#panelvuelto').hide();
                $('#labelvuelto').hide();
            }
            if (val == "VALE") {
                $('#labelcomi').hide();
                $('#consulta_comision').hide();
                $('#panelcomi').hide();
                $('#panelvuelto').hide();
                $('#labelvuelto').hide();
            }

        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var clienteId = <?php echo $operacion->getClienteId(); ?>;
        // 🔹 EVENTOS
        $(document).on('change', '#consulta_tipo_pago, #consulta_no_documento', function () {
            verificarTipoPago();
        });
        verificarTipoPago();

        function verificarTipoPago() {
            var tipopago = $("#consulta_tipo_pago").val() || '';
            tipopago = tipopago.replace(/\s+/g, '').toUpperCase();
            if (tipopago === "NOTACREDITO") {
                convertirASelect(clienteId,tipopago);
                setBloqueado(true);
            } else if (tipopago === "VALE") {
                convertirASelect(clienteId,tipopago);
                setBloqueado(false);
            } else if (tipopago === "VUELTO") {
                convertirATextarea();
                setBloqueado(false);
                aplicarVuelto(clienteId);
            } else {
                convertirATextarea();
                setBloqueado(false);
            }

            toggleComision(tipopago);
        }

        function aplicarVuelto(clienteId) {

            $.get('<?php echo url_for("cuenta_por_cobrar/getVuelto") ?>',
                    {cliente_id: clienteId},
                    function (response) {

                        var vuelto = parseFloat(response) || 0;
                        var deuda = parseFloat($("#deuda_total").val()) || 0;

                        var valorFinal = 0;

                        if (vuelto >= deuda) {
                            valorFinal = deuda;
                        } else {
                            valorFinal = vuelto;
                        }

                        // 🔹 Setea el valor calculado
                        $("#consulta_valor")
                                .val(valorFinal.toFixed(2))
                                .prop("readonly", true)
                                .addClass("campo-bloqueado");

                        $("#icono_bloqueo").show();

                        // 🔥 NUEVO: setear texto en documento
                        var texto = "Pago con Vuelto - Actual Acumulado: " + vuelto.toFixed(2);

                        if ($("#consulta_no_documento").is("textarea")) {
                            $("#consulta_no_documento").val(texto);
                        } else if ($("#consulta_no_documento").is("select")) {
                            // si por alguna razón sigue siendo select (por NOTACREDITO previo)
                            convertirATextarea();
                            $("#consulta_no_documento").val(texto);
                        }
                    }
            );
        }
        function setBloqueado(bloqueado) {
            if (bloqueado) {
                $("#consulta_valor")
                        .prop("readonly", true)
                        .prop("disabled", false) // 🔥 CLAVE
                        .addClass("campo-bloqueado");

                $("#icono_bloqueo").show();
            } else {
                $("#consulta_valor")
                        .prop("readonly", false)
                        .prop("disabled", false) // 🔥 CLAVE
                        .removeClass("campo-bloqueado");

                $("#icono_bloqueo").hide();
            }
        }

        function convertirASelect(clienteId, tipopago) {

            // evitar recrear si ya es select
            if ($("#consulta_no_documento").is("select"))
                return;

            tipopago = (tipopago || '').replace(/\s+/g, '').toUpperCase();

            var url = '';
            var textoDefault = '';

            // 🔹 decidir endpoint según tipo
            if (tipopago === "NOTACREDITO") {
                url = '<?php echo url_for("cuenta_por_cobrar/listaNotas") ?>';
                textoDefault = 'Seleccione nota crédito';
            } else if (tipopago === "VALE") {
                url = '<?php echo url_for("cuenta_por_cobrar/listaVales") ?>';
                textoDefault = 'Seleccione vale';
            } else {
                return; // no hace nada si no aplica
            }

            $.get(url, {cliente_id: clienteId}, function (data) {

                if (typeof data === "string") {
                    data = JSON.parse(data);
                }

                var html = '<select class="form-control" id="consulta_no_documento" name="consulta[no_documento]">';
                html += '<option value="">' + textoDefault + '</option>';

                data.forEach(function (item) {
                    html += '<option value="' + item.codigo + '" data-saldo="' + item.saldo + '">';
                    html += item.codigo + ' | Saldo: ' + item.saldo;
                    html += '</option>';
                });

                html += '</select>';

                // 🔥 reemplazar textarea/select
                $("#consulta_no_documento").replaceWith(html);
            });
        }

        function convertirATextarea() {

            // evitar recrear si ya es textarea
            if ($("#consulta_no_documento").is("textarea"))
                return;

            var html = '<textarea rows="2" class="form-control" name="consulta[no_documento]" id="consulta_no_documento"></textarea>';
            $("#contenedor_documento").html(html);
        }

    });


    $(document).on('change', '#consulta_no_documento', function () {
        var saldo = parseFloat($(this).find(':selected').data('saldo')) || 0;
        var deuda = parseFloat($("#deuda_total").val()) || 0;
        var valorFinal = 0;
        if (saldo >= deuda) {
            valorFinal = deuda;
        } else {
            valorFinal = saldo;
        }
        $("#consulta_valor")
                .val(valorFinal.toFixed(2))
                .prop("readonly", true)
                .addClass("campo-bloqueado");
    });

    function toggleComision(tipopago) {
        if (tipopago.includes("NOTA") && tipopago.includes("CREDITO")) {
            $("#consulta_comision").closest("div").hide(); // 🔥 oculta todo el contenedor
        } else {
            $("#consulta_comision").closest("div").show();
        }
    }
</script>



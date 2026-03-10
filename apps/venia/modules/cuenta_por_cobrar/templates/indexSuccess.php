
<?php $modulo = $sf_params->get('module'); ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<?php  $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario()); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-more-v4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Cuentas Por Cobrar
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
        <form action="<?php echo url_for($modulo . '/index') ?>" method="get">
            <div class="row"  style="padding-bottom:10px;">
                <div class="col-lg-1"></div>
                <div class="col-lg-4">
                    <span style="display:block">Clientes</span>
                    <select  onchange="this.form.submit()" class="form-control mi-selector"  name="prover" id="prover">
                        <option value="0">[    Todos    ]</option>
                        <?php foreach ($seleccion as $key => $value) { ?>
                            <option <?php if ($prover == $key) { ?> selected="selected"  <?php } ?>  value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <span style="display:block">Vendedores</span>
                    <select  onchange="this.form.submit()" class="form-control mi-selector"  name="vende" id="vende">
                        <option value="0">[    Todos    ]</option>
                        <?php foreach ($vendedores as $vent) { ?>
                            <option <?php if ($vent->getId() == $vende) { ?> selected="selected"  <?php } ?>  value="<?php echo $vent->getId(); ?>"><?php echo $vent->getNombre(); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-1"></div>

                <div class="col-lg-1">
                    <a target="_blank" href="<?php echo url_for($modulo . '/reporte?prover=' . $prover) ?>" class="btn  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
                </div>

            </div>
        </form>

        <div class="row">
            <div class="col-lg-7"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-2">
                <?php if (!$prover) { ?>
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-7" style="font-size:18px; font-weight: bold;"> Valor Total <?php echo Parametro::formato($totalSuma); ?> </div>
        </div>



        <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin <?php if (!$prover) { ?> kt-datatable   <?php } ?>" id="html_table" width="100%">
            <thead class="flip-content">
                <tr class="active">
                    <th align="center" width="20px"> Código</th>
                    <th align="center" width="20px">Fecha / Usuario</th>
                    <th  align="center">Vendedor </th>
                    <th  align="center"> Cliente / RUC</th>
                    <th  align="center"> Observaciones</th>    
                    <th  align="center"> Valor</th>    
                    <?php if ($prover) { ?>
                        <th  align="center"> Valor  Pagar</th>  
                    <?php } ?>
                    <th  align="center"> Valor Pagado</th>     
                    <th  align="center"> Saldo</th>     
                    <th  align="center"> Estado </th>
                    <th  align="center"> #</th>    
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($operaciones as $lista) { ?>
                    <?php $total = $lista->getValorTotal() + $total; ?>
                    <?php $detalleProducto = OperacionDetalleQuery::create()->filterByOperacionId($lista->getId())->count(); ?>    
                    <tr>     
                        <td> <?php if ($lista->getCodigo()) { ?>
                                <a class="btn btn-sm  btn-warning btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                    <font size="-2"> <?php echo $lista->getCodigoFactura() ?>   </font>
                                </a>
                            <?php } else { ?>
                                <a class="btn  btn-small  btn-info btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                    <?php echo $lista->getCodigoFactura() ?>  
                                </a>   
                                <font size="-2"> <?php echo $lista->getCodigoFactura() ?>  </font>
                            <?php } ?>
                            <font size="-2"> <?php echo substr($lista->getTienda(), 0, 5) ?> </font>  
                        </td>
                        <td><font size="-2"><?php echo $lista->getFecha('d/m/Y H:i') ?></font>  
                            <br><font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                        <td><?php if ($lista->getVendedorId()) echo $lista->getVendedor()->getNombre(); ?></td>
                        <td> <strong><?php
                                if ($lista->getClienteId()) {
                                    echo $lista->getCliente()->getCodigoCli();
                                }
                                ?></strong>  <br>
                            <?php if ($lista->getCliente()->getNombre() <> $lista->getNombre()) { ?>
                                <?php echo $lista->getCliente()->getNombre() . "   " . $lista->getNombre(); ?>
                            <?php } else { ?>
                                <?php echo $lista->getCliente()->getNombre(); ?>
                            <?php } ?>
                            <br> <font size="-1"><?php echo $lista->getNit() ?></font>  
                        </td>
                        <td>  <font size="-1"><?php echo $lista->getObservaciones() ?></font>  </td>


                        <td>  <font size="-1"><?php echo number_format($lista->getValorTotal(), 2) ?>  </font>  </td>

                        <?php if ($prover) { ?>
                            <td style="background-color:#eeeeee">
                                <?php
                                $saldo = $lista->getValorTotal() - $lista->getValorPagado();
                                ?>
                                <?php if ($TIPO_USUARIO=='ADMINISTRADOR') { ?>
                                <input  datoid="<?php echo $lista->getId(); ?>" class="form-control valor-pagar"  type="text"  placeholder="0.00" value="0.00" data-max="<?php echo $saldo; ?>"   >
                            <?php } ?>
                            </td>
                            </td>
                        <?php } ?>

                        <td>

                            <font size="-1"><?php echo number_format($lista->getValorPagado(), 2) ?>  </font>  </td>
                        <td style="text-align:right">  
                          <?php if ($TIPO_USUARIO=='ADMINISTRADOR') { ?>
                             <a class="btn btn-sm btn-block btn-success btn-outline  "  href="<?php echo url_for($modulo . '/caja?id=' . $lista->getId()) ?>"  >
                                <i class="fa flaticon-signs"></i> Pago <font size="-1"><?php echo number_format($lista->getValorTotal() - $lista->getValorPagado(), 2) ?>  </font>  
                            </a>
                             <?php } else { ?>
                               <?php echo number_format($lista->getValorTotal() - $lista->getValorPagado(), 2) ?>  </font>  
                             <?php } ?>
                        </td>

                        <td>  <font size="-1"><?php echo $lista->getEstatus() ?>  </font>  </td>
                        <td><?php echo $lista->getId(); ?></td>

                    </tr>



                <?php } ?>
            </tbody>
         
            <?php if ($prover) { ?>
                <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right"> <strong>Totales</strong></td>

                        <td style="text-align: right">
                            <font size='-1'><?php echo Parametro::formato($total); ?></font>
                        </td>

                        <td style="text-align: right">
                            <font size='+1' id="total_pagar_sumado">0.00</font>
                        </td>

                        <td></td>
                    </tr>
                </tfoot>
            <?php } ?>

        </table>
            <?php if ($TIPO_USUARIO=='ADMINISTRADOR') { ?>
        <?php if ($prover) { ?>
            <div style="margin-top:15px; text-align:right;">
<a id="btnProcesarPago"
   class="btn btn-sm btn-warning"
   href="#">
   Procesar Pago
</a>
            </div>
          <?php } ?>
        <?php } ?>
    </div>
</div>


 <div class="modal fade" id="ajaxmodalPago" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 750px">
            <div class="modal-content" style=" width: 750px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Cargando...</h4>
                </div>
            </div>
        </div>
    </div>




    
<script>
$(document).ready(function () {

    function recalcularTotal() {
        let total = 0;

        $('.valor-pagar').each(function () {
            let valor = parseFloat($(this).val()) || 0;
            total += valor;
        });

        $('#total_pagar_sumado').text(total.toFixed(2));
        return total;
    }

    // 🔹 Validación mientras escribe
    $(document).on('input', '.valor-pagar', function () {

        let valor = $(this).val();

        // permitir solo números y punto
        valor = valor.replace(/[^0-9.]/g, '');

        // permitir solo un punto decimal
        let partes = valor.split('.');
        if (partes.length > 2) {
            valor = partes[0] + '.' + partes[1];
        }

        $(this).val(valor);

        let numero = parseFloat(valor) || 0;
        let maximo = parseFloat($(this).data('max'));

        if (numero > maximo) {
            $(this).val(maximo.toFixed(2));
        }

        recalcularTotal();
    });

    // 🔹 Formatear al salir del campo
    $(document).on('blur', '.valor-pagar', function () {

        let numero = parseFloat($(this).val()) || 0;
        let maximo = parseFloat($(this).data('max'));

        if (numero < 0) numero = 0;
        if (numero > maximo) numero = maximo;

        $(this).val(numero.toFixed(2));

        recalcularTotal();
    });

    // 🔥 PROCESAR PAGO
    $('#btnProcesarPago').on('click', function (e) {

        e.preventDefault();

        let total = recalcularTotal();

        if (total <= 0) {
            alert('Debe ingresar un monto a pagar');
            return false;
        }

        // 🔹 Construir lista de pagos
        let lista = [];

        $('.valor-pagar').each(function () {

            let valor = parseFloat($(this).val()) || 0;

            if (valor > 0) {

                lista.push({
                    id: $(this).attr('datoid'),
                    valor: valor.toFixed(2)
                });

            }

        });

        // convertir a JSON
        let jsonList = encodeURIComponent(JSON.stringify(lista));

        let baseUrl = "<?php echo url_for('cuenta_por_cobrar/pagoMasiva') ?>?id=<?php echo $prover; ?>";

        let nuevaUrl = baseUrl
                + "&total=" + total.toFixed(2)
                + "&list=" + jsonList;

        $('#ajaxmodalPago .modal-content').load(nuevaUrl, function () {
            $('#ajaxmodalPago').modal('show');
        });

    });

});
</script>

 <div class="modal fade" id="ajaxmodalPago" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 750px">
            <div class="modal-content" style=" width: 750px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Cargando...</h4>
                </div>
            </div>
        </div>
    </div>


<?php foreach ($operaciones as $reg) { ?>
    <?php $lista = $reg; ?>
    <div class="modal fade" id="ajaxmodal<?php echo $reg->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 750px">
            <div class="modal-content" style=" width: 750px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Detalle de Operación</h4>
                </div>
            </div>
        </div>
    </div>



<?php } ?>

<?php if ($operacionPago) { ?>
    <div id="ajaxmodalP" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Recibo <?php echo $operacionPago->getCodigo(); ?>   </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-9" style="font-weight:bold;  font-size: 15px;"> Impresion de Recibo</div>
                        <div class="col-lg-3">
                            <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $operacionPago->getId()) ?>" class="btn btn-block  btn-sm btn-dark " target = "_blank">
                                <i class="flaticon2-printer"></i>  Recibo <?php echo $operacionPago->getCodigo(); ?>
                            </a>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#ajaxmodalP").modal();
        });
    </script>
<?php } ?>



<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>
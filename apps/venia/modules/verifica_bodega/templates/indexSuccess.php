<!--<meta http-equiv="refresh" content="30">-->
<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Productos Solcitados para Empaque
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">

        <form action="<?php echo url_for($modulo . '/index?id=0') ?>" method="get">
            <div class="row" style="padding-top:2px;padding-bottom:5px;">
                <div class="col-lg-1"></div>
                <div class="col-lg-2">Seleccione pedido </div>
                <div class="col-lg-4">
                    <select  onchange="this.form.submit()" class="form-control mi-selector" name="em" id="em">
                        <option  selected="selected"  value="99" >Todos los pedidos</option>
                        <?php foreach ($pedidos as $reg) { ?>
                            <option value="PE<?php echo $reg->getId(); ?>"  <?php if ($em == 'PE' . $reg->getId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo "PEDIDO" . $reg->getId(); ?>
                            </option>
                        <?php } ?>

                        <?php foreach ($cotizacio as $reg) { ?>
                            <option value="<?php echo $reg->getOperacionId(); ?>"  <?php if ($em == $reg->getOperacionId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo $reg->getOperacion()->getCodigo(); ?>      <?php echo $reg->getOperacion()->getNombre(); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <?php if ($muestraBoton) { ?>  
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-2">
                        <?php if ($tipo == 1) { ?>
                            <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token=' . $token) ?>" class="btn btn-sm btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
                        <?php } ?>
                        <?php if ($tipo == 2) { ?>

                            <a target="_blank" href="<?php echo url_for('producto_vendedor/reporte?id=' . $em) ?>" class="btn btn-sm btn-warning"  target = "_blank">
                                <i class="flaticon2-print"></i>   Pedido     
                            </a>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>     
        </form>
        <?php $ruta = 'ConfirmaPedi'; ?>

       <?php if ($muestraBoton) { ?>  
        <form action="<?php echo url_for($modulo . '/' . $ruta . '?id=' . $em) ?>" method="post">
       <?php } ?>
            <table  style="width: 100%" class=" <?php if (!$muestraBoton) { ?> table  <?php } ?> table-bordered " >
                <tr>
                    <th>Orden</th>
                    <th>Usuario</th>                    
                    <th>Codigo Producto</th>
                    <th>Producto </th>
                    <?php if ($muestraBoton) { ?>
                        <th>Cantidad Bulto</th>
                        <th>Peso</th>
                    <?php } ?>
                    <th>Cantidad</th>
                    <?php if ($muestraBoton) { ?>
                        <th>Existencia</th>
                        <th></th>
                    <?php } ?>
                </tr>
                <?php $totalPeso = 0; ?>
                <?php foreach ($detalles as $reg) { ?>
                    <?php $totalPeso = $totalPeso + ( $reg->getProducto()->getPeso() * $reg->getCantidad()) ?>
                    <?php $pesoLin = round($reg->getProducto()->getPeso() * $reg->getCantidad(), 2); ?>
                        <tr style="background-color:#D7EBF5;">
                            <td><?php echo $reg->getOperacion()->getCodigo(); ?></td>
                            <td><?php echo $reg->getOperacion()->getUsuario(); ?></td>
                            <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                            <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                            <?php if ($muestraBoton) { ?>
                                <td>
                                    <input min="0" type="number" any="step" step="any" class="form-control" value="<?php echo $reg->getCantidadCaja() ?>"   name="can_caja<?php echo $reg->getId(); ?>" id="can_caja<?php echo $reg->getId(); ?>">
                                </td>
                                <td>
                                    <input class="form-control" disabled="" value="<?php echo $pesoLin ?>"   name="peso<?php echo $reg->getId(); ?>" id="peso<?php echo $reg->getId(); ?>">
                                </td>
                            <?php } ?>
                            <td style="background-color:white !important; font-weight: bold; text-align: right; font-size:16px;">

                                <?php echo $reg->getCantidad(); ?>
                            </td>
                            <?php if ($muestraBoton) { ?>
                                <td></td>
                                <th>Despachar</th>
                            <?php } ?>
                        </tr>
                <?php } ?>
            </table>

            <?php if ($muestraBoton) { ?>  
                <div class="row" style="padding-top:2px;padding-bottom:5px;">
                    <div class="col-lg-6" ></div>
                    <div class="col-lg-2" style="font-weight:bold;">
                        Total Bulto
                        <input type="number" class="form-control" value="<?php echo $caja ?>"   name="total_caja" id="total_caja">
                    </div>
                    <div class="col-lg-2" style="font-weight:bold;"su>
                        Total Peso
                        <input type="number" class="form-control" disabled="" value="<?php echo $totalPeso ?>"   name="total_peso" id="total_peso">
                    </div>

                    <div class="col-lg-2" style="padding-top:10px;">
                        <button class="btn btn-block  btn-xs btn-dark dark"  type="submit">
                            <i class="flaticon2-check-mark"></i>CONFIRMAR EMPAQUE
                        </button>    
                    </div> 
                </div>
               </form>
            <?php } ?>
     
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#total_caja").on('change', function () {
            var id = <?php echo $idp; ?>;
            var val = $("#total_caja").val();
            $.get('<?php echo url_for("verifica_bodega/tcaja") ?>', {id: id, val: val}, function (response) {
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#total_peso").on('change', function () {
            var id = <?php echo $idp; ?>;
            var val = $("#total_peso").val();
            $.get('<?php echo url_for("verifica_bodega/tpeso") ?>', {id: id, val: val}, function (response) {
            });
        });
    });
</script>

<?php foreach ($detalles as $lista) { ?>




    <script type="text/javascript">
        $(document).ready(function () {
            $("#can_caja<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#can_caja<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("verifica_bodega/caja") ?>', {id: id, val: val}, function (response) {

                    $("#total_caja").val(response);
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#peso<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#peso<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("verifica_bodega/peso") ?>', {id: id, val: val}, function (response) {
                    $("#total_peso").val(response);
                });
            });
        });
    </script>

<?php } ?>



<script>
    const inputs = document.querySelectorAll('.cantidad');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            const max = Number(input.getAttribute('max'));
            const min = Number(input.getAttribute('min'));
            let valor = Number(input.value);

            if (valor > max) {
                input.value = max; // Forzar el valor máximo
            } else if (valor < min) {
                input.value = min; // Evitar valores negativos
            }
        });
    });
</script>

<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>

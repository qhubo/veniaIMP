<style>
    body {
        font-family: helvetica;
        font-size: 9px;
        color: #222222;
    }

    .encabezado {
        width: 100%;
        border-collapse: collapse;
    }

    .encabezado td {
        vertical-align: top;
        padding: 3px;
    }

    .empresa {
        font-size: 13px;
        font-weight: bold;
    }

    .titulo {
        font-size: 18px;
        font-weight: bold;
        text-align: right;
    }

    .prefactura {
        font-size: 11px;
        font-weight: bold;
        text-align: right;
    }

    .datos {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .datos td {
        border: 1px solid #cccccc;
        padding: 5px;
    }

    .label {
        font-weight: bold;
        background-color: #f2f2f2;
    }

    .detalle {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .detalle th {
        background-color: #eeeeee;
        border: 1px solid #000000;
        padding: 5px;
        text-align: center;
        font-weight: bold;
    }

    .detalle td {
        border: 1px solid #000000;
        padding: 5px;
    }

    .center {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .totales {
        width: 100%;
        margin-top: 10px;
    }

    .totales td {
        padding: 4px;
    }

    .total-final {
        font-size: 40px;
        font-weight: bold;
        border-top: 2px solid #000000;
        border-bottom: 2px solid #000000;
        padding: 7px;
    }

    .nota {
        margin-top: 15px;
        border: 1px solid #cccccc;
        padding: 7px;
        font-size:30px;
    }
</style>


<!-- =========================================================
     ENCABEZADO
     ========================================================= -->

<table class="encabezado">
    <tr>

        <!-- EMPRESA -->
        <td style="width:55%;">

            <div class="empresa" style="font-size:32px">
                <?php echo $operacion->getEmpresa()->getNombre(); ?>
            </div>

        

            <?php if ($operacion->getEmpresa()->getDireccion()) { ?>
                <strong>Dirección:</strong>
                <?php echo $operacion->getEmpresa()->getDireccion(); ?>
                <br>
            <?php } ?>

            <?php if ($operacion->getEmpresa()->getTelefono()) { ?>
                <strong>Teléfono:</strong>
                <?php echo $operacion->getEmpresa()->getTelefono(); ?>
            <?php } ?>

        </td>


        <!-- DOCUMENTO -->
        <td style="width:45%;">

            <div class="titulo">
                PREFACTURA
            </div>

            <div class="prefactura">
                No. <?php echo $codigo; ?>
            </div>

            <br>

            <div class="right">
                <strong>Fecha:</strong>
                <?php echo $operacion->getFechaVencimiento('d/m/Y'); ?>
                <br>

                <strong>Pedido:</strong>
                <?php echo $operacion->getCodigo(); ?>
            </div>

        </td>

    </tr>
</table>


<!-- =========================================================
     DATOS DEL CLIENTE
     ========================================================= -->

<table class="datos">

    <tr>

        <td class="label" style="width:15%;">
            Cliente
        </td>

        <td style="width:35%;">
            <?php echo $operacion->getNombre(); ?>
        </td>

        <td class="label" style="width:15%;">
          Codigo
        </td>

        <td style="width:35%;">
            <?php echo $operacion->getCliente()->getCodigo(); ?>
        </td>

    </tr>

    <tr>

        <td class="label">
            Código Cliente
        </td>

        <td>
            <?php
            if ($operacion->getClienteId()) {
                echo $operacion->getCliente()->getCodigo();
            }
            ?>
        </td>

        <td class="label">
            Vendedor
        </td>

        <td>
            <?php
            if ($operacion->getVendedorId()) {
                echo $operacion->getVendedor()->getNombre();
            }
            ?>
        </td>

    </tr>

    <tr>

        <td class="label">
            Observaciones
        </td>

        <td colspan="3">
            <?php echo $operacion->getComentario(); ?>
        </td>

    </tr>

</table>


<!-- =========================================================
     DETALLE DE PRODUCTOS
     ========================================================= -->

<table class="detalle">

    <thead>

        <tr>

            <th style="width:30px">
                #
            </th>

 

            <th style="width:450px">
                DESCRIPCIÓN
            </th>

            <th style="width:80px">
                CANTIDAD
            </th>

            <th style="width:80px">
                PRECIO UNIT.
            </th>

            <th style="width:95px">
                TOTAL
            </th>

        </tr>

    </thead>

    <tbody>

        <?php
        $pos = 0;
        $subtotal = 0;
        $cantidadTotal = 0;
        ?>

        <?php foreach ($detalle as $registro) { ?>

            <?php
            $pos++;

            $cantidad = $registro->getCantidad();
            $valorUnitario = $registro->getValorUnitario();
            $valorTotal = $registro->getValorTotal();

            $cantidadTotal += $cantidad;
            $subtotal += $valorTotal;
            ?>

            <tr>

                 <td style="width:30px">
                    <?php echo $pos; ?>
                </td>

                <td style="width:450px">
                    <?php echo $registro->getCodigo(); ?>
                    <br>
                    <?php echo $registro->getDetalle(); ?>
                </td>

                <td class="right" style="width:80px">
                    <?php echo Parametro::formato($cantidad, false); ?>
                </td>

                <td class="right" style="width:80px">
                    <?php echo Parametro::formato($valorUnitario, false); ?>
                </td>

                <td class="right" style="width:95px">
                    <?php echo Parametro::formato($valorTotal, false); ?>
                </td>

            </tr>

        <?php } ?>

    </tbody>

</table>


<!-- =========================================================
     TOTALES
     ========================================================= -->

<table class="totales">



    <?php
    /*
     * IVA
     *
     * Si tu sistema maneja el IVA de forma separada,
     * aquí puedes sustituir esta fórmula por el valor
     * almacenado en la operación.
     */

    $iva = $subtotal * 0.12;
    $total = $subtotal + $iva;
    ?>





    <tr>

        <td></td>

        <td class="total-final" style="text-align:right;">
            TOTAL:
        </td>

        <td class="total-final" style="text-align:right;">
            <?php echo Parametro::formato($total, false); ?>
        </td>

    </tr>

</table>


<!-- =========================================================
     PIE
     ========================================================= -->

<div class="nota">

    <strong>PREFACTURA - DOCUMENTO NO FISCAL</strong>
    <br><br>

    Este documento corresponde a una prefactura y se emite
    únicamente como referencia de los productos y valores
    asociados al pedido.

</div>
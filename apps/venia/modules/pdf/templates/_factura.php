
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .sin-borde td {
        border: none;
        padding: 3px;
    }

    .borde td, .borde th {
        border: 1px solid #000;
        padding: 5px;
    }

    .titulo {
        font-size: 40px;
        font-weight: bold;
    }

    .negrita {
        font-weight: bold;
    }

    .centrado {
        text-align: center;
    }

    .derecha {
        text-align: right;
    }

    .logo {
        width: 120px;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .espacio {
        height: 10px;
    }
</style>

<!-- ================= ENCABEZADO ================= -->
<table class="sin-borde">
    <tr>
        <td width="20%" style="text-align:center;">

        </td>
        <td width="65%" style="text-align:center;">
            <span class="titulo" style="display:block"><?php echo $orden->getEmpresa()->getNombre(); ?></span><br>
            <span style="display:block">RUC: <?php echo $orden->getEmpresa()->getTelefono(); ?></span><br>
            <span style="display:block">Teléfono: <?php echo $orden->getEmpresa()->getContactoTelefono(); ?></span><br>
            <span style="display:block"><?php echo $orden->getEmpresa()->getDireccion(); ?></span>
        </td>
        <td width="15%" class="borde">
            <table width="100%">
                <tr>
                    <td class="negrita" >FACTURA COMERCIAL</td>
                </tr>
                <tr>
                    <td class="centrado titulo" ><?php echo $orden->getCodigo(); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="espacio" style="text-align: right; font-size: 28px;"> Fecha Impresión <?php echo date('d/m/Y'); ?> </div>


<?php $operacion = $orden; ?>
<!-- ================= SEGUNDO ENCABEZADO ================= -->
<table style="width:100%" class="encabezado">
    <tr>
        <td  style="width:65%">  

            <div class="header-left">

                <strong>Fecha:</strong> <?php echo $operacion->getFecha('d/m/Y'); ?><br>
                <strong>Cliente:</strong> <?php echo $operacion->getNombre(); ?><br>
                <strong>Dirección:</strong> <?php echo $operacion->getCliente()->getDireccion(); ?><BR>
                <strong>Acuerdo de Pago:</strong> Credito 60 Dias <BR>
                <strong>Código Cliente:</strong> <?php echo $operacion->getCliente()->getCodigo(); ?><br>
                <strong>RUC:</strong> <?php echo $operacion->getNit(); ?><br>

            </div>
        </td>
        <td  style="width:35%">  
            <div class="header-right">
                <strong>No Pedido.</strong> <?php echo $operacion->getCodigo(); ?><br>
                <strong>Vendedor:</strong> <?php if ($operacion->getVendedorId()) {
    echo $operacion->getVendedor()->getNombre();
} ?> <br>
                <strong>País:</strong> <?php echo $operacion->getCliente()->getPais(); ?><br>
                <strong>Telefono:</strong> <?php echo $operacion->getCliente()->getTelefono(); ?><br>
                <strong>Transporte:</strong> <?php echo $operacion->getNombreTransporte(); ?><br>
            </div>
        </td>
    </tr>
</table>




<div class="espacio"></div>

<!-- ================= DETALLE ================= -->
<table>
    <thead>
        <tr class="centrado" style="background-color:#F2F2F2">
            <th style="width:20px;font-size: 26px; border-top: 1px solid #000; ">No</th>
            <th  style="width:75px;font-size: 26px; border-top: 1px solid #000;">Código</th>
            <th  style="width:225px;font-size: 26px; border-top: 1px solid #000;">Descripción</th>
            <th  style="width:85px;font-size: 26px; border-top: 1px solid #000;">Origen</th>
            <th  style="width:85px;font-size: 26px; border-top: 1px solid #000;">Marca</th>
            <th  style="width:90px;font-size: 26px; border-top: 1px solid #000;">Características</th>
            <th  style="width:50px;font-size: 26px; border-top: 1px solid #000;">Unidades</th>
            <th  style="width:60px;font-size: 26px; border-top: 1px solid #000;">Precio Unit</th>
            <th  style="width:60px;font-size: 26px; border-top: 1px solid #000;">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $can = 0; ?>
        <?php $totalPeso = 0; ?>
        <?php $totalMetros = 0; ?>
        <?php $totalUnidades = 0; ?>   
        <?php $Subtotal = 0; ?>   
        <?php $totalCajas = 0; ?>   
        <?php foreach ($lista as $regist) { ?>
            <?php $can++; ?>
            <?php $pro = $regist->getProducto(); ?>
            <?php $totalPeso = $totalPeso + $regist->getProducto()->getPeso(); ?>
            <?php $totalMetros = $totalMetros + ( ($pro->getAlto() * $pro->getAncho() * $pro->getLargo()) * $regist->getCantidad()); ?>
            <?php $totalUnidades = $totalUnidades + $regist->getCantidad(); ?>  
    <?php $totalCajas = $totalCajas + $regist->getCantidadCaja(); ?>  
    <?php $Subtotal = $Subtotal + $regist->getValorTotal(); ?>   
            <tr>
                <td style="width:20px; font-size: 25px; " class="centrado"><?php echo $can; ?></td>
                <td style="width:75px;font-size: 25px; " ><?php echo $regist->getCodigo(); ?></td>
                <td style="width:225px;font-size: 25px; "><?php echo $regist->getDetalle(); ?></td>
                <td class="centrado" style="width:85px;font-size: 25px; "><?php echo $regist->getProducto()->getOrigen(); ?></td>

                <td class="centrado" style="width:90px;font-size: 25px; "><?php echo $regist->getProducto()->getMarcaProducto(); ?></td>

                <td style="width:85px;font-size: 25px; "><?php echo $regist->getProducto()->getCaracteristica(); ?></td>
                <td style="width:50px;font-size: 25px; " class="centrado"><?php echo $regist->getCantidad(); ?></td>
                <td style="width:60px;font-size: 25px; " class="derecha"><?php echo $regist->getValorUnitario(); ?></td>
                <td style="width:60px;font-size: 25px; " class="derecha"><?php echo $regist->getValorTotal(); ?></td>
            </tr>
<?php } ?>
    </tbody>
</table>
<br>


<table class="sin-borde" >
    <tr>
        <td style="width: 470px;">

            <table>
                <tr>
                    <td class="negrita" style="width:130px;"> Metros Cúbicos</td>
                    <td style="text-align: right;width:100px;"><?php echo round($totalMetros, 2); ?></td>
                </tr>
                <tr>
                    <td class="negrita"> Kilogramos</td>
                    <td style="text-align: right;"><?php echo round($totalPeso, 2); ?></td>

                </tr>
                <tr>
                    <td class="negrita"> Bultos</td>
                    <td style="text-align: right;"><?php echo round($totalCajas, 2); ?></td>
                </tr>
            </table>
            <BR>
            <BR>
<?php echo $totalImprime; ?>

        </td>
        <td style="width: 400px;">
            <table>
                <tr>
                    <td class="negrita" style="height: 18px;"> Subtotal</td>
                    <td style="text-align: right;"><?php echo Parametro::formato($Subtotal); ?></td>
                    <td style="text-align: right;"></td>
                </tr>
                <tr>
                    <td class="negrita" style="height: 18px;"></td>
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;"></td>
                </tr>
                <tr>
                    <td class="negrita" style="height: 18px;"> (+) Recarga</td>
                    <td style="text-align: right;"><?php echo Parametro::formato($orden->getTotalRecargo()); ?></td>
                    <td style="text-align: right;"></td>
                </tr>
                <tr>
                    <td class="negrita" style="height: 18px;"></td>
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;"></td>
                </tr>
                <tr>
                    <td class="negrita" style="font-size:38px; height: 18px; border-top: 1px solid #000;"> TOTAL</td>
                    <td style="font-size:38px;text-align: right; border-top: 1px solid #000;"><?php echo Parametro::formato($orden->getValorTotal()); ?></td>
                    <td style="text-align: right;"></td>
                </tr>
            </table>

        </td>

    </tr>

</table>
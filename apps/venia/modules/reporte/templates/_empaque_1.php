
<style>

    /* =========================
       ESTILO TABLA ENCABEZADO
       ========================= */
    .encabezado {
        width: 100%;
        border-collapse: collapse;
    }

    .encabezado td,
    .encabezado th {
        border: none;
        padding: 5px;
        vertical-align: top;
    }


    /* =========================
       ESTILO TABLA DETALLE
       ========================= */
    .detalle {
        width: 100%;
        border-collapse: collapse;
    }

    .detalle th,
    .detalle td {
        border: 1px solid #000;
        padding: 5px;
        vertical-align: top;
    }

    .detalle th {
        text-align: center;
        font-weight: bold;
        background: #f2f2f2;
    }

    .detalle td.center {
        text-align: center;
    }

    .detalle td.right {
        text-align: right;
    }
    .logo {
        width: 120px;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }


</style>

<table style="width:100%" class="encabezado">
    <tr>
        <td  style="width:25%"> </td>
        <td  style="width:50%; text-align: center; font-size: 30px;">
            <strong><?php echo $operacion->getEmpresa()->getNombre(); ?></strong><br>
           <strong>RUC</strong> <?php echo $operacion->getEmpresa()->getTelefono(); ?><br>
            <?php echo $operacion->getEmpresa()->getDireccion(); ?>
        
        </td>
        <td  style="width:25% "> No Pedido  <?php echo $operacion->getCodigo(); ?> </td>        
    </tr>
</table>

    <br>

<!-- ENCABEZADO -->
<table style="width:100%" class="encabezado">
    <tr>
        <td  style="width:70%">  
        
            <div class="header-left">
               
                <strong>FECHA:</strong> <?php echo $operacion->getFecha('d/m/Y'); ?><br>
                <strong>NOMBRE:</strong> <?php echo $operacion->getNombre(); ?><br>
                <strong>DIRECCION:</strong> <?php echo $operacion->getCliente()->getDireccion(); ?><BR>
                <strong>ACUERDO DE PAGO:</strong> Credito 60 Dias <BR>
                <strong>CÓDIDGO DEL CLIENTE:</strong> <?php echo $operacion->getCliente()->getCodigo(); ?><br>
                <strong>RUC:</strong> <?php echo $operacion->getNit(); ?><br>
           
            </div>
        </td>
        <td  style="width:30%">  
            <div class="header-right">
                <strong>No PEDIDO.</strong> <?php echo $operacion->getCodigo(); ?><br>
                <strong>VENDEDOR:</strong> <?php  if ($operacion->getVendedorId()) { echo  $operacion->getVendedor()->getNombre(); } ?> <br>
                <strong>No PEDIDO.</strong> <?php echo $operacion->getCodigo(); ?><br>
                <strong>PAIS.</strong> <?php echo $operacion->getCliente()->getPais(); ?><br>
                <strong>TELEFONO.</strong> <?php echo $operacion->getCliente()->getTelefono(); ?><br>
            </div>
        </td>
    </tr>
    <tr>
        <td style="text-align:center;"></td>
    </tr>
    <tr>
        <td style="width:100%; text-align:center;"><h2>PACKING LIST</h2></td>
    </tr>

</table>
<br>


<!-- TABLA -->
<table class="detalle">
    <thead>
        <tr>
            <th style="width:30px; font-size:26px; font-weight: bold; text-align: center;">ITEM</th>
            <th style="width:80px; font-size:26px; font-weight: bold; text-align: center;">CÓDIGO</th>
            <th style="width:200px; font-size:26px; font-weight: bold; text-align: center;">DESCRIPCIÓN</th>
            <th style="width:60px;  font-size:26px; font-weight: bold; text-align: center;">MARCAS</th>
            <th style="width:50px;  font-size:26px; font-weight: bold; text-align: center;">UNT</th>
            <th style="width:50px;  font-size:26px; font-weight: bold; text-align: center;">CANT.<br>BULTOS</th>
            <th style="width:80px; font-size:26px; font-weight: bold; text-align: center;">NO. BULTOS</th>
            <th style="width:50px; font-size:26px; font-weight: bold; text-align: center;">PESO</th>
            <th style="width:50px; font-size:26px; font-weight: bold; text-align: center;">PESO<br>TOTAL</th>
            <th style="width:50px; font-size:26px; font-weight: bold; text-align: center;">CBM</th>
            <th style="width:50px; font-size:26px; font-weight: bold; text-align: center;">TOTAL<br>CBM</th>
        </tr>
    </thead>
    <tbody>
        <?php $can = 0; ?>
        <?php $totalUni = 0; ?>
        <?php $totalBulto = 0; ?>
        <?php $totalPeso = 0; ?>
        <?php $totalCmb = 0; ?>
        <?php foreach ($detalle as $detra) { ?>
            <?php $can++; ?>
            <?php $totalUni = $detra->getCantidad() + $totalUni; ?>
            <?php $totalBulto = $detra->getCantidadCaja() + $totalBulto; ?>
            <?php $totalPeso = ($detra->getProducto()->getPeso() * $detra->getCantidad()) + $totalPeso; ?>
            <?php $totalCmb = ($detra->getProducto()->getCMB() * $detra->getCantidad()) + $totalCmb; ?>
            <tr>
                <td style="width:30px; font-size:26px;"  class="center"><?php echo $can; ?></td>
                <td style="width:80px; font-size:26px;"><?php echo $detra->getProducto()->getCodigoSku(); ?></td>
                <td style="width:200px;  font-size:26px;"><?php echo $detra->getProducto()->getNombre(); ?></td>
                <td style="width:60px;  font-size:26px;" class="center"><?php echo $detra->getProducto()->getMarcaProducto(); ?></td>
                <td style="width:50px; font-size:26px;" class="center"><?php echo $detra->getCantidad(); ?></td>
                <td style="width:50px; font-size:26px;" class="center"><?php echo $detra->getCantidadCaja(); ?></td>
                <td style="width:80px; font-size:26px;" class="center">   <?php if ($detra->getCantidadCaja() > 0) { ?>
                        <?php echo "&nbsp;&nbsp;&nbsp;Bulto " . $detra->getBultoInicio(); ?>
                        <?php if ($detra->getCantidadCaja() > 1) { ?>
                            <?php echo "<br>&nbsp;&nbsp;&nbsp;A Bulto " . $detra->getBultoFin(); ?>
                        <?php } ?>
                    <?php } ?>
                </td>
                <td style="width:50px; font-size:26px;" class="right"><?php echo $detra->getProducto()->getPeso(); ?></td>
                <td style="width:50px; font-size:26px;" class="right"><?php echo $detra->getProducto()->getPeso() * $detra->getCantidad(); ?></td>
                <td style="width:50px; font-size:26px;" class="right"><?php echo $detra->getProducto()->getCMB(); ?></td>
                <td style="width:50px; font-size:26px;" class="right"><?php echo $detra->getProducto()->getCMB() * $detra->getCantidad(); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3" style="width:310px; "></td>
            <td style="width:60px;  font-size:26px;" class="center">Totales</td>
            <td style="width:50px; font-size:26px;" class="center"><?php echo $totalUni; ?></td>
            <td colspan="2" style=" width:130px; font-size:26px;" class="center"><?php echo $totalBulto; ?></td>
            <td style="width:50px; font-size:26px;" class="right"></td>
            <td style="width:50px; font-size:26px;" class="right"><?php echo $totalPeso; ?></td>
            <td style="width:50px; font-size:26px;" class="right"></td>
            <td style="width:50px; font-size:26px;" class="right"><?php echo $totalCmb; ?></td>
        </tr>

        <!-- Puedes seguir agregando filas aquí -->
    </tbody>
</table>


<?php $colorBorder ="#5E80B4;"; ?>
<?php $boder = 'border: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderBottom = 'border-bottom: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderTOp = 'border-top: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderR = 'border-right: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderL = 'border-left: 0.2px solid ' . $colorBorder . ';'; ?>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr class="info">
            <td style="<?php echo $boderL; ?>font-size:30px;color:#063173; font-weight: bold;" >Fecha </td>
            <td style="font-size:30px;color:#063173; font-weight: bold;" >Tienda</td>
            <td style="font-size:30px;color:#063173;  font-weight: bold;" >Usuario</td>
            <td style="font-size:30px;color:#063173;  font-weight: bold;" >Factura </td>
            <td style="<?php echo $boderR; ?>font-size:30px;color:#063173;  font-weight: bold;" >Valor </td>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($operaciones as $regi) { ?>
            <?php $total = $total + $regi->getValorTotal(); ?>
            <tr>
                <td style="<?php echo $boderL; ?> font-size:28px;" align="center">  <?php echo $regi->getFecha('d/m/Y'); ?><br> <?php echo $regi->getFecha('H:i'); ?></td>
                <td  style="font-size:28px;"><?php echo $regi->getTienda(); ?></td>
                <td  style="font-size:28px;"><?php echo $regi->getUsuario(); ?></td>
                <td  style="font-size:28px;"><?php echo $regi->getCodigo(); ?> <br><?php echo $regi->getFaceNumeroFactura(); ?></td>
                <td  style="<?php echo $boderR; ?> font-size:28px;" align="right"><strong><?php echo number_format($regi->getValorTotal(), 2); ?>&nbsp;&nbsp;</strong></td>

            </tr>
            
        <?php } ?>
              <?php foreach ($operacionCXC as $regi) { ?>
            <?php $total = $total + $regi->getValor(); ?>
            <tr>
                <td style="<?php echo $boderL; ?> font-size:28px;" align="center">  <?php echo $regi->getFechaCreo('d/m/Y'); ?><br> <?php echo $regi->getFechaCreo('H:i'); ?></td>
                <td  style="font-size:28px;"><?php echo $regi->getOperacion()->getTienda(); ?></td>
                <td  style="font-size:28px;"><?php echo $regi->getUsuario(); ?></td>
                <td  style="font-size:28px;"><?php echo $regi->getCxcCobrar(); ?> <br>Cxc Cobrar</td>
                <td  style="<?php echo $boderR; ?> font-size:28px;" align="right"><strong><?php echo number_format($regi->getValor(), 2); ?>&nbsp;&nbsp;</strong></td>
            </tr>

        <?php } ?>
        <tr>
            <td  style="<?php echo $boderL; ?> <?php echo $boderTOp; ?> font-size:28px; font-weight:bold;" align="right" colspan="4" class="bold">Total</td>
            <td  style="<?php echo $boderR; ?> <?php echo $boderTOp; ?> <?php echo $boderBottom; ?> font-size:28px;" align="right"><strong><?php echo number_format($total, 2); ?>&nbsp;&nbsp;&nbsp;</strong></td>

        </tr>

    </tbody>
</table>


<br>
<br><br>
<table >
    <thead>
        <tr >
            <td  style="<?php echo $boderTOp; ?><?php echo $boderL; ?>font-size:30px;color:#063173; font-weight: bold;">&nbsp;&nbsp;&nbsp;Codigo</td>
            <td  style="<?php echo $boderTOp; ?> font-size:28px; font-weight: bold;">Producto</td>
            <td  style="<?php echo $boderTOp; ?> font-size:28px; font-weight: bold;">Cantidad</td>
            <td  style="<?php echo $boderTOp; ?> <?php echo $boderR; ?>font-size:30px;color:#063173;  font-weight: bold;" >Valor </td>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($detalle as $regi) { ?>
            <?php $total = $total + $regi->getTotalValor(); ?>
            <tr>
                <td  style="<?php echo $boderL; ?> font-size:28px;">&nbsp;&nbsp;&nbsp;<?php echo $regi->getCodigo(); ?></td>
                <td  style="font-size:28px;"><?php echo $regi->getDetalle(); ?></td>
                <td  style="font-size:28px;" align="right"><strong><?php echo number_format($regi->getTotalCantidad(), 0); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                <td  style="<?php echo $boderR; ?> font-size:28px;" align="right"><strong><?php echo number_format($regi->getTotalValor(), 2); ?>&nbsp;&nbsp;&nbsp;</strong></td>

            </tr>
        <?php } ?>
        <tr>
            <td  style=" <?php echo $boderBottom; ?><?php echo $boderL; ?> font-size:28px;" align="right" colspan="3" class="bold">Total</td>
            <td   style=" <?php echo $boderBottom; ?> <?php echo $boderR; ?> font-size:28px;" align="right"><strong><?php echo number_format($total, 2); ?>&nbsp;&nbsp;&nbsp;</strong></td>

        </tr>
    </tbody>

</table>
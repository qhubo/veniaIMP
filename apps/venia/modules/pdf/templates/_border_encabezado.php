<?php $espacios = '&nbsp;&nbsp;'; ?>
<?php if (!$UNA_LINEA) { ?>
    <?php $sT = "font-size:" . ($Titulo_no + 1) . "px; "; ?>
    <?php $sT .= "color:" . $Titulo_Color . ";"; ?>
    <?php if ($Titulo_Bold) { ?>
        <?php $sT .= "font-weight: bold;"; ?>
    <?php } ?>
    <?php $sL = "font-size:" . ($linea_no + 1) . "px; "; ?>
    <?php $sL .= "color:" . $linea_Color . ";"; ?>
    <?php if ($linea_Bold) { ?>
        <?php $sL .= "font-weight: bold;"; ?>
    <?php } ?>

    <?php $espacios = '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
    <table cellpadding="0">
        <tr>
            <td>
                <span style="<?php echo $sT; ?>;  text-align: right;">Nombre&nbsp;&nbsp;&nbsp;</span>
                <span style="border: 1px solid red;<?php echo $sL; ?>; text-left: left;"><?php echo $valoresDefault['RECEPTOR']['NombreReceptor']; ?> <?php echo $espacios; ?><?php echo $espacios; ?></span>
                <span style="<?php echo $sT; ?>; text-align: right; ">&nbsp;&nbsp;&nbsp;</span>
                <span style="<?php echo $sL; ?>; text-align: left;"></span>
                <span style="<?php echo $sT; ?>; text-align: right; "></span>
                <span style="<?php echo $sL; ?>; text-align: left;"></span>
            </td>
        </tr>
        <tr>
            <td>
                <span style="<?php echo $sT; ?>; text-align: right; ">Nit&nbsp;&nbsp;&nbsp;</span>
                <span style="<?php echo $sL; ?>; text-align: left;"><?php echo $valoresDefault['RECEPTOR']['IDReceptor']; ?><?php echo $espacios; ?><?php echo $espacios; ?></span>
                <span style="<?php echo $sT; ?>; text-align: right; ">&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;</span>
                <span style="<?php echo $sL; ?>; text-align: left;"><?php echo $valoresDefault['GENERALES']['FechaHoraEmision'] ?></span>
            </td>
        </tr>
    </table>
<?php } ?>
<?php $espacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
<?php $boder = 'border: 0.2px solid .' . $colorBorder . ';'; ?>
<?php $boderBottom = 'border-bottom: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderR = 'border-right: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderT = 'border-top: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderL = 'border-left: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $sT = "font-size:" . $Titulo_no . "px; "; ?>
<?php $sT .= "color:" . $Titulo_Color . ";"; ?>
<?php if ($Titulo_Bold) { ?>
    <?php $sT .= "font-weight: bold;"; ?>
<?php } ?>
<?php $sL = "font-size:" . $linea_no . "px; "; ?>
<?php $sL .= "color:" . $linea_Color . ";"; ?>
<?php if ($linea_Bold) { ?>
    <?php $sL .= "font-weight: bold;"; ?>
<?php } ?>
<table cellpadding="3">
    <tr>
        <th <?php if ($setear) { ?> width="55px" <?php } ?> style="<?php echo $sT; ?>;<?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo $fondoEncabezado; ?>; <?php } ?>text-align: center; <?php echo $boder; ?>;"><strong> Cantidad</strong></th>
        <th <?php if ($setear) { ?> width="240px" <?php } ?> style="<?php echo $sT; ?>;<?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo $fondoEncabezado; ?>;<?php } ?> text-align: center; <?php echo $boder; ?>"><strong>Descripción</strong></th>
        <th <?php if ($setear) { ?> width="80px" <?php } ?> style="<?php echo $sT; ?>;<?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo $fondoEncabezado; ?>;<?php } ?> text-align: center; <?php echo $boder; ?>"><strong>Precio</strong></th>
        <th <?php if ($setear) { ?> width="80px" <?php } ?> style="<?php echo $sT; ?>;<?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo $fondoEncabezado; ?>;<?php } ?> text-align: center; <?php echo $boder; ?>"><strong>Descuento</strong></th>
        <!--    <th>Descuento</th>-->
        <th <?php if ($setear) { ?> width="112px" <?php } ?> style="<?php echo $sT; ?>;<?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo $fondoEncabezado; ?>;<?php } ?> text-align: center; <?php echo $boder; ?>"><strong>Total</strong></th>
    </tr>
    <?php $total = 0; ?>
    <?php foreach ($valoresDefault['lineas'] as $Linea) { ?>
        <?php $total = $total + $Linea['Precio']; ?>
        <tr>
            <td style="<?php echo $sL; ?>;text-align: center;<?php if ($fondoDetalle <> "#ffffff") { ?>  background-color:<?php echo $fondoDetalle; ?>; <?php } ?><?php echo $boderL; ?>"><?php echo $Linea['Cantidad']; ?></td>
            <td style="<?php echo $sL; ?>;padding: 15px; <?php if ($fondoDetalle <> "#ffffff") { ?>  background-color:<?php echo $fondoDetalle; ?>; <?php } ?> <?php echo $boderL; ?>"><?php echo $Linea['Descripcion']; ?></td>
            <td style="<?php echo $sL; ?>;text-align: right; <?php if ($fondoDetalle <> "#ffffff") { ?>  background-color:<?php echo $fondoDetalle; ?> ;<?php } ?> <?php echo $boderL; ?>"><?php echo Usuario::formato($Linea['PrecioUnitario'], '') ?><?php echo $espacios; ?></td>
            <td style="<?php echo $sL; ?>;text-align: right; <?php if ($fondoDetalle <> "#ffffff") { ?>  background-color:<?php echo $fondoDetalle; ?> ;<?php } ?> <?php echo $boderL; ?>"><?php echo Usuario::formato($Linea['Descuento'], '') ?><?php echo $espacios; ?></td>
            <td style="<?php echo $sL; ?>;text-align: right; <?php if ($fondoDetalle <> "#ffffff") { ?>  background-color:<?php echo $fondoDetalle; ?> ; <?php } ?><?php echo $boderL; ?><?php echo $boderR; ?>"><?php echo Usuario::formato($Linea['Precio'], '') ?><?php echo $espacios; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <th colspan="4" style="<?php echo $boderT; ?><?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>; <?php } ?> text-align: right; <?php echo $boder; ?>"><strong> Total Documento&nbsp;&nbsp;&nbsp;</strong></th>


        <!--    <th>Descuento</th>-->
        <th style="<?php echo $boderT; ?>;<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo $fondoEncabezado; ?>;<?php } ?> text-align: center; <?php echo $boder; ?>"><strong><?php echo Usuario::formato($total, ""); ?></strong></th>
    </tr>

    <tr>
        <th colspan="4" style="<?php echo $boderT; ?><?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>; <?php } ?> text-align: right; <?php echo $boder; ?>"><strong> </strong><?php echo  $valoresDefault['GENERALES']['LEYENDA']; ?>&nbsp;&nbsp;&nbsp;</th>


        <!--    <th>Descuento</th>-->
        <th style="<?php echo $boderT; ?>;<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo $fondoEncabezado; ?>;<?php } ?> text-align: center; <?php echo $boder; ?>"><strong><?php echo $valoresDefault['GENERALES']['CodigoMoneda']; ?></strong></th>
    </tr>
</table>
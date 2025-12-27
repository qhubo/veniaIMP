


<?php $bandera = ''; ?>
<?php $banderatotal = false; ?>
<?php $TOTAL = 0; ?>
<?php $CONTEO = 0; ?>

<?php foreach ($registros as $data) { ?>          
    <?php $Lista = LibroAgrupadoDetalleQuery::create()->filterByLibroAgrupadoId($data->getId())->find(); ?>
    <?php if ($bandera <> $data->getGrupo()) { ?>
        <?php $bandera = $data->getGrupo(); ?>
        <?php $can = 0; ?>

        <?php $maxi = LibroAgrupadoQuery::create()->filterByGrupo($bandera)->count(); ?>

        <table width="720px;">
            <tr>
                <td  width="720px;"><font size="+1"> <strong><?php echo $bandera; ?></strong> </font></td>
            </tr>
        </table>

    <?php } ?>
    <?php $can++; ?>
    <?php $SALDO = $data->getSaldo($fechafin); ?>
    <?php if ($data->getAbs()) { ?>
        <?php $SALDO = abs($SALDO); ?>
    <?php } ?>
    <?php $nombre = strtoupper(substr(rtrim($data->getNombre()), -9)); ?> 
    <?php if ($nombre == 'EJERCICIO') { ?>
        <?php $SALDO = $resultado; ?>
    <?php } ?>
    <?php $TOTAL = $TOTAL + $SALDO; ?>



    <table width="720px;">
        <tr>
            <td width="220px" style="font-size:20px;"> <?php echo $data->getNombre(); ?></td>
            <?php if (!$data->getHaber()) { ?>
                <td style="text-align: right;font-size:14px;"  width="140px;"><?php echo Parametro::formato($SALDO, true); ?></td>
                <td style="text-align: right;font-size:14px;" width="140px"></td>
            <?php } else { ?>
                <td style="text-align: right;font-size:14px;" width="140px"></td>
                <td style="text-align: right;font-size:14px;" width="140px"><?php echo Parametro::formato($SALDO, true); ?></td>

            <?php } ?>
            <td width="200px"></td>
        </tr>
    </table>


<?php if ($Lista) { ?>
    <table width="720px;">
        <tr>
            <td width="40px;"> </td>
                        <td width="680px;">
    <table width="680px;">
        <?php foreach ($Lista as $reg) { ?>
            <?php //$fechafin= date("Y-m-d",strtotime($fechafin."+ 1 days")); ?>
            <?php $saldo = CuentaErpContablePeer::getSaldoFecha($fechafin, $reg->getCuentaContable(), false); ?>
            <tr>
                <td width="150px;" style="border: 0.2px solid #5E80B4;"><strong><?php echo $reg->getCuentaContable(); ?></strong> </td>
                <td width="380px;" style="border: 0.2px solid #5E80B4;"><?php echo $reg->getDescripcion(); ?></td>
                <td  width="150px;" style="text-align: right;border: 0.2px solid #5E80B4;"><?php echo Parametro::formato($saldo, false); ?></td>
            </tr>
        <?php } ?>
    </table>
                        </td>
    </tr>
    </table>
<?PHP } ?>

    <?php if ($can == $maxi) { ?>
        <?php $TOTALFINAL = $TOTAL; ?>

        <table cellpadding="5" width="720px;">
            <tr>
                <td width="120px;"></td>
                <td width="300px;"><strong>TOTAL</strong> </td>
                <td width="300px;" style="text-align: right;  border-bottom: 0.2px solid #5E80B4;font-size:12px; "><STRONG><?php echo Parametro::formato($TOTAL, true); ?>  </strong></td>
            </tr>
        </table>


        <?php $CONTEO++; ?>
        <?php if ($CONTEO == 1) { ?>
            <?php $TOTAL1 = $TOTAL; ?>
        <?php } ?>
        <?php if ($CONTEO == 2) { ?>
            <?php $TOTAL2 = $TOTAL; ?>
        <?php } ?>

        <?php if ($CONTEO == 3) { ?>
            <?php $TOTAL3 = $TOTAL; ?>
        <?php } ?>
        <?php if ($CONTEO == 4) { ?>
            <?php $TOTAL4 = $TOTAL; ?>
        <?php } ?>
        <?php if ($CONTEO == 2) { ?>

            <table cellpadding="5" width="720px;">
                <tr style="background-color:#F8F5F0;">
                    <td width="120px;" style="background-color:#F8F5F0;"></td>
                    <td width="300px;" style="background-color:#F8F5F0;"><strong>TOTAL  ACTIVO</strong> </td>
                    <td width="300px;" style="background-color:#F8F5F0; text-align: right; font-size:16px; "><STRONG><?php echo Parametro::formato($TOTAL1 + $TOTAL2, true); ?>  </strong></td>
                </tr>
            </table>

        <?php } ?>

        <?php if ($CONTEO == 4) { ?>

            <table cellpadding="5" width="720px;">
                <tr style="background-color:#F8F5F0;">
                    <td width="120px;" style="background-color:#F8F5F0;"></td>
                    <td width="300px;" style="background-color:#F8F5F0;"><strong>TOTAL PASIVO</strong> </td>
                    <td width="300px;" style="background-color:#F8F5F0; text-align: right; font-size:16px; "><STRONG><?php echo Parametro::formato($TOTAL3 + $TOTAL4, true); ?>  </strong></td>
                </tr>
            </table>
        <?php } ?>


        <?php $TOTAL = 0; ?>

    <?php } ?>
<?php } ?>




<table cellpadding="5" width="720px;">
    <tr style="background-color:#F8F5F0;">
        <td width="120px;" style="background-color:#F8F5F0;"></td>
        <td width="300px;" style="background-color:#F8F5F0;"><strong>TOTAL </strong> </td>
        <td width="300px;" style="background-color:#F8F5F0; text-align: right; font-size:16px; "><STRONG><?php echo Parametro::formato($TOTAL3 + $TOTAL4 + $resultado + $TOTALFINAL, true); ?>  </strong></td>
    </tr>
</table>

<table class="table  " width="750px" >
    <?php if ($cuentas) { ?>
        <?php foreach ($cuentas as $cuenta) { ?>
            <?php //$datosCuenta = $listaDatos[$cuenta]; ?>
        <!--    <tr style="background-color:#ebedf2">
                <th align="center" style="font-weight: bold;"  width="80px"><strong> Partida</strong></th>
                <th align="center"   width="100px"><strong>Fecha</strong></th>
                <th  align="center" width="90px"><strong> Cuenta</strong></th>
                <th align="center" width="240px" ><strong>Descripción </strong></th>
                <th  align="center" width="120px"> <strong>Debe </strong></th>
                <th  align="center" width="120px" ><strong> Haber </strong></th>

            </tr>-->
            <?php $datosCuenta = $listaDatos[$cuenta]; ?>
            <tr style="background-color:#ebedf2">
                <th align="center"  width="70px">Partida</th>
                <th align="center"   width="80px">Fecha</th>
                <th  align="center" idth="80px"> Cuenta</th>
                <th align="center" width="110px">Detalle </th>
                <th align="center" width="110px">Descripción </th>
                <th  align="center" width="95px"> Debe</th>
                <th  align="center" width="95px" > Haber</th>
                <th  align="center" width="110px" > Saldo</th>
            </tr>
            <?php $saldo = CuentaErpContablePeer::getSaldoFecha($fechaInicial, $cuenta); ?>
            <tr>
                <td colspan='4'></td>
                <td>Saldo Inicial</td>
                <td></td>
                <td></td>
                <td  style="text-align:right"><?php echo Parametro::formato($saldo, true); ?></td>
            </tr>                       


            <?php foreach ($datosCuenta as $dato) { ?>

                <?php $saldo = $saldo + $dato['debe'] - $dato['haber']; ?>
            <tr <?php if (!$dato['confirmada']) { ?>  style="background-color: #ffffbf"  <?php } ?>>
                    <td>  <?php echo $dato['numero'] ?></td>
                    <td  style="text-align:center"><?php echo $dato['fecha'] ?></td>
                    <td><?php echo $cuenta ?><?php //echo $dato['movi'];  ?></td>
                    <td><?php echo $dato['tipo'] ?></td>
                    <td><?php echo $dato['detalle'] ?></td>
                    <td  style="text-align:right"><?php echo Parametro::formato($dato['debe'], true) ?></td>
                    <td  style="text-align:right"><?php echo Parametro::formato($dato['haber'], true) ?></td>
                    <td  style="text-align:right"><?php echo Parametro::formato($saldo, true); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="7"><hr></td>
            </tr>
        <?php } ?>


    <?php } ?>            

</table>
<table class="table  " width="745px" >
    <?php if ($cuentas) { ?>
        <tr style="background-color:#ebedf2">
            <th  align="center" width="180px"> Cuenta</th>
            <th align="center" width="300px" >Descripción </th>
            <th  align="center" width="230px" > Saldo</th>
            <th width="40px"></th>
        </tr>
        <?php $pinta = 0; ?>
        <?php $total = 0; ?>
        <?php foreach ($cuentas as $cuenta) { ?>
            <?php if ($pinta == 0) { ?>
                <?php if (substr($cuenta, 0, 1) == 7) { ?>
                    <?php $pinta = 1; ?>
                    <tr>
                        <td width="180px"></td>
                        <td width="250px"><strong>Total Gastos</strong></td>
                        <td width="175px"></td>
                        <td  width="140px" style="text-align:right"><?php echo Parametro::formato(($total6), true) ?></td> 
                    </tr>
                    <tr>
                        <td width="180px"> </td>
                        <td width="250px"><strong>Resultado del Ejercicio</strong></td>
                        <td width="175px"></td>
                        <td width="140px" style="text-align:right"><?php echo Parametro::formato($total4 + $total5 + $total6, true) ?></td> 
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <?php $datosCuenta = $listaDatos[$cuenta]; ?>
                <?php foreach ($datosCuenta as $dato) { ?>
                    <?php $total = $total + $dato['monto']; ?>
                    <td width="180px"><?php if (strlen($cuenta) > 3) echo $cuenta ?></td>
                    <td width="300px"><?php echo html_entity_decode($dato['detalle']) ?></td>
                    <td  width="230px" style="text-align:right"><?php echo Parametro::formato(($dato['monto']), true) ?></td>
                    <td width="40px"></td>
                </tr>
                <?php if ($cuenta == 5) { ?>
                    <tr>
                        <td width="180px"></td>
                        <td  width="250px"><strong>Margen Bruto</strong></td>
                        <td width="175px"></td>
                        <td  width="140px"style="text-align:right"><?php echo Parametro::formato($total, true) ?></td> 
                    </tr>    
                    <tr>

                        <td width="180px"><strong>Gastos</strong></td>
                        <td  width="250px"></td>
                        <td width="175px"></td>
                        <td width="140px" style="text-align:right"></td> 
                    </tr>  
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <tr>
            <td width="180px"></td>
            <td  width="250px"><strong>Total Otros gastos e ingresos</strong></td>
            <td width="175px"></td>
            <td width="140px"  style="text-align:right"><?php echo Parametro::formato($total7, true) ?></td> 
        </tr> 
        <tr>
            <td width="180px"></td>
            <td  width="250px"><strong>Utilidad Neta</strong></td>
            <td width="175px"></td>
            <td  width="140px" style="text-align:right"><?php echo Parametro::formato($total4 + $total5 + $total6 + $total7, true) ?></td> 
        </tr> 
    <?php } ?>
</table>
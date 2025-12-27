<table class="table  " width="750px" >

    <tr style="background-color:#ebedf2">
        <th align="center" style="font-weight: bold;"  width="80px"><strong> Partida</strong></th>
        <th align="center"   width="100px"><strong>Fecha</strong></th>
        <th  align="center" width="90px"><strong> Cuenta</strong></th>
        <th align="center" width="240px" ><strong>Descripción </strong></th>
        <th  align="center" width="120px"> <strong>Debe </strong></th>
        <th  align="center" width="120px" ><strong> Haber </strong></th>

    </tr>

    <?php $bandera = 0; ?>
    <?php $total1 = 0; ?>
    <?php $total2 = 0; ?> 
    <?php $cantida = 0; ?>
    <?php foreach ($operaciones as $registro) { ?>

        <?php if ($bandera <> $registro->getPartidaId()) { ?>
            <?php if ($total1 > 0) { ?>

                <tr>
                    <td style="text-align: center"  colspan="4"><strong>Totales <?php echo $registro->getPartida()->getTipo(); ?></strong></td>
                    <td  style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total1); ?></strong></td>
                    <td style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total2); ?></strong></td>
                  </tr>
                <tr>
                    <td colspan="6"> </td>
                </tr>
        
                  
                
          
                
    <tr style="background-color:#ebedf2">
        <th align="center" style="font-weight: bold;"  width="80px"><strong> Partida</strong></th>
        <th align="center"   width="100px"><strong>Fecha</strong></th>
        <th  align="center" width="90px"><strong> Cuenta</strong></th>
        <th align="center" width="240px" ><strong>Descripción </strong></th>
        <th  align="center" width="120px"> <strong>Debe </strong></th>
        <th  align="center" width="120px" ><strong> Haber </strong></th>

    </tr>
            <?php } ?>                            
        <?php } ?>
        <tr>
            <td width="80px"> <?php //echo $cantida. " --".count($operaciones);  ?><?php echo $registro->getPartida()->getNoAsiento() ; ?></td>
            <td  width="100px" style="text-align: center"><?php echo $registro->getPartida()->getFechaContable('d/m/Y'); ?></td>
            <td width="90px"><?php echo $registro->getCuentaContable(); ?></td>
            <td align="left" style="text-align:left"  width="240px"><?php echo $registro->getDetalle(); ?></td>
            <td style="text-align: right" width="120px"><?php echo Parametro::formato($registro->getDebe()); ?></td>
            <td style="text-align: right" width="120px"><?php echo Parametro::formato($registro->getHaber()); ?></td>
<!--            <td> <font size="-1"><?php //echo $registro->getPartida()->getTipo(); ?></font></td>-->
        </tr>
        <?php if ($bandera <> $registro->getPartidaId()) { ?>
            <?php $bandera = $registro->getPartidaId(); ?>
            <?php $total1 = 0; ?>
            <?php $total2 = 0; ?> 
        <?php } ?>
        <?php $total1 = $registro->getDebe() + $total1; ?>
        <?php $total2 = $registro->getHaber() + $total2; ?> 
    <?php } ?>
    <tr>
        <td style="text-align: center"  colspan="4"><strong>Totales</strong></td>
        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total1); ?></strong></td>
        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total2); ?></strong></td>
    </tr>

</table>
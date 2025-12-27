



<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>
        <td   width="50px"></td>
        <td  width="80px" style="background-color:#cbd6ec; font-size:32px">Sector</td>
        <td   width="200px" style="border-bottom: 0.2px solid #B8B8B8; color:#787878" ><?php echo $vivienda->getSector() ?></td>
         <td   width="50px"></td>
        <td    width="80px" style="background-color:#cbd6ec; font-size:32px" >Número</td>
        <td   width="170px" style="font-size:25px;border-bottom: 0.2px solid #B8B8B8; color:#787878"><?php echo $vivienda->getNumero(); ?></td>

    </tr>
    <tr>
        <td   width="50px"></td>
       <td  width="80px" style="background-color:#cbd6ec; font-size:32px">Dirección</td>
       <td   width="500px" style="font-size:25px;border-bottom: 0.2px solid #B8B8B8; color:#787878"><?php echo $vivienda->getDireccion(); ?></td>

    </tr>
    
</table>
<br>




<table cellspacing="0" style=" border: 0.2px solid #B8B8B8;" cellpadding="3"  width="740px">
    <tr  style="background-color:#cbd6ec;border: 0.2px solid #B8B8B8; " >
        <th style=" border: 0.2px solid #B8B8B8;" width="70px" align="center"><font size="-1">  Código</font> </th>
        <th style=" border: 0.2px solid #B8B8B8;" width="30px"  align="center"><font size="-1">No </font></th>
        <th style=" border: 0.2px solid #B8B8B8;" width="185px"  align="center"><font size="-1"> Detalle</font> </th>
        <th style=" border: 0.2px solid #B8B8B8;"style=" border: 0.2px solid #B8B8B8;" width="65px"  align="center"><font size="-1"> Fecha </font></th>
        <th style=" border: 0.2px solid #B8B8B8;" width="90px" align="center"><font size="-1"> Valor</font></th>
        <th style=" border: 0.2px solid #B8B8B8;" width="70px" align="center"><font size="-1">  Mora</font></th>
        <th style=" border: 0.2px solid #B8B8B8;" width="65px" align="center"><font size="-2"> Fecha&nbsp;Pago</font></th>
        <th style=" border: 0.2px solid #B8B8B8;" width="75px" align="center"><font size="-1"> Pago</font></th>
        <th style=" border: 0.2px solid #B8B8B8;" width="90px" align="center"><font size="-1">Valor Pagado</font></th>
    </tr>

    <?Php $total1 = 0; ?>
    <?Php $total2 = 0; ?>
    <?Php $total3 = 0; ?>
    <?php if ($cuenta) { ?>
        <?php foreach ($cuenta as $registro) { ?>
            <?Php $total1 = $total1 + $registro->getValor(); ?>
            <?Php $total2 = $total2 + $registro->getValorMora(); ?>
            <?Php $total3 = $registro->getValorPagado() + $total3; ?>
            <?php $li = $registro->getId(); ?>
            <tr>
                <td style=" border: 0.8px solid #B8B8B8;" width="70px"><font size="-2"><?php echo $registro->getCodigo() ?></font></td>
                <td style=" border: 0.2px solid #B8B8B8;" width="30px"><font size="-2"> <?php echo  substr($registro->getNumero(),0,3) ?></font></td>
                <td style=" border: 0.2px solid #B8B8B8;"width="185px"><font size="-1"><?php echo $registro->getDetalle() ?></font></td>
                <td style=" border: 0.2px solid #B8B8B8;" width="65px" align="center"><font size="-1"><?php echo $registro->getFecha('d/m/y') ?></font></td>
            
                <td style=" border: 0.2px solid #B8B8B8;"width="90px" align="right"><font size="-1"><?php echo number_format($registro->getValor(), 2); ?></font></td>
                <td style=" border: 0.2px solid #B8B8B8;" width="70px" align="right"><font size="-1"><?php echo number_format($registro->getValorMora(), 2); ?></font></td>
                <td style=" border: 0.2px solid #B8B8B8;" width="65px" align="center"><font size="-1"><?php echo $registro->getFechaPago('d/m/y'); ?></font></td>
                <td style=" border: 0.2px solid #B8B8B8;" width="75px" align="center">  <font size="-1"><?php echo $registro->getCodigoPago(); ?></font> </td>
                <td  style=" border: 0.2px solid #B8B8B8;"width="90px"align="right"><font size="-1"><?php echo number_format($registro->getValorPagado(), 2); ?></font></td>
            </tr>
        <?php } ?>
    <?php } ?>

            <tr>
                <td  width="50px"></td>
                <td colspan="3"  width="305px"> <font size="+1">
                    <strong>Totales</strong></font></td>
            
                <td width="90px" align="right"><font size="+1"><?php echo number_format($total1, 2); ?></font></td>
                <td  width="70px" align="right"><font size="+1"><?php echo number_format($total2, 2); ?></font></td>
                <td  width="65px"><font size="-1"><?php //echo $registro->getFechaPago('d/m/Y H:i'); ?></font></td>
                <td  width="75px">  <font size="-1"><?php //echo $registro->getCodigoPago(); ?></font> </td>
                <td  width="90px" align="right"><font size="+1"><?php echo number_format($total3, 2); ?></font></td>
            </tr>

</table>
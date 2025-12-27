<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>
        <td  width="50px"> </td>
        <td width="590px" style="border: 0.2px solid #5E80B4;">
            <table cellspacing="1" cellpadding="3"   width="590px">
                   <tr>
                       <td  colspan="3"  width="425px" style="font-size:35px;"> <strong>Recibimos de </strong> <?php echo  $contranse->getProveedor(); ?> </td>

                    <td></td>
                </tr>
                   <tr>
                       <td  colspan="3"  width="425px" style="font-size:30px;"> Los siguientes documentos </td>

                    <td></td>
                </tr>
                
                <?php $total = 0; ?>
                <?php foreach ($lista as $registro) { ?>
                    <?php $gasto = GastoQuery::create()->findOneById($registro->getGastoId()); ?>
                    <?php if ($gasto) { ?>
                        <?php $total = $total + $gasto->getValorTotal(); ?>
                        <tr>
                            <td  width="80px" style="font-size:25px;color:#063173"><?php echo $gasto->getTipoDocumento(); ?></td>
                            <td  width="240px" style="font-size:30px;"><strong><?php echo $gasto->getDocumento(); ?> </strong> </td>
                            <td  width="125px" style="font-size:35px; text-align:right "><?php echo Parametro::formato($gasto->getValorTotal(), true); ?>&nbsp;&nbsp; </td>
                            <td  width="100px" ></td>
                        </tr>
                    <?php } ?>


                <?php } ?>
                        
                          <?php foreach ($lista as $registro) { ?>
                    <?php $gasto = OrdenProveedorQuery::create()->findOneById($registro->getOrdenProveedorId()); ?>
                    <?php if ($gasto) { ?>
                        <?php $total = $total + $gasto->getValorTotal(); ?>
                        <tr>
                            <td  width="80px" style="font-size:25px;color:#063173"><?php echo $gasto->getSerie(); ?></td>
                            <td  width="240px" style="font-size:30px;"><strong><?php echo $gasto->getNoDocumento(); ?> </strong> </td>
                            <td  width="125px" style="font-size:35px; text-align:right "><?php echo Parametro::formato($gasto->getValorTotal(), true); ?>&nbsp;&nbsp; </td>
                            <td  width="100px" ></td>
                        </tr>
                    <?php } ?>


                <?php } ?>
                        
                <tr>
                    <td  colspan="2"  width="320px" style="text-align:right;font-size:35px;"> <strong>Total</strong> </td>

                    <td  width="125px" style="font-size:40px; text-align:right;color:#063173 "><strong><?php echo Parametro::formato($total, true); ?>&nbsp;&nbsp;</strong> </td>
                    <td></td>
                </tr>
                
                 <tr>
                    <td colspan="3"></td>
                    <td> </td>
                </tr>
                <tr>
                    <td colspan="3">Para pagar el día <?php echo $contranse->getFechaPago('d/m/Y'); ?></td>
                    <td style="border-top: 0.08px;"> Recibido Por:</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>
        <td  width="50px"> </td>
        <td  width="320px" style="text-align:left;font-size:35px;">CONFIRMACIÓN DE PAGOS </td>
        <td  width="50px"> </td>
        <td  width="320px" style="text-align:left;font-size:35px;">ÚNICO DÍA DE PAGO </td>
    </tr>
        <tr>
        <td  width="50px"> </td>
        <td  width="320px" style="text-align:left;font-size:30px;">Viernes de 11:30 a 13:00 horas </td>
        <td  width="50px"> </td>
        <td  width="320px" style="text-align:left;font-size:30px;">Viernes de 14:00 a 16:00 horas </td>
    </tr>
</table>
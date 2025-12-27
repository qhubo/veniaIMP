<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>
        <td  width="150px"> <img width="140px" alt="Logo" src="/uploads/images/<?php echo $logo; ?>"></td>
        <td width="590px" style="border: 0.2px solid #5E80B4;">
            <table cellspacing="1" cellpadding="3"   width="590px">
                <tr>
                    <td  width="60px" style="font-size:25px;color:#063173">Reporte</td>
                    <td  width="330px" style="font-size:40px;"><strong><?php echo $titulo; ?> </strong> </td>
                    <td  width="75px" style="font-size:25px;color:#063173"><?php if ($referencia) { ?> Ref# <?php } ?> </td>
                    <td  width="125px" style="font-size:45px; text-align:right "><?php echo $referencia; ?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
                </tr>
                <tr>
                    <td  width="90px" style="font-size:25px;color:#063173"><?php if ($nombre2 <> '') { ?><?php echo html_entity_decode($nombre2); ?><?php } else { ?>Observaciones<?php } ?>
                    </td>
                    <td  width="300px" style="font-size:40px;"><?php echo html_entity_decode($observaciones); ?></td>
                    <td  width="95px" style="font-size:25px;color:#063173">Fecha Impresion</td>
                    <td  width="105px" style="font-size:25px;"><?php echo date('d/m/Y H:i'); ?> </td>
                </tr>
            </table>

            
            

        </td>
    </tr>
</table>
<br>
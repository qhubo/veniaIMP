<style>
    .titulo {
        color:#ffdf00;
        font-weight: bold;
        font-size: 40px;
        display: block;
    }
    .titulon {
        color:#ffdf00;
        font-weight: bold;
        font-size: 50px;
        display: block;
    }
    .dere {
        border-right-color:black;  
        border-right-style: solid;
    }
    .izqui {
        border-left-color:black;  
        border-left-style: solid;
    }
    .arriba {
        border-top-color:black;  
        border-top-style: solid;
    }
    .abajo {
        border-bottom-color:black;  
        border-bottom-style: solid;
    }
</style>
<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>
        <td  width="150px"> <img width="140px" alt="Logo" src="/uploads/images/<?php echo $logo; ?>"></td>
        <td width="590px" style="border: 0.2px solid #5E80B4;">
            <table cellspacing="1" cellpadding="3"   width="590px">
                <tr>
                    <td  width="90px" style="font-size:30px;"><strong>Cliente</strong> </td>
                    <td  width="300px" style="font-weight: bold; font-size:40px;color:#063173"><?php echo html_entity_decode($observaciones); ?>
                    </td>
                    <td  width="75px" style="font-size:30px;color:#063173"><?php if ($referencia) { ?> Codigo# <?php } ?> </td>
                    <td  width="125px" style="font-size:45px; text-align:right "><?php echo $referencia; ?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
                </tr>
                <tr>

                    <td  width="90px" style="font-size:30px;"><strong>Direccion</strong> </td>
                    <td  width="300px" style=" font-size:30px;color:#063173"><?php echo html_entity_decode($cliente->getDireccion()); ?>
                    </td>
                    <td  width="95px" style="font-size:25px;color:#063173">Telefono</td>
                    <td  width="105px" style="font-size:25px;"><?php echo $cliente->getTelefono(); ?> </td>
                </tr>
                <tr>
                    <td  width="90px" style="font-size:30px;"><strong>Correo</strong> </td>
                    <td  width="300px" style=" font-size:30px;color:#063173"><?php echo html_entity_decode($cliente->getCorreoElectronico()); ?>
                    </td>
                    <td  width="95px" style="font-size:25px;color:#063173">Fecha Impresion</td>
                    <td  width="105px" style="font-size:25px;"><?php echo date('d/m/Y H:i'); ?> </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table style="width: 90%" width='90%'>
    <tr>
        <td class="arriba abajo izqui" style="height: 25px; font-weigth:bold; text-align: center" >Fecha</td>
        <td class="arriba abajo izqui" style="height: 15px; font-weigth:bold; text-align: center" >Factura</td>
        <td class="arriba abajo izqui" style="height: 15px; font-weigth:bold; text-align: center" >Estado</td>
        <td class="arriba abajo izqui" style="height: 15px; font-weigth:bold; text-align: center" >Valor Total</td>
        <td class="arriba abajo izqui" style="height: 15px; font-weigth:bold; text-align: center" >Valor Pagado</td>
        <td class="arriba abajo izqui dere" style="height: 15px; font-weigth:bold; text-align: center" >Saldo</td>
    </tr>
    <?php $total1 = 0; ?>
    <?php $total2 = 0; ?>
    <?php $total3 = 0; ?>
    <?php foreach ($operaciones as $registr) { ?>
        <?php $saldo = $registr->getValorTotal() - $registr->getValorPagado(); ?>
        <?php $total1 = $registr->getValorTotal()+ $total1; ?>
    <?php $total2 = $registr->getValorPagado() + $total2; ?>
    <?php $total3 = $saldo+ $total3; ?>
        <tr>
            <td class="arriba abajo izqui"><?php echo $registr->getFecha('d/m/Y'); ?></td>
            <td class="arriba abajo izqui"><?php echo $registr->getCodigo(); ?></td>
            <td class="arriba abajo izqui"><?php echo $registr->getEstatus(); ?></td>
            <td class="arriba abajo izqui" style="height: 18px; text-align:right" ><?php echo Parametro::formato($registr->getValorTotal()); ?></td>
            <td class="arriba abajo izqui" style="text-align:right" ><?php echo Parametro::formato($registr->getValorPagado()); ?></td>
            <td class="arriba abajo izqui dere" style="text-align:right" ><?php echo Parametro::formato($saldo); ?></td>
        </tr>    
    <?php } ?>

        <tr>
            <td colspan="3" style="height: 15px; font-weigth:bold; font-size: 37px; text-align: center" > Totales </td>
                     <td class="arriba abajo izqui" style="font-weigth:bold; font-size: 37px;height: 22px; text-align:right" ><?php echo Parametro::formato($total1); ?></td>
            <td class="arriba abajo izqui" style="font-weigth:bold; font-size: 37px;text-align:right" ><?php echo Parametro::formato($total2); ?></td>
            <td class="arriba abajo izqui dere" style="font-weigth:bold; font-size: 37px; text-align:right" ><?php echo Parametro::formato($total3); ?></td>
  
        </tr>
        
</table>

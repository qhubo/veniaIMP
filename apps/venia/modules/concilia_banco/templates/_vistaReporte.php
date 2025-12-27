
<?php $valor = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), '', 'seguridad'); ?>
<?php $ValorBanco = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'conciliado'); ?>
<?php $retorna =0; // sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'diferencia'); ?>

               <?php $valor = $banco->getHsaldoBanco($dia); ?>              
                <?php $ValorBanco = $banco->getHsaldoConciliado($dia); ?>   
                <?php $retorna = $banco->getHDiferencia($dia); ?>



<table width="740px">

    <tr>
        <th  style="text-align: left; padding-left: 40px">Banco</th>
        <td  ><?php echo $banco->getNombre(); ?> </td>
    </tr>
    <tr>
        <th  style="text-align: left; padding-left: 40px">Saldo en  Libros</th>
        <td   style="text-align: right; padding-right: 40px"><?php echo Parametro::formato($banco->getHSaldoLibros($dia)); ?> </td>
    </tr>
    <tr>
        <th  style="text-align: left; padding-left: 40px">Saldo en  Bancos</th>
        <td   style="text-align: right; padding-right: 40px"><?php echo Parametro::formato($valor); ?> </td>

    </tr>
</table>
<br>

<?php include_partial('concilia_banco/transitoReporte', array('banco' => $banco,'dia'=>$dia)) ?>  
<br>
<br>

<table width="740px">
    <tr>
        <th  style="text-align: left; padding-left: 40px">Saldo Conciliado</th>
        <td   style="text-align: right; padding-right: 40px"><?php echo Parametro::formato($ValorBanco); ?> </td>
    </tr>
    <tr>
        <th  style="text-align: left; padding-left: 40px">Diferencia</th>
        <td   style="text-align: right; padding-right: 40px"><?php echo Parametro::formato($retorna); ?> </td>

    </tr>
</table>



<br>

<?php $listaDepo = $banco->getDepositoTransito(0, $dia); ?>
<table width="740px" style="">
    <tr>
        <td width="80px" style="text-align: center; " > </td>
        <td width="660px" colspan="3" style="text-align: center; " ><strong> DEPOSITOS EN TRÁNSITO</strong> </td>
    </tr>
    <tr>
        <td width="80px" style="text-align: center; border: 1px solid #c7d0df; " ><strong> Fecha</strong> </td>
        <td width="220px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Tienda </strong></td>
        <td width="300px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Observaciones </strong></td>
        <td width="150px"  style="text-align: center; border: 1px solid #c7d0df;"> <strong>Valor </strong></td>
    </tr>
    <?php foreach ($listaDepo as $regi) { ?>
        <tr>
            <td width="80px"  style="text-align: center; border: 1px solid #c7d0df;"><font size="-1"> <?php echo $regi->getFechaDocumento('d/m/Y'); ?></font> </td>
            <td width="220px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getTienda(); ?></font></td>
            <td width="300px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getObservaciones(); ?> </font></td>
            <td width="150px"  style="text-align: right; border: 1px solid #c7d0df; padding-right: 20px"><font size="-1"><?php echo Parametro::formato($regi->getValor(), false); ?></font>&nbsp;&nbsp;</td>
        </tr>
    <?php } ?>
</table>

<br>

<?php $listaDepo = $banco->getNotasCreditoTransito(0, $dia); ?>
<table width="740px" style="">
    <tr>
        <td width="80px" style="text-align: center; " > </td>
        <td width="660px" colspan="3" style="text-align: center; " ><strong> NOTAS DE CREDITO EN TRÁNSITO</strong> </td>
    </tr>
    <tr>
        <td width="80px" style="text-align: center; border: 1px solid #c7d0df; " ><strong> Fecha</strong> </td>
        <td width="220px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Tienda </strong></td>
        <td width="300px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Observaciones </strong></td>
        <td width="150px"  style="text-align: center; border: 1px solid #c7d0df;"> <strong>Valor </strong></td>
    </tr>
    <?php foreach ($listaDepo as $regi) { ?>
        <tr>
            <td width="80px"  style="text-align: center; border: 1px solid #c7d0df;"><font size="-1"> <?php echo $regi->getFechaDocumento('d/m/Y'); ?></font> </td>
            <td width="220px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getTienda(); ?></font></td>
            <td width="300px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getObservaciones(); ?> </font></td>
            <td width="150px"  style="text-align: right; border: 1px solid #c7d0df; padding-right: 20px"><font size="-1"><?php echo Parametro::formato($regi->getValor(), false); ?></font>&nbsp;&nbsp;</td>
        </tr>
    <?php } ?>
</table>



<br>
<?php $listaDepo = $banco->getNotasChequesCircula(0, $dia); ?>
<table width="740px" style="">
    <tr>
        <td width="80px" style="text-align: center; " > </td>
        <td width="660px" colspan="3" style="text-align: center; " ><strong> CHEQUES EN CIRCULACIÓN</strong> </td>
    </tr>
    <tr>
        <td width="80px" style="text-align: center; border: 1px solid #c7d0df; " ><strong> Fecha</strong> </td>
        <td width="220px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Tienda </strong></td>
        <td width="300px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Observaciones </strong></td>
        <td width="150px"  style="text-align: center; border: 1px solid #c7d0df;"> <strong>Valor </strong></td>
    </tr>
    <?php foreach ($listaDepo as $regi) { ?>
        <tr>
            <td width="80px"  style="text-align: center; border: 1px solid #c7d0df;"><font size="-1"> <?php echo $regi->getFechaDocumento('d/m/Y'); ?></font> </td>
            <td width="220px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getTienda(); ?></font></td>
            <td width="300px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getObservaciones(); ?> </font></td>
            <td width="150px"  style="text-align: right; border: 1px solid #c7d0df; padding-right: 20px"><font size="-1"><?php echo Parametro::formato($regi->getValor(), false); ?></font>&nbsp;&nbsp;</td>
        </tr>
    <?php } ?>
</table>



<br>
<?php $listaDepo = $banco->getNotasDebitoTransito(0, $dia); ?>
<table width="740px" style="">
    <tr>
        <td width="80px" style="text-align: center; " > </td>
        <td width="660px" colspan="3" style="text-align: center; " ><strong> NOTAS DE DÉBITO EN TRANSITO</strong> </td>
    </tr>
    <tr>
        <td width="80px" style="text-align: center; border: 1px solid #c7d0df; " ><strong> Fecha</strong> </td>
        <td width="220px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Tienda </strong></td>
        <td width="300px"  style="text-align: center; border: 1px solid #c7d0df;"><strong>Observaciones </strong></td>
        <td width="150px"  style="text-align: center; border: 1px solid #c7d0df;"> <strong>Valor </strong></td>
    </tr>
    <?php foreach ($listaDepo as $regi) { ?>
        <tr>
            <td width="80px"  style="text-align: center; border: 1px solid #c7d0df;"><font size="-1"> <?php echo $regi->getFechaDocumento('d/m/Y'); ?></font> </td>
            <td width="220px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getTienda(); ?></font></td>
            <td width="300px"  style="text-align: left; border: 1px solid #c7d0df;  padding-left: 10px">&nbsp;&nbsp;<font size="-1"><?php echo $regi->getObservaciones(); ?> </font></td>
            <td width="150px"  style="text-align: right; border: 1px solid #c7d0df; padding-right: 20px"><font size="-1"><?php echo Parametro::formato($regi->getValor(), false); ?></font>&nbsp;&nbsp;</td>
        </tr>
    <?php } ?>
</table>





<?php $total = $banco->getSaldo(); ?>

<table class="table  " width="100%">
    <tbody>
        <tr style="background-color:#ebedf2">
            <th align="center" >Movimiento</th>
            <th align="center" width="10px">Tipo</th>
            <th align="center" width="100px"> Valor</th>
        </tr>
        <?php $total = $total + $banco->getDepositoTransito() + $banco->getNotasCreditoTransito() + $banco->getNotasChequesCircula() + $banco->getNotasDebitoTransito(); ?>
        <tr>
            <td>DEPOSITOS EN TRÁNSITO</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getDepositoTransito()), false); ?></th>
        </tr>
        <tr>
            <td>NOTAS DE CREDITO EN TRÁNSITO</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getNotasCreditoTransito()), false); ?></th>
        </tr>
        <tr>
            <td>CHEQUES EN CIRCULACIÓN</td>
            <td style="text-align: center">-</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getNotasChequesCircula()), false); ?></th>
        </tr>
        <tr>
            <td>NOTAS DE DÉBITO EN TRANSITO</td>
            <td style="text-align: center">-</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getNotasDebitoTransito()), false); ?></th>
        </tr>
<!--        <tr style="background-color:#ebedf2">
            <th align="center" ><strong>SALDO CONCILIADO</strong></th>
            <th align="center" width="10px"></th>
            <th style="text-align: right"> <?php echo Parametro::formato($total, false); ?></th>

        </tr>-->
    </tbody>
</table>
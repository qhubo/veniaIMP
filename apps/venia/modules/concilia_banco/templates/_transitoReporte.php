
<?php $total = $banco->getSaldo(); ?>

<table class="table  " width="740px">
    <tbody>
        <tr style="background-color:#ebedf2">
            <th align="center" width="400px" >Movimiento</th>
            <th align="center" width="100px">Tipo</th>
            <th align="center" width="240px"> Valor</th>
        </tr>
        <?php $total = $total + $banco->getHDepositoTransito($dia) + $banco->getHNotasCreditoTransito($dia) + $banco->getHNotasChequesCircula($dia) + $banco->getHNotasDebitoTransito($dia); ?>
        <tr>
            <td>DEPOSITOS EN TRÁNSITO</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getHDepositoTransito($dia)), false); ?></th>
        </tr>
        <tr>
            <td>NOTAS DE CREDITO EN TRÁNSITO</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getHNotasCreditoTransito($dia)), false); ?></th>
        </tr>
        <tr>
            <td>CHEQUES EN CIRCULACIÓN</td>
            <td style="text-align: center">-</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getHNotasChequesCircula($dia)), false); ?></th>
        </tr>
        <tr>
            <td>NOTAS DE DÉBITO EN TRANSITO</td>
            <td style="text-align: center">-</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getHNotasDebitoTransito($dia)), false); ?></th>
        </tr>
<!--        <tr style="background-color:#ebedf2">
            <th align="center" ><strong>SALDO CONCILIADO</strong></th>
            <th align="center" width="10px"></th>
            <th style="text-align: right"> <?php echo Parametro::formato($total, false); ?></th>

        </tr>-->
    </tbody>
</table>

<?php $total = $banco->getSaldo(); ?>

<table class="table  " width="100%">
    <tbody>
        <tr style="background-color:#ebedf2">
            <th align="center" >Movimiento</th>
            <th align="center" width="10px">Tipo</th>
            <th align="center" width="100px"> Valor</th>
        </tr>
        <tr>
            <td>DEPOSITOS EN TRÁNSITO</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getHDepositoTransito($dia)), false); ?></th>
        </tr>
        <tr>
            <td>NOTAS DE CREDITO EN TRÁNSITO</td>
            <td style="text-align: center">+ </td>
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

    </tbody>
</table>
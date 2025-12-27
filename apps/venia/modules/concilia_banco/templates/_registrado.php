
<?php $total = $banco->getSaldo(); ?>
<?php $total = $banco->getDepositoRegistrar() + $banco->getNotasRegistrar() + $banco->getAjusteVarios() + $banco->getChequesRegistrar() + $banco->getDebitoRegistrar(); ?>
<table class="table  ">
    <tbody>
        <tr style="background-color:#ebedf2">
            <th align="center" >Movimiento</th>
            <th align="center" width="10px">Tipo</th>
            <th align="center" width="100px"> Valor</th>
        </tr>
        <tr>
            <td>DEPOSITOS A REGISTRAR</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"><?php echo Parametro::formato($banco->getDepositoRegistrar(), false); ?></th>
        </tr>
        <tr>
            <td>NOTAS DE CREDITO A REGISTRAR</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"><?php echo Parametro::formato(abs($banco->getNotasRegistrar()), false); ?></th>
        </tr>
        <tr>
            <td>AJUSTES VARIOS</td>
            <td style="text-align: center">+</td>
            <th style="text-align: right"><?php echo Parametro::formato(abs($banco->getAjusteVarios()), false); ?></th>
        </tr>

        <tr>
            <td>CHEQUES POR REGISTRAR</td>
            <td style="text-align: center">-</td>
            <th style="text-align: right"> <?php echo Parametro::formato(abs($banco->getChequesRegistrar()), false); ?></th>
        </tr>
        <tr>
            <td>NOTAS DE DÉBITO EN REGISTRAR</td>
            <td style="text-align: center">-</td>
            <th style="text-align: right"><?php echo Parametro::formato(abs($banco->getDebitoRegistrar()), false); ?></th>
        </tr>
<!--                                <tr style="background-color:#ebedf2">
<th align="center" ><strong>SALDO CONCILIADO</strong></th>
<th align="center" width="10px"></th>
<th style="text-align: right"> <?php echo Parametro::formato($total, false); ?></th>

</tr>-->
    </tbody>
</table>
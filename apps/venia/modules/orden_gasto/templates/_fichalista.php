<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success">Concepto </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor </span></th>
        </tr>
    </thead>
    <tbody><?php $can = 0; ?>
        <?php foreach ($lista as $data) { ?>
            <?php $can++; ?>
            <?php $nombre = ''; ?>
            <?php $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($data->getCuentaContable()); ?>
            <?php
            if ($cuentaQ) {
                $nombre = $cuentaQ->getNombre();
            }
            ?>
            <tr>
                <td><?php echo $can; ?> </td>
         
                <td><?php echo $data->getConcepto(); ?> </td>
                <td><?php echo $data->getCantidad(); ?> </td>
                <td> <div style="text-align: right"> <?php echo number_format((float) ($data->getValorTotal()), 2, '.', ''); ?></div> </td>

            </tr>
        <?php } ?>

 
              <tr>
                <td><?php //echo $can;  ?></td>
                <td colspan="3" style="text-align: right"><font size="+2"> <strong> Valor  a Pagar </strong></font>  </td>
                <td> <div style="text-align: right"> <font size="+2"> <strong><?php echo Parametro::formato($orden->getValorTotal()); //, 2, '.', '');  ?> </strong></font> </div> </td>
                <td colspan="2"></td>
            </tr>
    </tbody>

</table>
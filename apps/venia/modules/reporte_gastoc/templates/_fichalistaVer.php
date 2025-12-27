<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success">Cuenta Contable </span></th>
            <th  align="center"><span class="kt-font-success">Concepto </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor </span></th>
         
   

        </tr>
    </thead>
    <tbody><?php $can=0; ?>
          <?php foreach ($lista  as $data) { ?>
        <?php $can++; ?>
            <?php $nombre = ''; ?>
        <?php $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($data->getCuentaContable()); ?>
        <?php if ($cuentaQ) {
            $nombre = $cuentaQ->getNombre();
        } ?>
        <tr>
                 <td><?php echo $can; ?> </td>
         <td><?php echo $data->getCuentaContable() . " " . $nombre; ?> </td>
            <td><?php echo $data->getConcepto(); ?> </td>
            <td><?php echo $data->getCantidad(); ?> </td>
            <td> <div style="text-align: right"> <?php echo Parametro::formato($data->getValorTotal()); //, 2, '.', ''); ?></div> </td>
                </tr>
          <?php } ?>
                <?php if ($orden->getValorImpuesto() >0) { ?>
                <tr>
                    <td><?php echo $can; ?></td>
                     <td>ISR</td>
                      <td>Valor Retenido</td>
                       <td></td>
                       <td> <div style="text-align: right"> <?php echo Parametro::formato($orden->getValorImpuesto()*-1); //, 2, '.', ''); ?></div> </td>
     
                </tr>
                <?php } ?>
    </tbody>
    
</table>
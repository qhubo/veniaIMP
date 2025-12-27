<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
         

        </tr>
    </thead>
    <tbody><?php $can=0; ?>
          <?php foreach ($lista  as $registro) { ?>
        <?php $can++; ?>
        <tr>
                 <td><?php echo $can; ?> </td>
            <td><?php echo $registro->getDetalle(); ?>
                <font size="-1">
            <?php echo $registro->getObservaciones(); ?>
                </font>
            </td> 

              <td  style="text-align: right" ><?php echo $registro->getCantidad(); ?></td> 
                    <td style="text-align: right" ><?php echo  number_format((float) ($registro->getValorTotal()), 2, '.', ','); ?></td>

        </tr>
          <?php } ?>
    </tbody>
    
</table>
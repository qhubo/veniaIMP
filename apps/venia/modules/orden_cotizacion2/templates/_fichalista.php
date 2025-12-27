<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success">Producto  </span></th>
            <th  align="center"><span class="kt-font-success">Servicio </span></th>
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Valor Unitario </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
            <th>Iva</th>

        </tr>
    </thead>
    <tbody><?php $can=0; ?>
          <?php foreach ($lista  as $registro) { ?>
        <?php $can++; ?>
        <tr>
                 <td><?php echo $can; ?> </td>
            <td><?php if ($registro->getProductoId()) { echo  $registro->getProducto()->getCodigoSku(); } ?></td>    
            <td><?php if ($registro->getServicioId()) { echo  $registro->getServicio()->getCodigo(); } ?></td>    
            <td><?php echo $registro->getDetalle(); ?></td> 
            <td style="text-align: right" ><?php echo  number_format((float) ($registro->getValorUnitario()), 2, '.', ''); ?></td>

              <td  style="text-align: right" ><?php echo $registro->getCantidad(); ?></td> 
                          <td style="text-align: right" ><?php echo  number_format((float) ($registro->getValorTotal()), 2, '.', ''); ?></td>
            <td style="text-align: right" ><?php echo  number_format((float) ($registro->getTotalIva()), 2, '.', ''); ?></td>

        </tr>
          <?php } ?>
    </tbody>
    
</table>
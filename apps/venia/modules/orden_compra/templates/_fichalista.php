<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr <?php if ($orden->getEstatus()=="Autorizado") { ?>
        style="background-color:  #D1DEF6" <?Php } ?> >
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success">Producto/Servicio </span></th>
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Detalle </span></th>
            
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
            <td><?php if ($registro->getProductoId()) { echo  substr($registro->getProducto()->getCodigoSku(),-6); } ?>
                <?php if ($registro->getServicioId()) { echo  substr($registro->getServicio()->getCodigo(),-6); } ?></td>    
            <td <?php if ($orden->getEstatus()=="Autorizado") { ?>
        style="background-color:  #D1DEF6" <?Php } ?> ><?php echo $registro->getDetalle(); ?></td> 
            <td <?php if ($orden->getEstatus()=="Autorizado") { ?>
        style="background-color:  #D1DEF6" <?Php } ?> ><?php echo $registro->getObservaciones(); ?></td> 
            
            <td style="text-align: right" ><?php echo Parametro::formato($registro->getValorUnitario()); ?></td>

              <td  style="text-align: right" ><?php echo $registro->getCantidad(); ?></td> 
                          <td style="text-align: right" ><?php echo Parametro::formato($registro->getValorTotal()); ?></td>
            <td style="text-align: right" ><?php echo Parametro::formato($registro->getTotalIva()); ?></td>

        </tr>
          <?php } ?>
    </tbody>
    
</table>
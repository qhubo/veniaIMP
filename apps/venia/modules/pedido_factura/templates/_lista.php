
<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
<!--            <th  align="center"><span class="kt-font-success"># </span></th>-->
            <th  align="center"><span class="kt-font-success">Codigo  </span></th><!--            
            <th  align="center"><span class="kt-font-success">Servicio </span></th>-->
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Valor Unitario </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
            <th></th>
           

        </tr>
    </thead>

    
    <tbody>
        <?php foreach ($detalle as $registro) { ?>
            <tr>
                <td><?php echo $registro->getCodigo(); ?></td>
                <td><?php echo $registro->getDetalle(); ?></td>
                <td style="text-align: right">
                     <?php if ($registro->getProductoId()) { ?>
                    <?php echo Parametro::formato($registro->getValorUnitario(),false); ?>
                     <?php } else { ?>
             <input class="form-control"   name="valor<?php echo $registro->getId(); ?>" id="valor<?php echo $registro->getId(); ?>" type="text"  value="<?php echo $registro->getValorUnitario(); ?>" >         

                     <?php } ?>
                
                </td>
                <td style="text-align: right"><?php echo $registro->getCantidad(); ?></td>
                <td style="text-align: right; font-weight:bold;">
          <input style="background-color:#F0F8FA"  class="form-control" id="linea<?php echo $registro->getId(); ?>" name="linea<?php echo $registro->getId(); ?>" readonly="1"  value="<?php echo Parametro::formato($registro->getValorTotal(),false); ?>">
     
                    </td>
                 <td>
                     <?php if (!$registro->getProductoId()) { ?>
                     <a href="<?php echo url_for($modulo . '/eliminaLinea?id='.$registro->getId()) ?>" class="btn btn-sm  btn-danger" > -  </a></td>
                     <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"> TOTALES</td>
            <th style="text-align: right;"> 
                <div name="total" id="total">
               <?php echo Parametro::formato($operacion->getValorTotal()); ?> 
                </div>
                </th>
            <th></th>
        </tr>
    </tfoot>
    
</table>
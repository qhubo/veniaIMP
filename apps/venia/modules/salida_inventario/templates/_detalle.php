   <form action="<?php echo url_for($modulo . '/confirmar?id=0') ?>" method="post">
            <table class="table-bordered table-checkable xdataTable no-footer xkt-datatable" xid="html_table" width="100%">

                <thead class="flip-content">
                    <tr class="active">          
                        <th  align="center"> Código Sku</th>
                        <th  align="center"> Nombre</th>
                         <th  align="center">Existencia</th>
                        <th>Salida</th>
    
                    </tr>
                </thead>
                <tbody>
                    <?php $TOTAL = 0 ?>
             
                        <?php if ($linea) { ?>
                            <?php foreach ($linea as $lista) { ?>
                   
                                <?php $productoId = $lista['productoId']; ?>
                                <tr   <?php if ($lista['valido'] == 0) { ?>    class="danger"         <?php } ?>  >

                                    <td><?php echo $lista['Codigo'] ?> </td>

                                    <?php if ($lista['productoId']) { ?>
                                    <td><?php echo html_entity_decode($lista['nombre']) ?></td>
                                     
                                    <?php } ?>
                                    <?php if (!$lista['productoId']) { ?>
                                        <td><strong>Código de producto no valido </strong></td>
                                    <?php } ?>
                                    <td align="right">
                                        <?php if ($lista['valido']) { ?>
                                            <?php echo $lista['existencia'] ?>
                                        <?php } ?>
                                    </td>
                                    <td width="150px">
                                        <?php if ($lista['valido']) { ?>
                                            <?php $TOTAL = $TOTAL + (INT) $lista['Cantidad']; ?> 
                                        <?php //echo $TOTAL; ?>
                                            <input  max="<?php echo $lista['existencia']; ?>"  class="form-control cantidad" placeholder="0" value="<?php echo $lista['Cantidad'] ?>" type="number" name="valor<?php echo $productoId ?>" id="valor<?php echo $productoId ?>"   >
                                        <?php } ?>  
                                    </td>                                  
                                </tr>
                                
                           
                            <?php } ?>
                        <?php } ?>                                
                
                </tbody>
                <tfoot>
                </tfoot>
            </table>



                    <?php if ($TOTAL >0) { ?>   
                        
                <div class="row">
                    <div class="col-lg-6">
                        Confirmar Salida Inventario    <?php //echo $bodega->getNombre(); ?>     
                    </div>
                    <div class="col-lg-2">Items  <input type="hidden"   value="<?php echo $estadob ?>"  name="estado" id="estado" >  </div>
                    <div class="col-lg-1"> <input class="form-control " readonly="true"  type="text" id="res_total" name="res_2111total" value="<?php echo $TOTAL ?>" ></div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary btn-block  btn-block"
                                procesa="procesa"
                                type="submit">
                            <i class="fa fa-check "></i>
                            <span>Procesar</span>
                        </button>
                    
                    </div>
                </div>
                    <?PHP } ?>

            <?php echo '</form>'; ?>              
        </div>
    </div>
</div>


        <script>
    const inputs = document.querySelectorAll('.cantidad');

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        const max = Number(input.getAttribute('max'));
        const min = Number(input.getAttribute('min'));
        let valor = Number(input.value);

        if (valor > max) {
          input.value = max; // Forzar el valor máximo
        } else if (valor < min) {
          input.value = min; // Evitar valores negativos
        }
      });
    });
  </script>
        
<div class="row" style="padding-top: 20px; padding-bottom: 20px;">
    <div class="col-lg-12"> 
        <div class="table-scroll-container" style="width: 100%;">

            <!-- Scroll superior -->
            <div class="table-scroll-top" style="overflow-x: auto; overflow-y: hidden;">
                <div></div>
            </div>

            <!-- Scroll inferior (normal) -->
            <div class="table-scroll-bottom" style="overflow-x: auto;">
                <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin " width="100%">
                    <thead >
                        <tr class="active">

                            <th  align="center"><span class="kt-font-success">Fecha</span></th>


                            <th  align="center"><span class="kt-font-success">Vendedor   </span></th>
                            <th  align="center"><span class="kt-font-success">Usuario</span></th>

                            <th  align="center"><span class="kt-font-success">Código Producto</span></th>
                            <th  align="center"><span class="kt-font-success">Descripcion</span></th>
                            <th  align="center"><span class="kt-font-success">Valor Unitario </span></th>
                            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
                            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
                                <th  align="center"><span class="kt-font-success">Valor Neto </span></th>
                             <th  align="center"><span class="kt-font-success">Costo Total </span></th>
                                 <th  align="center"><span class="kt-font-success">Margen </span></th>
                            <th  align="center"><span class="kt-font-success">Código Factura </span></th>
                            <th  align="center"><span class="kt-font-success">Cliente </span></th>
                            <th  align="center"><span class="kt-font-success">Nombre Factura</span></th>
                            <th  align="center"><span class="kt-font-success"> Estatus</span></th>
                            <th  align="center"><span class="kt-font-success">Valor Factura</span></th>
                            <th  align="center"><span class="kt-font-success">Valor Pagado</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $conta = 0; ?>
                        <?php foreach ($registros as $reg) { ?>
                            <?php //$data = $reg->getGasto(); ?>
                            <?php $conta++; ?>
                     <?php       $valor_neto = $reg['cantidad'] * $reg['valor_unitario']; ?>
            <?php  $valor_neto = $valor_neto / 1.12; ?>
    <?php $valorCosto = round($reg['cantidad'] * $reg['costo_proveedor'], 1); ?>
       <?php   $valorMargen = $valor_neto - $valorCosto; ?>
                            <tr>
                                <td><?php echo $reg['fecha']; ?></td>


                                <td><?php echo $reg['vendedor']; ?></td>
                                <td><?php echo $reg['usuario']; ?>
                                    <br>
                                    <?php echo substr($reg['tienda'],0,20); ?>
                                
                                
                                </td>

                                <td><?php echo $reg['codigo_producto']; ?></td>


                                <td><?php echo $reg['detalle']; ?></td>

                                <td style="text-align: right;"> <?php echo Parametro::formato($reg['valor_unitario'], 2); ?></td>
                                <td style="text-align: right;"><?php echo $reg['cantidad']; ?></td>
                                <td style="text-align: right;"><?php echo Parametro::formato($reg['cantidad'] * $reg['valor_unitario'], 2); ?></td>
                                 <td style="text-align: right;"><?php echo Parametro::formato($valor_neto, 2); ?></td>
                                <td style="text-align: right;"><?php echo Parametro::formato($reg['cantidad'] * $reg['costo_proveedor'], 2); ?></td>
   <td style="text-align: right;"><?php echo Parametro::formato($valorMargen, 2); ?></td>
                                <td><?php echo $reg['codigo_factura']; ?></td>
                                <td><?php  if ($reg['cliente'] <> "CONTRAENTREGA") echo $reg['cliente']; ?></td>
                                <td><?php echo $reg['nombre']; ?></td>
                                <td><?php echo $reg['estatus']; ?></td>
                                <td style="text-align: right;"><?php echo Parametro::formato($reg['valor_total'], 2); ?></td>
                                <td style="text-align: right;"><?php echo Parametro::formato($reg['valor_pagado'], 2); ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const topScroll = document.querySelector('.table-scroll-top');
        const bottomScroll = document.querySelector('.table-scroll-bottom');

        // Sincroniza ambos scrolls
        const innerDiv = topScroll.querySelector('div');
        innerDiv.style.width = bottomScroll.scrollWidth + 'px';

        topScroll.addEventListener('scroll', function () {
            bottomScroll.scrollLeft = topScroll.scrollLeft;
        });
        bottomScroll.addEventListener('scroll', function () {
            topScroll.scrollLeft = bottomScroll.scrollLeft;
        });
    });
</script>
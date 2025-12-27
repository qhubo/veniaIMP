    <div class="table-scrollable">

                    <table class="table table-bordered  dataTable table-condensed flip-content" >
                       
                            <tr >
                                <th align="center" > Tipo</th>
                                <th align="center" > Fecha</th>
                                <th align="center" > Banco</th>
                                <th align="center" > Proveedor</th>
                                <th align="center" > Nombre</th>
                                <th align="center" > Observaciones</th>
                                <th align="center" > Valor Total</th>
                                <th align="center" >Acción</th>
                            </tr>
                
                            <?php foreach ($gastos as $registro) { ?>
                                <tr>
                                    <td>Gasto</td>
                                    <td><?php echo $registro->getFecha('d/m/Y'); ?></td>
                                    <td><?php echo $registro->getBanco(); ?></td>
                                    <td><?php echo $registro->getProveedor()->getCodigo(); ?></td><!-- comment -->
                                    <td><?php echo $registro->getProveedor()->getNombre(); ?></td>
                                    <td><?php echo $registro->getGasto()->getDetalle(); ?></td>
                                    <td><div style="text-align: right"> <?php echo Parametro::formato($registro->getValorTotal(), 2); ?></div> </td>
                                    <td>
                                        <div style="text-align: center">
                                            <a href="<?php echo url_for($modulo . '/limpiag?id=' . $registro->getId()) ?>" class="btn btn-sm btn-dark" > <i class="flaticon2-files-and-folders"></i> Cheque </a>
                                        </div>
                                    </td>   
                                </tr>
                            <?php } ?>                         
                            <?php foreach ($ordenes as $registro) { ?>
                                <tr>
                                    <td>Orden</td>
                                    <td><?php echo $registro->getFecha('d/m/Y'); ?></td>
                                    <td><?php echo $registro->getBanco(); ?></td>
                                    <td><?php echo $registro->getProveedor()->getCodigo(); ?></td><!-- comment -->
                                    <td><?php echo $registro->getOrdenProveedor()->getNombre(); ?></td>
                                    <td><?php echo $registro->getOrdenProveedor()->getComentario(); ?></td>
                                    <td><div style="text-align: right"> <?php echo Parametro::formato($registro->getValorTotal(), 2); ?></div> </td>
                                    <td>
                                        <div style="text-align: center">
                                            <a href="<?php echo url_for($modulo . '/limpia?id=' . $registro->getId()) ?>" class="btn btn-sm btn-dark" > <i class="flaticon2-files-and-folders"></i> Cheque </a>
                                        </div>
                                    </td>   
                                </tr>
                            <?php } ?>
                    </table>
                </div>
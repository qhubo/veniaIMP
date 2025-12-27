            <div class="table-scrollable">
                <table class="table table-bordered  dataTable table-condensed flip-content" >
                    <thead class="flip-content">
                        <tr class="active">

                 
                            <th  align="center"> Código</th>
                            <th  align="center"> Nombre</th>
                            <th  align="center"><?php echo TipoAparatoQuery::tipo(); ?>  </th>  
                            <th  align="center"><?php echo TipoAparatoQuery::Marca(); ?>  </th>  
                            <th  align="center"> Fecha Vencimiento</th>
                            <th  align="center"> Bodega</th>
                            <th  align="center"> Cantidad</th>
                
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($productosVence) { ?>
                            <?php foreach ($productosVence as $lista) { ?>
                                <tr>
                                    <td><?php echo $lista->getProducto()->getCodigoSku() ?> </td>
                                    <td><?php echo $lista->getProducto()->getNombre() ?></td>
                                    <td><?php echo $lista->getProducto()->getTipoAparato(); ?> </td>
                                    <td><?php echo $lista->getProducto()->getMarca(); ?> </td>
                                    <td>   <?php echo $lista->getFechaVence('d/m/Y') ?></td>

                                        <td  align="right"><span class="font-blue "> 

                                       <?php echo $lista->getTienda()->getNombre() ?> </span></td>
                                    <td  align="right"><?php echo $lista->getTotalGeneral(); ?> </td>


                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
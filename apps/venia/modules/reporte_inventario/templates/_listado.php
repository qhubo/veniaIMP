            <div class="table-scrollable">
                <table class="table table-bordered  dataTable table-condensed flip-content" >
                    <thead class="flip-content">
                        <tr class="active">

                 
                    
                            <th  align="center"> Código Sku</th>
                            <th  align="center"> Nombre</th>
                            <th  align="center"><?php echo TipoAparatoQuery::tipo(); ?>  </th>  
<!--                            <th  align="center"><?php //echo TipoAparatoQuery::Marca(); ?>  </th>  
                            <th  align="center"> Proveedor</th>-->
<!--                            <th  align="center"> Descripción</th>-->
                                <?php foreach ($bodegas as $data) { ?>
                                    <?php $bode = $data->getTienda(); ?>
         
                                <th  align="center"><span class="font-blue sbold"> <?php echo $bode->getNombre() ?> </span></th>
                            <?php } ?>
                            <th  align="center"> Precio</th>
                         <th  align="center"> Costo</th>
                         <?php foreach($listaPrecio as $dtPrecio) { ?>
                         <th  align="center"><?php echo $dtPrecio->getNombre(); ?> </th>
                         <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($productos) { ?>
                            <?php foreach ($productos as $lista) { ?>
                                <tr>
                             
                                    <td><?php echo $lista->getCodigoSku() ?> </td>
                                    <td><?php echo $lista->getNombre() ?></td>
                                    <td><?php echo $lista->getTipoAparato(); ?> </td>
<!--                                    <td><?php //echo $lista->getMarca(); ?> </td>
                                    <td><?php //echo $lista->getProveedor(); ?> </td>-->
<!--                                    <td>   <?php echo $lista->getDescripcion() ?></td>-->

                                    <?php foreach ($bodegas as $data) { ?>
                                    <?php $bode = $data->getTienda(); ?>
                                        <td  align="right"><span class="font-blue "> 
                                                <?php echo $cant = $lista->getExistenciaBodega($bode->getId()) ?> </span></td>
                                    <?php } ?>
                                    <td  align="right"><?php echo Parametro::formato($lista->getPrecio(), false); ?> </td>
 <td  align="right"><?php echo Parametro::formato($lista->getCostoProveedor(), false); ?> </td>
       <?php foreach($listaPrecio as $dtPrecio) { ?>
 <td  align="right">

     
     <?php echo Parametro::formato($lista->getPrecioLista($dtPrecio->getId()), false); ?> </td>
                         <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
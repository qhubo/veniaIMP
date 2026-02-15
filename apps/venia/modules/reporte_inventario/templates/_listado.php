 <?php      $tipoPrecios = ListaPrecioQuery::create()->orderByNombre()->filterByActivo(true)->find(); ?>
<div class="table-scrollable">
    <table class="table table-bordered  dataTable table-condensed flip-content" >
        <thead class="flip-content">
            <tr class="active">



                <th  align="center"> Código Sku</th>
                <th  align="center"> Nombre</th>
                <th  align="center">Marca  </th>  
<!--                            <th  align="center"><?php //echo TipoAparatoQuery::Marca();    ?>  </th>  
                <th  align="center"> Proveedor</th>-->
<!--                            <th  align="center"> Descripción</th>-->
                <?php foreach ($bodegas as $data) { ?>
                <?php if ($data->getTiendaId()) { ?>
                    <?php $bode = $data->getTienda(); ?>
                    <th  align="center"><span class="font-blue sbold"> <?php echo $bode->getNombre() ?> </span></th>
                <?php } ?>
                        <?php } ?>
                <th  align="center"> Precio</th>
                <?php foreach ($tipoPrecios as $datad) { ?>
                    <th  align="center"><span class="font-blue sbold"> <?php echo $datad->getNombre() ?> </span></th>
                    <?php } ?>
                <th  align="center"> Costo</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($productos) { ?>
                <?php foreach ($productos as $lista) { ?>
                    <?php $pinta = true; ?>
                    <?php if ($filtro) { ?> 
                        <?php $existencia = $lista->getExistenciaTotal($bodegaId); ?>
                        <?php $pinta = false; ?>
                        <?php if ($existencia > 0) { ?> 
                            <?php $pinta = true; ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($pinta) { ?> 
                        <tr>

                            <td> <?php echo $lista->getCodigoSku() ?> </td>
                            <td><?php echo $lista->getNombre() ?></td>
                            <td><?php echo $lista->getMarcaProducto(); ?> </td>
                            <?php foreach ($bodegas as $data) { ?>
                                            <?php if ($data->getTiendaId()) { ?>
                                <?php $bode = $data->getTienda(); ?>
                                <td  align="right"><span class="font-blue "> 
                                        <?php echo $cant = $lista->getExistenciaBodega($bode->getId()) ?> </span></td>
                                    <?php } ?>
                                   <?php } ?>
                            <td  align="right"><?php echo number_format($lista->getPrecio(), 2); ?> </td>
                                <?php foreach ($tipoPrecios as $datad) { ?>
 <td  align="right"><?php echo number_format($lista->getPrecioLista($datad->getId()), 2); ?> </td>                           
     <?php } ?>
                            <td  align="right"><?php echo number_format($lista->getCostoProveedor(), 2); ?> </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </tbody>

    </table>
</div>
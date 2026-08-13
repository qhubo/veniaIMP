<div class="table-scrollable">

    <table class="table table-bordered table-hover table-condensed">

        <thead>

            <tr class="active">

                <th align="center">
                    Código SKU
                </th>

                <th align="center">
                    Producto
                </th>

                <th align="center">
                    Marca Producto
                </th>

                <th align="center">
                    Marcas Vehículo
                </th>

                <th align="right">
                    Existencia
                </th>

                <th align="right">
                    Precio
                </th>

            </tr>

        </thead>


        <tbody>

            <?php if ($productos) { ?>

                <?php foreach ($productos as $producto) { ?>

                    <tr>

                        <td>
                            <?php echo $producto->getCodigoSku(); ?>
                        </td>


                        <td>

                            <?php echo $producto->getNombre(); ?>

                        </td>


                        <td>

                            <?php echo $producto->getMarcaProducto(); ?>

                        </td>


                        <td style="min-width:250px;">

                            <?php

                            $marcas = isset(
                                    $marcasVehiculo[$producto->getId()]
                            )
                                    ? $marcasVehiculo[$producto->getId()]
                                    : array();

                            ?>

                            <?php if (!empty($marcas)) { ?>

                                <?php foreach ($marcas as $marca) { ?>

                                    <span
                                        class="badge badge-primary"
                                        style="margin:2px;">

                                        <?php echo $marca; ?>

                                    </span>

                                <?php } ?>

                            <?php } else { ?>

                                <span
                                    style="color:#999;">

                                    Sin asignar

                                </span>

                            <?php } ?>

                        </td>


                        <td align="right">

                            <?php echo number_format(
                                    $producto->getExistencia(),
                                    0
                            ); ?>

                        </td>


                        <td align="right">

                            <?php echo number_format(
                                    $producto->getPrecio(),
                                    2
                            ); ?>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td
                        colspan="6"
                        align="center"
                        style="padding:30px;">

                        <i class="fa fa-info-circle"></i>

                        No se encontraron productos.

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
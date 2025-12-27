


        <div class="row">
            <div class="col-lg-10">
                <table  class="table" style="width:100%" >
                    <tbody>
                        <?php foreach ($pendientes as $registro) { ?>
                            <tr>
                                <td><font color=""><?php echo $registro->getOrdenCotizacion()->getCodigo(); ?> </font></td>
                                <td><font color=""><?php echo $registro->getOrdenCotizacion()->getFecha('d/m/Y'); ?></font> </td>
                                <td><font color=""><?php echo $registro->getOrdenCotizacion()->getNombre(); ?> </font></td>
                                <td> <a href="<?php echo url_for($modulo . '/nueva?codigo=' . $registro->getOrdenCotizacion()->getCodigo()) ?>" class="btn btn-sm btn-success btn-secondary" > Continuar >> </a> </td>
                                <td>
                                    <a class="btn btn-small btn-danger" data-toggle="modal" href="#staticB<?php echo $registro->getId() ?>">  </a>
                                </td> 
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="col-lg-1"></div>
        </div>






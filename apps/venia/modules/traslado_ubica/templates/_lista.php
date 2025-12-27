<?php $modulo = 'traslado_ubica'; ?>
<form action="<?php echo url_for($modulo . '/confirma') ?>" method="get">
    <input type="hidden" id="mov" name="mov" value="<?php echo $id ?>" >
    <table class="table table-bordered "  >
        <thead class="flip-content">
            <tr class="active">
                <th  align="center"><span class="kt-font-success">Producto  </span></th>
                <th  align="center"><span class="kt-font-success">Descripción </span></th>
                <th  align="center"><span class="kt-font-success">Ubicación Actual</span></th>

                <th  align="center"><span class="kt-font-success">Cantidad </span></th>
                <th  align="center"><span class="kt-font-success">Nueva Ubicación</span></th>


            </tr>
        </thead>
        <?php if ($id) { ?>
            <tbody>
                <?php $can = 0; ?>
                <?php $grantotal = 0; ?>
                <?php foreach ($listado as $registro) { ?>
                    <?php
                    $max = 1;
                    $pproductoU = ProductoUbicacionQuery::create()
                            ->filterByUbicacion($registro->getUbicacionOriginal())
                            ->filterByTiendaId($registro->getTrasladoUbicacion()->getTiendaId())
                            ->filterByProductoId($registro->getProductoId())
                            ->findOne();
                    if ($pproductoU) {
                        $max = $pproductoU->getCantidad();
                    }
                    ?>

                    <?php $lista = $registro; ?>
                    <?php $can = $registro->getCantidad(); ?>

                    <?php $pid = $registro->getId() ?>
                    <tr <?php if (($can % 2) == 0) { ?>  style="background-color:#ebedf2"  <?php } ?> >
                        <td style="font-size:12px"><?php echo $registro->getProducto()->getCodigoSku(); ?> <br>
                            <a href="<?php echo url_for($modulo . '/eliminaLinea?id=' . $lista->getId()) ?>" class="btn btn-sm  btn-danger" >   </a>
                        </td>    
                        <td style="font-size:12px"><?php echo $registro->getProducto()->getNombre(); ?></td>    
                        <td style="font-size:12px"><?php echo $registro->getUbicacionOriginal(); ?></td>
                        <td>
                            <input min="1"  type="number"  class="form-control cantidad" value="<?php echo $can ?>"  id="numero<?php echo $pid ?>" name="numero<?php echo $pid ?>"   
                                   max="<?php echo $max; ?>" >
                        </td>    
                        <td>         
                            <select  class="form-control" id="tienda<?php echo $pid ?>" name="tienda<?php echo $pid ?>">
                                <option  value=""> Seleccione </option>
                                <?php foreach ($bodegas as $data) { ?>
                                    <option <?php if ($data->getId() == $registro->getTiendaId()) { ?> selected="selected"  <?php } ?>  value="<?php echo $data->getId() ?>"><?php echo $data->getNombre(); ?></option>
                                <?php } ?>
                            </select>
                            <input type="text" class="form-control"  id="ubicacion<?php echo $pid ?>" name="ubicacion<?php echo $pid ?>" value="<?php echo $lista->getNuevaUbicacion(); ?>"><!-- comment -->      </td>    
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>


    <?php foreach ($listado as $registro) { ?>
        <?php $id = $registro->getId(); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#tienda<?php echo $id ?>").on('change', function () {
                    var valor = $("#tienda<?php echo $id ?>").val();
                    var id = <?php echo $id ?>;
                    $.get('<?php echo url_for($modulo . "/tienda") ?>', {id: id, valor: valor}, function (response) {
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#numero<?php echo $id ?>").on('change', function () {
                    var valor = $("#numero<?php echo $id ?>").val();
                    var id = <?php echo $id ?>;
                    $.get('<?php echo url_for($modulo . "/cantidad") ?>', {id: id, valor: valor}, function (response) {
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#ubicacion<?php echo $id ?>").on('change', function () {
                    var valor = $("#ubicacion<?php echo $id ?>").val();
                    var id = <?php echo $id ?>;
                    $.get('<?php echo url_for($modulo . "/ubicacion") ?>', {id: id, valor: valor}, function (response) {
                    });
                });
            });
        </script>
    <?php } ?>
    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <button class="btn btn-success " type="submit">
                <i class="fa fa-save "></i>Confirmar</button>
        </div>
    </div>
</form>


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
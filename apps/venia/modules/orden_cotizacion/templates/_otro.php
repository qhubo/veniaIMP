<?php $modulo = 'orden_cotizacion'; ?>
<div class="row">
    <div class="col-lg-12"><br></div>
</div>
    <div class="row">
    <div class="col-lg-12">
<?php $combos = ComboProductoQuery::create()->filterByActivo(true)->find(); ?>
<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer " width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success">Código </span></th>
            <th  align="center"><span class="kt-font-success">  Nombre</span></th>
            <th  align="center"><span class="kt-font-success"> Seleccionar </span></th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($combos as $registro) { ?>

            <tr>
                <td>
                     <a href="<?php echo url_for($modulo . '/combo?id=' . $registro->getId()) ?>"  > 
                    <?php echo $registro->getCodigoSku(); ?> 
                     </a>
                     </td>
                <td>
                     <a href="<?php echo url_for($modulo . '/combo?id=' . $registro->getId()) ?>"  > 
                    <font size="-1"><?php echo $registro->getNombre(); ?> </font>
                     </a>
                     </td>
                <td>

                    <a href="<?php echo url_for($modulo . '/combo?id=' . $registro->getId()) ?>"  > 
                        <font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></font></font>
                    </a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
    </div>
    </div>
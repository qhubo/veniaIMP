<?php $modulo = 'orden_compra'; ?>
<div class="row">
    <div class="col-lg-12"><br></div>
</div>
    
<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success">Código </span></th>
            <th  align="center"><span class="kt-font-success">  Nombre</span></th>
            <th  align="center"><span class="kt-font-success"> Seleccionar </span></th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($servicios as $registro) { ?>

            <tr>
                <td>
                     <a href="<?php echo url_for($modulo . '/servicio?id=' . $registro->getId()) ?>"  > 
                    <font size="-1"><?php echo $registro->getCodigo(); ?> </font>
                     </a>
                     </td>
                <td>
                     <a href="<?php echo url_for($modulo . '/servicio?id=' . $registro->getId()) ?>"  > 
                    <font size="-1"><?php echo $registro->getNombre(); ?> </font>
                     </a>
                     </td>
                <td>

                    <a href="<?php echo url_for($modulo . '/servicio?id=' . $registro->getId()) ?>"  > 
                        <font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></font></font>
                    </a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
        
<div class="row">
    <div class="col-lg-10">  </div>
    <div class="col-lg-2"><br>				
        <!--        <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>-->
    </div>
</div>
                <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success"> Fecha</span></th>
            <th  align="center"><span class="kt-font-success">Recibo </span></th>
            <th  align="center"><span class="kt-font-success">Factura </span></th>
            <th  align="center"><span class="kt-font-success">Tienda </span></th>
            <th  align="center"><span class="kt-font-success">Cliente </span></th>
            <th  align="center"><span class="kt-font-success"> Medio Pago </span></th>
            <th  align="center"><span class="kt-font-success">Banco  </span></th>
            <th  align="center"><span class="kt-font-success"> Documento</span></th>
            <th  align="center"><span class="kt-font-success"> Fecha Documento</span></th>
            <th  align="center"><span class="kt-font-success">Valor </span></th>
            <th  align="center"><span class="kt-font-success"> Usuario </span></th>
            <th  align="center"><span class="kt-font-success">Comisión  </span></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
        <?php foreach ($registros as $reg) { ?>
            <?php //$data = $reg->getGasto(); ?>
            <?php $conta++; ?>
            <tr >
                <td><?php echo $reg->getFechaCreo('d/m/Y'); ?></td>
                <td style="text-align: center">
                       <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $reg->getId()) ?>" class="btn btn-block btn-xs btn-info " target = "_blank">
                    <?php echo $reg->getCodigo(); ; ?>
                       </a>
                       </td>
                <td><?php echo $reg->getOperacion()->getCodigo(); ?></td>
                <td><?php echo $reg->getOperacion()->getTienda()->getNombre(); ?></td>
                <td><?php echo $reg->getOperacion()->getNombre(); ?> </td>
                <td><?php echo $reg->getTipo(); ?></td>
                <td style="text-align: right" ><?php echo $reg->getBanco(); ?></td>
                <td style="text-align: right" ><?php echo $reg->getDocumento(); ?></td>
                <td style="text-align: center" ><?php echo $reg->getFechaDocumento('d/m/Y'); ?></td>
                <td style="text-align: right" ><div style="text-align:right"> <?php echo Parametro::formato($reg->getValor()); ?></div></td>
                <td><?php echo $reg->getUsuario(); ?></td>

                <td style="text-align: right" ><div style="text-align:right"> <?php echo Parametro::formato($reg->getComision()); ?></div></td>
            </tr>
        <?php } ?>

    </tbody>
</table>






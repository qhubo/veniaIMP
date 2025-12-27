        
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
<table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success"> Fecha</span></th>
            <th  align="center"><span class="kt-font-success">Vendedor </span></th>
            <th  align="center"><span class="kt-font-success">Observaciones</span></th>
            <th  align="center"><span class="kt-font-success">Estado</span></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
        <?php foreach ($registros as $reg) { ?>
            <?php //$data = $reg->getGasto(); ?>
            <?php $conta++; ?>
            <tr >
     
                <td style="text-align: center">
                    
                    <?php echo $reg->getId(); ; ?>

                       </td>
                                  <td><?php echo $reg->getFecha('d/m/Y H:i'); ?></td>
                <td><?php echo $reg->getFecha('d/m/Y'); ?></td>
                <td><?php echo $reg->getVendedor()->getNombre(); ?></td>
                <td><?php echo $reg->getObservaciones(); ?> </td>
                <td><?php echo $reg->getEstado(); ?></td>
                <td>
                                   <a target="_blank" href="<?php echo url_for('producto_vendedor/reporte?id=' . $reg->getId()) ?>" class="btn btn-block btn-xs btn-info " target = "_blank">
               Pedido     
                       </a>
                    
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>






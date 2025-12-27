<table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin " width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success"> Tipo</span></th>
            <th  align="center"><span class="kt-font-success"> Valor</span></th>
            <th  align="center"><span class="kt-font-success"> Inicio </span></th>
            <th  align="center"><span class="kt-font-success"> Fin</span></th>
            <th  align="center"><span class="kt-font-success"> Dias</span></th>
            <th  align="center"><span class="kt-font-success"> Dolares</span></th>
            <th  align="center"><span class="kt-font-success"> Tasa Cambio </span></th>
            <th  align="center"><span class="kt-font-success"> Quetzales</span></th>
 <th  align="center"><span class="kt-font-success"> Creacion</span></th>
 <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detalle as $regi) { ?>
            <tr>
                <td>
                                        <a href="<?php echo url_for("prestamo/partida?id=".$regi->getId()) ?>" 
                                           class="btn-dark btn  btn-sm btn-block" data-toggle="modal" data-target="#ajaxmodal<?php echo  $regi->getId(); ?>"> 
                    <?php echo $regi->getId(); ?>
                                        </a>
                                        </td>
                <td><?php echo $regi->getTipo(); ?></td>
                <td  style="text-align: right"><strong>$</strong> <?php echo Parametro::formato($regi->getValor(), false); ?></td>
                <td  style="text-align: center"><?php echo $regi->getFechaInicio('d/m/Y'); ?></td>
                <td  style="text-align: center"><?php echo $regi->getFechaFin('d/m/Y'); ?></td>
                <td style="text-align: right"><?php echo $regi->getDias(); ?></td>
                <td style="text-align: right"><strong>$</strong>&nbsp;<?php echo Parametro::formato($regi->getValorDolares(), false); ?></td>

                <td style="text-align: right"><?php echo Parametro::formato($regi->getTasaCambio(), false); ?></td>
                <td style="text-align: right"><?php echo Parametro::formato($regi->getValorQuetzales(), true); ?></td>
                <td style="text-align: center; font-size: 11px;"><?php echo $regi->getCreatedAt(); ?><br><?php echo $regi->getCreatedBy(); ?></td>
                <td>  
                    <?php if ($regi->getCreatedBy() <> "") { ?>
                    <?php if ($ultimo==$regi->getId()) { ?>
                    <a class="btn   btn-sm btn-danger" data-toggle="modal" href="#static<?php echo $regi->getId(); ?>"><i class="fa fa-trash"></i>   </a>
                    <?php } ?>
                    <?php } ?>
                    
                </td>

            </tr>

        <?php } ?>

    </tbody>
</table>



    <?php foreach ($detalle as $regi) { ?>
<?php $lista=$regi; ?>
    <div class="modal fade" id="ajaxmodal<?php echo $regi->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Detalle Partida</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

      <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Eliminar </span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de eliminar  <?php echo $lista->getTipo() ?> <?php echo $lista->getFechaInicio('d/m/Y') ?>
 
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $lista->getId() ?>
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = md5($lista->getId()); ?>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn green " href="<?php echo url_for('prestamo/eliminaPagp?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                    <i class="fa fa-trash-o "></i> Confirmar</a> 
                            </div>
                        </div>
                    </div>
                </div> 
    <?php } ?>
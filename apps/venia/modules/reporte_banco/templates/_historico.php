

<div class="row">
    <div class="col-lg-12">

        <table class="kt-datatable table-bordered " xid="html_table" width="100%">
            
            <thead>
                <tr class="info">
                    <th>Fecha </th>

                    <th>Banco</th>
                    <th>Movimiento</th>
                    <th>Documento</th>
                   <th>Observaciones </th>
                     <th>Detalle </th>
                   <th>Valor </th>
                   <?php if ($dolares) { ?> 
                   <th>Tasa Cambio</th>
                 
                   <th>Valor Banco</th>
                   <?php } ?>
                                       <th>Usuario</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($operaciones as $regi) { ?>

                    <tr>
                        <td><font size="-1"><?php echo $regi->getFechaDocumento('d/m/Y'); ?></font></td>
                        <td><font size="-1"><?php echo $regi->getBancoRelatedByBancoId()->getNombre(); ?></font></td>
                        <td><font size="-1"><?php echo $regi->getTipo(); ?><br><?php echo $regi->getTipoMovimiento(); ?></font> </td>
                        <td><font size="-1"><?php if (!$regi->getVentaResumidaLineaId()) { ?><?php echo $regi->getDocumento(); ?><?php } ?> </font></td>
                        <td><font size="-1"><?php echo $regi->getObservaciones(); ?></font></td>
                        <td><font size="-1"><?php echo $regi->getDetalleMovimiento(); ?></font></td>
                        <td style="text-align: right"><div style="text-align:right"><font size="-1"><?php echo Parametro::formato(abs($regi->getValor())); ?></font></div> </td>     
                                           <?php if ($dolares) { ?> 
       <td style="text-align: right"><div style="text-align:right"><font size="-1"><?php echo $regi->getTasaCambio(); ?></font></div> </td>     
                                  
                          <?php } ?>

                         <?php if ($dolares) { ?> 
                        <?php $valorQ=abs($regi->getValor()); ?>
                        <?php $valorDolar = $valorQ/ $regi->getTasaCambio(); ?>
                        <td style="text-align: right"><div style="text-align:right"><strong>$ </strong> <font size="-1"><?php echo Parametro::formato($valorDolar, false); ?></font></div> </td>     
                               <td><font size="-1"><?php echo $regi->getUsuario(); ?></font></td>  
                         <?php } ?>
                    </tr>      
                <?php } ?>
            </tbody>
        </table>
    </div>      
</div>      


<?php foreach ($operaciones as $data) { ?>
    <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Débito  <?php echo $data->getId(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <div class="modal fade"  id="ajaxmodalRECHAZA<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Rechazo Debito  <?php echo $data->getDocumento(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<?php } ?>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
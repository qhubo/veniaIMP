<div class="detalleInte kt-portlet kt-portlet--responsive-mobile" id="detalleInte">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body " >
        <div class="row" style="margin-bottom: 10px; padding-bottom: 5px;">
            <div class="col-lg-1">Del</div>
            <div class="col-lg-2" style="background-color:#ebedf2"><strong><?php echo $inicio; ?></strong> </div>
            <div class="col-lg-1">Al</div>
            <div class="col-lg-2" style="background-color:#ebedf2"><strong> <?php echo $fin; ?> </strong></div>
            
        </div>
        
             <table class="table  " >
                        <tr style="background-color:#ebedf2">
                            <th align="center"   width="10px">#</th>
                            <th align="center"  width="120px">Fecha</th>
                            <th  align="center"> Monto Actual</th>
                            <th  align="center"> Interes</th>
                        </tr>
                        <?php $monto=0; ?>
                        <?php foreach($lista as $deta) { ?>
                        <?php $monto=$monto+$deta['interes']; ?>
                        <tr>
                            <td><?php echo $deta['id']; ?></td>
                            <td style="text-align: center;"><?php echo $deta['fecha']; ?></td>
                            <td style="text-align: right;"><strong>$</strong>&nbsp;<?php echo Parametro::formato($deta['monto_actual'],false); ?>&nbsp;&nbsp;</td>
                             <td style="text-align: right;"><?php echo Parametro::formato($deta['interes'],false); ?>&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th style="text-align: right;" colspan="3">Totales</th>
                            <td style="text-align: right;"><strong>$</strong>&nbsp;<?php echo Parametro::formato($monto,false); ?>&nbsp;&nbsp;</td>
                        </tr>
                         
             </table>
                        
    </div>
</div>

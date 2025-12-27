<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-document  text-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Partida Contable  
            </h3> &nbsp;&nbsp;&nbsp; <?php //echo $partida->getTipo(); ?> 
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        
             <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  active " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Partida
                </a>
            </li>
            <?php if ($prestmoDetalle->getTipo()=="CALCULO INTERES") { ?>
            <li class="nav-item">
                <a class="nav-link   " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Detalle Interes
                </a>
            </li>
            <?php } ?>
        </ul>
           <div class="tab-content">
            <div class="tab-pane  active  " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
             
<?php include_partial('prestamo/partida', array('id' =>$id,'form'=>$form,'partidaDetalle'=>$partidaDetalle,'cuentasUno'=>$cuentasUno )) ?>  
            </div>
                  <div class="tab-pane  " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
       <?php //$lista= json_decode($prestmoDetalle->getDetalleInteres()); ?>
                    
                                 <?php if ($prestmoDetalle->getTipo()=="CALCULO INTERES") { ?>

                   
                         <table class="table  " >
                        <tr style="background-color:#ebedf2">
                            <th align="center"   width="10px">#</th>
                            <th align="center"  width="120px">Fecha</th>
                            <th  align="center"> Monto Actual</th>
                            <th  align="center"> Interes</th>
                        </tr>
                        <?php $monto=0; ?>
                        <?php foreach($listaInteres as $deta) { ?>
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
                                 <?php } ?>
                  </div>
        
    </div>
</div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>
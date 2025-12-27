<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Ingreso de partidas
                <small>&nbsp;&nbsp;&nbsp;Verifique la información a almacenar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <?php $incorrectos =0; ?>
    <?php $pen=0; ?>
    <?php $Grantotal=0; ?>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <?php $ASIENTOS = $datos['lista']; ?>  
            <?php $partidas = $datos['datosAgrupado']; ?>
            <?php foreach ($ASIENTOS AS $ASIENTO) { ?>
                <table class="table">
                    <tr style="background-color:#ebedf2">
                        <th align="center"  width="80px">ASIENTO</th>
                        <th align="center"   width="100px">FECHA</th>
                        <th  align="center"> CUENTA</th>
                        <th align="center" >DESCRIPCION </th>
                        <th align="center" >DOCUMENTO</th>
                        <th  align="center" width="100px"> DEBE</th>
                        <th  align="center" width="100px" > Haber</th>
                        <th  align="center">TIPO </th>
                        <th  align="center">NUMERO </th>
                        <th  align="center">DETALLE </th>
                    </tr>
                    <?php $total1 = 0; ?>
                    <?php $total2 = 0; ?> 
                    <?php foreach ($partidas[$ASIENTO] AS $reg) { ?>
                        <?php $total1 = $total1 + $reg['DEBE']; ?>
                        <?php $total2 = $total2 + $reg['HABER']; ?>
                    <?php $Grantotal= $reg['HABER']+$Grantotal; ?>
                        <tr style="border: 1px;<?php if (!$reg['ID']) { ?> <?php $pen++; ?> background-color: #FBD789;   <?php } ?>  ">
                            <td >
                                <?php if (!$reg['ID']) { ?> ERROR  <?php } ?>
                                <?php echo $reg['ASIENTO']; ?></td>
                            <td><?php echo $reg['FECHA']; ?></td>
                            <td><?php echo $reg['CUENTA']; ?></td>
                            <td><?php echo $reg['DESCRIPCION']; ?></td>
                            <td><?php echo $reg['DOCUMENTO']; ?></td>
                            <td  style="text-align: right; align-content: right" ><?php echo Parametro::formato($reg['DEBE'], false); ?></td>
                            <td style="text-align: right; align-content: right"><?php echo Parametro::formato($reg['HABER'], false); ?></td>
                            <td><?php echo $reg['TIPO']; ?></td>
                            <td><?php echo $reg['NUMERO']; ?></td>
                            <td><?php echo $reg['DETALLE']; ?></td>


                        </tr>
                    <?php } ?>
                    <?php $color = '#ebedf2'; ?>
                    <?php $alerta = 'Totales'; ?>
                    <?php if (round($total1, 2) <> round($total2, 2)) { ?>
                        <?php $color = '#F66F16'; ?>
                            <?php $incorrectos++; ?>
                        <?php $diferencia = round($total1, 2) - round($total2, 2); ?>                        
                        <?php $alerta = '************ Partida NO VALIDA montos incorrectos  **************** ' . $diferencia; ?>                                 
                    <?php } ?>

                    <tr style="background-color:<?php echo $color; ?>">
                        <th colspan="5"><strong><?php echo $alerta; ?></strong></th>
                        <th  style="text-align: right; align-content: right" ><?php echo Parametro::formato($total1); ?></th>
                        <th style="text-align: right; align-content: right"><?php echo Parametro::formato($total2); ?></th>
                        <th colspan="3"></th>
                    </tr>

                </table>

            <?php } ?>
            <?php if ($pen==0) { ?>

            <div class="row">
                <div class="col-md-10"></div>
                               <div class="col-md-2">
                     <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-success  btn-block" > <i class="fa fa-lock"></i> Confirmar</a>
                               </div>

            </div>
            <?Php } ?>
            
        </div>
    </div>
</div>




    <div id="staticCONFIRMA" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>  Cierre  de Partidas  
                        <strong>Confirmar la grabación de  <?php echo count($ASIENTOS); ?>   partidas  </strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            Por un valor de  <?php echo Parametro::formato($Grantotal) ?>
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn  btn-success " href="<?php echo url_for( 'partida_todas/confirmar?id=' . $id . "&token=" . sha1($id)) ?>" >
                        <i class="flaticon2-lock "></i> Confirmar </a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div>
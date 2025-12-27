<?php $modulo = $sf_params->get('module'); ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Listado de Carga
                <small>&nbsp;&nbsp;&nbsp; muestra los datos a cargar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-body"> 


            <?php foreach ($datos['lista'] as $asiento) { ?>
                <table class="table  " >

                    <tr style="background-color:#ebedf2">
                        <th align="center"  width="80px">Partida</th>
                        <th align="center"   width="100px">Fecha</th>
                        <th  align="center"> Cuenta</th>
                        <th align="center" >Descripción </th>
                        <th  align="center" width="100px"> Debe</th>
                        <th  align="center" width="100px" > Haber</th>
                        <th  align="center" width="10px" ></th>
         

                    </tr>

                    <?php $total1 = 0; ?>
                    <?php $total2 = 0; ?> 
                    <?php $cantida = 0; ?>
                    <?php foreach ($datos['datos'][$asiento] as $data) { ?>
                    <?php $ano= substr($data['ASIENTO'], 0,4); ?>
                    <?php $mes=substr($data['ASIENTO'], 6,2);; ?>
                    <?php $dia=substr($data['ASIENTO'], -2);; ?>
                     <tr style="">
                       <td align="left"  width="80px"><?php echo $data['ASIENTO']; ?></td>
                        <td align="center"   width="100px"><?php echo $dia."/".$mes."/".$ano;  ?> </td>
                        <td  align="left"> <?php echo $data['CUENTA']; ?></td>
                        <td align="left" ><?php echo $data['NOMBRE']; ?>
                        <?php if (! $data['VALIDO']) { ?> <font size="+1" color="#EB6F50"> **  Cuenta no encontrada </font> <?php } ?>
                        </td>
                        <td    style="text-align: right;" width="100px"> <?php echo Parametro::formato($data['DEBITO']); ?></td>
                        <td   style="text-align: right;" width="100px" > <?php echo Parametro::formato($data['CREDITO']); ?></td>
                        <td <?php if (! $data['VALIDO']) { ?> style="background-color:#EB6F50"  <?php } ?>  align="center"><?php if (! $data['VALIDO']) { ?><i   class="warning icon-2x text-dark-50 flaticon-cancel"></i>  <?php } ?></td>
                    </tr>
                      <?php $total1 = $total1+$data['DEBITO']; ?>
                    <?php $total2 = $total2+$data['CREDITO']; ?> 
                    <?php } ?>
                    <tr style="">
                        <td style="text-align: center"  colspan="4"><strong>Totales</strong></td>
                        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total1); ?></strong></td>
                        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total2); ?></strong></td>
                        <td><?php //echo $asiento. "<pre>";  print_r($datos['listaNO']); echo "</pre>" ?></td>
                    </tr>
                    <?php foreach($datos['listaNO'] as $verri) { ?>
                    <?php if ($verri==$asiento) { ?>
                    <tr>
                        <td style="text-align: right" colspan="7"> <strong> <font size ="+2"> !! Imposible cargar esta partida,  Cuenta no encontrada en este partida</font> </strong> </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>

                </table>
            <?php } ?>
        </div>
    </div>
</div>
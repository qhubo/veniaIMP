<?php echo $form->renderFormTag(url_for('lista_entrega/entrega?id=' . $operacion->getId()), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>    
<table class="table table-striped- table-bordered   no-footer dtr-inlin "  width="100%">
    <thead>
        <tr>
            <th><span class="kt-font-bold kt-font-success">Codigo</span></th>
            <th  ><span class="kt-font-bold kt-font-success">Detalle</span></th>
            <th align="center"><span class="kt-font-bold kt-font-success">Valor Unitario</span></th>
            <th width="300px;"  align="center" colspan="2" ><span align="center" class="kt-font-bold kt-font-success">Stock</span></th>

        </tr>
    </thead>
    <tbody>
        <?php $totalC = 0; ?>
        <?php foreach ($detalle as $reg) { ?>
            <?php $totalC = $reg->getValorTotal() + $totalC; ?>
            <tr>
                <td><?php echo $reg->getCodigo(); ?></td>
                <td><?php echo $reg->getDetalle(); ?>

                </td>
                <td align="right"><?php echo number_format($reg->getValorUnitario(), 2); ?></td>
           
                <td align="right">
                    <table width="100%"> 
                        <tr>
                            <td style="font-size:14px; font-weight: bold">Cantidad Entregar</td>
                            <td  style="font-size:16px; font-weight: bold; background-color: #FAF8F8"><?php echo $reg->getTotalGeneral(); ?></td>
                        <tr>
                    </table>
                    <table width="100%"> 
                        <tr>
                            <td  style="font-size:12px; font-weight: bold">Vencimiento</td>
                            <td  style="font-size:12px; font-weight: bold">Existencia</td>
                            <td  style="font-size:12px; font-weight: bold">Rebaja</td>

                        </tr>
                        <?php foreach ($reg->getDetallePro() as $de) { ?>
                        
<?php       $name = $de->getFechaVence('dmY')."_".$de->getProductoId()."_".$reg->getOperacion()->getTiendaId(); ?>
<?php       $nameE = $de->getFechaVence('dmY')."_".$de->getProductoId()."_".$reg->getOperacion()->getTiendaId()."existe"; ?>                        
                            <tr>
                                <td  style="font-size:12px; text-align: center"><?php echo $de->getFechaVence('d/m/Y'); ?></td>
                                <td  style="font-size:12px; text-align: right; "  ><?php echo $de->getTotalGeneral(); ?></td>
                                <td  style="font-size:12px; ">  <?php echo $form[$name] ?>  <?php echo $form[$nameE] ?>   </td>
                            </tr>   
                            
                        <?php } ?>
                    </table>

                </td>

            </tr>
        <?php } ?>
    </tbody>

</table>


     <div class="row">
            <div class="col-lg-10"> </div>
            <div class="col-lg-2">
                <button class="btn-block btn-success btn " type="submit">
                    <i class="fa fa-check "></i>
                    Aceptar
                </button>
            </div>
        </div>

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!--//                if (valor >existe ){
//                $("#ingreso_<?php echo $name; ?>").val(existe);
//                }-->
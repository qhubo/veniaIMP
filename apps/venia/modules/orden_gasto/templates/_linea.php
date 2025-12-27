
     <?php   $empresaId= sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
    $empreaq = EmpresaQuery::create()->findOneById($empresaId);
    $moneda='';
    if ($empreaq) {
        $moneda=$empreaq->getMonedaQ();
        
    } ?>
<table class="table table-bordered " >
    <thead >
    <th  align="center"><font size="-1">Cuenta Contable </font> </th>
    <th  align="center"><font size="-1">Concepto </font> </th>
    <th  align="center"><font size="-1">Cantidad </font> </th>
    <th  align="center"> </th>
    <th  align="center"><font size="-1">Valor </font> </th>
    <th  align="center"><font size="-1">Subtotal </font></th>
    <th  align="center"><font size="-1">IVA </font></th>
    <th></th>


</thead>
<tbody>
    <?php $can=0 ; ?>
    <?php foreach ($detalles as $data) { ?>
    <?php $can++ ; ?>
        <?php $nombre = ''; ?>
        <?php $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($data->getCuentaContable()); ?>
        <?php if ($cuentaQ) {
            $nombre = $cuentaQ->getNombre();
        } ?>
        <tr>
            <td><?php echo $data->getCuentaContable() . " " . $nombre; ?> </td>
            <td><?php echo $data->getConcepto(); ?> </td>
            <td><?php echo $data->getCantidad(); ?> </td>
            <td><strong><?php echo $moneda; ?></strong> </td>
            <td><?php echo number_format((float) ($data->getValorTotal()), 2, '.', ''); ?> </td>
            <td><?php echo number_format((float) ($data->getSubTotal()), 2, '.', ''); ?> </td>
            <td><?php echo number_format((float) ($data->getIva()), 2, '.', ''); ?> </td>
            <td>  
                <a href="<?php echo url_for($modulo . '/eliminaLinea?id=' . $data->getId()) ?>" class="btn btn-sm  btn-danger" > <i class="fa fa-trash"></i>  </a>


                    <?php if (!$id_detalle) { ?>              
 <?php if (!$agrega) {  ?>
                <?php if ($can ==count($detalles)) { ?>
                <a href="<?php echo url_for($modulo . '/index?agrega=1') ?>" class="btn btn-sm  btn-success" > <i class="fa flaticon2-add"></i>  </a></td>
               <?php } ?>
               <?php } ?>
<?php }?>
            </td>

        </tr>

    <?php } ?>
    <?php if ($orden) { ?>
        <?php if ($muestalinea) { ?>
        <?php $id = 0; ?>
                    <?php $total = 0; ?>
            <tr>
                <td class=" <?php if ($form['cuenta_contable']->hasError()) echo "has-error" ?>">
                        <?php echo $form['cuenta_contable'] ?>     
                    <span class="help-block form-error"> 
        <?php echo $form['cuenta_contable']->renderError() ?>  
                    </span>
                </td>
                <td class=" <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
                        <?php echo $form['nombre'] ?>     
                    <span class="help-block form-error"> 
        <?php echo $form['nombre']->renderError() ?>  
                    </span>
                </td>
                <td class=" <?php if ($form['cantidad']->hasError()) echo "has-error" ?>">
                        <?php echo $form['cantidad'] ?>     
                    <span class="help-block form-error"> 
        <?php echo $form['cantidad']->renderError() ?>  
                    </span>
                </td>
                <td><strong><?php echo $moneda; ?></strong></td>
                <td class=" <?php if ($form['valor']->hasError()) echo "has-error" ?>">
                        <?php echo $form['valor'] ?>     
                    <span class="help-block form-error"> 
        <?php echo $form['valor']->renderError() ?>  
                    </span>
                </td>
                <td>       <div  align="right" class="total" id="total"><?php echo number_format($subtotal, 2); ?></div>

                </td>
                <td>
                    <div  align="right" class="graiva" id="graiva"><?php echo number_format($iva, 2); ?></div>

                </td>
                <td> 
                    <?php if ($can >0 ) { ?>
                    <?php if (!$id_detalle) { ?>   
                    <?php if (!$agrega) {  ?>
                    <a href="<?php echo url_for($modulo . '/index?agrega=1') ?>" class="btn btn-sm  btn-success" > <i class="fa flaticon2-add"></i>  </a></td>
                    <?php } else { ?>
                  <button class="btn btn-primary btn-sm " type="submit">
                            <i class="fa fa-save "></i> Agregar
                        </button>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
 <?php if (($id_detalle) or ($can==0)) { ?>   
   <button class="btn btn-primary btn-sm " type="submit">
                            <i class="fa fa-save "></i> Agregar
                        </button>
 <?php  } ?>

            </tr>
    <?php } ?>
<?php } ?>
</tbody>

</table>
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
<?php $id = 0; ?>
<?php $idv = 0; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_observaciones").on('change', function () {
            var id = $("#consulta_observaciones").val();
            var idv = <?php echo $idv ?>;
            $.get('<?php echo url_for($modulo . "/observaciones") ?>', {id: id, idv: idv}, function (response) {
                var respuestali = response;
                var arr = respuestali.split('|');
                var linea = arr[0];
                var totalIva = arr[1];
                $("#total").html(linea);
                $("#graiva").html(totalIva);
            });


        });
    });
</script>




<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_valor").on('change', function () {
            var id = $("#consulta_valor").val();
            var idv = <?php echo $idv ?>;
            var idca = $("#consulta_cantidad").val();
            var cuenta =$("#consulta_cuenta_contable").val();
            $.get('<?php echo url_for($modulo . "/valor") ?>', {id: id, idv: idv,idca: idca, cuenta:cuenta}, function (response) {
                var respuestali = response;
                var arr = respuestali.split('|');
                var linea = arr[0];
                var totalIva = arr[1];
                $("#total").html(linea);
                $("#graiva").html(totalIva);
            });


        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_cantidad").on('change', function () {
            var id = $("#consulta_valor").val();
            var idv = <?php echo $idv ?>;
            var idca = $("#consulta_cantidad").val();
            var cuenta =$("#consulta_cuenta_contable").val();
             $.get('<?php echo url_for($modulo . "/valor") ?>', {id: id, idv: idv,idca: idca, cuenta:cuenta}, function (response) {
                var respuestali = response;
                var arr = respuestali.split('|');
                var linea = arr[0];
                var totalIva = arr[1];
                $("#total").html(linea);
                $("#graiva").html(totalIva);
            });


        });
    });
</script>



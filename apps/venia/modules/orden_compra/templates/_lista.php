<?php $modulo = 'orden_compra'; ?>
<?php if ($id) { ?>
    <!--<div class="row">
                        <div class="col-lg-10"></div>
                            <div class="col-lg-2">				
                                    <div class="kt-input-icon kt-input-icon--left">
                                        <input type="text" class="form-control" placeholder="Buscar..." >
                                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                            <span><i class="la la-search"></i></span>
                                        </span>
                                    </div>
                            </div>
                        </div>-->
<?php } ?>
<table class="table table-bordered "  >
    <thead class="flip-content">
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success">Producto /  Servicio </span></th>
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Valor Unitario </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
            <th></th>

        </tr>
    </thead>
    <?php if ($id) { ?>
        <tbody>
            <?php $can = 0; ?>
            <?php $grantotal = 0; ?>
            <?php foreach ($listado as $registro) { ?>
                <?php $lista = $registro; ?>
                <?php $can++; ?>
                <?php $pid = $lista->getId(); ?>
                <?php $can = $lista->getCantidad(); ?>
                <?php $val = $lista->getValorUnitario(); ?>
                <?php $total = $lista->getValorUnitario() * $can; ?>
                <?php $grantotal = $total + $grantotal; ?>
                <?php $detalle = $lista->getObservaciones(); ?>

                <tr <?php if (($can % 2) == 0) { ?>  style="background-color:#ebedf2"  <?php } ?> >
                    <td  rowspan="2" ><?php echo $can; ?> </td>
                    <td><?php
                        if ($registro->getProductoId()) {
                            echo substr($registro->getProducto()->getCodigoSku(), -6);
                        }
                        ?>
                        <?php
                        if ($registro->getServicioId()) {
                            echo substr($registro->getServicio()->getCodigo(), -6);
                        }
                        ?></td>    
                    <td><?php echo $registro->getDetalle(); ?></td>    
                    <td><?php //echo $registro->getValorUnitario();   ?>
                        <input    class="form-control " value="<?php echo $val ?>" type="number" step="any" id="consulta_valor_<?php echo $lista->getId() ?>"  
                                  name="consulta[valor_<?php echo $lista->getId() ?>]" onkeypress='validateX<?php echo $lista->getId() ?>(event)' >
                    </td>    
                    <td><?php //echo $registro->getCantidad();   ?>
                        <input min="1"   class="form-control xlarge" value="<?php echo $can ?>"  id="consulta_numero_<?php echo $pid ?>"  
                               name="consulta[numero_<?php echo $pid ?>]" onkeypress='validate<?php echo $pid ?>(event)' >
                    </td>    
                    <td><?php //echo $registro->getValorTotal();   ?>
                        <div  align="right" class="total_<?Php echo $pid ?>" id="total_<?Php echo $pid ?>"><?php echo number_format($total, 2); ?></div>


                    </td>    
                    <td rowspan="2" style="padding-top:45px;">   <a href="<?php echo url_for($modulo . '/eliminaLinea?id=' . $pid) ?>" class="btn btn-sm  btn-danger" > <i class="fa fa-trash"></i>  </a></td>

                </tr>

                <tr  <?php if (($can % 2) == 0) { ?>  style="background-color:#ebedf2"  <?php } ?> >
                    <td style="text-align:right; align-content: right "> <strong>Detalle </strong> </td>
                    <td colspan="4">
                        <textarea name="consulta[det_<?php echo $lista->getId() ?>]" id="consulta_det_<?php echo $lista->getId() ?>"  name="textarea" rows="3" class="form-control" ><?php echo $detalle ?></textarea>
  </td>
                  

                </tr>
    <?php } ?>
        </tbody>
<?php } ?>
</table>


<?php foreach ($listado as $lis) { ?>
    <?php $id = $lis->getId(); ?>
    <?php $idv = $lis->getId(); ?>  
    <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_numero_<?php echo $id ?>").on('change', function () {
                var id = $("#consulta_numero_<?php echo $id ?>").val();
                var idv = <?php echo $idv ?>;
                $.get('<?php echo url_for($modulo . "/cantidad") ?>', {id: id, idv: idv}, function (response) {
                    var respuestali = response;
                    var arr = respuestali.split('|');
                    var linea = arr[0];
                    var totalResumen = arr[1];
                    var totalIva = arr[2];
                    var totalSinIva = arr[3];
                    $("#total_<?php echo $id ?>").html(linea);
                    $("#gratotal").html(totalResumen);
                    $("#graiva").html(totalIva);
                    $("#grasubtotal").html(totalSinIva);
                });


            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_valor_<?php echo $id ?>").on('change', function () {
                var id = $("#consulta_valor_<?php echo $id ?>").val();
                var idv = <?php echo $idv ?>;
                $.get('<?php echo url_for($modulo . "/valor") ?>', {id: id, idv: idv}, function (response) {
                    var respuestali = response;
                    var arr = respuestali.split('|');
                    var linea = arr[0];
                    var totalResumen = arr[1];
                    var totalIva = arr[2];
                    var totalSinIva = arr[3];
                    $("#total_<?php echo $id ?>").html(linea);
                    $("#gratotal").html(totalResumen);
                    $("#graiva").html(totalIva);
                    $("#grasubtotal").html(totalSinIva);

                });


            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_det_<?php echo $id ?>").on('change', function () {
                var id = $("#consulta_det_<?php echo $id ?>").val();
                var idv = <?php echo $idv ?>;
                $.get('<?php echo url_for($modulo . "/detalle") ?>', {id: id, idv: idv}, function (response) {

                });


            });
        });
    </script>



    <script>
        function validate<?php echo $id ?>(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }
    </script>


<?php } ?>
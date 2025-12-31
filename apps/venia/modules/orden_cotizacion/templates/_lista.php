<?php $modulo = 'orden_cotizacion'; ?>
<br><br>

<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
<!--            <th  align="center"><span class="kt-font-success"># </span></th>-->
            <th  align="center"><span class="kt-font-success">Codigo  </span></th>
<!--            
            <th  align="center"><span class="kt-font-success">Servicio </span></th>-->
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Valor Unitario </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
            <th></th>

        </tr>
    </thead>
    <?php if ($id) { ?>
    <tbody>
        <?php $can=0; ?>
          <?php $grantotal=0; ?>
        <?php foreach ($listado  as $registro) { ?>
        <?php $Max=999; ?>
        <?php if ($registro->getProductoId()) {  ?>
        <?php $Max=$registro->getProducto()->getExistencia()-$registro->getProducto()->getTransito();; //Bodega($registro->getOrdenCotizacion()->getTiendaId()); ?>
        
        <?php } ?>
            <?php $lista= $registro; ?>
        <?php $can++; ?>
             <?php $pid = $lista->getId(); ?>
            <?php $can = $lista->getCantidad(); ?>
            <?php $val = $lista->getValorUnitario(); ?>
            <?php $total = $lista->getValorUnitario() * $can; ?>
        <?php $grantotal= $total+$grantotal; ?>
        
        <tr>
<!--            <td><?php echo $can; ?> </td>-->
            <td>
             <a class="btn btn-block  btn-xs " style="font-size: 11px !important;" data-toggle="modal" href="#staticE<?php echo $registro->getId() ?>">
               <?php if ($registro->getProductoId()) { echo  $registro->getProducto()->getCodigoSku(); } ?>
                <?php if ($registro->getServicioId()) { echo  $registro->getServicio()->getCodigo(); } ?>
              </a>
               
            </td>    
            <td><?php echo $registro->getDetalle(); ?> </td>    
                    <td style="text-align:right; padding-right: 8px; font-weight: bold; font-size: 14px;">
                        <?php if ($registro->getId()==$edit) { ?>
                <input    class="form-control " value="<?php echo $val ?>" type="number" step="any" id="consulta_valor_<?php echo $lista->getId() ?>"  
            name="consulta[valor_<?php echo $lista->getId() ?>]" value="            <?php  echo $registro->getValorUnitario(); ?>" >
     
                        <?php } else {  ?>
            <?php  echo $registro->getValorUnitario(); ?>
                        <?php  } ?>
            </td>
            <td style="text-align:right; padding-right: 8px; font-weight: bold; font-size: 14px;">
                
                <?php if ($lista->getComboNumero()=="") { ?>
                <input min="1"   class="form-control xlarge" value="<?php echo $can ?>" type="number" id="consulta_numero_<?php echo $pid ?>"  
                  min="1" max="<?php echo $Max; ?>"         name="consulta[numero_<?php echo $pid ?>]" onkeypress='validate<?php echo $pid ?>(event)' >
                <?php } else { ?>
                <?php echo $registro->getCantidad(); ?>
                
                <?php } ?> <?php //echo $Max; ?>
            </td>    
               
            <td><?php //echo $registro->getValorTotal(); ?>
            <div  align="right" class="total_<?Php echo $pid ?>" id="total_<?Php echo $pid ?>"><?php echo number_format($total, 2); ?></div>
            
            
            </td>    
            <td>   <a href="<?php echo url_for($modulo . '/eliminaLinea?id='.$pid) ?>" class="btn btn-sm  btn-danger" > -  </a></td>
       
        </tr>
        <?php } ?>
    </tbody>
    <?php } ?>
</table>


<script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_nit").on('change', function () {
                var nit = $("#consulta_nit").val();
                $.get('<?php echo url_for("soporte/buscaNit") ?>', {nit: nit}, function (response) {
                    $("#consulta_nombre").val(response);
              });


            });
        });
    </script>
    
    

<?php foreach ($listado as $lis) { ?>

       <div id="staticE<?php echo $lis->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Editar Precio</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de editar precio
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $lis->getDetalle() ?>
                                    </span> ?
                                </p>
                            </div>
                                      <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn green " href="<?php echo url_for('orden_cotizacion/index?edit=' . $lis->getId()) ?>" >
                                    <i class="fla flaticon2-checking "></i> Confirmar</a> 
                            </div>
                        </div>
                    </div>
                </div> 


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
                      var canti =arr[4];
                    $("#total_<?php echo $id ?>").html(linea);
                    $("#gratotal").html(totalResumen);
                    $("#graiva").html(totalIva);
                    $("#grasubtotal").html(totalSinIva);
                    $("#consulta_numero_<?php echo $id ?>").val(canti);
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

    <script>
        function validate<?php echo $id ?>(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-8]|\9/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }
    </script>


<?php } ?>
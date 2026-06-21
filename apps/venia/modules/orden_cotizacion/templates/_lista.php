<?php $modulo = 'orden_cotizacion'; ?>

<?php    $Precios = ListaPrecioQuery::create()->filterByConfidencial(false)->orderByNombre()->filterByActivo(true)->find(); ?>
<?php        $Precioscon = ListaPrecioQuery::create()->filterByConfidencial(true)->orderByNombre()->filterByActivo(true)->find(); ?>
   
<?php $tipoUsua = strtoupper(sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad')); ?>
<br><br>
<style>
.eli-check {
    transform: scale(1.9);
    cursor: pointer;
    margin-left: 8px;
}
</style>
<?php  $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario()); ?>
<form method="post" action="<?php echo url_for('orden_cotizacion/eliminarMultiple') ?>" id="formEliminar">
<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
            <td></td>
            <th  align="center"><span class="kt-font-success">Codigo  </span></th>
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Valor Unitario </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
            <th></th>
        </tr>
    </thead>
    <?php if ($id) { ?>
    <tbody>
        <?php $pos=0; ?>
        <?php $archi=0; ?>
          <?php $grantotal=0; ?>
        <?php foreach ($listado  as $registro) { ?>
        <?php if ($registro->getArchivo()) { ?>       <?php $archi++; ?>  <?php } ?>
        <?php $Max=999; ?>
        <?php if ($registro->getProductoId()) {  ?>
        <?php $Max=$registro->getProducto()->getExistencia()-$registro->getProducto()->getTransito();; //Bodega($registro->getOrdenCotizacion()->getTiendaId()); ?>
        <?php } ?>
          <?php $lista= $registro; ?>
         <?php $pos++; ?>
          <?php $pid = $lista->getId(); ?>
            <?php $can = $lista->getCantidad(); ?>
            <?php $val = $lista->getValorUnitario(); ?>
            <?php $total = $lista->getValorUnitario() * $can; ?>
        <?php $grantotal= $total+$grantotal; ?>
        
        <tr <?php if ($registro->getArchivo()) { ?> style="color: #0924A9; font-weight:bold;"<?php } ?> >   
            <td><?php echo $pos; ?> </td>
            <td>
             <a class="btn btn-block  btn-xs " style=" font-size: 11px !important;" data-toggle="modal" href="#staticE<?php echo $registro->getId() ?>">
               <?php if ($registro->getProductoId()) { echo  $registro->getProducto()->getCodigoSku(); } ?>
                <?php if ($registro->getServicioId()) { echo  $registro->getServicio()->getCodigo(); } ?>
              </a>
               
            </td>    
            <td <?php if ($registro->getExistenciaActual()>0) { ?> style="background-color:#F59B89" <?php  } ?>><?php echo $registro->getDetalle(); ?> </td>    
                    <td style=" text-align:right; padding-right: 8px; font-weight: bold; font-size: 14px;">
                        <?php if ($registro->getId()==$edit) { ?>
                <input    class="form-control " value="<?php echo $val ?>" type="number" step="any" id="consulta_valor_<?php echo $lista->getId() ?>"  
            name="consulta[valor_<?php echo $lista->getId() ?>]" value="            <?php  echo $registro->getValorUnitario(); ?>" >
     
                        <?php } else {  ?>
            <?php  echo $registro->getValorUnitario(); ?>
                        <?php  } ?>
            </td>
            <td style="text-align:right; padding-right: 8px; font-weight: bold; font-size: 14px;">
                <?php //echo $registro->getExistenciaActual(); ?>
           
        <?php if ($registro->getExistenciaActual()>0) { ?>
                <span style="width:100%; background-color: #F24522; padding: 2px;  text-align: center"><font size='-2'>Solicitado&nbsp;&nbsp;</font><?php echo $registro->getCantidad(); ?></span>
            <?php $can = $registro->getExistenciaActual(); ?>
        <?php } ?>
             <input min="1"   class="form-control xlarge" value="<?php echo $can ?>" type="number" id="consulta_numero_<?php echo $pid ?>"  
                    name="consulta[numero_<?php echo $pid ?>]" onkeypress='validate<?php echo $pid ?>(event)' >
        <?php if ($registro->getProductoId()) {  ?>
             <span  style="font-size: 13px;  padding-right: 20px; padding-left: 20px; background-color:whitesmoke">  <?php echo $registro->getProducto()->getExistencia(); ?> </span>
            <?php } ?>
            </td>    
               
            <td><?php //echo $registro->getValorTotal(); ?>
            <div  align="right" class="total_<?Php echo $pid ?>" id="total_<?Php echo $pid ?>"><?php echo number_format($total, 2); ?></div>
            
            
            </td>    
    <td style="display:flex; align-items:center; gap:8px;">
    <a href="<?php echo url_for($modulo . '/eliminaLinea?id='.$pid) ?>" 
       class="btn btn-sm btn-danger">-</a>

    <input type="checkbox"
           class="eli-check"
           id="eli<?php echo $pid ?>"
           name="eli[]"
           value="<?php echo $pid ?>">
</td>
       
        </tr>
        <?php } ?>
    </tbody>
    <?php } ?>
</table>
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-3"> <?php if ($archi) { ?>
 <a href="<?php echo url_for($modulo . '/cargacancel') ?>" 
       class="btn btn-sm btn-info"> Cancelar Carga </a>

 <?php } ?> </div>
        
        <div class="col-md-4">
            <button type="button" 
        id="btnEliminarSeleccionados" 
        class="btn btn-danger btn-sm">
    Eliminar seleccionados
</button>
        </div>
        
    </div>


</form>

<div id="modalEliminar" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p id="textoConfirmacion"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
                <button id="confirmarEliminar" class="btn btn-danger">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    $("#btnEliminarSeleccionados").click(function(){

        let total = $(".eli-check:checked").length;

        if(total === 0){
            alert("Debe seleccionar al menos un registro");
            return;
        }

        $("#textoConfirmacion").html(
            "¿Está seguro de eliminar <b>" + total + "</b> registros?"
        );

        $("#modalEliminar").modal("show");
    });

    $("#confirmarEliminar").click(function(){
        $("#formEliminar").submit();
    });

});
</script>

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
    
    <?php if ($ListaDetalle) { ?>
  
        <div id="staticPE" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                       <?php if ($ListaDetalle->getProductoId()) { ?> 
                                <h4> <?php echo $ListaDetalle->getProducto()->getCodigoSku(); ?> <?php echo $ListaDetalle->getProducto()->getNombre(); ?> </h4>
                                       <?php } ?>
                         
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                             
                            </div>
                        
                            <?php if (!$ListaDetalle->getProductoId()) { ?>
                            <div class="modal-body">
                                <p> Esta seguro de editar precio
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $ListaDetalle->getDetalle() ?>
                                    </span> ?
                                </p>
                            </div>
                                      <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn green " href="<?php echo url_for('orden_cotizacion/index?edit=' . $ListaDetalle->getId()) ?>" >
                                    <i class="fla flaticon2-checking "></i> Confirmar</a> 
                            </div>
                            <?php } ?>
                            
                          <?php if ($ListaDetalle->getProductoId()) { ?> 
                            <div class="modal-body">
                                <div class='row'>
                                    <div class="col-lg-12" style="text-align:center;">
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-6">
                                    
                                        <?php $Menor=$ListaDetalle->getProducto()->getPrecio(); ?>
                                         <?php if ($TIPO_USUARIO=='ADMINISTRADOR') { ?>
                                        <?php //$Menor=$ListaDetalle->getProducto()->getPrecio; ?>

                                        <?php } ?>
                                        
                                             <form action="<?php echo url_for('orden_cotizacion/precio') ?>" method="get">
                                        <table class="table ">
                                            <tr>
                                                <th>PUBLICO</th>
                                                <td style="text-align: right;"><?php echo Parametro::formato($ListaDetalle->getProducto()->getPrecio()); ?></td>
                                                <td style="width:30px;">
                                                    <a class="btn btn-sm   btn-primary " href="<?php echo url_for('orden_cotizacion/precioEdit?edit=' . $ListaDetalle->getId()."&valor=".$ListaDetalle->getProducto()->getPrecio()) ?>"><i class="fa fa-check"></i> </a>  
                                                </td>
                                            </tr>
                                            <?php foreach($precios as $deta) { ?>
                                            <?php if ($ListaDetalle->getProducto()->getPrecioLista($deta->getId()) < $Menor) { ?>
                                            <?php $Menor=$ListaDetalle->getProducto()->getPrecioLista($deta->getId()); ?>
                                                <?php  } ?>
                                            <tr>
                                                <th style="text-align: left;"><?php echo $deta->getNombre(); ?></th>
                                                <td style="text-align: right;"><?php echo Parametro::formato($ListaDetalle->getProducto()->getPrecioLista($deta->getId())); ?></td>
                                                <td>
                                                    <a class="btn btn-sm   btn-primary " href="<?php echo url_for('orden_cotizacion/precioEdit?edit=' . $ListaDetalle->getId()."&valor=".$ListaDetalle->getProducto()->getPrecioLista($deta->getId())) ?>"><i class="fa fa-check"></i> </a>  
                                                </td>
                                            </tr>                                            
                                            <?php } ?>
                                            
                                            
                                                   <?php if ($tipoUsua == "ADMINISTRADOR") { ?>
                                              <?php foreach($Precioscon as $deta) { ?>
                                            <?php if ($ListaDetalle->getProducto()->getPrecioLista($deta->getId()) < $Menor) { ?>
                                            <?php $Menor=$ListaDetalle->getProducto()->getPrecioLista($deta->getId()); ?>
                                                <?php  } ?>
                                            <tr>
                                                <th style="text-align: left;"><?php echo $deta->getNombre(); ?></th>
                                                <td style="text-align: right;"><?php echo Parametro::formato($ListaDetalle->getProducto()->getPrecioLista($deta->getId())); ?></td>
                                                <td>
                                                    <a class="btn btn-sm   btn-primary " href="<?php echo url_for('orden_cotizacion/precioEdit?edit=' . $ListaDetalle->getId()."&valor=".$ListaDetalle->getProducto()->getPrecioLista($deta->getId())) ?>"><i class="fa fa-check"></i> </a>  
                                                </td>
                                            </tr>                                            
                                            <?php } ?>
                                                   <?php } ?>
                                            <?php $min = $Menor; ?>
                                             <?php if ($TIPO_USUARIO=='ADMINISTRADOR') { ?>
                                            <?php $min = 0; ?>

                                             <?php } ?>
                                            
                                            <input type="hidden" id='lineaid' name='lineaid' value='<?php echo $ListaDetalle->getId(); ?>' />
                                            <input type="hidden" id='mini<?php echo $ListaDetalle->getId(); ?>' name='mini<?php echo $ListaDetalle->getId(); ?>' value='<?php echo $min; ?>' />
                                               <tr>
                                                <th>NUEVO PRECIO</th>
                                                <td style="text-align: right;"><input min="<?php $min; ?>" class="form-control" id="nuevoprecio<?php echo $ListaDetalle->getId(); ?>" name="nuevoprecio<?php echo $ListaDetalle->getId(); ?>" value="<?php echo $Menor; ?>" /></td>
                                                <td>
                                                <button class="btn btn-sm  btn-primary " type="submit"><i class="fa fa-check"></i></button>
                                                </td>
                                               </tr>
                                               <tr style="background-color:#E9F1F5; height: 15px !important;">
                                                   <th>CANTIDAD</th>
                                                   <td>
                                                       <input type="number" min="1" class="form-control" id="cantidad" name="cantidad" value="1" />
                                                       
                                                   </td>

                                                   <td></td>
                                               </tr>
                                        </table>
                                               </form>
                                        
                                    </div>                                    
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
             
                               
                            </div>
                          <?php } ?>
                        </div>
                    </div>
                </div> 
    
   <script>
        $(document).ready(function () {
            $("#staticPE").modal();
        });
    </script>
    
    
    <script type="text/javascript">
        $(document).ready(function () {
            $("#cantidad").on('change', function () {
                var id = $("#cantidad").val();
                var idv = <?php echo $ListaDetalle->getId(); ?>;
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
                    $("#consulta_numero_<?php echo $ListaDetalle->getId(); ?>").val(canti);
              });


            });
        });
    </script>
    
    <?php  } ?>
    
    
    
    
    
    

<?php foreach ($listado as $lis) { ?>

       <div id="staticE<?php echo $lis->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Editar Precio</span>
                            </div>
                        
                            <?php if (!$lis->getProductoId()) { ?>
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
                            <?php } ?>
                            
                                        <?php if ($lis->getProductoId()) { ?> 
                            <div class="modal-body">
                                <div class='row'>
                                    <div class="col-lg-12" style="text-align:center;">
                                            <h4> <?php echo $lis->getProducto()->getCodigoSku(); ?> <?php echo $lis->getProducto()->getNombre(); ?> </h4>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-8">
                                    
                                        <?php $Menor=$lis->getProducto()->getPrecio(); ?>
                                             <form action="<?php echo url_for('orden_cotizacion/precio') ?>" method="get">
                                        <table class="table table-bordered">
                                            <tr style="background-color:#E6F0F2 !important">
                                            <th>LISTA</th>
                                            <th>PRECIO</th>
                                            </tr>
                                            <tr>
                                                <th>PUBLICO</th>
                                                <td style="text-align: right;"><?php echo Parametro::formato($lis->getProducto()->getPrecio()); ?></td>
                                                <td style="width:30px;">
                                                    <a class="btn btn-sm   btn-primary " href="<?php echo url_for('orden_cotizacion/precioEdit?edit=' . $lis->getId()."&valor=".$lis->getProducto()->getPrecio()) ?>"><i class="fa fa-check"></i> </a>  
                                                </td>
                                            </tr>
                                            <?php foreach($precios as $deta) { ?>
                                            <?php if ($lis->getProducto()->getPrecioLista($deta->getId()) < $Menor) { ?>
                                            <?php $Menor=$lis->getProducto()->getPrecioLista($deta->getId()); ?>
                                                <?php  } ?>
                                            <tr>
                                                <th style="text-align: left;"><?php echo $deta->getNombre(); ?></th>
                                                <td style="text-align: right;"><?php echo Parametro::formato($lis->getProducto()->getPrecioLista($deta->getId())); ?></td>
                                                <td>
                                                    <a class="btn btn-sm   btn-primary " href="<?php echo url_for('orden_cotizacion/precioEdit?edit=' . $lis->getId()."&valor=".$lis->getProducto()->getPrecioLista($deta->getId())) ?>"><i class="fa fa-check"></i> </a>  
                                                </td>
                                            </tr>                                            
                                            <?php } ?>
                                              <?php $min = $Menor; ?>
                                             <?php if ($TIPO_USUARIO=='ADMINISTRADOR') { ?>
                                            <?php $min = 0; ?>

                                             <?php } ?>
                                            
                                            <input type="hidden" id='lineaid' name='lineaid' value='<?php echo $lis->getId(); ?>' />
                                            <input type="hidden" id='mini<?php echo $lis->getId(); ?>' name='mini<?php echo $lis->getId(); ?>' value='<?php echo $min; ?>' />
                                               <tr>
                                                <th>NUEVO PRECIO</th>
                                                <td style="text-align: right;"><input min="<?php $min; ?>" class="form-control" id="nuevoprecio<?php echo $lis->getId(); ?>" name="nuevoprecio<?php echo $lis->getId(); ?>" value="<?php echo $Menor; ?>" /></td>
                                                
                                                <td>
                                                <button class="btn btn-sm  btn-primary " type="submit"><i class="fa fa-check"></i></button>
                                                </td>
                                               </tr>
                                         
                                        </table>
                                               </form>
                                    </div>                                    
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
             
                               
                            </div>
                          <?php } ?>
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
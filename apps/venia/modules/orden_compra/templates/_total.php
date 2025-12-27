<?php $va=0; ?>
<?php $pideGas =false; ?>
<?php if ($orden) { ?>
<?php $va  = $orden->getImpuestoGas(); ?>
     <?php if ($orden->getEstatus() =="Autorizado") { ?>
<?php $pideGas=true; ?>
     <?php } ?>
<?php } ?>

<div class="row"  style="padding-top: 3px; margin-top: 5px;  padding-bottom: 3px;  background-color: #D8F2F8">        
    <div class="col-lg-1"></div>          
     <?php if ($pideGas) { ?>
    <div class="col-lg-2" style="text-align:right">
                <span class="kt-font-success"> <h5>IMPUESTO GAS </h5>  </span>
     </div>
    <div class="col-lg-2">
        <input class="form-control "  placeholder="0.00"  <?php if ($va) { ?> value="<?php echo $va; ?>" <?php } ?> type="number"  id="impuesto_gas" name="impuesto_gas" >
    </div>
     <?php }  else { ?>
    <div class="col-lg-4"></div>
     <?php } ?>
            <div class="col-lg-1">
                <span class="kt-font-success"> <h5>SUB TOTAL </h5>  </span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><div name="grasubtotal" id ="grasubtotal"><?php if ($orden)  { echo  Parametro::formato($orden->getSubTotal(),false);   } ?></div>  </span>
            </div>                
            <div class="col-lg-1"  style="text-align:right">
                <span class="kt-font-success"><h5>IVA  </h5></span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><div name="graiva" id ="graiva"><?php if ($orden)  { echo  Parametro::formato($orden->getIva(),false);   } ?></div>  </span>
            </div>                
            <div class="col-lg-1"  style="text-align:right">
                <span class="kt-font-success"><h5>TOTAL </h5> </span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><h3> <div name="gratotal" id ="gratotal"><?php if ($orden)  { echo Parametro::formato($orden->getValorTotal());   } ?></div></h3> </span>
            </div>                

        </div>

<?php if (count($listado) >0) { ?>
<?php $image ='300.jpg'; ?>
<?php $tituloBoton ='Confirmar'; ?>
<?php  $icon='flaticon-lock'; ?>
<?php $textoLi = '  Confirmar orden de compra '; ?>
    <?php if ($orden->getEstatus() =="Autorizado") { ?>
<?php $tituloBoton ='Finalizar'; ?>
<?php $image ='bg-5.jpg'; ?>
<?php $textoLi=' Finalizar orden de compra '; ?>
<?php $icon ='flaticon2-shield'; ?>
    <?php } ?>
<div class="row" style="background-image: url(./assets/media/bg/<?php echo $image;  ?>);">
    <div class="col-lg-5"></div>
      <div class="col-lg-2">
             <?php if ($orden) { ?>
            <?php if ($orden->getProveedorId()) { ?>
                        <?php  if ($orden->getEstatus() !="Autorizado") {  ?>
          <a href="<?php echo url_for($modulo . '/posponer?id='.$orden->getId()."&token=". sha1($orden->getCodigo())) ?>" class="btn btn-small btn-success" > <i class="flaticon-black"></i><br> Guardar </a>
                        <?Php } ?>
             <?Php } ?>
          <?Php } ?>
      </div>
    <div class="col-lg-3" style="text-align: right"><font color="white"><br> 
     <?php echo $textoLi; ?>
        
        </font></div>
    <div class="col-lg-1">
          <?php if ($orden) { ?>
            <?php if ($orden->getProveedorId()) { ?>
<!--        <a href="<?php echo url_for($modulo . '/confirmar?id='.$orden->getId()."&token=". sha1($orden->getCodigo())) ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-lock"></i> Procesar </a>-->
          <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-dark" > <i class="<?php echo $icon; ?>"></i> <?php echo $tituloBoton; ?> </a>
     <?Php } else { ?>
          <SPAN style='color:red; font-weight: bold;'>&nbsp;SELECCIONE<br> PROVEEDOR&nbsp;</span>
          <?Php } ?>
          <?Php } ?>
    </div>
     <div class="col-lg-1">
         <a target="_blank" href="<?php echo url_for('reporte/ordenCompra?token='.$orden->getToken()) ?>" class="btn btn-secondary btn-warning" > <i class="flaticon2-print"></i><br> Reporte </a>
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
                                <p>  <?php echo $textoLi; ?>
                                    <strong>Orden de Compra</strong>
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $orden->getCodigo() ?>
                                    </span> ?
                                </p>
                            </div>

                            <div class="modal-footer">
                                <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmar?id='.$orden->getId()."&token=". sha1($orden->getCodigo())) ?>" >
                                    <i class="flaticon2-lock "></i> <?php echo $tituloBoton; ?> </a> 
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                            </div>

                        </div>
                    </div>
                </div>
<?php }?>


<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->

<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content" style=" width: 750px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Agrega Servicio</h4>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxmodalv" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content" style=" width: 750px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Busqueda Proveedor</h4>
            </div>
        </div>
    </div>
</div>


<?php if ($pideGas) { ?>

          <script type="text/javascript">
        $(document).ready(function () {
            $("#impuesto_gas").on('change', function () {
                var valor = $("#impuesto_gas").val();
                var id =<?php echo $orden->getId(); ?> 
                $.get('<?php echo url_for("orden_compra/valorGas") ?>', {id: id, valor: valor}, function (response) {
                   var respuestali = response;
                    var arr = respuestali.split('|');
                    var subtotal = arr[0];
                    var iva = arr[1];
                     $("#grasubtotal").html(subtotal);
                    $("#graiva").html(iva);
                     
                });
            });
        });
    </script>
    
<?php } ?>
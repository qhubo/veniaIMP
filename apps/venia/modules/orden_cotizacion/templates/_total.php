        <div class="row">        
            <div class="col-lg-4"></div>
            <div class="col-lg-1">
                <span class="kt-font-success"> <h5>SUB TOTAL </h5>  </span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><div name="grasubtotal" id ="grasubtotal"><?php if ($orden)  { echo number_format($orden->getSubTotal(),2);   } ?></div>  </span>
            </div>                
            <div class="col-lg-1">
                <span class="kt-font-success"><h5>IVA  </h5></span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><div name="graiva" id ="graiva"><?php if ($orden)  { echo number_format($orden->getIva(),2);   } ?></div>  </span>
            </div>                
            <div class="col-lg-1">
                <span class="kt-font-success"><h5>TOTAL </h5> </span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><h3> <div name="gratotal" id ="gratotal"><?php if ($orden)  { echo number_format($orden->getValorTotal(),2);   } ?></div></h3> </span>
            </div>                

        </div>

<?php if (count($listado) >0) { ?>
<div class="row" style="background-image: url(./assets/media/bg/bg-6.jpg);">
    <div class="col-lg-5"></div>
      <div class="col-lg-2">

    </div>
    <div class="col-lg-3" style="text-align: right"><font color="white"><br>  Confirmar venta </font></div>
    <div class="col-lg-1">
<!--        <a href="<?php echo url_for($modulo . '/confirmar?id='.$orden->getId()."&token=". sha1($orden->getCodigo())) ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-lock"></i> Procesar </a>-->
<!--          <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-dark" > <i class="flaticon-lock"></i> Procesar </a>-->
          <a href="<?php echo url_for($modulo . '/posponer?id='.$orden->getId()."&token=". sha1($orden->getCodigo())) ?>" class="btn btn-small btn-success btn-block" > <i class="flaticon-black"></i><br> Enviar </a>
    </div>
     <div class="col-lg-1">
         <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token='.$orden->getToken()) ?>" class="btn btn-secondary btn-warning" > <i class="flaticon2-print"></i><br> Reporte </a>
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
                                <p> Confirma Procesar Documento
                                    <strong>Cotización</strong>
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $orden->getCodigo() ?>
                                    </span> ?
                                </p>
                            </div>

                            <div class="modal-footer">
                                <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmar?id='.$orden->getId()."&token=". sha1($orden->getCodigo())) ?>" >
                                    <i class="flaticon2-lock "></i> Confirmar </a> 
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                            </div>

                        </div>
                    </div>
                </div>
<?php }?>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
                <h4 class="modal-title" id="myModalLabel6">Busqueda Cliente</h4>
            </div>
        </div>
    </div>
</div>


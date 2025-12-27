        <div class="row" style="padding-top: 5px;">        
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


   <div class="row" style="padding-top: 5px;">        
            <div class="col-lg-4"></div>
                     
            <div class="col-lg-2">
                <span class="kt-font-success"><h5>ISR RETENIDO  </h5></span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><div name="graiva" id ="graisr"><?php if ($orden)  { echo number_format($orden->getValorIsr(),2);   } ?></div>  </span>
            </div>                
            <div class="col-lg-2">
                <span class="kt-font-success"><h5>IVA RETENIDO </h5> </span>
            </div>
            <div class="col-lg-1">
                <span class="kt-font-success"><h5> <div name="graRETIENEivA" id ="graRETIENEivA"><?php if ($orden)  { echo number_format($orden->getValorRetieneIva()+$orden->getValorRetenidoIva(),2);   } ?></div></h5> </span>
            </div>  
            

        </div>

<?php if (count($orden) >0) { ?>
<div class="row" style="background-size: auto; background-image: url(./assets/media//bg/300.jpg);">
    <div class="col-lg-5"></div>
      <div class="col-lg-2">
          <a href="<?php echo url_for($modulo . '/posponer?id='.$orden->getId()."&token=". sha1($orden->getCodigo())) ?>" class="btn btn-small btn-success" > <i class="flaticon-black"></i><br> Guardar </a>
    </div>
    <div class="col-lg-3" style="text-align: right"><font color="white"><br>  Confirmar Gasto </font></div>
    <div class="col-lg-1">
        <?php //echo  ?>
        
        <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-dark" > <i class="flaticon-lock"></i> Procesar </a>
    </div>
     <div class="col-lg-1">
         <a target="_blank" href="<?php echo url_for('reporte/gasto?token='.$orden->getToken()) ?>" class="btn btn-secondary btn-warning" > <i class="flaticon2-print"></i><br> Reporte </a>
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
                                    <strong>Gasto</strong>
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



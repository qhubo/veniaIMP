<!--<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>-->
<div id="ajaxmodalPartida" class="ajaxmodalPartida">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getNoAsiento(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-2" style="font-size: 13px; font-weight: bold">FECHA PARTIDA</div>
                        <div class="col-8"><?php echo $partidaPen->getFechaContable('d/m/Y') ?></div>
                    </div>
                                        <div class="row">
                        <div class="col-1"></div>
                        <div class="col-3" style="font-size: 13px; font-weight: bold">PARTIDA</div>
                        <div class="col-8"><?php echo $partidaPen->getCompleto() ?></div>
                    </div>
                    
                    
                                          <div class="row">
                        <div class="col-1"></div>
                        <div class="col-3" style="font-size: 13px; font-weight: bold">Tienda</div>
                        <div class="col-8"><?php echo $partidaPen->getTienda(); ?></div>
                    </div>
                                        <div class="row">
                        <div class="col-1"></div>
                        <div class="col-3" style="font-size: 13px; font-weight: bold">FECHA OPERACION</div>
                        <div class="col-8"><?php echo $partidaPen->getFechaOperacion() ?></div>
                    </div>
                    
                                          <div class="row">
                        <div class="col-1"></div>
                        <div class="col-3" style="font-size: 13px; font-weight: bold">Movimiento Banco</div>
                        <div class="col-8"><?php echo $partidaPen->getBanco(); ?></div>
                    </div>
    <?php include_partial('proceso/partidaCambia', array('partidaPen' => $partidaPen)) ?>  
                </div>
            </div>
        </div>
    
    
    
</div>
<!--    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
    <?php foreach ($partidaPen->getListDetalle() as $cta) { ?>
        <script>
            $(document).ready(function () {
                $("#cuenta<?php echo $cta; ?>").select2({
                    dropdownParent: $("#ajaxmodalPartida")
                });
            });
        </script>
    <?php } ?>


<!--<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>-->
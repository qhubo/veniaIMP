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
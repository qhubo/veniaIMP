<?php if ($partida) { ?>


    <div id="staticCONFIRMA" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>  Cierre  de Partida  # 
                        <strong>Confirmar la grabación de partida</strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            Por un valor de  <?php echo Parametro::formato($partida->getValor()) ?>
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmar?id=' . $partida->getId() . "&token=" . sha1($partida->getId())) ?>" >
                        <i class="flaticon2-lock "></i> Confirmar </a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div>
<?php } ?>


<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_valor_debe").on('change', function () {
            var numero = $("#consulta_numero").val();
            var valor = $("#consulta_valor_debe").val();
            var tipo = 1;
            var edit =<?php echo $edit; ?>;
            $.get('<?php echo url_for("partida_manual/valor") ?>', {edit: edit, numero: numero, valor: valor, tipo: tipo}, function (response) {
                var respuesta = response;
                $("#total1").html(respuesta);
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_valor_haber").on('change', function () {
            var numero = $("#consulta_numero").val();
            var valor = $("#consulta_valor_haber").val();
            var tipo = 2;
            var edit =<?php echo $edit; ?>;
            $.get('<?php echo url_for("partida_manual/valor") ?>', {edit: edit,numero: numero, valor: valor, tipo: tipo}, function (response) {
                var respuesta = response;
                $("#total2").html(respuesta);
            });
        });
    });
</script>

<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
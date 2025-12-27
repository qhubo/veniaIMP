<script>
    $(document).ready(function () {
        $("#consulta_region").on('change', function () {
            $("#consulta_departamento").empty();
            $("#consulta_municipio").empty();
            $.getJSON('<?php echo url_for("soporte/dptoRegion") ?>?id=' + $("#consulta_region").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#consulta_departamento").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
        });
    });
</script>


<script>
    $(document).ready(function () {
        $("#consulta_departamento").on('change', function () {
            $("#consulta_municipio").empty();
            $.getJSON('<?php echo url_for("soporte/dptoMunicipioL") ?>?id=' + $("#consulta_departamento").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#consulta_municipio").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
        });
    });
</script>


<?php $modal = sfContext::getInstance()->getUser()->getAttribute('modal', null, 'seguridad');
; ?>

<?php if ($modal) { ?>
    <div id="ajaxmodalConfirma" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Confirmación de Proceso
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                    <span class="caption-subject bold font-yellow-casablanca uppercase"> </span>
                </div>
                <div class="modal-body">
                    <p class=" titulo"> Visita Registrada Con éxito
                        <font size="+2">
                        <i class="flaticon2-checkmark"></i>
                        </font>
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cerrar</button>

                </div>
            </div>
        </div>
    </div> 



    <script>
        $(document).ready(function () {
            $("#ajaxmodalConfirma").modal();
        });
    </script>
<?php } ?>
    
    
    
        <div id="staticCONFIRMA" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación  Visita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>  
                        <strong>Visita </strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            confirma la información ingresada
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmar') ?>" >
                        <i class="flaticon2-lock "></i> Confirmar </a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div>

<?php sfContext::getInstance()->getUser()->setAttribute('modal', null, 'seguridad'); ?>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">COMPLETA FACTURA
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <span class="kt-font-info"  style="font-weight: bold; font-size: 20px; padding: 5px;">   <?php echo $operacion->getCodigo(); ?> </span>
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>

    <div class="kt-portlet__body">

        <?php include_partial($modulo . '/cabecera', array('operacion' => $operacion, 'modulo' => $modulo)) ?>
        <div class="row" style="padding-top:10px;">
            <div class="col-lg-2">
                <a class="btn btn-sm btn-warning btn-block" data-toggle="modal" href="#staticB"> <li class="fa fa-plus"></li>  Servicios</a>


            </div>

            <div class="col-lg-10">        <?php include_partial($modulo . '/lista', array('detalle' => $detalle, 'operacion' => $operacion, 'modulo' => $modulo)) ?></div>

        </div>
        <div class="row">
            <div class="col-lg-9" style="text-align: right;"> CONFIRMAR DESEA FACTURAR PEDIDO</div>
            <div class="col-lg-3">       <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-block btn-sm  btn-secondary btn-dark" > <i class="flaticon-lock"></i> PROCESAR FACTURA </a>
</div>     
        </div>
 
    </div>
</div>

<script src='/assets/global/plugins/jquery.min.js'></script>


<div id="staticB" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="bordered table">
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Valor</th>
                            </tr>
                            <?php foreach ($servicios as $servicio) { ?>
                                <tr>
                                    <td> 
                                        <a href="<?php echo url_for($modulo . '/agrega?id=' . $operacion->getId() . "&servicio=" . $servicio->getId()) ?>" class="btn btn-block btn-sm" > 
                                            <?php echo $servicio->getCodigo(); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo url_for($modulo . '/agrega?id=' . $operacion->getId() . "&servicio=" . $servicio->getId()) ?>" class="btn btn-block btn-sm" > 
                                            <?php echo $servicio->getNombre(); ?>
                                        </a>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="<?php echo url_for($modulo . '/agrega?id=' . $operacion->getId() . "&servicio=" . $servicio->getId()) ?>" class="btn btn-block btn-sm" > 
                                            <?php echo Parametro::formato($servicio->getPrecio(), false); ?>
                                        </a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

            </div>

        </div>
    </div>
</div> 

<script type="text/javascript">
    $(document).ready(function () {
        $("#transporte").on('change', function () {
            var id = <?php echo $operacion->getId(); ?>;
            var val = $("#transporte").val();
            $.get('<?php echo url_for("pedido_factura/transporte") ?>', {id: id, val: val}, function (response) {
            });
        });
    });
</script>

<?php foreach ($detalle as $registro) { ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#valor<?php echo $registro->getId(); ?>").on('change', function () {
            var id = <?php echo $registro->getId(); ?>;
            var val = $("#valor<?php echo $registro->getId(); ?>").val();
            $.get('<?php echo url_for("pedido_factura/cambia") ?>', {id: id, val: val}, function (response) {
                 $("#linea<?php echo $registro->getId(); ?>").val(response.linea);
                $("#total").html(response.total);
            },
       'json'        
    );
        });
    });
</script>

<?php } ?>


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
                                    <strong>FACTURA</strong>
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $operacion->getCodigo() ?>
                                    </span> ?
                                </p>
                            </div>

                            <div class="modal-footer">
                                <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmar?id='.$operacion->getId()."&token=". sha1($operacion->getCodigo())) ?>" >
                                    <i class="flaticon2-lock "></i> Confirmar </a> 
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                            </div>

                        </div>
                    </div>
                </div>
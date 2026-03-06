<?php $modulo = $sf_params->get('module'); ?>
<style>
    .box-empaque {
        background-color: #f8f9fa;       /* fondo suave */
        border: 2px solid #dee2e6;       /* borde gris claro */
        border-radius: 6px;              /* 🔥 pequeño rounded */
        padding: 12px 10px;
    }

    .select-empaque {
        background-color: #ffffff;       
        border: 1px solid #0d6efd;       /* borde azul */
        border-radius: 5px;              /* pequeño rounded */
        height: 38px;
    }

    .select-empaque:focus {
        border-color: #084298;
        box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25);
    }

    .btn-empaque {
        border-radius: 5px;              /* pequeño rounded */
    }
</style>

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

        <?php include_partial($modulo . '/cabecera', array('transportes' => $transportes, 'operacion' => $operacion, 'modulo' => $modulo)) ?>

        <form action="<?php echo url_for('pedido_factura/agregarEmpa') ?>" method="GET">
            <div class="row box-empaque"  style="padding-top:5px;">
                <div class="col-lg-2"></div>
                <div class="col-lg-2" style="font-size: 16px; font-weight: bold;">Agregar Lista Empaque </div>
                <div class="col-lg-4">
                    <input  type="hidden" id="pedido" value="<?php echo $operacion->getCodigo() ?>" name="pedido">
                    <select class="form-control select-empaque" name="em" id="em">
                        <option selected="selected" >Seleccione</option>

                        <?php foreach ($empaques as $preci) { ?>
                            <?php $ordenCoti = OrdenCotizacionEmpaqueQuery::create()->findOneByOrdenEmpaque($preci->getId()); ?>
                            <?php if (!$ordenCoti) { ?>
                                <option value="<?php echo $preci->getId(); ?>"     > <?php echo $preci->getCodigo(); ?> <?php echo $preci->getNombre(); ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>              
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-xs btn-primary " type="submit">
                        <i class="fa fa-plus"></i> Agregar
                    </button>
                </div>
                       <div class="col-lg-2">
  
            </div>
                
            </div>
        </form>        
        <div class="row" style="padding-top:10px;">
            <div class="col-lg-2">
                <a class="btn btn-sm btn-warning btn-block" data-toggle="modal" href="#staticB"> <li class="fa fa-plus"></li>  Servicios</a>


            </div>

            <div class="col-lg-10">  

                <?php include_partial($modulo . '/lista', array('detalle' => $detalle,  'operacion' => $operacion, 'modulo' => $modulo)) ?></div>

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
                    <span class="caption-subject font-green bold uppercase" style="font-weight: bold; font-size: 13px;"> 
                        <?php echo $operacion->getCodigo() ?>
                    </span> ?
                </p>
            </div>
            <?php $CAMPOuSUARIO = CampoUsuarioQuery::create()->findOneByNombre("SERIEFAC"); ?>
            <?php if ($CAMPOuSUARIO) { ?>
                <?php $lista = $CAMPOuSUARIO->getValores(); ?>
                <?php $lista = explode(",", $lista); ?>
                <?php $lista[trim($operacion->getPrefijo())] = trim($operacion->getPrefijo()); ?>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2" style="font-weight:bold; font-size: 14px">Tipo Serie</div>
                    <div class="col-lg-3">  
                        <select id="tipoSerie" class="form-control">
                            <?php foreach ($lista as $de) { ?>
                                <option <?php if ($operacion->getPrefijo() == $de) { ?> selected="" <?Php } ?> value="<?php echo trim($de); ?>"> <?php echo $de; ?> </option>
                            <?php } ?>
                        </select>
                    </div> 
                </div>
            <?PHP } ?>
            <div class="modal-footer">
                <a class="btn btn-success" id="btnConfirmar">
                    <i class="flaticon2-lock"></i> Confirmar
                </a>
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById("btnConfirmar").addEventListener("click", function () {

        // capturar valor del select
        var tipoSerie = document.getElementById("tipoSerie").value;

        if (!tipoSerie) {
            alert("Seleccione el tipo de serie");
            return;
        }

        // construir URL Symfony
        var url = "<?php echo url_for($modulo . '/confirmar') ?>?id=<?php echo $operacion->getId() ?>";

                // agregar parámetro
                url += "&tipoSerie=" + encodeURIComponent(tipoSerie);

                // redireccionar
                window.location.href = url;
            });
</script>

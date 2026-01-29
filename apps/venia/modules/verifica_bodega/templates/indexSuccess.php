<!--<meta http-equiv="refresh" content="30">-->
<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Productos Solcitados para Empaque
                <small>&nbsp;&nbsp;&nbsp; &nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar"> </div>
    </div>
    <div class="kt-portlet__body">
        <form action="<?php echo url_for($modulo . '/index?id=0') ?>" method="get">
            <div class="row" style="padding-top:2px;padding-bottom:1px;">
                <div class="col-lg-1"></div>
                <div class="col-lg-2">Seleccione pedido </div>
                <div class="col-lg-7">
                    <select  onchange="this.form.submit()" class="form-control mi-selector" name="em" id="em">
                        <option  selected="selected"  value="99" >Todos los pedidos</option>
                        <?php foreach ($cotizacio as $reg) { ?>
                            <option value="<?php echo $reg->getOrdenCotizacionId(); ?>"  <?php if ($em == $reg->getOrdenCotizacionId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo $reg->getOrdenCotizacion()->getCodigo(); ?>      <?php echo $reg->getOrdenCotizacion()->getNombre(); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>     
             <?php if ($muestraBoton) { ?>  
                <div class="row" style="padding-top:2px;padding-bottom:5px;">
                <div class="col-lg-1"></div>
                <div class="col-lg-2">Seleccione producto </div>
                <div class="col-lg-7">
                    <select  onchange="this.form.submit()" class="form-control mi-selector" name="pr" id="pr">
                        <option  selected="selected"  value="" >Todos los Productos</option>
                        <?php foreach ($productos as $reg) { ?>
                            <option value="<?php echo $reg->getProductoId(); ?>"  <?php if ($pr == $reg->getProductoId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo $reg->getProducto()->getCodigoSku(); ?>      <?php echo $reg->getProducto()->getNombre(); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>  
             <?php } ?>
        </form>
        <?php $ruta = 'ConfirmaPedi'; ?>
        <?php if ($muestraBoton) { ?>  
            <form action="<?php echo url_for($modulo . '/' . $ruta . '?id=' . $em) ?>" method="post">
            <?php } ?>
            <table  style="width: 100%" class=" <?php if (!$muestraBoton) { ?> table  <?php } ?> table-bordered " >
                <tr>
                    <?php if ($muestraBoton) { ?>
                        <th>#</th>
                    <?php } else { ?>
                        <th>Orden</th>
                    <?php } ?>
                    <th>Codigo Producto</th>
                    <th>Producto </th>
                    <th>Marca</th>       
                    <th>Unidad</th>
                    <?php if ($muestraBoton) { ?>
                        <th>Cant.<br>Bultos</th>
                        <th>No.<br>Bultos</th>
                        <th>Peso</th>
                        <th>Total<br>Peso</th>
                        <th>CBM</th>
                        <th>Total<br>CBM</th>

                    <?php } ?>
                        <td></td>
                                                <td></td>
                </tr>
                <?php $totalPeso = 0; ?>
                <?php $no = 0; ?>
                <?php $pendiente = false; ?>
                <?php foreach ($detalles as $reg) { ?>
                <?php $ver=true; ?>
                <?php if ($pr) { ?>
                <?php $ver=false; ?>
               <?php if ($pr) { ?>
                <?php if ($pr==$reg->getProductoId()) { ?>
                <?php $ver=true; ?>

                <?php } ?>
 
                
                <?php } ?>
 
                <?php } ?>
                    <?php $no++; ?>
                    <?php $totalPeso = $totalPeso + ( $reg->getProducto()->getPeso() * $reg->getCantidad()) ?>
                    <?php $pesoLin = round($reg->getProducto()->getPeso() * $reg->getCantidad(), 2); ?>
                <?php if ($ver) { ?>  
                <tr>
                        <?php if (!$muestraBoton) { ?>
                            <td><?php echo $reg->getOrdenCotizacion()->getCodigo(); ?></td>
                        <?php } else { ?>
                            <td style="text-align:right;"><?php echo $no; ?>&nbsp;&nbsp;</td>
                        <?php } ?>
                        <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                        <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                        <td><?php echo $reg->getProducto()->getMarcaProducto(); ?></td>
                        <td style="background-color:white !important; font-weight: bold; text-align: right; font-size:16px;">
                        <?php if ($muestraBoton) { ?>
                            <a class="btn btn-sm btn-block" href="#" data-toggle="modal" data-target="#ajaxmodalCan<?php echo $reg->getId() ?>">       
                                <?php echo $reg->getCantidad(); ?>
                            </a>
                        <?php }  else { ?>
                                <?php echo $reg->getCantidad(); ?>
                            
                        <?php } ?>
                        </td>                   
                        <?php if ($muestraBoton) { ?>
                            <td  style="text-align:right"><?php echo $reg->getCantidadCaja(); ?></td>
                            <td>
                                <?php if ($reg->getCantidadCaja() > 0 or $reg->getBultoSuperior() > 0) { ?>
                                    <?php echo "&nbsp;&nbsp;&nbsp;Bulto " . $reg->getBultoInicio(); ?>
                                    <?php if ($reg->getBultoInicio() < $reg->getBultoFin()) { ?>
                                        <?php echo "<br>&nbsp;&nbsp;&nbsp;A Bulto " . $reg->getBultoFin(); ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php $pendiente = true; ?>
                                <?php } ?>
                            </td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getPeso(); ?></td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getPeso() * $reg->getCantidad(); ?></td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getCMB(); ?></td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getCMB() * $reg->getCantidad(); ?></td>
                            <td><a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#ajaxmodalCE<?php echo $reg->getId() ?>">..</a>  </td>
                            <td><a class="btn btn-sm btn-danger" style="width:10px !important;" data-toggle="modal" href="#static<?php echo $reg->getId() ?>"></a> </td>                     
  <?php } ?>
                    </tr>
                <?php } ?>
                      <?php } ?>
            </table>

            <?php if ($muestraBoton) { ?>  
                <div class="row" style="padding-top:2px;padding-bottom:5px;">
                    <div class="col-lg-6" ></div>
           
                    <div class="col-lg-2" >
                        <a target="_blank" href="<?php echo url_for('reporte/empaque?id=' . $idp) ?>" class="btn btn-block btn-sm btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
                    </div>
                         <div class="col-lg-2">
                 <a target="_blank" href="<?php echo url_for('reporte_excel/empaque?id=' . $idp) ?>" class="btn btn-block  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte </a>
        
                                
                    </div>
                    <div class="col-lg-2" style="padding-top:10px;">
                        <?php if (!$pendiente) { ?>
                            <button class="btn btn-block  btn-xs btn-dark dark"  type="submit">
                                <i class="flaticon2-check-mark"></i>CONFIRMAR EMPAQUE
                            </button> 
                        <?php } ?>
                    </div> 
                </div>
            </form>
        <?php } ?>

    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $("#total_caja").on('change', function () {
            var id = <?php echo $idp; ?>;
            var val = $("#total_caja").val();
            $.get('<?php echo url_for("verifica_bodega/tcaja") ?>', {id: id, val: val}, function (response) {
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#total_peso").on('change', function () {
            var id = <?php echo $idp; ?>;
            var val = $("#total_peso").val();
            $.get('<?php echo url_for("verifica_bodega/tpeso") ?>', {id: id, val: val}, function (response) {
            });
        });
    });
</script>

<?php foreach ($detalles as $lista) { ?>

     <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <p> Confirma Eliminar 
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $lista->getCodigo() ?>
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = md5($lista->getId()); ?>
                            <div class="modal-footer">
                                <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                    <i class="fa fa-trash-o "></i> Confirmar </a> 
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                            </div>

                        </div>
                    </div>
                </div> 

    <script type="text/javascript">
        $(document).ready(function () {

            var id = <?php echo $lista->getId(); ?>;

            var $select = $("#seleccion_" + id);
            var $datos = $("#datos_" + id);

            function toggleDatos() {
                if ($select.val() == "0") {
                    $datos.show();
                } else {
                    $datos.hide();
                }
            }

            // Ejecutar al cargar
            toggleDatos();

            // Ejecutar al cambiar el select
            $select.on("change", function () {
                toggleDatos();
            });

        });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {

            var id = <?php echo $lista->getId(); ?>;

            var $cantidad = $("#cantidadV" + id);
            var $linea1 = $("#linea1_" + id);
            var $linea2 = $("#linea2_" + id);

            // Cuando cambia la cantidad total
            $cantidad.on("input", function () {
                var cantidad = parseInt($(this).val()) || 0;

                $linea1.val(cantidad);
                $linea2.val(0);
            });

            // Cuando cambia la línea 1
            $linea1.on("input", function () {
                var cantidad = parseInt($cantidad.val()) || 0;
                var linea1 = parseInt($(this).val()) || 0;

                // No permitir mayor que cantidad
                if (linea1 > cantidad) {
                    linea1 = cantidad;
                    $(this).val(cantidad);
                }

                var linea2 = cantidad - linea1;
                $linea2.val(linea2);
            });

        });
    </script>

    <form action="<?php echo url_for($modulo . '/dividir?id=' . $lista->getId()) ?>" method="get">
        <div class="modal fade" id="ajaxmodalCan<?php echo $lista->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
             role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 550px">
                <div class="modal-content" style=" width: 550px">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel6"><span style="background-color: #DCEEF2; padding-top:3px; padding-bottom: 3px;"> Distribuir Item </span>  <?php echo $lista->getProducto()->getCodigoSku(); ?> </h4>
                        <?php echo $lista->getProducto()->getNombre(); ?>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table ">
                            <tr>
                                <th style="width:200px;">Cantidad</th>
                                <td>
                                    <span style="display:block;  font-size: 10px;">Solicitada</span>
                                    <input min="0" type="number" " class="form-control" value="<?php echo $lista->getCantidad() ?>"  disabled="" >
                                </td>
                                <td>
                                    <span style="display:block;  font-size: 10px;">Nueva Cantidad</span>
                                    <input min="0" type="number" max="<?php echo  $lista->getProducto()->getExistencia(); ?>" class="form-control" value="<?php echo $lista->getCantidad() ?>"   name="cantidadV<?php echo $lista->getId(); ?>" id="cantidadV<?php echo $lista->getId(); ?>">
                                </td>
                            </tr>
                            <tr>
                                <th style="width:200px;">Dividir  </th>
                                <th>Linea 1  </th>
                                <th>Linea 2  </th>
                            </tr>
                            <tr>

                                <td style="width:200px;"></td>
                                <td><input min="1" type="number" " class="form-control" value="<?php echo $lista->getCantidad() ?>"   name="linea1_<?php echo $lista->getId(); ?>" id="linea1_<?php echo $lista->getId(); ?>"></td>
                                <td><input min="1" type="number" " class="form-control" placeholder="0"   name="linea2_<?php echo $lista->getId(); ?>" id="linea2_<?php echo $lista->getId(); ?>" disabled=""></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm " type="submit"> <i class="fa fa-save "></i>Actualizar        </button>
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#cantidad<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var cantidad = parseInt($("#cantidad" + <?php echo $lista->getId(); ?>).val(), 10);
                var inicio = parseInt($("#inicio" + <?php echo $lista->getId(); ?>).val(), 10);
                // Contemplar null, vacío o NaN
                cantidad = isNaN(cantidad) ? 0 : cantidad;
                inicio = isNaN(inicio) ? 0 : inicio;
                var fin = inicio + cantidad - 1;
                if (fin > 0) {
                    $('#fin' + <?php echo $lista->getId(); ?>).val(fin);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#inicio<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var cantidad = parseInt($("#cantidad" + <?php echo $lista->getId(); ?>).val(), 10);
                var inicio = parseInt($("#inicio" + <?php echo $lista->getId(); ?>).val(), 10);
                // Contemplar null, vacío o NaN
                cantidad = isNaN(cantidad) ? 0 : cantidad;
                inicio = isNaN(inicio) ? 0 : inicio;
                var fin = inicio + cantidad - 1;
                if (fin > 0) {
                    $('#fin' + <?php echo $lista->getId(); ?>).val(fin);
                }
            });
        });
    </script>
    <form action="<?php echo url_for($modulo . '/grabaEmpaque?id=' . $lista->getId()) ?>" method="get">
        <div class="modal fade" id="ajaxmodalCE<?php echo $lista->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
             role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 550px">
                <div class="modal-content" style=" width: 550px">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel6">
                            <span style="background-color: #DCEEF2; padding-top:3px; padding-bottom: 3px;">
                                Detallar Bultos </span> <?php echo $lista->getProducto()->getCodigoSku(); ?> </h4>
                        <?php echo $lista->getProducto()->getNombre(); ?>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="padding-bottom:3px;">
                            <div class="col-lg-2 " style="font-weight:bold;"> Selección   </div>
                            <div class="col-lg-10 ">
                                <select   class="form-control" name="seleccion_<?php echo $lista->getId() ?>" id="seleccion_<?php echo $lista->getId() ?>">
                                    <option  selected="selected"  value='0' >Nuevo Bulto</option>
                                    <?php foreach ($bultosCreado as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>" >  
                                            <?php echo $value; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 ">  
                                <div id='datos_<?php echo $lista->getId(); ?>' >
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span style="display: block; font-weight:bold; font-size: 13px;">Unidades</span>
                                                <input  class="form-control" value="<?php echo $lista->getCantidad() ?>" disabled="" ></td>
                                            <td>
                                                <span style="display: block; font-weight:bold; font-size: 13px;">Cantidad Bultos</span>
                                                <input min="0" type="number" " class="form-control" value="<?php echo $lista->getCantidadCaja() ?>"   name="cantidad<?php echo $lista->getId(); ?>" id="cantidad<?php echo $lista->getId(); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span style="display: block; font-weight:bold; font-size: 13px;">Bulto Inicial</span>
                                                <input min="0" type="number" " class="form-control" value="<?php echo $lista->getBultoInicio() ?>"   name="inicio<?php echo $lista->getId(); ?>" id="inicio<?php echo $lista->getId(); ?>">
                                            </td>
                                            <td>
                                                <span style="display: block; font-weight:bold; font-size: 13px;">Bulto Final</span>
                                                <input  disabled="" min="0" type="number" " class="form-control" value="<?php echo $lista->getBultoFin() ?>"   name="fin<?php echo $lista->getId(); ?>" id="fin<?php echo $lista->getId(); ?>"></td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm " type="submit"> <i class="fa fa-save "></i>Actualizar        </button>
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <script type="text/javascript">
        $(document).ready(function () {
            $("#can_caja<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#can_caja<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("verifica_bodega/caja") ?>', {id: id, val: val}, function (response) {

                    $("#total_caja").val(response);
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#peso<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#peso<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("verifica_bodega/peso") ?>', {id: id, val: val}, function (response) {
                    $("#total_peso").val(response);
                });
            });
        });
    </script>

<?php } ?>



<script>
    const inputs = document.querySelectorAll('.cantidad');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            const max = Number(input.getAttribute('max'));
            const min = Number(input.getAttribute('min'));
            let valor = Number(input.value);

            if (valor > max) {
                input.value = max; // Forzar el valor máximo
            } else if (valor < min) {
                input.value = min; // Evitar valores negativos
            }
        });
    });
</script>

<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>

<?php if ($operacion) { ?>
    <div id="ajaxmodalFactura" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <?php include_partial('soporte/avisos') ?>
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Pedido Empaque <?php echo $operacion->getCodigo(); ?>   </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-6" style="text-align:right; font-weight: bold;">
                            Empaque
                        </div>
                        <div class="col-lg-2">
                                   <a target="_blank" href="<?php echo url_for('reporte/empaque?id=' . $operacion->getId()) ?>" class="btn btn-sm btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
                    </div>
                            <div class="col-lg-2">
                 <a target="_blank" href="<?php echo url_for('reporte_excel/empaque?id=' . $operacion->getId()) ?>" class="btn btn-block  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte </a>
        
                                
                    </div>
                    </div>


               
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {
        $("#ajaxmodalFactura").modal();
    });
</script>


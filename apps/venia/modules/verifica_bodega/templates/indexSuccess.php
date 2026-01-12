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
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">

        <form action="<?php echo url_for($modulo . '/index?id=0') ?>" method="get">
            <div class="row" style="padding-top:2px;padding-bottom:5px;">
                <div class="col-lg-1"></div>
                <div class="col-lg-2">Seleccione pedido </div>
                <div class="col-lg-4">
                    <select  onchange="this.form.submit()" class="form-control mi-selector" name="em" id="em">
                        <option  selected="selected"  value="99" >Todos los pedidos</option>
                        <?php foreach ($pedidos as $reg) { ?>
                            <option value="PE<?php echo $reg->getId(); ?>"  <?php if ($em == 'PE' . $reg->getId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo "PEDIDO" . $reg->getId(); ?>
                            </option>
                        <?php } ?>
                        <?php foreach ($cotizacio as $reg) { ?>
                            <option value="<?php echo $reg->getOperacionId(); ?>"  <?php if ($em == $reg->getOperacionId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo $reg->getOperacion()->getCodigo(); ?>      <?php echo $reg->getOperacion()->getNombre(); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <?php if ($muestraBoton) { ?>  
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-2">
                        <?php if ($tipo == 1) { ?>
                          <?php } ?>
                        <?php if ($tipo == 2) { ?>

                            <a target="_blank" href="<?php echo url_for('producto_vendedor/reporte?id=' . $em) ?>" class="btn btn-sm btn-warning"  target = "_blank">
                                <i class="flaticon2-print"></i>   Pedido     
                            </a>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>     
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
                </tr>
                <?php $totalPeso = 0; ?>
                <?php $no = 0; ?>
                <?php $pendiente=false; ?>
                <?php foreach ($detalles as $reg) { ?>
                    <?php $no++; ?>
                    <?php $totalPeso = $totalPeso + ( $reg->getProducto()->getPeso() * $reg->getCantidad()) ?>
                    <?php $pesoLin = round($reg->getProducto()->getPeso() * $reg->getCantidad(), 2); ?>
                    <tr>
                        <?php if (!$muestraBoton) { ?>
                            <td><?php echo $reg->getOperacion()->getCodigo(); ?></td>
                        <?php } else { ?>
                            <td style="text-align:right;"><?php echo $no; ?>&nbsp;&nbsp;</td>
                        <?php } ?>
                        <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                        <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                        <td><?php echo $reg->getProducto()->getMarcaProducto(); ?></td>
                        <td style="background-color:white !important; font-weight: bold; text-align: right; font-size:16px;">
                            <?php echo $reg->getCantidad(); ?>
                        </td>                   
                        <?php if ($muestraBoton) { ?>
                            <td  style="text-align:right"><?php echo $reg->getCantidadCaja(); ?></td>
                            <td>
                                <?php if ($reg->getCantidadCaja() >0) { ?>
                                <?php echo "&nbsp;&nbsp;&nbsp;Bulto ".$reg->getBultoInicio(); ?>
                                <?php if ($reg->getCantidadCaja() >1) { ?>
                                         <?php echo "<br>&nbsp;&nbsp;&nbsp;A Bulto ".$reg->getBultoFin(); ?>
                                   <?php  }  ?>
                              <?php  }  else { ?>
                              <?php $pendiente=true; ?>
                                                                        

                              <?php } ?>
                            </td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getPeso(); ?></td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getPeso() * $reg->getCantidad(); ?></td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getCMB(); ?></td>
                            <td style="text-align:right"><?php echo $reg->getProducto()->getCMB() * $reg->getCantidad(); ?></td>
                            <td>
                                      <a class="btn btn-sm  btn-block btn-success  "   href="#"  data-toggle="modal" data-target="#ajaxmodalCE<?php echo $reg->getId() ?>">
                                ..    </a>                         

                            </td>
                              
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

            <?php if ($muestraBoton) { ?>  
                <div class="row" style="padding-top:2px;padding-bottom:5px;">
                    <div class="col-lg-6" ></div>
                    <div class="col-lg-2" style="font-weight:bold;">

                    </div>
      
                 
                    <div class="col-lg-2" style="padding-top:10px;">
                       <a target="_blank" href="<?php echo url_for('reporte/empaque?id=' . $idp) ?>" class="btn btn-sm btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
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

   <script type="text/javascript">
        $(document).ready(function () {
            $("#cantidad<?php echo $lista->getId(); ?>").on('change', function () {
              var id = <?php echo $lista->getId(); ?>;
              var cantidad = parseInt($("#cantidad" + <?php echo $lista->getId(); ?>).val(), 10);
              var inicio = parseInt($("#inicio" + <?php echo $lista->getId(); ?>).val(), 10);
              // Contemplar null, vacío o NaN
              cantidad = isNaN(cantidad) ? 0 : cantidad;
              inicio = isNaN(inicio) ? 0 : inicio;
              var fin = inicio + cantidad-1;
              if (fin >0) {
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
              var fin = inicio + cantidad-1;
             if (fin >0) {
                $('#fin' + <?php echo $lista->getId(); ?>).val(fin);
               }
            });
        });
    </script>


  <form action="<?php echo url_for($modulo . '/grabaEmpaque?id='.$lista->getId()) ?>" method="get">
    <div class="modal fade" id="ajaxmodalCE<?php echo $lista->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                 
                    <h4 class="modal-title" id="myModalLabel6">Detallar Bultos  <?php echo $lista->getProducto()->getCodigoSku(); ?> </h4>
                     <?php echo $lista->getProducto()->getNombre(); ?>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 ">  
                            <table class="table table-bordered">
                                <tr>
                                    <th>Cantidad Bultos</th>
                                    <td>
                                    <input min="1" type="number" " class="form-control" value="<?php echo $lista->getCantidadCaja() ?>"   name="cantidad<?php echo $lista->getId(); ?>" id="cantidad<?php echo $lista->getId(); ?>">
                                    </td>
                                </tr>
                                  <tr>
                                    <th>Bulto Inicial</th>
                                    <td>
                                      <input min="1" type="number" " class="form-control" value="<?php echo $lista->getBultoInicio() ?>"   name="inicio<?php echo $lista->getId(); ?>" id="inicio<?php echo $lista->getId(); ?>">
                                    </td>
                                </tr>
                                   <tr>
                                    <th>Bulto Final</th>
                                    <td>
                                        <input  disabled="" min="1" type="number" " class="form-control" value="<?php echo $lista->getBultoFin() ?>"   name="fin<?php echo $lista->getId(); ?>" id="fin<?php echo $lista->getId(); ?>">                                        
                                    </td>
                                </tr>
                            </table>
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

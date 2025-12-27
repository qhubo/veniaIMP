<?php echo $forma->renderFormTag(url_for($modulo . '/muestra') . "?id=" . $id . "&tab=2&c=1&val=" . $val, array("class" => "form-vertical login-form",)); ?>
<?php echo $forma->renderHiddenFields() ?>  

<?Php $precioVar = false; ?>
<?php if ($combo) { ?>
    <?php $precioVar = $combo->getPrecioVariable(); ?>
<?php } ?>

<div class="row">
    <?php if ($combo) { ?>
        <?php if ($combo->getImagen()) { ?>
            <div class="col-lg-2"> 
                <img src="<?php echo $combo->getImagen() ?>"  width="150px">
            </div>
        <?php } ?>
    <?php } ?>

    <div class="col-lg-10">  
        <?php if ($combo) { ?>
            <?php if (($combo->getEstatus() == 'Pendiente') or ( $combo->getEstatus() == 'Confirmado')) { ?>
                <h3>Agregar Productos para el Combo</h3>

                <div class="row">
                    <div class=" col-lg-2 " >Opción </div>
                    <div class="col-lg-7   <?php if ($forma['tipo_aparato_id']->hasError()) echo "has-error" ?>">
                        <?php echo $forma['tipo_aparato_id'] ?>     

                        <span class="help-block form-error"> 
                            <?php echo $forma['tipo_aparato_id']->renderError() ?>  
                        </span>

                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-1">

                    </div>
                </div>
                <div class="row">
                    <div class=" col-lg-2 " >Sub Grupo </div>
                    <div class="col-lg-7   <?php if ($forma['marca_id']->hasError()) echo "has-error" ?>">
                        <?php echo $forma['marca_id'] ?>     
                        <span class="help-block form-error"> 
                            <?php echo $forma['marca_id']->renderError() ?>  
                        </span>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-1"></div>
                </div>
                <div class="row">
                    <div class=" col-lg-2 " >Producto </div>
                    <div class="col-lg-7   <?php if ($forma['producto_id']->hasError()) echo "has-error" ?>">
                        <?php echo $forma['producto_id'] ?>    
                        <span class="help-block form-error"> 
                            <?php echo $forma['producto_id']->renderError() ?>  
                        </span>
                    </div>

                    <div class="col-lg-1"></div>

                </div>
          <div class="row">
                    <div class=" col-lg-2 " >Cantidad </div>
                    <div class="col-lg-5   <?php if ($forma['cantidad_medida']->hasError()) echo "has-error" ?>">
                        <?php echo $forma['cantidad_medida'] ?>    
                        <span class="help-block form-error"> 
                            <?php echo $forma['cantidad_medida']->renderError() ?>  
                        </span>
                    </div>

                    <div class="col-lg-1"></div>
      <div class="col-lg-2">
                        <button class="btn btn-info " type="submit">
                            <i class="fa fa-plus"></i> Agregar
                        </button>
                    </div>
                </div>

                
                
          
                
                <div class="row">
                    <div class="col-lg-12"><br></div>
                </div>
                
                
                
                
                
                
                

                <div class="row">
<!--                    <div class=" col-lg-2 " >Obligatorio </div>
                    <div class="col-lg-2   <?php if ($forma['obligatorio']->hasError()) echo "has-error" ?>">
                        <?php echo $forma['obligatorio'] ?>     
                    </div>-->
                    <?php if ($precioVar) { ?>
                        <div class=" col-lg-1 " >Precio </div>
                        <div class="col-lg-2   <?php if ($forma['precio']->hasError()) echo "has-error" ?>">
                            <?php echo $forma['precio'] ?>  
                            <span class="help-block form-error"> 
                                <?php echo $forma['precio']->renderError() ?>  
                            </span>
                        </div>
                    <?php } else { ?>
                        <?php if ($combo) { ?>
                            <div class=" col-lg-3 kt-font-bold kt-font-info" ><h3> Precio COMBO <?php echo number_format($combo->getPrecio(), 2); ?> </h3> </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="col-lg-1"></div>
              
                </div>
                <!--        <div class="row">
                            <div class="col-lg-2">    <br> <br></div>
                            <div class="col-lg-8 kt-font-info">  Los componentes de Receta son  <strong> PRODUCTO NO AFECTO INVENTARIO</strong>  </div>
                        </div>-->

            <?php } ?>
            <?php if ($combo) { ?>
                <?php if (!$precioVar) { ?>
                    <?php if ($combo->getEstatus() != 'Pendiente') { ?>
                        <h3> Precio Combo <?php echo number_format($combo->getPrecio(), 2); ?> </h3> 
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>

</div>

<?php echo '</FORM>'; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th><span class="kt-font-bold kt-font-success">Grupo de Productos</span></th>
            <th  ><span class="kt-font-bold kt-font-success">Producto </span></th>
            <th>Cantidad</th>
            <th width="20px" ><span class="kt-font-bold kt-font-success">Acción</span></th>
            <th width="50px" ><span class="kt-font-bold kt-font-success">Elimina</span></th>
        </tr>
    </thead>
    <tbody>
        <?php $ca = 0; ?>
        <?php $totalG = 0; ?>
        <?php $listaP[] = 0; ?>
        <?Php foreach ($campos as $reg) { ?>
            <?php $tip = TipoAparatoQuery::create()->findOneById($reg->getSeleccion()); ?>
            <?php $combolista = ListaComboDetalleQuery::create()->filterByComboProductoDetalleId($reg->getId())->find(); ?>
            <?php $pre = $reg->getPrecio(); ?>
            <?php $totalG = $totalG + $pre; ?>
            <?php $ca++; ?>
            <tr>
                <td><?php echo $tip; ?>  <?php echo $reg->getMarca(); ?>
                <td><?php echo $reg->getProductoNombre(); ?></td>      
               <td  style="text-align:right"><?php echo $reg->getCantidadMedida(); ?></td>   
                <td><?php if (($combo->getEstatus() == 'Pendiente') or ( $combo->getEstatus() == 'Confirmado')) { ?><a href="<?php echo url_for($modulo . '/muestra?val=' . $reg->getId()) ?>" class=" btn btn-sm btn-block btn-info"> <i class="flaticon-edit"></i>Editar </a><?php } ?> </td>
    <td><?php if (($combo->getEstatus() == 'Pendiente') or ( $combo->getEstatus() == 'Confirmado')) { ?><a href="<?php echo url_for($modulo . '/eliminaCom?id=' . $reg->getId()) ?>" class="btn btn-sm btn-block btn-danger"><i class="flaticon2-trash"></i></a> <?php } ?></td>
            </tr>

<?php } ?>

<?php //} ?> 
    
    
    <?php if ($combo) { ?> 
     <?php if ($combo->getPrecio() >0 ) { ?> 
            <tr>
        <td colspan="3" align="right" ><span class="kt-font-bold kt-font-success">Precio</span></td>
        <td align="right"><strong><?php echo number_format($combo->getPrecio(), 2); ?> </strong></td> 
        <td colspan="4"></td>
    </tr>
    <?php } ?>
<?php } ?>
    
    
    
<?php if ($precioVar) { ?> 
    <tr>
        <td colspan="3" align="right" ><span class="kt-font-bold kt-font-success">Precio Total</span></td>
        <td align="right"><div id="totalv"><?php echo number_format($totalG, 2); ?> </div></td> 
        <td colspan="4"></td>
    </tr>
<?php } ?>
</tbody>
</table>



<!--<script src='/assets/global/plugins/jquery.min.js'></script> -->


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<?php foreach ($listaP as $lis) { ?>
    <script>
                            $(document).ready(function () {
                                $("#preciolin<?php echo $lis; ?>").on('change', function () {
                                    var id = $("#preciolin<?php echo $lis; ?>").val();
                                    var idv = <?php echo $lis; ?>;
                                    $.get('<?php echo url_for("crea_combo/montoAdicional") ?>', {id: id, idv: idv}, function (response) {
                                    });
                                });
                            });
    </script>
<?php } ?>

<?php foreach ($campos as $lis) { ?>
    <?php $id = $lis->getId(); ?>
    <script >
        $(document).ready(function () {
            $("#monto_<?php echo $id ?>").on('change', function () {
                var id = $("#monto_<?php echo $id ?>").val();
                var idv = <?php echo $id ?>;
                $.get('<?php echo url_for("crea_combo/monto") ?>', {id: id, idv: idv}, function (response) {
                    $("#totalv").html(response);
                });
            });
        });
    </script>

    <script>
        function validate<?php echo $id ?>(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }
    </script>
<?php } ?>


<script>
    $(document).ready(function () {
        $("#ingreso_tipo_aparato_id").on('change', function () {
            //    alert('cambio');
            $("#ingreso_marca_id").empty();
            $("#ingreso_producto_id").empty();
            $.getJSON('<?php echo url_for("soporte/tipoMarca") ?>?id=' + $("#ingreso_tipo_aparato_id").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#ingreso_marca_id").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
            $.getJSON('<?php echo url_for("soporte/tipoMarcaProducto") ?>?id=' + $("#ingreso_tipo_aparato_id").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#ingreso_producto_id").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
        });
    });
</script>



<script>
    $(document).ready(function () {
        $("#ingreso_marca_id").on('change', function () {
            //    alert('cambio');
            $("#ingreso_producto_id").empty();
            $.getJSON('<?php echo url_for("soporte/marcaProducto") ?>?id=' + $("#ingreso_marca_id").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#ingreso_producto_id").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#ingreso_producto_id").on('change', function () {


            $.get('<?php echo url_for("soporte/costoProducto") ?>?id=' + $("#ingreso_producto_id").val(), function (response) {

//                     
                var respuestali = response;
                var arr = respuestali.split('|');
                var unidad = arr[0];
                var costo = arr[1];
                var costoProme = arr[2];
                console.log('aqui');
                $("#ingreso_unidad_medida").val(unidad);
                $("#ingreso_costo_pro").val(costo);
                $("#ingreso_cantidad_medida").val(1);
                $("#ingreso_costo_unidad").val(costo);
                $("#ingreso_costo_pro2").val(costoProme);
                $("#ingreso_costo_unidad2").val(costoProme);
                        
                console.log(costo);
                console.log(unidad);
//   
            });

        });
    });
</script>


<script>
    $(document).ready(function () {
        $("#ingreso_cantidad_medida").on('change', function () {


        var cantidad2 = $("#ingreso_cantidad_medida").val();
  var costo2 = $("#ingreso_costo_pro2").val();

        var cantidad = $("#ingreso_cantidad_medida").val();
  var costo = $("#ingreso_costo_pro").val();

  var resultado = cantidad * costo;
  var resultado2 = cantidad2 * costo2;

             $("#ingreso_costo_unidad2").val(resultado2);
             $("#ingreso_costo_unidad").val(resultado );
            });

        });
    
</script>


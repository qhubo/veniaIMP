<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>



<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte Ventas Por Producto
                <small>&nbsp;&nbsp;&nbsp; filtra la información que necesitas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="input-icon right">

            </div>
        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="form-body">

            <div class="row">
                <div class="col-lg-1"> </div>  

                <label class="col-lg-1 control-label right "> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right ">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-1 control-label right ">Tienda </label>
                <div class="col-lg-4 <?php if ($form['bodega']->hasError()) echo "has-error" ?>">
                    <?php echo $form['bodega'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['bodega']->renderError() ?>  
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::tipo(); ?>  </label>
                <div class="col-lg-4 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                    <?php echo $form['tipo'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tipo']->renderError() ?>  
                    </span>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::marca(); ?>  </label>
                <div class="col-lg-4 <?php if ($form['marca']->hasError()) echo "has-error" ?>">
                    <?php echo $form['marca'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['marca']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-block green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        Buscar
                    </button>
                </div>
                <div class="col-lg-2">
                    <div class="actions"> <a class="btn  btn grey-cascade  btn-block "  target="_blank"  href="<?php echo url_for($modulo . '/reporte') ?>" ><i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;  <i class="fa fa-print"></i></a></div>

                </div>
            </div>
        </div>



        <div class="table-scrollable">
            <table class="table table-bordered   table-condensed flip-content" >
                <thead class="flip-content">
                    <tr class="info">
                        <th  align="center">Tienda</th>
                        <th  align="center">Periodo</th>
                        <th  align="center">Codigo Sku</th>   
                        <th  align="center">Nombre</th>   
                        <th  align="center">Descripción</th>
                        <th  align="center">Unidad</th>
                        <th  align="center">Ventas</th>


                        <th  align="center">Costo Promedio </th>                    
                        <th  align="center">Precio Uni.</th>
                        <th  align="center">Precio Total</th>
                        <th  align="center">Costo Total</th>                    
                        <th  align="center">Margen </th>                    


                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $registro) { ?>
                        <?php if ($registro->getProductoId()) { ?>
                            <?php $valorCostoPromedio = ProductoQuery::ValorCostoPromedio ($bodegaId, $fechaInicio, $fechaFin, $registro->getProductoId()); ?>
                            <?php $precioUNi = $registro->getTotalMonto() / $registro->getTotalCantidad(); ?>
                            <?php $valorCosto = ProductoQuery::ValorCosto($bodegaId, $fechaInicio, $fechaFin, $registro->getProductoId()); ?>

                            <tr>
                                <td><?php echo $registro->getOperacion()->getBodega()->getNombre(); ?></td>
                                <td><?php echo $fechaInicio . " AL " . $fechaFin ?></td>
                                <td><?php echo $registro->getProducto()->getCodigoSku(); ?></td>
                                <td><?php echo $registro->getProducto()->getNombre(); ?></td>
                                <td><?php echo $registro->getProducto()->getDescripcion(); ?></td>
                                <td><?php echo $registro->getProducto()->getUnidadMedida(); ?></td>
                                <td  align="right"><?php echo number_format($registro->getTotalCantidad(),2); ?></td>
                                <td  align="right"><?php echo number_format( $valorCostoPromedio,2); ?></td>
                                <td  align="right"><?php echo number_format( $precioUNi,2); ?></td>
                                <td  align="right"><?php echo number_format( $registro->getTotalMonto(),2); ?></td>
                                <td align="right"><?php echo  number_format($valorCosto,2); ?></td>
                                <td  align="right"><?php echo  number_format($registro->getTotalMonto() - $valorCosto,2); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

                </tbody>
            </table>


        </div>

        <?php echo '</form>'; ?>
        <script>

            $(document).ready(function () {
                $("#consulta_tipo").on('change', function () {
                    //      alert('cambio');
                    $('#consulta_nombrebuscar').val('');
                    $("#consulta_marca").empty();
                    $.getJSON('<?php echo url_for("soporte/tipoMarca") ?>?id=' + $("#consulta_tipo").val(), function (data) {
                        console.log(JSON.stringify(data));
                        $.each(data, function (k, v) {
                            $("#consulta_marca").append("<option value=\"" + k + "\">" + v + "</option>");
                        }).removeAttr("disabled");
                    });
                });

                $("#consulta_marca").on('change', function () {
                    //      alert('cambio');
                    $('#consulta_modelo').val('');
                    $("#consulta_modelo").empty();
                    $.getJSON('<?php echo url_for("soporte/marcaModelo") ?>?id=' + $("#consulta_marca").val(), function (data) {
                        console.log(JSON.stringify(data));
                        $.each(data, function (k, v) {
                            $("#consulta_modelo").append("<option value=\"" + k + "\">" + v + "</option>");
                        }).removeAttr("disabled");
                    });
                });

            });



        </script>
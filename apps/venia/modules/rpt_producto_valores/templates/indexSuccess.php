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
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte Valores Producto
                <small>&nbsp;&nbsp;&nbsp; filtra por categorias, código ,nombre de productos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="input-icon right">
                <i class="icon-magnifier"></i>
                <?php echo $form['nombrebuscar'] ?> 
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">




        <div class="form-body">
            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::tipo(); ?>  </label>
                <div class="col-lg-4 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                    <?php echo $form['tipo'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tipo']->renderError() ?>  
                    </span>
                </div>

                <div class="col-lg-4">
                    <font color="#9eacb4" size="2px">   No Productos Total&nbsp;&nbsp;<strong> <?php echo $total ?> </strong> </font>
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
                <div class="col-lg-3">
                    <font color="#9eacb4" size="2px">   No Productos Busqueda&nbsp;&nbsp;<strong> <?php echo $totalB ?></strong> </font>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::modelo(); ?>  </label>
            <div class="col-lg-4 <?php if ($form['modelo']->hasError()) echo "has-error" ?>">
                <?php echo $form['modelo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['modelo']->renderError() ?>  
                </span>
            </div>


        </div>



        <div class="row">
            <div class="col-lg-6"> </div>        

            <div class="col-lg-4">
                <button class="btn green btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
            </div>
                <div class="col-lg-2">
                      <div class="actions"> <a class="btn  btn grey-cascade  btn-block "  target="_blank"  href="<?php echo url_for($modulo . '/reporte') ?>" ><i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;  <i class="fa fa-print"></i></a></div>

                </div>
        </div>
    </div>


    <div class="table-scrollable">
        <table class="table table-bordered  dataTable table-condensed flip-content" >
            <thead class="flip-content">
                <tr class="info">
                    <th  align="center">Categoria</th>   
                    <th  align="center">SubCategoria</th>
                    <th  align="center">Codigo Sku</th>   
                    <th  align="center">Nombre</th>   
                    <th  align="center">Descripción</th>
                    <th  align="center">Unidad</th>
                    <th  align="center">Precio</th>
                    <th  align="center">Unidad Costo </th>   
                    <th  align="center">Costo</th>   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $regis) { ?>
                <?php $regis = ProductoQuery::create()->findOneById($regis->getId()); ?>
                    <tr>
                        <td><?php echo  $regis->getTipoAparato(); ?></td>
                        <td><?php echo  $regis->getMarca(); ?></td>
                        <td><?php echo  $regis->getCodigoSku(); ?></td>
                        <td><?php echo  $regis->getNombre(); ?></td>
                        <td><?php echo  $regis->getDescripcion(); ?></td>
                        <td><?php echo  $regis->getUnidadMedida(); ?></td>
                        <td><?php echo  $regis->getPrecio(); ?></td>
                        <td><?php echo  $regis->getUnidadMedidaCosto(); ?></td>
                        <td><?php echo  $regis->getCostoProveedor(); ?></td>
                    </tr>

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
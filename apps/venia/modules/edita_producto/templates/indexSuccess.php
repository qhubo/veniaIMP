

<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Buscador de Productos <small> puedes filtrar tu busqueda para editar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;puedes crear un nuevo producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> NUEVO </a>

        </div>
    </div>


    <div class="kt-portlet__body">

        <div class="row"  style="padding-top:5px">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right ">Busqueda  </label>
            <div class="col-lg-4 <?php if ($form['producto']->hasError()) echo "has-error" ?>">
                <?php echo $form['producto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['producto']->renderError() ?>  
                </span>
            </div>
        </div>


        <div class="row"  style="padding-top:5px">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::tipo(); ?>  </label>
            <div class="col-lg-5 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>


        </div>
        <div class="row"  style="padding-top:5px">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::marca(); ?>  </label>
            <div class="col-lg-5 <?php if ($form['marca']->hasError()) echo "has-error" ?>">
                <?php echo $form['marca'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['marca']->renderError() ?>  
                </span>
            </div>





        </div>


        <div class="row" style="padding-top:5px">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::modelo(); ?>  </label>
            <div class="col-lg-5 <?php if ($form['modelo']->hasError()) echo "has-error" ?>">
                <?php echo $form['modelo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['modelo']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1">


            </div>
            <div class="col-lg-2">

                <button class="btn btn-dark  btn-small btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
            </div>
        </div>
    </div>



    <?php echo '</form>'; ?>


    <div class="kt-portlet kt-portlet--responsive-mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">


            </div>
            <div class="kt-portlet__head-toolbar">

            </div>
        </div>


        <!--    <div class="kt-portlet__body">
                           <div class="row">
                            <div class="col-lg-10"></div>
                                <div class="col-lg-2">				
                                        <div class="kt-input-icon kt-input-icon--left">
                                            <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                                            <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                <span><i class="la la-search"></i></span>
                                            </span>
                                        </div>
                                </div>
                            </div>-->
        <table class="table table-bordered  dataTable table-condensed flip-content" >
            <thead >
                <tr class="active">
                    <th align="center" width="35px"></th>
                    <th  align="center"><font size="-2"> Codigo Sku</font></th>
                    <th  align="center"><font size="-2"> Grupo</font></th>
                    <th  align="center"><font size="-2"> Nombre</font></th>
                    <th  align="center"><font size="-2"> Activo</font></th>
                    <th><font size="-2">Editar</font></th>
                    <th><font size="-2">Eliminar</font></th>
                </tr>
            </thead>
            <tbody>

                <?php if ($productos) { ?>
                    <?php foreach ($productos as $lista) { ?>
                        <tr>
                            <td>  <img src="<?php echo $lista->getImagen() ?>" width="75px" ></td>
                            <td><?php echo $lista->getCodigoSku() ?></td>
                            <td><font size="-1"> <?php echo $lista->getTipoAparato(); ?></font> </td>
                            <td> <font size="-1"> <?php echo $lista->getNombre(); ?></font>  </td>
        
                            <td> <font size="-1"> <?php if ($lista->getActivo()) { ?><li class="fa fa-check  font-green-jungle"></li> <?php } ?> </font>  </td>

                    <td>
                        <a class="btn btn-info btn-sm btn-block flaticon-edit-1"  href="<?php echo url_for($modulo . '/muestra?id=' . $lista->getId()) ?>" ><li class="fa fa-picture-o"></li> Editar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
                    </td>        
                    <td>
                        <a class="btn btn-sm btn-block btn-danger" data-toggle="modal" href="#static<?php echo $lista->getId() ?>"><i class="fa fa-trash"></i>  Eliminar </a>
                    </td>   
                    </tr>
                    <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmación Eliminación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p> Esta seguro de eliminar Producto Código
                                        <span class="caption-subject font-green bold uppercase"> 
                                            <?php echo $lista->getCodigoSku() ?>
                                        </span> ?
                                    </p>
                                </div>
                                <?php $token = md5($lista->getCodigoSku()); ?>
                                <div class="modal-footer">
                                    <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                        <i class="fa fa-trash-o "></i> Confirmar</a> 
                                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>

                                </div>

                            </div>
                        </div>
                    </div> 
                <?php } ?>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>

<script src="./assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>


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
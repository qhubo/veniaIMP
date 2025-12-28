<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')   ?>
<?php //$areglo= unserialize($areglo);       ?> 
<?php //$areglo = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'producto'));       ?>
<?php //echo  "<pre>";   print_r($areglo); die();        ?>
<?php $ocultavd = false; ?> 
<style>
    .required {
        color: red;
        font-weight: bold;
        margin-left: 2px;
    }
</style>
<script src='/assets/global/plugins/jquery.min.js'></script>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-medal kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php if ($producto) { ?>
                    <?php echo $producto->getCodigoSku() ?> <small> <?php echo $producto->getNombre() ?> &nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <?php } else { ?>
                        <i class="flaticon2-plus"></i>  Nuevo Producto     
                    <?Php } ?>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>


    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <?php if (!$producto) { ?>
            <div class="row" style="padding-bottom:5px;">
                <div class="col-lg-1"> </div>
                <label class="col-lg-1 control-label">Código Sku</label>
                <div class="col-lg-2 <?php if ($form['codigo_sku']->hasError()) echo "has-error" ?>">
                    <?php echo $form['codigo_sku'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['codigo_sku']->renderError() ?>  
                    </span>
                </div>
                <div class="col-md-3" id="vali" style="display: none;"> <font color="red" size="-2"> Codigo Ya existe</font>
                    <input id="te" name="te" readonly="" >
                </div>

            </div>
        <?php } ?>
        <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>
            <label class="col-lg-1 control-label">Nombre:<span class="required"> * </span>                                                                   </label>
            <div class="col-lg-8 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
                <?php echo $form['nombre'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombre']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>
            <label class="col-lg-1 control-label">Nombre Ingles: </label>
            <div class="col-lg-8 <?php if ($form['nombre_ingles']->hasError()) echo "has-error" ?>">
                <?php echo $form['nombre_ingles'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombre_ingles']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label">Descripción:<span class="required"> * </span>                                                                   </label>
            <div class="col-lg-8 <?php if ($form['descripcion']->hasError()) echo "has-error" ?>">
                <?php echo $form['descripcion'] ?> 
                <span class="help-block form-error"> 
                    <?php echo $form['descripcion']->renderError() ?>  
                </span>
            </div>
        </div>
         <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label"><?php echo TipoAparatoQuery::tipo(); ?> <span class="required"> * </span> </label>
            <div class="col-lg-3 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
  <label class="col-lg-1 control-label"><?php echo TipoAparatoQuery::marca(); ?>  </label>
            <div class="col-lg-3 <?php if ($form['marca']->hasError()) echo "has-error" ?>">
                <?php echo $form['marca'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['marca']->renderError() ?>  
                </span>
            </div>

        </div>
          <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label">Código Barras</label>
            <div class="col-lg-3 <?php if ($form['codigo_barras']->hasError()) echo "has-error" ?>">
                <?php echo $form['codigo_barras'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['codigo_barras']->renderError() ?>  
                </span>
            </div>
       <label class="col-lg-1 control-label">Código Arancel</label>
            <div class="col-lg-3 <?php if ($form['codigo_arancel']->hasError()) echo "has-error" ?>">
                <?php echo $form['codigo_arancel'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['codigo_arancel']->renderError() ?>  
                </span>
            </div>            
        </div>
         <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label">Caracteristica </label>
            <div class="col-lg-3 <?php if ($form['caracteristica']->hasError()) echo "has-error" ?>">
                <?php echo $form['caracteristica'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['caracteristica']->renderError() ?>  
                </span>
            </div>
                  <label class="col-lg-1 control-label">Marca </label>
            <div class="col-lg-3 <?php if ($form['marcaProducto']->hasError()) echo "has-error" ?>">
                <?php echo $form['marcaProducto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['marcaProducto']->renderError() ?>  
                </span>
            </div>
        </div>
        
   
         <div class="row" style="padding-bottom:5px;">
          <div class="col-lg-1"></div>
          <label class="col-lg-1 control-label">Peso Producto  </label>
          <div class="col-lg-2 <?php if ($form['peso']->hasError()) echo "has-error" ?>">
                <?php echo $form['peso'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['peso']->renderError() ?>  
                </span>
            </div>
             <label class="col-lg-1 control-label">Alto  </label>
         <div class="col-lg-1 <?php if ($form['alto']->hasError()) echo "has-error" ?>">
                <?php echo $form['alto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['alto']->renderError() ?>  
                </span>
            </div>   
                     <label class="col-lg-1 control-label">Ancho  </label>
         <div class="col-lg-1 <?php if ($form['ancho']->hasError()) echo "has-error" ?>">
                <?php echo $form['ancho'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['ancho']->renderError() ?>  
                </span>
            </div>    
                             <label class="col-lg-1 control-label">Largo  </label>
         <div class="col-lg-1 <?php if ($form['largo']->hasError()) echo "has-error" ?>">
                <?php echo $form['largo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['largo']->renderError() ?>  
                </span>
            </div>    
         </div>
         <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"></div>
            <div class="col-lg-1 ">Proveedor </div>

            <div class="col-lg-3 <?php if ($form['proveedor']->hasError()) echo "has-error" ?>">
                <?php echo $form['proveedor'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['proveedor']->renderError() ?>  
                </span>
            </div>
            <label class="col-lg-2 control-label">Código Proveedor</label>
            <div class="col-lg-2 <?php if ($form['codigo_proveedor']->hasError()) echo "has-error" ?>">
                <?php echo $form['codigo_proveedor'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['codigo_proveedor']->renderError() ?>  
                </span>
            </div>
        </div>
            <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label"> Precio Venta: <span class="required"> * </span></label>
            <div class="col-lg-2 <?php if ($form['precio']->hasError()) echo "has-error" ?>">
                <?php echo $form['precio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['precio']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1 ">Costo </div>
            <div class="col-lg-1 <?php if ($form['costo']->hasError()) echo "has-error" ?>">
                <?php echo $form['costo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['costo']->renderError() ?>  
                </span>
            </div>
                       <div class="col-lg-1 ">Costo Fabrica</div>
            <div class="col-lg-1 <?php if ($form['costo_fabrica']->hasError()) echo "has-error" ?>">
                <?php echo $form['costo_fabrica'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['costo_fabrica']->renderError() ?>  
                </span>
            </div>
                                  <div class="col-lg-1 ">Costo Cif </div>
            <div class="col-lg-1 <?php if ($form['costo_cif']->hasError()) echo "has-error" ?>">
                <?php echo $form['costo_cif'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['costo_cif']->renderError() ?>  
                </span>
            </div>
            
        </div>

        <div class="row">    
            <div class="col-lg-1"></div>
            <!--            <div class="col-lg-2 ">Unidad Medida </div>
            
                        <div class="col-lg-2 <?php if ($form['unidad_medida']->hasError()) echo "has-error" ?>">
            <?php echo $form['unidad_medida'] ?>           
                            <span class="help-block form-error"> 
            <?php echo $form['unidad_medida']->renderError() ?>  
                            </span>
                        </div>-->

            <!--     <div class="col-lg-2 ">Unidad Medida Costo </div>-->

<!--            <div class="col-lg-2 <?php if ($form['unidad_medida_costo']->hasError()) echo "has-error" ?>">
            <?php echo $form['unidad_medida_costo'] ?>           
                <span class="help-block form-error"> 
            <?php echo $form['unidad_medida_costo']->renderError() ?>  
                </span>
            </div>-->

   
            <div class="col-lg-2 <?php if ($form['tercero']->hasError()) echo "has-error" ?>">

            </div>
            <div class="col-lg-1 align-items-lg-center">Activo </div> 
            <div class="col-lg-1 <?php if ($form['activo']->hasError()) echo "has-error" ?>">

                <?php echo $form['activo'] ?>  
                <span class="help-block form-error"> 
                    <?php echo $form['activo']->renderError() ?>  
                </span>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-1"><br> </div>        
        </div>

    

        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <!--             <div class="row">    
                    <div class="col-lg-1"></div>
                    <div class="col-lg-1 ">Promocional </div>
                    <div class="col-lg-1"><?php echo $form['promocional'] ?>  </div>
                    <div class="col-lg-1 ">Top Venta </div>
                    <div class="col-lg-1"><?php echo $form['top_venta'] ?>  </div>
                    <div class="col-lg-1 ">Salida </div>
                    <div class="col-lg-1"><?php echo $form['salida'] ?>  </div>
                    <div class="col-lg-1 ">Afecto Inventario </div>
                    <div class="col-lg-1"><?php echo $form['afecto_inventario'] ?>  </div>
                    <div class="col-lg-1 ">Traslado </div>
                    <div class="col-lg-1"><?php echo $form['traslado'] ?>  </div>
        
                     </div>-->

        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row">    
            <div class="col-lg-1"></div>
            <div class="col-lg-1 ">Imagen </div>

            <div class="col-lg-3 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
                <?php echo $form['archivo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['archivo']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-2 ">
                <?php if ($producto) { ?>
                    <?php if ($producto->getImagen()) { ?>
                        <img src="<?php echo $producto->getImagen() ?>"  width="150px">
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="col-lg-2 "></div>
            <div class="col-lg-2">

                <button class="btn btn-xs btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                    <span>Actualizar</span>
                </button>
            </div>
        </div>
        <?php echo '</form>'; ?>
        <br><br>        <br><br>
    </div>
</div> 

<!--
<script src="/assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('.ckeditor').each(function () {
            if ($(this).attr('height')) {
                CKEDITOR.replace($(this).attr('tama'),
                        {
                            height: $(this).attr('height')
                        });
            }
        });
    });
</script>-->











<script type="text/javascript">
    $(document).ready(function () {
        $('#ocultarInicio').click(function () {
            var id = $(this).attr('dat');
            $('#0ca1').val('');
            $('#0ca2').val('');
            $('#0pre').val('');
            $('#0exi').val('');


            var valoconf = $("#txtlimpia").val();

            if (valoconf == 0) {
                $('#ocultaconf').val(0);
                $('#txtlimpia').val(1);
                $('#inicioconfigura').slideToggle(250);
                $('#iniciobt').hide();
            }


            // alert('xx');
            // alert(id);
            $.ajax({
                type: 'POST',
                url: '/posweb_dev.php/edita_producto/eliminaCaracteristica',
                data: {'id': id},
                success: function (data) {
                }
            });
        });
    });
</script>
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

<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_codigo_sku").on('change', function () {
            var id = $("#consulta_codigo_sku").val();
            var idv = $("#sec").val();
            $.get('<?php echo url_for("edita_producto/codigo") ?>', {id: id, idv: idv}, function (response) {
                if (response == 1) {
                    $("#vali").slideToggle(250);
                    $("#consulta_codigo_sku").val('');
                    $("#te").val(id);
                }
                if (response == 0) {
                    $("#vali").hide();

                }
            });

        });

    });
</script>



<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_proveedor").on('change', function () {
            var id = $("#consulta_proveedor").val();

            $.get('<?php echo url_for("edita_producto/proveedor") ?>', {id: id}, function (response) {

                $("#consulta_codigo_proveedor").val(response);



            });

        });

    });
</script>
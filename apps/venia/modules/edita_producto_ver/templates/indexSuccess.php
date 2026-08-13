<style>
.img-producto{
    transition:.2s;
}

.img-producto:hover{
    transform:scale(1.08);
}

#imagenModal{
    transition:.3s;
}
</style>

<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<?php $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId); ?>
<?php
$TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Buscador de Productos <small> puedes filtrar tu busqueda para editar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar"> </div>
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
            <label class="col-lg-1 control-label right ">Marca Producto </label>
            <div class="col-lg-5 <?php if ($form['marca_producto']->hasError()) echo "has-error" ?>">
                <?php echo $form['marca_producto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['marca_producto']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1"> </div>
            <div class="col-lg-2">

                <button class="btn btn-dark  btn-small btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
            </div>
        </div>

    <?php echo '</form>'; ?>
        <div class="row">
           <div class="col-lg-7"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-2">
            <div class="kt-input-icon kt-input-icon--left">
              <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                  <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                  </div>
            </div>
        </div>

 <table class="table table-bordered dataTable table-condensed flip-content kt-datatable"  id="html_table"  width="100%">
     <thead>
                <tr class="active">
                    <th align="center" width="35px">Imagen</th>
                    <th  align="center"><font size="-2"> Codigo Sku</font></th>
                    <th  align="center"><font size="-2"> Nombre</font></th>
                    <th  align="center"><font size="-2"> Marca</font></th>
                    <th  align="center"><font size="-2"> Existencia</font></th>
                    <th align="center">
    <font size="-2">Marcas Vehículo</font>
</th>
                    <th  align="center"><font size="-2"> Precio</font></th>
                    <th  align="center"><font size="-2"> Activo</font></th>
                    <th><font size="-2">Editar</font></th>
                    <th align="center" width="35px"></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($productos) { ?>
                    <?php foreach ($productos as $lista) { ?>
                        <tr>
                            <td>
                                <?php if ($lista->getImagen() <> "") { ?>
                                    <img src="<?php echo $lista->getImagen() ?>"
                                         width="75"
                                         class="img-thumbnail img-producto"
                                         style="cursor:pointer"
                                                                         data-imagen="<?php echo $lista->getImagen() ?>">
                                </td>
                            <?php } ?>
                            <td><?php echo $lista->getCodigoSku() ?></td>
                            <td> <font size="-1"> <?php echo $lista->getNombre(); ?></font> 
                                <br>
                                <font size="-1"> <?php echo $lista->getNombreIngles(); ?></font> 
                            </td>
                            <td> <font size="-1"> <?php echo $lista->getMarcaProducto(); ?></font> </td>
                            <td style="text-align: right;"> <font size="-1"> <?php echo $lista->getExistencia(); ?></font> </td>
                          
                            <td>
    <?php
    $marcas = isset($marcasVehiculo[$lista->getId()])
            ? $marcasVehiculo[$lista->getId()]
            : array();
    ?>

    <?php if (!empty($marcas)) { ?>

        <?php foreach ($marcas as $marcaVehiculo) { ?>

            <span class="label label-primary"
                  style="display:inline-block; margin:2px; font-size:10px;">
                <?php echo $marcaVehiculo; ?>
            </span>

        <?php } ?>

 

    <?php } ?>
</td>
                            <td style="text-align: right;"> <font size="-1"> <?php echo Parametro::formato($lista->getPrecio(), false); ?></font> </td>
                            <td> <font size="-1"> <?php if ($lista->getActivo()) { ?><li class="fa fa-check  font-green-jungle"></li> <?php } ?> </font>  </td>
                    <td>
                        <a class="btn btn-info btn-sm btn-block flaticon-edit-1"  href="<?php echo url_for($modulo . '/muestra?id=' . $lista->getId()) ?>" ><li class="fa fa-picture-o"></li> Editar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
                    </td>   
                    <td><?php echo $lista->getId() ?></td>
                    </tr>
              <?php } ?>
            <?php } ?>
            </tbody>
        </table>
            </div>
    </div>


<script>
$(document).ready(function () {

    $('.mi-selector').select2();

    $(document).on('click', '.img-producto', function () {

        var imagen = $(this).data('imagen');

        $('#imagenModal').attr('src', imagen);

        $('#modalImagen').modal('show');
    });

});
</script>

<div class="modal fade" id="modalImagen" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Vista de la imagen</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <img id="imagenModal"
                     src=""
                     class="img-fluid"
                     style="max-width:100%;max-height:80vh;">
            </div>

        </div>
    </div>
</div>
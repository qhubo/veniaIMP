<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')    ?>
<?php //$areglo= unserialize($areglo);        ?> 
<?php //$areglo = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'producto'));        ?>
<?php //echo  "<pre>";   print_r($areglo); die();         ?>
<?php $ocultavd = false; ?> 
<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<?php $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId); ?>
<?php
$TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
$usuarioa = sfContext::getInstance()->getUser()->getAttribute("usuarioNombre", null, 'seguridad');
$tipoUsua = sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad');
$usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
$usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
$tipoUsuaId = $usuarioQ->getTipoUsuario();
$pefilq = PerfilQuery::create()->findOneById($tipoUsuaId);
if ($pefilq) {
    $tipoUsua = $pefilq->getDescripcion();
}
?>
<style>
    .required {
        color: red;
        font-weight: bold;
        margin-left: 2px;
    }
</style>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

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
        <div class="row" style="padding-bottom:5px;">
            <div class="col-lg-1"> </div>
            <label class="col-lg-2 control-label" style="font-weight:bold;">Código Sku</label>
            <div  style="background-color:#646c9a;" class="col-lg-3 <?php if ($form['codigo_sku']->hasError()) echo "has-error" ?>">
                <?php echo $form['codigo_sku'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['codigo_sku']->renderError() ?>  
                </span>
            </div>

        </div>
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
            <div class="col-lg-2 <?php if ($form['codigo_barras']->hasError()) echo "has-error" ?>">
                <?php echo $form['codigo_barras'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['codigo_barras']->renderError() ?>  
                </span>
            </div>
            <label class="col-lg-1 control-label">Código Arancel</label>
            <div class="col-lg-2 <?php if ($form['codigo_arancel']->hasError()) echo "has-error" ?>">
                <?php echo $form['codigo_arancel'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['codigo_arancel']->renderError() ?>  
                </span>
            </div>            


            <label class="col-lg-1 control-label">Origen</label>
            <div class="col-lg-2 <?php if ($form['origen']->hasError()) echo "has-error" ?>">
                <?php echo $form['origen'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['origen']->renderError() ?>  
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
     
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>

        <div class="row" style="padding-bottom:10px;">    
            <div class="col-lg-1"></div>


    <label class="col-lg-1 control-label">
        Marcas Vehículo
    </label>

    <div class="col-lg-6 <?php if ($form['marcasVehiculo']->hasError()) echo "has-error" ?>">
        <?php echo $form['marcasVehiculo'] ?>

        <span class="help-block form-error">
            <?php echo $form['marcasVehiculo']->renderError() ?>
        </span>
    </div>
        </div>

        <div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-1">Imagen</div>

    <div class="col-lg-3 <?php if ($form['archivo']->hasError()) echo "has-error"; ?>">

        <?php echo $form['archivo']; ?>

        <div class="mt-2">
            <img
                id="previewImagen"
                src="<?php echo ($producto && $producto->getImagen()) ? $producto->getImagen() : ''; ?>"
                style="
                    <?php echo (!$producto || !$producto->getImagen()) ? 'display:none;' : ''; ?>
                    max-width:180px;
                    max-height:180px;
                    cursor:pointer;
                    border:1px solid #ddd;
                    padding:4px;
                    border-radius:4px;">
        </div>

        <span class="help-block form-error">
            <?php echo $form['archivo']->renderError(); ?>
        </span>

    </div>

    <div class="col-lg-2"></div>
    <div class="col-lg-2"></div>

    <div class="col-lg-2">
        <button class="btn btn-xs btn-primary" type="submit">
            <i class="fa fa-save"></i>
            <span>Actualizar</span>
        </button>
    </div>
</div>
        
        <?php echo '</form>'; ?>
        <br><br>        <br><br>
    </div>
</div> 


<div class="modal fade" id="modalImagen" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vista previa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="imagenZoom" src="" style="max-width:100%;max-height:80vh;">
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    
    // ==========================
// Select2 - Marcas Vehículo
// ==========================
$("#consulta_marcasVehiculo").select2({
    width: '100%',
    placeholder: 'Seleccione una o varias marcas',
    allowClear: true
});

    // ==========================
    // Vista previa de imagen
    // ==========================
    $("#consulta_archivo").on("change", function () {

        var archivo = this.files[0];

        if (!archivo) {
            return;
        }

        // Validar extensión
        var extension = archivo.name.split('.').pop().toLowerCase();
        if ($.inArray(extension, ['jpg', 'jpeg', 'png']) === -1) {
            alert("Solo se permiten imágenes JPG, JPEG o PNG.");
            $(this).val('');
            $("#previewImagen").hide().attr("src", "");
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            $("#previewImagen")
                .attr("src", e.target.result)
                .show();
        };

        reader.readAsDataURL(archivo);
    });

    // ==========================
    // Zoom de la imagen
    // ==========================
    $(document).on("click", "#previewImagen", function () {

        var src = $(this).attr("src");

        if (src) {
            $("#imagenZoom").attr("src", src);
            $("#modalImagen").modal("show");
        }
    });

    // ==========================
    // Ocultar configuración
    // ==========================
    $("#ocultarInicio").click(function () {

        var id = $(this).attr("dat");

        $("#0ca1,#0ca2,#0pre,#0exi").val("");

        if ($("#txtlimpia").val() == 0) {
            $("#ocultaconf").val(0);
            $("#txtlimpia").val(1);
            $("#inicioconfigura").slideToggle(250);
            $("#iniciobt").hide();
        }

        $.ajax({
            type: "POST",
            url: "/posweb_dev.php/edita_producto/eliminaCaracteristica",
            data: { id: id }
        });

    });

    // ==========================
    // Validar Código SKU
    // ==========================
    $("#consulta_codigo_sku").on("change", function () {

        $.get(
            "<?php echo url_for('edita_producto/codigo') ?>",
            {
                id: $(this).val(),
                idv: $("#sec").val()
            },
            function (response) {

                if (response == 1) {
                    $("#vali").slideDown(250);
                    $("#te").val($("#consulta_codigo_sku").val());
                    $("#consulta_codigo_sku").val('');
                } else {
                    $("#vali").hide();
                }

            }
        );

    });

});
</script>
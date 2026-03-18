<?php $va = 0; ?>
<?php $pideGas = false; ?>
<?php if ($orden) { ?>
    <?php $va = $orden->getImpuestoGas(); ?>
    <?php if ($orden->getEstatus() == "Autorizado") { ?>
        <?php $pideGas = true; ?>
    <?php } ?>
<?php } ?>

<div class="row"  style="padding-top: 3px; margin-top: 5px;  padding-bottom: 3px;  background-color: #D8F2F8">        
    <div class="col-lg-1"></div>          
    <?php if ($pideGas) { ?>
        <div class="col-lg-2" style="text-align:right">
            <span class="kt-font-success"> <h5>IMPUESTO GAS </h5>  </span>
        </div>
        <div class="col-lg-2">
            <input class="form-control "  placeholder="0.00"  <?php if ($va) { ?> value="<?php echo $va; ?>" <?php } ?> type="number"  id="impuesto_gas" name="impuesto_gas" >
        </div>
    <?php } else { ?>
        <div class="col-lg-4"></div>
    <?php } ?>
<!--    <div class="col-lg-1">
        <span class="kt-font-success"> <h5>SUB TOTAL </h5>  </span>
    </div>-->
<!--    <div class="col-lg-1">
        <span class="kt-font-success"><div name="grasubtotal" id ="grasubtotal"><?php if ($orden) {
        echo Parametro::formato($orden->getSubTotal(), false);
    } ?></div>  </span>
    </div>                -->
<!--    <div class="col-lg-1"  style="text-align:right">
        <span class="kt-font-success"><h5>IVA  </h5></span>
    </div>-->
<!--    <div class="col-lg-1">
        <span class="kt-font-success"><div name="graiva" id ="graiva"><?php if ($orden) {
        echo Parametro::formato($orden->getIva(), false);
    } ?></div>  </span>
    </div>                -->
    <div class="col-lg-5"  style="text-align:right">
        <span class="kt-font-success"><h5>TOTAL </h5> </span>
    </div>
    <div class="col-lg-1">
        <span class="kt-font-success"><h3> <div name="gratotal" id ="gratotal"><?php if ($orden) {
        echo Parametro::formato($orden->getValorTotal());
    } ?></div></h3> </span>
    </div>                

</div>

<?php if (count($listado) > 0) { ?>
    <?php $image = '300.jpg'; ?>
    <?php $tituloBoton = 'Confirmar'; ?>
    <?php $icon = 'flaticon-lock'; ?>
    <?php $textoLi = '  Confirmar orden de compra '; ?>
    <?php if ($orden->getEstatus() == "Autorizado") { ?>
        <?php $tituloBoton = 'Finalizar'; ?>
                <?php $image = 'bg-5.jpg'; ?>
                <?php $textoLi = ' Finalizar orden de compra '; ?>
                <?php $icon = 'flaticon2-shield'; ?>
            <?php } ?>
    <div class="row" style="background-image: url(./assets/media/bg/<?php echo $image; ?>);">
        <div class="col-lg-5"></div>
        <div class="col-lg-2">
            <?php if ($orden) { ?>
        <?php if ($orden->getProveedorId()) { ?>
                    <?php if ($orden->getEstatus() != "Autorizado") { ?>
                        <a href="<?php echo url_for($modulo . '/posponer?id=' . $orden->getId() . "&token=" . sha1($orden->getCodigo())) ?>" class="btn btn-small btn-success" > <i class="flaticon-black"></i><br> Guardar </a>
            <?Php } ?>
        <?Php } ?>
            <?Php } ?>
        </div>
        <div class="col-lg-3" style="text-align: right"><font color="white"><br> 
    <?php echo $textoLi; ?>

            </font></div>
        <div class="col-lg-1">
            <?php if ($orden) { ?>
                <?php if ($orden->getProveedorId()) { ?>
            <!--        <a href="<?php echo url_for($modulo . '/confirmar?id=' . $orden->getId() . "&token=" . sha1($orden->getCodigo())) ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-lock"></i> Procesar </a>-->
                    <a id="btnConfirmarOrden" data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-dark"> <i class="<?php echo $icon; ?>"></i> <?php echo $tituloBoton; ?> </a>
        <?Php } else { ?>
                    <SPAN style='color:red; font-weight: bold;'>&nbsp;SELECCIONE<br> PROVEEDOR&nbsp;</span>
        <?Php } ?>
    <?Php } ?>
        </div>
        <div class="col-lg-1">
            <a target="_blank" href="<?php echo url_for('reporte/ordenCompra?token=' . $orden->getToken()) ?>" class="btn btn-secondary btn-warning" > <i class="flaticon2-print"></i><br> Reporte </a>
        </div>
    </div>



    <div id="staticCONFIRMA" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>  <?php echo $textoLi; ?>
                        <strong>Orden de Compra</strong>
                        <span class="caption-subject font-green bold uppercase"> 
    <?php echo $orden->getCodigo() ?>
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmar?id=' . $orden->getId() . "&token=" . sha1($orden->getCodigo())) ?>" >
                        <i class="flaticon2-lock "></i> <?php echo $tituloBoton; ?> </a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div>

    <?php echo $formProducto->renderFormTag(url_for($modulo . '/agregaProducto?id=' . $orden->getId()), array('class' => 'form')) ?>
    <?php echo $formProducto->renderHiddenFields() ?>

    <div id="staticProducto" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Producto Nuevo</h5>
             Completar la informacion requerida
                </div>
                <div class="modal-body">
            
                    
                    <div class="row">
                        <div class="col-lg-2">Codigo<span class="required">*</span> </div>
                           <div class="col-lg-4"><?php echo $formProducto['codigo_sku']; ?> </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2">Nombre <span class="required">*</span></div>
                           <div class="col-lg-8"><?php echo $formProducto['nombre']; ?> </div>
                    </div>
                     
                    <div class="row">
                        <div class="col-lg-2">Grupo <span class="required">*</span></div>
                           <div class="col-lg-8"><?php echo $formProducto['tipo']; ?> </div>
                    </div>
                    
                          <div class="row">
                        <div class="col-lg-2">Precio <span class="required">*</span></div> 
                        <div class="col-lg-3"><?php echo $formProducto['precio']; ?> </div>

                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2">Cantidad <span class="required">*</span></div> 
                        <div class="col-lg-3"><?php echo $formProducto['existencia']; ?> </div>
                        <div class="col-lg-2">Costo Unitario <span class="required">*</span></div> 
                        <div class="col-lg-3"><?php echo $formProducto['costo']; ?> </div>
                    </div>
                    

                    
                    <div class="row">
                        <div class="col-lg-2">Nombre Ingles</div>
                           <div class="col-lg-8"><?php echo $formProducto['nombre_ingles']; ?> </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2">Marca Producto</div>
                           <div class="col-lg-8"><?php echo $formProducto['marcaProducto']; ?> </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2">Caracteristica</div>
                           <div class="col-lg-8"><?php echo $formProducto['caracteristica']; ?> </div>
                    </div>
                    
                    
<div class="row">
                       <div class="col-lg-3">
                           <span style="display:block">Codigo Arancel</span>
                           <?php echo $formProducto['codigo_arancel']; ?> </div>
           <div class="col-lg-3">    <span style="display:block">Costo Fabrica</span><?php echo $formProducto['costo_fabrica']; ?> </div>
                      <div class="col-lg-3"> <span style="display:block">Costo Cif</span><?php echo $formProducto['costo_cif']; ?> </div>
                    </div>
                    
                       
               



                    
                    
                    <div class="row">
                           <div class="col-lg-3">
                                                         <span style="display:block">Origen</span>
                              <?php echo $formProducto['origen']; ?> </div>
            
       
                       <div class="col-lg-3">  <span style="display:block">Peso</span><?php echo $formProducto['peso']; ?> </div>
                        
                    </div>
                    
                    
                    <div class="row">
                           <div class="col-lg-3"> <span style="display:block">Alto</span><?php echo $formProducto['alto']; ?> </div>
                        <div class="col-lg-3"><span style="display:block">Ancho</span><?php echo $formProducto['ancho']; ?> </div>
                        <div class="col-lg-3"><span style="display:block">Largo</span><?php echo $formProducto['largo']; ?> </div>
                    </div>

                </div>

                <div class="modal-footer">
<button id="btnAgregar"
        class="btn btn-xs btn-primary d-none"
        type="submit">
    <i class="fa fa-save"></i> Agregar
</button>


                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>
                </div>
            </div>
        </div>
    </div>
    <?php echo "</form>"; ?>
<?php } ?>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content" style=" width: 750px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Agrega Servicio</h4>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxmodalv" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content" style=" width: 750px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Busqueda Proveedor</h4>
            </div>
        </div>
    </div>
</div>


<?php if ($pideGas) { ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#impuesto_gas").on('change', function () {
                var valor = $("#impuesto_gas").val();
                var id =<?php echo $orden->getId(); ?>
                $.get('<?php echo url_for("orden_compra/valorGas") ?>', {id: id, valor: valor}, function (response) {
                    var respuestali = response;
                    var arr = respuestali.split('|');
                    var subtotal = arr[0];
                    var iva = arr[1];
                    $("#grasubtotal").html(subtotal);
                    $("#graiva").html(iva);

                });
            });
        });
    </script>

<?php } ?>

    <script>
(function () {

    function initValidacionProducto() {

        var modal = document.getElementById("staticProducto");
        if (!modal) return;

        var btn = document.getElementById("btnAgregar");
        var requiredFields = modal.querySelectorAll(".required");

        function validarCampos() {
            var completos = true;

            for (var i = 0; i < requiredFields.length; i++) {
                var field = requiredFields[i];

                // SELECT
                if (field.tagName === "SELECT") {
                    if (field.value === "") {
                        completos = false;
                        break;
                    }
                }
                // INPUT (text, number, etc)
                else if (field.tagName === "INPUT") {
                    if (String(field.value).trim() === "") {
                        completos = false;
                        break;
                    }
                }
            }

            btn.classList.toggle("d-none", !completos);
        }

        // Eventos
        for (var i = 0; i < requiredFields.length; i++) {
            requiredFields[i].addEventListener("input", validarCampos);
            requiredFields[i].addEventListener("change", validarCampos);
        }

        validarCampos();
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initValidacionProducto);
    } else {
        initValidacionProducto();
    }

})();
</script>



<script>
document.getElementById("btnConfirmarOrden").addEventListener("click", function (e) {

    let errores = [];

    document.querySelectorAll("input[id^='costo_']").forEach(function (costoInput) {

        let pid = costoInput.id.replace("costo_", "");

        let costo = parseFloat(costoInput.value) || 0;
        let valorInput = document.getElementById("consulta_valor_" + pid);

        if (valorInput) {
            let valor = parseFloat(valorInput.value) || 0;

            if (costo > valor) {

                // obtenemos descripción del producto (columna 3)
                let fila = costoInput.closest("tr");
                let descripcion = "";

                if (fila) {
                    let celdas = fila.querySelectorAll("td");
                    if (celdas.length > 2) {
                        descripcion = celdas[2].innerText.trim();
                    }
                }

                errores.push("• " + pid + " - " + descripcion + " (Costo: " + costo + " > Valor: " + valor + ")");
            }
        }
    });

    if (errores.length > 0) {

        let mensaje = "⚠️ Los siguientes productos tienen costo mayor al valor:\n\n";
        mensaje += errores.join("\n");
        mensaje += "\n\n¿Está seguro que desea continuar?";

        let confirmar = confirm(mensaje);

        if (!confirmar) {
            e.preventDefault();
            return false;
        }
    }

});
</script>
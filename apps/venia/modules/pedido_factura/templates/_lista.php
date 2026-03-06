
 
<table class="table table-bordered  xdataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="active">
            <th  align="center"><span class="kt-font-success"># </span></th>
            <th  align="center"><span class="kt-font-success">Codigo  </span></th>
            <th  align="center"><span class="kt-font-success">Descripción </span></th>
            <th  align="center"><span class="kt-font-success">Valor Unitario </span></th>
            <th  align="center"><span class="kt-font-success">Cantidad </span></th>
            <th  align="center"><span class="kt-font-success">Valor Total </span></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $can = 0; ?>
        <?php $total = 0; ?>
        <?php $pos = 0; ?>
        <?php foreach ($detalle as $registro) { ?>
            <?php $pos++; ?>
            <?php $total = $total + $registro->getValorTotal(); ?>
            <tr>
                <td <?php if ($registro->getOrdenCotizacionId() <> $operacion->getId()) { ?>  style="background-color:#FFCC00" <?php } ?> ><?php echo $pos; ?></td>
                <td><?php echo $registro->getCodigo(); ?></td>
                <td><?php echo $registro->getDetalle(); ?>
                    <?php if ($registro->getOrdenCotizacionId() <> $operacion->getId()) { ?> <span style="font-weight: bold; display: block" ><?php echo $registro->getOrdenCotizacion()->getCodigo(); ?> </span>  <?php } ?>

                </td>
                <td style="text-align: right">
                    <?php if ($registro->getProductoId()) { ?>
                        <?php $can = $can + $registro->getCantidad(); ?>
<input class="form-control valor-unitario"
       data-id="<?php echo $registro->getId(); ?>"
       data-cantidad="<?php echo $registro->getCantidad(); ?>"
       id="valor<?php echo $registro->getId(); ?>"
       value="<?php echo $registro->getValorUnitario(); ?>"
       disabled>                       

 <?php //echo Parametro::formato($registro->getValorUnitario(), false); ?>
                    <?php } else { ?>
     
<input class="form-control valor-unitario"
       data-id="<?php echo $registro->getId(); ?>"
       data-cantidad="<?php echo $registro->getCantidad(); ?>"
       id="valor<?php echo $registro->getId(); ?>"
       value="<?php echo $registro->getValorUnitario(); ?>"
   > 
                        
                    <?php } ?>
                </td>
                <td style="text-align: right"><?php echo $registro->getCantidad(); ?></td>
                <td style="text-align: right; font-weight:bold;">
                    <input style="background-color:#F0F8FA"  class="form-control" id="linea<?php echo $registro->getId(); ?>" name="linea<?php echo $registro->getId(); ?>" readonly="1"  value="<?php echo Parametro::formato($registro->getValorTotal(), false); ?>">
                </td>
                <td>
                    <?php if (!$registro->getProductoId()) { ?>
                        <a href="<?php echo url_for($modulo . '/eliminaLinea?id=' . $registro->getId()) ?>" class="btn btn-sm  btn-danger" > -  </a>
                    <?php } ?>
                    <?php if ($registro->getOrdenCotizacionId() <> $operacion->getId()) { ?>
                        <a href="<?php echo url_for($modulo . '/eliminaPedido?id=' . $registro->getId()) ?>" class="btn btn-sm  btn-danger" > -  </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"> TOTALES</td>
            <td>
                                                 <button class="btn btn-warning" id="btnEditarPrecios">
    Actualizar Precios
</button>
                
            </td>
            <th style="text-align: right;"><?php echo $can; ?></th>
            <th style="text-align: right;"> 
                <div name="total" id="total">
                    <?php echo Parametro::formato($total); ?> 
                </div>
            </th>
            <th></th>
        </tr>
    </tfoot>

</table>



<div class="modal fade" id="modalEditarPrecio">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4>Actualizar precios</h4>
            </div>

            <div class="modal-body">
                ¿Desea habilitar la edición de todos los precios?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="confirmarEditar">Confirmar</button>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {

    // Abrir modal
    $("#btnEditarPrecios").click(function () {

        $("#modalEditarPrecio").modal("show");

    });


    // Confirmar habilitación de precios
    $("#confirmarEditar").click(function () {

        $("#modalEditarPrecio").modal("hide");

        // habilitar todos los precios
        $(".valor-unitario").prop("disabled", false);

    });


    // Calcular total por línea
    $(".valor-unitario").on("keyup change", function () {

        let id = $(this).data("id");
        let cantidad = parseFloat($(this).data("cantidad")) || 0;
        let valor = parseFloat($(this).val()) || 0;

        let totalLinea = valor * cantidad;

        $("#linea" + id).val(totalLinea.toFixed(2));


    });


    // Guardar en base de datos
//$(".valor-unitario").blur(function () {
//
//    let id = $(this).data("id");
//    let valor = $(this).val();
//
//    $.get("<?php echo url_for($modulo.'/actualizaPrecio'); ?>", {
//        id: id,
//        valor: valor
//    }, function(response){
//               //    $("#total").html(response);
//
//
//    });

});


    // Función calcular total general


});
 </script>
 
 <script>
     $(document).ready(function () {

    // Botón que abre el modal
    $("#btnEditarPrecios").on("click", function () {
        $("#modalEditarPrecio").modal("show");
    });

    // Confirmar edición de precios
    $("#confirmarEditar").on("click", function () {

        // cerrar modal
        $("#modalEditarPrecio").modal("hide");

        // habilitar todos los inputs de precio
        $(".valor-unitario").prop("disabled", false);

        // opcional: enfocar el primer campo
        $(".valor-unitario:first").focus();

    });

});
     </script>
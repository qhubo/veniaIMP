
<style>

    /* Switch contenedor */
    .switch {
        position: relative;
        display: inline-block;
        width: 45px;
        height: 24px;
    }

    /* Oculta checkbox original */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* Fondo del switch */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .3s;
        border-radius: 34px;
    }

    /* Bolita */
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    /* Activo */
    .switch input:checked + .slider {
        background-color: #28a745; /* rojo tipo nota crédito */
    }

    .switch input:checked + .slider:before {
        transform: translateX(21px);
    }

    /* Efecto hover */
    .switch:hover .slider {
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }

</style>
<style>

    /* ============================= */
    /* SWITCH CERTIFICA GRANDE */
    /* ============================= */

    .switch-certifica {
        position: relative;
        display: inline-block;
        width: 70px;
        height: 34px;
    }

    .switch-certifica input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider-certifica {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    /* Bolita */
    .slider-certifica:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    /* Activo */
    .switch-certifica input:checked + .slider-certifica {
        background-color: #28a745; /* Verde profesional */
    }

    .switch-certifica input:checked + .slider-certifica:before {
        transform: translateX(36px);
    }

    /* Efecto hover */
    .switch-certifica:hover .slider-certifica {
        box-shadow: 0 0 8px rgba(0,0,0,0.3);
    }

</style>
<table class="table table-bordered" id="tablaRetorno">
    <thead>
        <tr>
            <th><span class="kt-font-bold kt-font-success">Codigo</span></th>
            <th><span class="kt-font-bold kt-font-success">Detalle</span></th>
            <th align="center"><span class="kt-font-bold kt-font-success">Valor Unitario</span></th>
            <th align="center"><span class="kt-font-bold kt-font-success">Cantidad</span></th>
            <th align="center"><span class="kt-font-bold kt-font-success">Valor Total</span></th>
            <th align="center"><span class="kt-font-bold kt-font-danger">Cant. <br> Retornar</span></th>
            <th align="center"><span class="kt-font-bold kt-font-danger">Retornar <br> Inventario</span></th>


        </tr>
    </thead>
    <tbody>
        <?php $totalC = 0; ?>
        <?php foreach ($detalle as $reg) { ?>
            <?php $totalC = $reg->getValorTotal() + $totalC; ?>
            <tr>
                <td><?php echo $reg->getCodigo(); ?></td>
                <td><?php echo $reg->getDetalle(); ?></td>
                <td align="right"><?php echo number_format($reg->getValorUnitario(), 2); ?></td>
                <td align="right" class="cantidad_actual">
                    <?php echo $reg->getCantidad(); ?>
                </td>
                <td align="right"><?php echo number_format($reg->getValorTotal(), 2); ?></td>

                <!-- INPUT CANTIDAD -->
                <td align="center">
                    <input type="number"
                           class="form-control inputRetorno"
                           style="width:80px; margin:auto;"
                           min="0"
                           max="<?php echo $reg->getCantidad(); ?>"
                           data-id="<?php echo $reg->getId(); ?>"
                           data-max="<?php echo $reg->getCantidad(); ?>"
                           data-precio="<?php echo $reg->getValorUnitario(); ?>"
                           value="0">
                </td>
                <td align="center">
                    <label class="switch">
                        <input type="checkbox"
                               class="checkRetorno"
                               data-id="<?php echo $reg->getId(); ?>">
                        <span class="slider"></span>
                    </label>
                </td>

            </tr>
        <?php } ?>
            <?php if (count($detalle)==0) { ?>
              <tr>
                <td>CDDEVOLUCION</td>
                <td>Devolución de Producto</td>
                <td align="right"><?php //echo number_format($reg->getValorUnitario(), 2); ?></td>
                <td align="right" class="cantidad_actual">   <input type="number" style="background-color: whitesmoke"
                           class="form-control inputRetorno"
                           style="width:80px; margin:auto;"
                           min="0"
                           max="1"
                           data-id="0"
                           data-max="1"
                           data-precio="<?php echo $total; ?>"
                           value="1"> </td>
                <td align="right"><input class="form-control" type="number" step="any" name="devolu" id="devolu" placeholder="0.00"> </td>

                <!-- INPUT CANTIDAD -->
                <td align="center">
                 
                </td>
                <td align="center"> </td>

            </tr>
            <?php } ?>
            
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" align="right"><strong>TOTAL</strong></td>
            <td align="right"><?php echo number_format($totalC, 2); ?></td>
            <td colspan="1"></td>
        </tr>
    </tfoot>
</table>
<input type="hidden" name="jsonRetorno" id="jsonRetorno">
<div class="row" style="padding-top:5px;">
    <div class="col-lg-2 control-label right ">Observaciones </div>
    <div class="col-lg-5 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
        <?php echo $form['observaciones'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['observaciones']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1">Total Productos  </div>
    <div class="col-lg-1">    <span id="totalRetorno" class="label label-danger" style="font-size:16px;">0</span></div>
    <div class="col-lg-1 control-label right ">Valor Nota </div>
    <div class="col-lg-2 <?php if ($form['valor']->hasError()) echo "has-error" ?>">
        <input type="number" style="background-color:whitesmoke"
               id="consulta_valor"
               name="consulta[valor]"
               class="form-control"
               readonly>
               <?php //echo $form['valor'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['valor']->renderError() ?>  
        </span>
    </div>
</div>

<div class="row" style="padding-top:5px; padding-bottom:5px;">
    <div class="col-lg-8"> </div>
    <div class="col-lg-1"> 


    </div>
    <div class="col-lg-2">
        <button class="btn btn-primary " type="submit">
            <i class="fa fa-save "></i>
            Crear Nota
        </button>
    </div>
</div>
<script>

    document.addEventListener("DOMContentLoaded", function () {

        let inputValor = document.getElementById("consulta_valor");
        let inputMax = document.getElementById("tota");

        if (inputValor && inputMax) {

            let max = parseFloat(inputMax.value) || 0;

            // Evento cuando escriben
            inputValor.addEventListener("input", function () {

                let valor = parseFloat(this.value) || 0;

                if (valor > max) {
                    alert("El valor no puede ser mayor a " + max);

                    // Regresa automáticamente al máximo permitido
                    this.value = max.toFixed(2);
                }

                if (valor < 0) {
                    this.value = 0;
                }

            });

        }

    });

</script>


<script>

    document.addEventListener("DOMContentLoaded", function () {

        /* ==========================================
         RECALCULAR TOTALES
         ========================================== */
        function recalcularTotales() {

            let totalCantidad = 0;
            let totalMonto = 0;

            document.querySelectorAll(".inputRetorno").forEach(function (input) {

                let cantidad = parseFloat(input.value) || 0;
                let max = parseFloat(input.dataset.max);
                let precio = parseFloat(input.dataset.precio);

                if (cantidad > max) {
                    alert("No puede retornar más de " + max);
                    input.value = max;
                    cantidad = max;
                }

                if (cantidad < 0) {
                    input.value = 0;
                    cantidad = 0;
                }

                if (cantidad > 0) {

                    totalCantidad += cantidad;
                    totalMonto += (cantidad * precio);

                    // Marcar switch automáticamente
                    let id = input.dataset.id;
                    let check = document.querySelector(".checkRetorno[data-id='" + id + "']");
                    if (check) {
                        check.checked = true;
                    }
                }
            });

            totalMonto = totalMonto.toFixed(2);

            // Actualizar total productos
            let totalLabel = document.getElementById("totalRetorno");
            if (totalLabel) {
                totalLabel.innerText = totalCantidad;
            }

            // Actualizar valor nota automáticamente
            let valorNota = document.getElementById("consulta_valor");
            if (valorNota) {
                valorNota.value = totalMonto;
            }

        }


        /* ==========================================
         GENERAR JSON ANTES DE ENVIAR FORM
         ========================================== */
        function generarJsonRetorno() {

            let resultado = [];

            document.querySelectorAll(".inputRetorno").forEach(function (input) {

                let id = input.dataset.id;
                let cantidad = parseFloat(input.value) || 0;

                let check = document.querySelector(".checkRetorno[data-id='" + id + "']");
                let retornarInventario = (check && check.checked) ? 1 : 0;

                let ubicacionInput = document.querySelector(".inputUbicacion[data-id='" + id + "']");
                let ubicacion = ubicacionInput ? ubicacionInput.value : "";

                if (cantidad > 0) {

                    resultado.push({
                        id: id,
                        cantidad: cantidad,
                        retornar_inventario: retornarInventario,
                        ubicacion: ubicacion
                    });

                }

            });

            document.getElementById("jsonRetorno").value = JSON.stringify(resultado);

            console.log("JSON Generado:", resultado);
        }

        /* ==========================================
         EVENTOS INPUT CANTIDAD
         ========================================== */
        document.querySelectorAll(".inputRetorno").forEach(function (input) {

            input.addEventListener("input", function () {
                recalcularTotales();
            });

        });


        /* ==========================================
         EVENTO SWITCH VISUAL
         ========================================== */
        document.querySelectorAll(".checkRetorno").forEach(function (check) {

            check.addEventListener("change", function () {

                let label = this.closest("td")?.querySelector(".estadoSwitch");

                if (label) {
                    label.innerText = this.checked ? "Sí" : "No";
                    label.className = this.checked
                            ? "estadoSwitch text-danger"
                            : "estadoSwitch text-muted";
                }

            });

        });


        /* ==========================================
         GENERAR JSON AL ENVIAR FORM
         ========================================== */
        let form = document.querySelector("form");

        if (form) {
            form.addEventListener("submit", function () {

                generarJsonRetorno();

            });
        }

    });
</script>


<script>

document.addEventListener("DOMContentLoaded", function () {

    let devolu = document.getElementById("devolu");
    let valorNota = document.getElementById("consulta_valor");
    let totalProductos = document.getElementById("totalRetorno");
    let jsonInput = document.getElementById("jsonRetorno");

    if (devolu) {

        let max = <?php echo $total; ?>;

        devolu.addEventListener("input", function () {

            let valor = parseFloat(this.value) || 0;

            /* ================================
             VALIDAR NO MAYOR AL TOTAL
             ================================ */
            if (valor > max) {
                alert("El valor no puede ser mayor a " + max);
                valor = max;
                this.value = max.toFixed(2);
            }

            if (valor < 0) {
                valor = 0;
                this.value = 0;
            }

            /* ================================
             ACTUALIZAR VALOR NOTA
             ================================ */
            if (valorNota) {
                valorNota.value = valor.toFixed(2);
            }

            /* ================================
             ACTUALIZAR TOTAL PRODUCTOS
             ================================ */
            if (totalProductos) {
                totalProductos.innerText = valor > 0 ? 1 : 0;
            }

            /* ================================
             GENERAR JSON MISMA ESTRUCTURA
             ================================ */
            let json = [];

            if (valor > 0) {

                json.push({
                    id: 0,
                    cantidad: 1,
                    retornar_inventario: 0,
                    ubicacion: "",
                    valor_manual: valor
                });

            }

            if (jsonInput) {
                jsonInput.value = JSON.stringify(json);
            }

            console.log("JSON DEVOLUCION:", json);

        });

    }

});
</script>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>

<?php echo $form->renderFormTag(url_for('recetario/nueva')) ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Receta Médica
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            &nbsp;
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>


            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Nueva Receta
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo url_for('recetario/lista') ?>">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row" style="padding-top: 10px;">
                    <div class="form-group col-md-6">
                        <?php echo $form['cliente']->renderLabel() ?>
                        <?php echo $form['cliente'] ?>
                        <span>
                            <?php echo $form['cliente']->renderError() ?>
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <?php echo $form['fecha']->renderLabel() ?>
                        <?php echo $form['fecha'] ?>
                        <span>
                            <?php echo $form['fecha']->renderError() ?>
                        </span>
                    </div>
                    <div class="form-group col-md-12">
                        <?php echo $form['observaciones_cabecera']->renderLabel() ?>
                        <?php echo $form['observaciones_cabecera'] ?>
                        <span>
                            <?php echo $form['observaciones_cabecera']->renderError() ?>
                        </span>
                    </div>
                    <div class="col-md-12">
                        <h5>Detalle</h5>
                        <hr />
                    </div>
                    <div class="col-md-6">
                        <div class="table-striped">
                            <table class="table table-striped">
                                <tr>
                                    <td>Tipo:</td>
                                    <td><?php echo $form['tipo'] ?></td>
                                </tr>
                                <tr class="element_tipo">
                                    <td id="tipo_elemento"></td>
                                    <td>
                                        <?php echo $form['producto'] ?>
                                        <?php echo $form['servicio'] ?>
                                    </td>
                                </tr>
                                <tr class="element_tipo">
                                    <td>Dosis:</td>
                                    <td><?php echo $form['dosis'] ?></td>
                                </tr>
                                <tr class="element_tipo">
                                    <td>Cada:</td>
                                    <td>
                                        <?php echo $form['cada'] ?><?php echo $form['frecuencia'] ?>
                                    </td>
                                </tr>
                                <tr class="element_tipo">
                                    <td>Observaciones:</td>
                                    <td><?php echo $form['observaciones'] ?></td>
                                </tr>
                                <tr class="element_tipo">
                                    <td></td>
                                    <td style="align-content: right;">
                                        <button type="button" onclick="registrar()" class="btn btn-info"><i class="flaticon-plus"></i> Agregar</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo</th>
                                        <th>Detalle</th>
                                        <th>Dosis</th>
                                        <th>Frecuencia</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla">

                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6">

                                <button type="submit" class="btn btn-block btn-success">
                                    <i class="fa  fa-save"></i>
                                    Guardar

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $form['detalle'] ?>
<?php echo $form->renderHiddenFields() ?>
<?php echo "</form>" ?>
<div class="modal fade" id="kt_modal_detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Receta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="modal_body_detalle">


            </div>
            <div class="modal-footer">
                
                <a target="_blank" class="btn btn-danger" href="<?php echo url_for('recetario/eliminar') . "?id=" . $id ?>">
                   <i class="flaticon2-trash"></i>  Eliminar
                </a>
                <a target="_blank" class="btn btn-warning" href="<?php echo url_for('recetario/imprimir') . "?id=" . $id ?>">
                   <i class="flaticon2-printer"></i>  Imprimir
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-secondary btn-dark">Cancelar</button>

            </div>
        </div>
    </div>
</div>
<script>
    function limpieza_forms() {
        //Tipo
        $("#receta_nueva_tipo").select2("destroy");
        $("#receta_nueva_tipo").val("");
        $("#receta_nueva_tipo").select2();
        //Producto
        $("#receta_nueva_producto").select2("destroy");
        $("#receta_nueva_producto").val("");
        $("#receta_nueva_producto").select2();
        //Resto campos
        $("#receta_nueva_servicio").val("");
        $("#receta_nueva_dosis").val("");
        $("#receta_nueva_frecuencia").val("");
        $("#receta_nueva_observaciones").val("");
        tipo_change()
    }

    function registrar() {
        //Validacion
        const tipo = $("#receta_nueva_tipo").val();
        const servicio = $("#receta_nueva_servicio").val();
        const producto = $("#receta_nueva_producto").val();
        const producto_texto = $("#receta_nueva_producto option:selected").text();
        const dosis = $("#receta_nueva_dosis").val();
        const frecuencia = $("#receta_nueva_frecuencia").val();
        const observaciones = $("#receta_nueva_observaciones").val();
        const cada = $("#receta_nueva_cada").val();
        if (tipo == "") {
            alert("Campo 'TIPO' requerido")
            return 0;
        }
        if (tipo == "Producto" && producto == "") {
            alert("Campo 'Producto' requerido")
            return 0;
        }
        if (tipo != "Producto" && servicio == "") {
            alert("Campo 'Servicio' requerido")
            return 0;
        }
        if (producto != "") {
        if (dosis == "") {
            alert("Campo 'Dosis' requerido")
            return 0;
        }
        if (frecuencia == "") {
            alert("Campo 'Frecuencia' requerido")
            return 0;
        }
    }
        const contador = $("#tabla").children('tr').length + 1;
        inserta_elemento_input(tipo, servicio, producto, producto_texto, dosis, frecuencia, observaciones, cada)
        limpieza_forms();
    }

    function inserta_elemento_input(tipo, servicio, producto, producto_texto, dosis, frecuencia, observaciones, cada) {
        var detalle = $("#receta_nueva_detalle").val();
        var objeto = [];
        if (detalle != "") {
            objeto = JSON.parse(detalle);
        }
        objeto.push({
            tipo,
            servicio,
            producto,
            producto_texto,
            dosis,
            frecuencia: ("cada " + frecuencia + " " + cada),
            observaciones
        })
        $("#receta_nueva_detalle").val(JSON.stringify(objeto));
        construye_tabla();
    }

    function construye_tabla() {
        var detalle = $("#receta_nueva_detalle").val();
        var objeto = [];
        if (detalle != "") {
            objeto = JSON.parse(detalle);
            let new_row = ''
            let contador = 1;
            for (let i = 0; i < objeto.length; i++) {
                new_row += '<tr class="fila_tabla">\
        <td>' + contador + '</td>\
        <td>' + objeto[i].tipo + '</td>\
        <td>' + (objeto[i].tipo == "Producto" ? objeto[i].producto_texto : objeto[i].servicio) + '</td>\
        <td>' + objeto[i].dosis + '</td>\
        <td>' + objeto[i].frecuencia + '</td>\
        <td><button type="button" class="btn btn-xs btn-danger" onclick="eliminar_row(' + contador + ')">-</button></td>\
        </tr>'
                contador++;
            }
            $("#tabla").html(new_row)
        }
    }

    function eliminar_row(contador) {
        var detalle = JSON.parse($("#receta_nueva_detalle").val());
        detalle.splice(contador - 1, 1)
        $("#receta_nueva_detalle").val(JSON.stringify(detalle));
        construye_tabla();
    }

    function tipo_change() {
        $('.element_tipo').hide();
        $('#receta_nueva_producto').next(".select2-container").hide();
        $('#receta_nueva_servicio').hide();
        const val = $("#receta_nueva_tipo").val();
        if (val !== "") {
            $('.element_tipo').show();
            $("#tipo_elemento").html(val)
        }
        if (val === 'Producto') {
            $('#receta_nueva_producto').next(".select2-container").show();
        } else {
            $('#receta_nueva_servicio').show();
        }
    }

    function open_pdf() {
        var url = '<?php echo url_for('recetario/detalle') . "?id=" . $id ?>';
        $.get(url, function(html) {
            $("#modal_body_detalle").html(html);
            $("#kt_modal_detalle").modal('show');
        })
    }
    $(document).ready(function() {

        $('.element_tipo').hide();
        $('#receta_nueva_producto').next(".select2-container").hide();
        $('#receta_nueva_servicio').hide();
        $('#receta_nueva_tipo').on('change', function() {
            tipo_change();
        })
        construye_tabla();
        <?php if ($id != null && $id > 0) : ?>
            open_pdf();
        <?php endif; ?>
    })
</script>
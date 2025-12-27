<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                PAGO PRESTAMO <?php echo $prestamo->getNombre(); ?><small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            
            
                  
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class='col-md-10' >  
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist"  style="background-color:#e1e1ef !important;">
                <li class="nav-item">
                    <a class="nav-link  <?php if ($sele == 0) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_3_99_tab_content" role="tab" aria-selected="false">
                        Ingreso
                    </a>
                </li>                
                <?php $conta = 0; ?>
                <?php foreach ($result as $vende) { ?>
                    <?php $conta++; ?>
                    <li class="nav-item">
                        <a class="nav-link  <?php if ($conta == $sele) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_3_<?php echo $vende['Years'] ?>_tab_content" role="tab" aria-selected="false">
                            &nbsp; &nbsp;Historico <?php echo $vende['Years']; ?>
    <!--                                    <span style="margin-right: 5px; margin-left: 5px; color:#FFFFFF !important; background-color: #FFCC00  !important; padding-bottom: 5px; padding-top: 5px; padding-left: 5px; padding-right:  5px;">  <?php //echo $vende['citas']          ?> </span>-->

                        </a>
                    </li>
                <?php } ?>
            </ul>
            </div>
              <div class='col-md-1' >  
            
               <a target="_blank" href="<?php echo url_for( 'prestamo/reporte?id='.$prestamo->getId())  ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
              </div>
                     
        </div>




        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane  <?php if ($sele == 0) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_99_tab_content" role="tabpanel">
                        <?php $modulo = $sf_params->get('module'); ?>
                        <?php echo $form->renderFormTag(url_for($modulo . '/pago?id=' . $id), array('class' => 'form-horizontal"')) ?>
                        <?php echo $form->renderHiddenFields() ?>
                        <br>
                        <div class='row'>
                            <div class='col-md-6' >   
                                <?php include_partial($modulo . '/datos', array('quetzales' => $quetzales, 'interes' => $interes, 'dias' => $dias, 'prestamo' => $prestamo, 'form' => $form, 'modulo' => $modulo)) ?>
                            </div> 
                            <div class="col-md-3">
                                <?php include_partial($modulo . '/valores', array('prestamo' => $prestamo, 'tasa' => $tasa, 'modulo' => $modulo)) ?>


                                <div class="row" style="padding-top:10px;">               
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-6">

                                        <a href="<?php echo url_for($modulo . "/lista") ?>" id="deta" class=" deta btn-dark btn  btn-sm btn-block" data-toggle="modal" data-target="#ajaxmodal"> <i class="flaticon-list"></i> Detalle Interes   </a>
                                    </div>
                                </div>                


                                <div class="row" style="padding-top:50px;">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-6">
                                        <button class="btn btn-block btn-primary " type="submit">
                                            <i class="fa fa-save "></i>
                                            Aceptar  
                                        </button>
                                    </div>  
                                </div>

                            </div>

                        </div>  
                        <?php echo "</form>"; ?>
                    </div>
                    <?php $conta = 0; ?>
                    <?php foreach ($result as $vende) { ?>
                        <?php $conta++; ?>
                        <div class="tab-pane <?php if ($conta == $sele) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_<?php echo $vende['Years'] ?>_tab_content" role="tabpanel">

                            <div class="row">


                                <div class="col-md-10 " style="padding-top:20px;">
                                    <?php $anio = $vende['Years'] ?>
                                    <?php $detalle = $data[$anio]; ?>
                                    <?php include_partial($modulo . '/listado', array('ultimo' => $ultimo, 'detalle' => $detalle, 'modulo' => $modulo)) ?>
                                </div>
<!--                                <div class="col-md-3 " style="padding-top:20px;">
                                    <table cellpadding="8" border="1" >
                                        <tr>
                                            <td colspan="2">
                                                <div class="text-align:center; content-align:center;">
                                                    <h3>&nbsp; &nbsp; &nbsp; &nbsp; <?php echo $anio; ?></h3>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"  style="  background-color:#ebedf2" >&nbsp;&nbsp;Total Interes&nbsp;&nbsp;</td>
                                            <th style="text-align:right">&nbsp;&nbsp; 00,000.00</th>
                                        <tr>
                                        <tr>
                                            <td align="center"  style="background-color:#ebedf2" >&nbsp;&nbsp;Total Gastos&nbsp;&nbsp;</td>
                                            <th style="text-align:right">&nbsp;&nbsp; 0,000.00&nbsp;&nbsp;</th>
                                        <tr>
                                    </table>

                                </div>-->
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>



<script>
    jQuery(document).ready(function(){
 
 $("#deta").click(function(){

  
            $.get('<?php echo url_for("prestamo/lista") ?>', {id: 1}, function (response) {
                $("#detalleInte").html(response);
            });
    
    })
 
    })
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_tipo").on('change', function () {

            var valor = $("#consulta_tipo").val();
            if (valor == "CALCULO INTERES") {

                $("#consulta_valor_dolares").prop("readonly", true);
                $("#consulta_valor_dolares").css("background-color", "#F9FBFE");
                $("#valfecha").css("display", "block");
                $("#valbanco").css("display", "none");
                $("#valfecha1").css("display", "block");
                $("#valbanco1").css("display", "none");
                $("#valdia").css("display", "block");
 
                
            }
            if (valor != "CALCULO INTERES") {
                $("#consulta_valor_dolares").prop("readonly", false);
                $("#consulta_valor_dolares").css("background-color", "#FFFFFF");
                $("#valfecha").css("display", "none");
                $("#valbanco").css("display", "block");
                $("#valfecha1").css("display", "none");
                $("#valbanco1").css("display", "block");
                 $("#valdia").css("display", "none");

            }
            if (valor == "AJUSTE DIFERENCIAL") {
                $("#consulta_valor_dolares").prop("readonly", true);
                $("#consulta_valor_dolares").css("background-color", "#F9FBFE");
                $("#consulta_valor_quetzales").prop("readonly", false);
                $("#consulta_valor_quetzales").css("background-color", "#FFFFFF");
                $("#valbanco").css("display", "none");
                $("#valbanco1").css("display", "none");
            }
            if (valor != "AJUSTE DIFERENCIAL") {
                $("#consulta_valor_quetzales").prop("readonly", true);
                $("#consulta_valor_quetzales").css("background-color", "#F9FBFE");

            }

        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_tipo").on('change', function () {
            var id =<?php echo $prestamo->getId(); ?>;
            var valor = $("#consulta_fecha").val();
            var tipo = $("#consulta_tipo").val();
            var tasa = $("#tasacambio").val();

            var fecha_inicio = $("#consulta_fecha_inicio").val();

            $.get('<?php echo url_for("prestamo/tipo") ?>', {id: id, valor: valor, tipo: tipo, fecha_inicio: fecha_inicio}, function (response) {
                $("#consulta_valor_dolares").val(response);
            });
            $.get('<?php echo url_for("prestamo/tipo") ?>', {id: id, valor: valor, tipo: tipo, fecha_inicio: fecha_inicio, tasa: tasa}, function (response) {
                $("#consulta_valor_quetzales").val(response);
            });
        });
    });
</script>




<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_valor_dolares").on('change', function () {
            var valor = $("#consulta_valor_dolares").val();
            var tasa = $("#tasacambio").val();
            $.get('<?php echo url_for("prestamo/tasaque") ?>', {valor: valor, tasa: tasa}, function (response) {
                $("#consulta_valor_quetzales").val(response);
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_valor_quetzales").on('change', function () {
            var valor = $("#consulta_valor_quetzales").val();
            var tasa = $("#tasacambio").val();
            $.get('<?php echo url_for("prestamo/tasado") ?>', {valor: valor, tasa: tasa}, function (response) {
                $("#consulta_valor_dolares").val(response);
            });
        });
    });
</script>



<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_fecha").on('change', function () {
            var id =<?php echo $prestamo->getId(); ?>;
            var valor = $("#consulta_fecha").val();
            $.get('<?php echo url_for("prestamo/tasa") ?>', {id: id, valor: valor}, function (response) {
                $("#tasacambio").val(response);
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_fecha").on('change', function () {
            var id =<?php echo $prestamo->getId(); ?>;
            var valor = $("#consulta_fecha").val();
            var fecha_inicio = $("#consulta_fecha_inicio").val();
            var tasa = $("#tasacambio").val();
            $.get('<?php echo url_for("prestamo/interes") ?>', {id: id, valor: valor, fecha_inicio: fecha_inicio, tipo: 1, tasa: tasa}, function (response) {
                $("#consulta_valor_dolares").val(response);

            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_fecha").on('change', function () {
            var id =<?php echo $prestamo->getId(); ?>;
            var valor = $("#consulta_fecha").val();
            var fecha_inicio = $("#consulta_fecha_inicio").val();
            var tasa = $("#tasacambio").val();
            $.get('<?php echo url_for("prestamo/interes") ?>', {id: id, valor: valor, fecha_inicio: fecha_inicio, tipo: 2, tasa: tasa}, function (response) {
                $("#consulta_valor_quetzales").val(response);

            });
        });
    });
</script>




<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_fecha").on('change', function () {
            var id =<?php echo $prestamo->getId(); ?>;
            var valor = $("#consulta_fecha").val();
            $.get('<?php echo url_for("prestamo/dias") ?>', {id: id, valor: valor}, function (response) {
                $("#vdia").val(response);
            });
        });
    });
</script>

<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<?php if ($prestamoDetalle) { ?>


    <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida   </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">



                    <?php include_partial('prestamo/partida', array('id' => $Idv, 'form' => $forma, 'partidaDetalle' => $partidaDetalle, 'cuentasUno' => $cuentasUno)) ?>  

                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $("#cuenta").select2({
            dropdownParent: $("#ajaxmodalPartida")
        });
    });
    </script>

    <script>
        $(document).ready(function () {
            $("#ajaxmodalPartida").modal();
        });
    </script>

<?php } ?>


<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Detalle Calculo Interes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="conteni" class="modal-body">


            </div>
        </div>
    </div>
</div>

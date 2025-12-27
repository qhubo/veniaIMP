<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-list-1 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Partida Inicial<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Carga de saldos iniciales </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporteModelo') ?>" class="btn-sm btn-info" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-4">Carga los saldos de tu partida inicial</div> 
            <div class="col-lg-2">    <a href="<?php echo url_for($modulo . '/index?ma2=1') ?>" class="btn-sm btn-black" >Ver&nbsp;todas&nbsp;las&nbsp;cuentas</a></div>
            <div class="col-lg-2"> <a href="<?php echo url_for("carga/index?tipo=partida") ?>" class="btn btn-dark" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa flaticon-upload"></li> Importar archivo   </a></div>
            <div class="col-lg-2"> </div>
        </div>
        <div class='row'>
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row">
            <div class="col-lg-12">


                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link  active  " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Carga
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o  " aria-hidden="true"></i>Historico
                        </a>
                    </li>
                </ul>
                <div class="tab-content"    >
                    <div class="tab-pane  active  " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">

                        <?php echo $form->renderFormTag(url_for('partida_inicial/index?carga=' . $carga), array('class' => 'form')) ?>
                        <?php echo $form->renderHiddenFields() ?>
                        <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin "  width="100%">
                            <thead>
                                <tr class="active">
<th  width="10px"   align="center"><span class="kt-font-info"> #</span></th>
                                    <th  width="50px"   align="center"><span class="kt-font-info"> Tipo</span></th>
                                    <th  width="150px"   align="center"><span class="kt-font-info"> Cuenta</span></th>
                                    <th   align="center"><span class="kt-font-info"> Nombre</span></th>
                                    <th  width="150px"   align="center"><span class="kt-font-info"> Debe</span></th>
                                    <th  width="150px"   align="center"><span class="kt-font-info"> Haber</span>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $can=0; ?>
                                <?php foreach ($listaCuentas as $registro) { ?>
                                  <?php $can++; ?>
                                 <?php  $reg= $registro; ?>
                                    <tr>
                                          <td><?php echo $can ?></td>
                                        <td><?php echo $registro->getTipo() ?></td>
                                        <td><?php echo $registro->getCuentaContable() ?> </td>
                                        <td><?php echo $registro->getNombre() ?></td>
                                        <td><?php echo $form['debe' . $registro->getId()]; ?></td>
                                        <td><?php echo $form['haber' . $registro->getId()]; ?></td>
                                    </tr>
                                    
    <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_debe<?php echo $reg->getId(); ?>").on('change', function () {
                var valortotal = 0;
                var valortotal2 = 0;

    <?php foreach ($lis as $dev) { ?>
                    var valor = $("#consulta_debe<?php echo $dev; ?>").val();
                    if (valor != '') {
                        valortotal = parseFloat(valor) + parseFloat(valortotal);
                    }
                    var valor2 = $("#consulta_haber<?php echo $dev; ?>").val();
                    if (valor2 != '') {
                        valortotal2 = parseFloat(valor2) + parseFloat(valortotal2);
                    }
    <?php } ?>
                $("#total1").html("<strong>" + parseFloat(valortotal).toFixed(2) + "</strong>");
                $("#total2").html("<strong>" + parseFloat(valortotal2).toFixed(2) + "</strong>");
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_haber<?php echo $reg->getId(); ?>").on('change', function () {
                var valortotal = 0;
                var valortotal2 = 0;

    <?php foreach ($lis as $dev) { ?>
                    var valor = $("#consulta_debe<?php echo $dev; ?>").val();
                    if (valor != '') {
                        valortotal = parseFloat(valor) + parseFloat(valortotal);
                    }
                    var valor2 = $("#consulta_haber<?php echo $dev; ?>").val();
                    if (valor2 != '') {
                        valortotal2 = parseFloat(valor2) + parseFloat(valortotal2);
                    }
    <?php } ?>
                $("#total1").html("<strong>" + parseFloat(valortotal).toFixed(2) + "</strong>");
                $("#total2").html("<strong>" + parseFloat(valortotal2).toFixed(2) + "</strong>");

            });
        });
    </script>

                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"  style="text-align: right"> <strong>Totales</strong> </td>
                                    <td style="text-align:right" >   <div class="total1" id="total1" > <strong><?php echo Parametro::formato($total1); ?></strong></div>
                                    </td>
                                    <td  style="text-align:right">   <div class="total2" id="total2" ><strong><?php echo Parametro::formato($total2); ?></strong></div>
                                    </td>

                                </tr>


                                <?php if ($listaCuentas) { ?>
                                    <tr>
                                        <td>
                                            <?php if ($carga) { ?>
                                                <a class="btn btn-sm  btn-danger" data-toggle="modal" href="#staticVE">
                                                    <i class="fa fa-trash"></i>  Eliminar
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td colspan="3" class="<?php if ($form['confirma']->hasError()) echo "has-error" ?>" style="text-align: right"> Confirmo carga de saldos iniciales
                                            <?php echo $form['confirma']; ?>
                                            <span class="help-block form-error"> 
                                                <?php echo $form['confirma']->renderError() ?>  
                                            </span>
                                        </td>
                                        <td>    


                                            <button class="btn btn-success " type="submit">
                                                <i class="fa fa-check"></i> Aceptar
                                            </button>



                                        </td>
                                    </tr> 
                                <?php } ?>

                            </tfoot>
                        </table>
                        <?php echo '</form>'; ?>
                    </div>
                    
                    <div class="tab-pane " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
                            <div class="row">
                            <div class="col-lg-12"><br><br><br><br></div>
                        </div>
<?php foreach($partidas as $li) { ?>
                    
                        <div class="row">
                            <div class="col-lg-12">                        
                       <?php include_partial('proceso/partida', array('id' => $li->getId())) ?>  
                                   </div>
                </div>
<?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script src='/assets/global/plugins/jquery.min.js'></script>
<?php foreach ($listaCuentas as $reg) { ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_debe<?php echo $reg->getId(); ?>").on('change', function () {
                var valortotal = 0;
                var valortotal2 = 0;

    <?php foreach ($lis as $dev) { ?>
                    var valor = $("#consulta_debe<?php echo $dev; ?>").val();
                    if (valor != '') {
                        valortotal = parseFloat(valor) + parseFloat(valortotal);
                    }
                    var valor2 = $("#consulta_haber<?php echo $dev; ?>").val();
                    if (valor2 != '') {
                        valortotal2 = parseFloat(valor2) + parseFloat(valortotal2);
                    }
    <?php } ?>
                $("#total1").html("<strong>" + parseFloat(valortotal).toFixed(2) + "</strong>");
                $("#total2").html("<strong>" + parseFloat(valortotal2).toFixed(2) + "</strong>");
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_haber<?php echo $reg->getId(); ?>").on('change', function () {
                var valortotal = 0;
                var valortotal2 = 0;

    <?php foreach ($lis as $dev) { ?>
                    var valor = $("#consulta_debe<?php echo $dev; ?>").val();
                    if (valor != '') {
                        valortotal = parseFloat(valor) + parseFloat(valortotal);
                    }
                    var valor2 = $("#consulta_haber<?php echo $dev; ?>").val();
                    if (valor2 != '') {
                        valortotal2 = parseFloat(valor2) + parseFloat(valortotal2);
                    }
    <?php } ?>
                $("#total1").html("<strong>" + parseFloat(valortotal).toFixed(2) + "</strong>");
                $("#total2").html("<strong>" + parseFloat(valortotal2).toFixed(2) + "</strong>");

            });
        });
    </script>
<?php } ?>




<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>


<div id="staticVE" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p> Confirma Eliminar Todas los saldos cargados
                    <span class="caption-subject font-green bold uppercase"> 
                        <strong> Esta seguro de eliminar todos los registros </strong>
                    </span> ?
                </p>
            </div>
            <?php $token = md5('axa'); ?>
            <div class="modal-footer">
                <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/eliminaCompleto?token=' . $token . '&id=') ?>" >
                    <i class="fa fa-trash-o "></i> Confirmar </a> 
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

            </div>

        </div>
    </div>
</div> 

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
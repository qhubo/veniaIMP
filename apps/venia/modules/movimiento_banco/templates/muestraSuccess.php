<?php $modulo = $sf_params->get('module'); ?>

<!--<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>-->
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-arrows kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                DETALLE  DE TRANSFERENCIA BANCARIA &nbsp;&nbsp;<strong> # <?php echo $muestra->getId(); ?>  </strong><small> &nbsp;&nbsp;&nbsp;
                </small>
            </h3>

        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <?php $bancoUnoo = BancoQuery::create()->findOneById($muestra->getBancoOrigen()); ?>
    <?php $bancoDos = BancoQuery::create()->findOneById($muestra->getBancoId()); ?>
    <div class="kt-portlet__body">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link   active  " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>General
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Partida
                </a>
            </li>
        </ul>
        <div class="tab-content"    >
            <div class="tab-pane  active  " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">

                <div class="row">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-8">
                        <table class="table  table-bordered " >
                            <tr>
                                <th style="background-color: #146CB5;color:white"> <h3>Bancos</h3></th>

                                <th style="background-color: #146CB5;color:white"> Origen</th>
                                <td><?php echo $bancoUnoo->getNombre() ?></td>
                                <th style="background-color: #ebedf2">Destino</th>
                                <td><?php echo $bancoDos->getNombre() ?></td>
                            </tr>
                            <tr>
                                <th style="background-color: #146CB5;color:white"> <h3>Detallle</h3></th>

                                <th style="background-color: #146CB5;color:white">Referencia</th>
                                <td><?php echo $muestra->getDocumento() ?></td>
                                <th  style="background-color: #ebedf2;">Observaciones</th>
                                <td ><?php echo $muestra->getObservaciones() ?></td>
                            </tr>
                            <tr>
                                <td><font size="-2"><?php echo $muestra->getUsuario(); ?> </font><br>
                                    <font size="-2"><?php echo $muestra->getCreatedAt('d/m/Y H:i:s'); ?> </font>
                                </td>

                                <th style="background-color: #146CB5;  color:white">Fecha Documento</th>
                                <td><?php echo $muestra->getFechaDocumento('d/m/Y') ?></td>

                                <td style="text-align: right"> <h3>Total</h3></td>
                                <td style="text-align: right"><h3> <?php echo Parametro::formato(abs($muestra->getValor())); ?></h3> </td>
                            </tr>                
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane  " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">

                <div class="row">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-8">
                        <?php if ($muestra->getPartidaNo()) { ?>
                            <?php include_partial('proceso/partida', array('id' => $muestra->getPartidaNo())) ?> 
                        <?php } ?>
                    </div>
                </div>
            </div>      
        </div>



    </div>
</div>

<?php $partidas[] = $muestra->getPartidaNo(); ?>
<?php $partidaPen = PartidaQuery::create()->filterById($partidas, Criteria::IN)->filterByConfirmada(false)->orderById('Asc')->findOne(); ?>

<?php if ($partidaPen) { ?>
     <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">



                    <?php include_partial('proceso/partidaCambia', array('partidaPen' => $partidaPen)) ?>  
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <?php foreach ($partidaPen->getListDetalle() as $cta) { ?>
        <script>
            $(document).ready(function () {
                $("#cuenta<?php echo $cta; ?>").select2({
                    dropdownParent: $("#ajaxmodalPartida")
                });
            });
        </script>
    <?php } ?>
    <script>
        $(document).ready(function () {
            $("#ajaxmodalPartida").modal();
        });
    </script>

<?php } ?>


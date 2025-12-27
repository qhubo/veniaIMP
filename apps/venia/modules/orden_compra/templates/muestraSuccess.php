<?php $tabSelec = sfContext::getInstance()->getUser()->getAttribute('tab', null, 'seguridad'); ?>
<?php if ($tabSelec) { ?>
    <?php $tab = 6; ?>
<?php } ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php $partidas[] = 0; ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares-1 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                ORDEN DE COMPRA <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Información del documento&nbsp;&nbsp;&nbsp; </small>
            </h3>
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>

        </div>
        <div class="kt-portlet__head-toolbar">

            <?php if ($tabSelec) { ?>
                <a href="<?php echo url_for('cxc_por_pagar/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

            <?php } elseif ($orden->getEstatus() == "Autorizado") { ?>
                <a href="<?php echo url_for('pro_ordencompra/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>



            <?php } else { ?>
                <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

            <?php } ?>

           
        </div>
    </div>



    <div class="kt-portlet__body">



        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>General
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 3) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Información Adicional
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 4) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_4_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Documento
                </a>
            </li>
            <?php if ($orden->getEstatus() == "Autorizado") { ?>
                <li class="nav-item">
                    <a class="nav-link <?php if ($tab == 5) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_5_tab_content" role="tab" aria-selected="false">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>Contable
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($tab == 6) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_6_tab_content" role="tab" aria-selected="false">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>Pago
                    </a>
                </li>
            <?Php } ?> 
        </ul>

        <div class="tab-content"    >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                <?php include_partial($modulo . '/ficha', array('orden' => $orden)) ?>  

                <?php include_partial($modulo . '/fichalista', array('orden' => $orden, 'lista' => $lista)) ?> 
            </div>
            <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
            <?php include_partial('soporte/valorCampo', array('tipoDocumento' => 'OrdenCompra', 'idDoc' => $orden->getId())) ?> 
          
            </div>
            <div class="tab-pane <?php if ($tab == 4) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_4_tab_content" role="tabpanel">
                <?php $urlFrame = "http://" . $_SERVER['SERVER_NAME']; ?>
                <?php if ($_SERVER['SERVER_NAME'] == "venia") { ?>
                    <?php $urlFrame = "http://" . $_SERVER['SERVER_NAME'] . ':8080'; ?>
                <?php } ?>
                <?php $urlReporte = $urlFrame . "/index.php/reporte/ordenCompra?token=" . $orden->getToken(); ?>

                <div class="row">
                    <div class="col-lg-10"></div>
                    <div class="col-lg-2">          <a target="_blank" href="<?php echo url_for('reporte/ordenCompra?token=' . $orden->getToken()) ?>" class="btn btn-secondary btn-warning" > <i class="flaticon-download-1"></i> Descargar </a>
                    </div>
                </div>

                <?php //echo $urlReporte; ?>
                
                <embed src="<?php echo $urlReporte ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="600px" />         
            </div>
           <?php if ($orden->getPartidaNo()) { ?>
            <div class="tab-pane <?php if ($tab == 5) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_5_tab_content" role="tabpanel">
                <?php include_partial('proceso/partida', array('id' => $orden->getPartidaNo())) ?>  
                <?php $partidas[] = $orden->getPartidaNo(); ?>
                <?Php foreach ($pagos as $pago) { ?>
                    

                    <?php $partidas[] = $pago->getPartidaNo(); ?>
                <?php } ?>


            </div>
           <?php } ?>
            <div class="tab-pane <?php if ($tab == 6) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_6_tab_content" role="tabpanel">

                <?php include_partial($modulo . '/pago', array('pagos' => $pagos, 'orden' => $orden, 'form' => $form)) ?>  

            </div>
        </div>

    </div>
</div>


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


          <script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_tipo_pago").on('change', function () {
            var val= $("#consulta_tipo_pago").val();
            var id =<?php echo $orden->getId(); ?>;
            
              $.get('<?php echo url_for("orden_compra/valorPendiente") ?>', {val: val, id:id } , function (response) {
    $("#consulta_valor").val(response);           
    });
                      
        
        });

    });
</script>
          <script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_tipo_pago").on('change', function () {
            var val= $("#consulta_tipo_pago").val();
            var id =<?php echo $orden->getId(); ?>;
            
              $.get('<?php echo url_for("orden_gasto/valorDocumento") ?>', {val: val, id:id } , function (response) {
    $("#consulta_no_documento").val(response);           
    });
                      
        
        });

    });
</script>
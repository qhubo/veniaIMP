<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-signs  kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Caja
                <small>  &nbsp;&nbsp;&nbsp;&nbsp; Procede a ingresar el pago</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
<!--            <a href="<?php echo url_for('orden_cotizacion/index') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> NUEVO VENTA</a>-->

            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="row">


            <div class="col-lg-6" >
                <div class="row" style="padding-top:3PX; padding-bottom:3PX; ;">
                    <div class="col-lg-2"><strong> <font size="+1">Código</font></strong></div>
                    <div class="col-lg-4"><font size="+1"><?php echo $operacion->getCodigo(); ?></font></div>
                    <div class="col-lg-2"><strong><font size="+1">Nit</font></strong></div>
                    <div class="col-lg-4"><font size="+1"><?php echo $operacion->getNit(); ?></font></div>
                </div>

                <div class="row">
                    <div class="col-lg-2"><br></div>
                </div>

                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link  active  " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link   " data-toggle="tab" href="#kt_portlet_base_demo_3_4_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Pagos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link   " data-toggle="tab" href="#kt_portlet_base_demo_3_5_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Contable
                        </a>
                    </li>
                </ul>

                <div class="tab-content"    >
                    <div class="tab-pane  active  " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                        <div class="row">
                        <div class="col-lg-12">
                      
                            <div style="display:block; color:#blue; font-size: 18px; text-align: center;">  <?php echo $operacion->getObservaciones(); ?></div>
                        </div>
                        
                        </div>
                            <?php include_partial('reporte_venta/detalle', array('operacion' => $operacion, 'detalle' => $detalle, 'pagos' => $pagos)) ?>  
                     <?php if ($operacion->getClienteId()) { ?>
                             <?php if (!$operacion->getPagado()) { ?>
                        <div class="row">
                     <div class="col-lg-8"></div> 
                     <div class="col-lg-4">
                         <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-sm btn-secondary btn-dark" > <i class="flaticon-bell"></i>Cuenta por cobrar</a>
                     </div>
                 </div>
                     <?php } ?>
                     <?php } ?>

                    </div>
                    <div class="tab-pane    " id="kt_portlet_base_demo_3_4_tab_content" role="tabpanel">
                        <?php include_partial('reporte_venta/detallePago', array('operacion' => $operacion, 'detalle' => $detalle, 'pagos' => $pagos)) ?>  

                    </div>
                    <div class="tab-pane  " id="kt_portlet_base_demo_3_5_tab_content" role="tabpanel">

                        <div class="row">
                            <div class="col-lg-6"><br><br><br><br></div> 
                        </div>
                        <?php $partidas[] = 0; ?>
                        <?Php foreach ($pagos as $pago) { ?>
                        <?php if ($pago->getPartidaNo()) { ?>
                            <div class="row">
                                <?php  include_partial('proceso/partida', array('id' => $pago->getPartidaNo())) ?>  
                            </div>
                            <?php $partidas[] = $pago->getPartidaNo(); ?>
                        <?php } ?>
                        <?php } ?>

                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="row" style="padding-top:3PX;  padding-bottom:3PX;  ">
                    <div class="col-lg-2"><strong> <font size="+1">Cliente</font></strong></div>
                    <div class="col-lg-6"><font size="+1"><?php echo $operacion->getNombre(); ?></font></div>
                </div>
                <?php include_partial($modulo . '/pago', array('operacion' => $operacion, 'form' => $form)) ?>  

                <div class="row">
                    <div class="col-lg-12">
                        <?php $numero = ''; ?>
                        <?php if ($operacion->getFaceEstado() <> "") { ?>
                            <?php $numero = $operacion->getFaceFirma() ?>
                            <?php if ($operacion->getFaceEstado() == "CONTINGENCIA") { ?>
                                <?php $numero = "CONTINGENCIA"; ?>
                            <?php } ?>

                            <?php if ($operacion->getFaceError() <> "") { ?>
                        
                        
                                               <?php if ($operacion->getFaceEstado() == "ERROR NIT") { ?>
                      <div class="row" style="background-color:#F9FBFE; padding-bottom: 5px; ">
    <div class="col-lg-1"><div style="text-align:right">Nit</div> </div>
    <div class="col-lg-3 ">
        <input class="form-control" value="<?php echo $operacion->getNit(); ?>" placeholder="Nit" name="consulta[nit]" id="consulta_nit">
     </div>
    <div class="col-lg-2"><div style="text-align:right">Nombre</div> </div>
   <div class="col-lg-6 ">
        <input class="form-control"  value="<?php echo $operacion->getNombre(); ?>"  placeholder="Nombre" name="consulta[nombre]" id="consulta_nombre" >

   </div>
                      </div>      
                        
                        <?php  } ?>
                        
                                <div class="row">  
                                    <div class="col-lg-9">
                                        <span style="font-size:14px;  font-weight: bold">
                                            Ocurrio un error en la facturación fel intentalo de nuevo  
                                        </span>
                                        <span style="font-size:11px;">
                                            <?php echo $operacion->getFaceError() ?>
                                        </span>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="<?php echo url_for('lista_cobro/reenviar?id=' . $operacion->getId()) ?>" class="btn btn-secondary btn-dark btn-sm" > <i class="flaticon-refresh"></i> Reenviar Fel</a>
                                    </div>
                                </div>
              
                        
           
                        
                        
                        
                            <?php } else { ?>
                                <span style="font-size: 12px; font-weight: bold; " >Descarga la Factura Aqui </span>





                                <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $operacion->getCodigo()) ?>" class="btn btn-block btn-xs btn-warning " target = "_blank">

                                    <li class="fa fa-print"></li>     <font size='-2'>FACTURA <?php echo $numero ?> </font> 
                                </a>

                            <?php } ?>

                        <?php } ?>

 
                    </div>

                </div>
<?php if ($ulPago) { ?>
                <div class="row" style="padding-top: 5px;">
     <div class="col-lg-4">
  <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $ulPago->getId()) ?>" class="btn btn-block  btn-sm btn-dark " target = "_blank">
   Recibo <?php echo $ulPago->getCodigo(); ?>
   </a>
     </div>
 </div>
<?php } ?>

            </div>
        </div>

    </div>

</div>



<div id="staticCONFIRMA" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso Cuentas por Cobrar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <p> Confirma Enviar a Cuentas por Cobrar
                                    <strong><?php echo $operacion->getNombre(); ?></strong>
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $operacion->getCodigo() ?>
                                    </span> ?
                                </p>
                            </div>

                            <div class="modal-footer">
<!--                              <a class="btn  btn-warning " href="<?php echo url_for($modulo . '/confirmarCuenta?id='.$operacion->getId()."&fel=NO") ?>" >
                                    <i class="flaticon2-lock "></i> Confirmar sin FEL </a> 
                                -->
                                <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmarCuenta?id='.$operacion->getId()."&fel=SI") ?>" >
                                    <i class="flaticon2-lock "></i> Confirmar </a> 
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                            </div>

                        </div>
                    </div>
                </div>

<?php $partidaPen = PartidaQuery::create()->filterById($partidas, Criteria::IN)->filterByConfirmada(false)->orderById('Asc')->findOne(); ?>
<?php if ($partidaQ) { ?>
<?php $partidaPen = $partidaQ; ?>
<?php } ?>
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




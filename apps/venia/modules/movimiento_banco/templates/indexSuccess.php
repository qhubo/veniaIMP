<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php 

   $operacionesp = MovimientoBancoQuery::create()
                ->orderById("Desc")
                ->filterByTipo('Transferencia')
                ->setLimit(50)
                 ->find();
        $partidas[]=0;   
         foreach ($operacionesp as $regi){
        $partidas[]=$regi->getPartidaNo();
             
         }
         ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Tranferencia Bancos
                <small>&nbsp;&nbsp;&nbsp; Ingresa una nueva transferencia  y/o visualiza por un rango de fechas  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
       
        </div>
    </div>
    <div class="kt-portlet__body">
        
             <div class="row">
            <div class="col-lg-4"><h3>Bancos</h3> 
                <div class="row">
                    <div class="col-lg-11">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>Banco</td>
                            <td>Nombre</td>
                            <td>Saldo </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bancos as $registr) { ?>
                        <tr>
                            <td><?php echo $registr->getCodigo() ?></td>
                            <td><?php echo $registr->getNombre(); ?></td>
                            <td style="text-align: right"><?php echo Parametro::formato($registr->getSaldo())  // echo $registr ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                    </div>
                </div>



            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4"><h3>Transferencias</h3></div>
                    <div class="col-lg-2">     <a href="<?php echo url_for($modulo . '/nueva') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a></div>
                
                                                <div class="col-lg-2">
                     <a target="_blank" href="<?php echo url_for( $modulo.'/reporte')  ?>" class="btn  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
          </div>
                </div>
                <div class="row">
                    <div class="col-lg-12"><br></div>
                </div>
                
                <?php  include_partial($modulo . '/historico', array('form' => $form, 'modulo' => $modulo, 'operaciones'=>$operaciones )) ?> 
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

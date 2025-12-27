<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')     ?>
<?php //$areglo= unserialize($areglo);         ?> 
<?php //$areglo = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'producto'));         ?>
<?php //echo  "<pre>";   print_r($areglo); die();          ?>
<?php $ocultavd = false; ?> 

<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php $numberToLetterConverter = new NumberToLetterConverter(); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-printer kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Impresión de Cheque  <small> Ya puedes imprimir el cheque</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $valor = $cheque->getValor(); ?>
        <?php $valor = Parametro::formato($valor); ?>
        <?Php $valor = str_replace(",", "", $valor); ?>        
        <?php $totalImprime = str_replace(".", ",", $valor); ?>

        <div class="row">
            <div class="col-lg-7">
                <div class="table-scrollable">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4"><?php echo $cheque->getBanco(); ?> </div>
                        <div class="col-lg-2"><strong> Cheque No</strong> </div>
                        <div class="col-lg-2"><?php echo $cheque->getNumero(); ?></div>                        
                    </div>
                    <?php if ($devolucion) { ?>
                        <table class="table table-bordered  dataTable table-condensed flip-content" >
                            <thead >
                                <tr class="active">

                                    <th  align="center"> <font >Nombre</font>  </th>
                                    <th  width="75px" align="center"> <font >Monto</font>  </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><?php echo $devolucion->getNombre(); ?></td><!-- comment -->
                                    <td><div style="text-align: right"> <?php echo Parametro::formato($devolucion->getValor() - $devolucion->getValorOtros(), 2); ?></div> </td>

                                </tr>

                            </tbody>
                        </table>
                    <?php } ?>
     <?php if ($solcheque) { ?>
                        <table class="table table-bordered  dataTable table-condensed flip-content" >
                            <thead >
                                <tr class="active">

                                    <th  align="center"> <font >Nombre</font>  </th>
                                    <th  width="75px" align="center"> <font >Monto</font>  </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><?php echo $solcheque->getNombre(); ?></td><!-- comment -->
                                    <td><div style="text-align: right"> <?php echo Parametro::formato($solcheque->getValor(), 2); ?></div> </td>

                                </tr>

                            </tbody>
                        </table>
                    <?php } ?>
                    <?php if ((!$devolucion) && (!$solcheque)) { ?>
                        <table class="table table-bordered  dataTable table-condensed flip-content" >
                            <thead >
                                <tr class="active">

                                    <th  align="center"> <font >Proveedor</font>  </th>
                                    <th  align="center"> <font >Nombre</font>  </th>
                                    <th  width="75px" align="center"> <font >Monto</font>  </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gastos as $registro) { ?>
                                    <?php $lista = $registro; ?>
                                    <tr>
                                        <td><?php echo $registro->getProveedor()->getCodigo(); ?></td><!-- comment -->
                                        <td><?php echo $registro->getProveedor()->getNombre(); ?></td>
                                        <td><div style="text-align: right"> <?php echo Parametro::formato($registro->getValorTotal(), 2); ?></div> </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>


                </div>
            </div>
            <div class="col-lg-5" style=" padding-top: 10px; border: ridge;border-radius: 0.5px;">

                <div class="row">
                    <div class="col-lg-6"><strong><?php echo $cheque->getBanco(); ?> </strong> </div>
                    <div class="col-lg-2" ><?php echo $cheque->getFechaCheque('d/m/Y'); ?></div>
                    <div class="col-lg-4"  style="text-align:right" ><strong>  <?php echo Parametro::formato($cheque->getValor()); ?> </strong></div>
                </div>

                <div class="row">
                    <div class="col-lg-2"><br></div>
                </div>                
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5"><strong><?php echo $cheque->getBeneficiario(); ?></strong></div>
                </div>

                <div class="row">
                    <div class="col-lg-2"><br></div>
                </div>                
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-10"><strong><?php //echo $numberToLetterConverter->to_word($totalImprime, $miMoneda = null);  ?></strong></div>
                </div>


                <div class="row">
                    <div class="col-lg-8"><br></div>

                    <div class="col-lg-4">
                        <a target="_blank" href="<?php echo url_for('reporte/cheque?id=' . $cheque->getId()) ?>" class="btn  btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
                    </div>
                </div>  

            </div>

        </div>
        <div class="row">
            <div class="col-lg-8"><br></div>
        </div>        
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <?php $urlFrame = "http://" . $_SERVER['SERVER_NAME']; ?>
                <?php if ($_SERVER['SERVER_NAME'] == "venia") { ?>
                    <?php $urlFrame = "http://" . $_SERVER['SERVER_NAME'] . ':8080'; ?>
                <?php } ?>
                <?php $urlReporte = $urlFrame . "/index.php/reporte/cheque?id=" . $cheque->getId(); ?>

                <embed src="<?php echo $urlReporte ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="600px" />         



            </div>

        </div>

    </div>
</div>




<?php if ($partidaPen) { ?>


    <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include_partial('proceso/partidaModifica', array('partidaPen' => $partidaPen)) ?>  
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


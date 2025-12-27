
<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-more-v4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Cuentas Por Cobrar
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
        <form action="<?php echo url_for($modulo . '/index') ?>" method="get">
            <div class="row"  style="padding-bottom:10px;">
                <div class="col-lg-2"></div>
                <div class="col-lg-5">
                    <select  onchange="this.form.submit()" class="form-control mi-selector"  name="prover" id="prover">
                        <option value="0">[    Todos    ]</option>
                        <?php foreach ($seleccion as $key => $value) { ?>
                            <option <?php if ($prover == $key) { ?> selected="selected"  <?php } ?>  value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <a target="_blank" href="<?php echo url_for($modulo . '/reporte?prover=' . $prover) ?>" class="btn  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
                </div>

            </div>
        </form>

        <div class="row">
            <div class="col-lg-7"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-2">
                <?php if (!$prover) { ?>
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if ($prover) { ?>
            <table class="table table-striped- table-bordered table-hover table-checkable XXdataTable no-footer dtr-inlin XXkt-datatable" id="html_table" width="100%">
            <?php } ?>
            <?php if (!$prover) { ?>
                <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
                <?php } ?>
                <thead class="flip-content">
                    <tr class="active">
                        <th align="center" width="20px"> Código</th>
                        <th align="center" width="20px">Fecha / Usuario</th>

                        <th  align="center"> Cliente</th>
                        <th  align="center"> Nit</th>
                        <th  align="center"> Observaciones</th>    

                        <th  align="center"> Valor</th>    
                        <th  align="center"> Cheque Prefechado</th>     
                        <th  align="center"> Valor Pagado</th>     
                        <th  align="center"> Saldo</th>     
                        <th  align="center"> Pagar</th>  
                        <th  align="center"> Estado </th>
                        <th  align="center"> #</th>    

                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($operaciones as $lista) { ?>
                        <?php $total = $lista->getValorTotal() + $total; ?>
                        <?php $detalleProducto = OperacionDetalleQuery::create()->filterByOperacionId($lista->getId())->count(); ?>    
                        <tr>     
                            <td>
                                <?php if ($lista->getCodigo()) { ?>


                                    <a class="btn btn-sm  btn-warning btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">

                                        <font size="-2"> <?php echo $lista->getCodigo() ?>   </font>
                                    </a>
                                <?php } else { ?>

                                    <a class="btn  btn-small  btn-info btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                        <?php echo $lista->getCodigoFactura() ?>  
                                    </a>   
                                    <font size="-2"> <?php echo $lista->getCodigoFactura() ?>  </font>
                                <?php } ?>

                                <font size="-2"> <?php echo substr($lista->getTienda(), 0, 5) ?> </font>  


                            </td>
                            <td><font size="-2"><?php echo $lista->getFecha('d/m/Y H:i') ?></font>  
                                <br><font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                            <td>
                            <td> <strong><?php  if ($lista->getClienteId()) {  echo  $lista->getCliente()->getCodigoCli(); } ?></strong>  <br>
                                
                                <?php if ($lista->getCliente()->getNombre() <> $lista->getNombre()) { ?>
                                    <?php echo $lista->getCliente()->getNombre() . "   " . $lista->getNombre(); ?>
                                <?php } else { ?>
                                    <?php echo $lista->getCliente()->getNombre(); ?>
                                <?php } ?>
                            </td>
                            <td>  <font size="-1"><?php echo $lista->getNit() ?></font>  </td>
                            <td>  <font size="-1"><?php echo $lista->getObservaciones() ?></font>  </td>


                            <td>  <font size="-1"><?php echo number_format($lista->getValorTotal(), 2) ?>  </font>  </td>
                            <td>  <font size="-1"><?php echo number_format($lista->getValorPrefechado(), 2) ?>  </font>  </td>
                            <td>  <font size="-1"><?php echo number_format($lista->getValorPagado(), 2) ?>  </font>  </td>
                            <td style="text-align:right">  <font size="-1"><?php echo number_format($lista->getValorTotal() - $lista->getValorPagado(), 2) ?>  </font>  </td>

                            <td >
                                <a class="btn btn-sm btn-block btn-success btn-outline  "  href="<?php echo url_for($modulo . '/caja?id=' . $lista->getId()) ?>"  >
                                    <i class="fa flaticon-signs"></i> Pago </a>    
                            </td>
                            <td>  <font size="-1"><?php echo $lista->getEstatus() ?>  </font>  </td>
                            <td><?php echo $lista->getId(); ?></td>

                        </tr>



                    <?php } ?>
                </tbody>
                <?php if ($prover) { ?>
                    <tfoot>
                    <td></td>
                    <td colspan="4" style="text-align: right"> <strong>Totales</strong></td>
                    <td></td>
                    <td  style="text-align: right"><font size='-1'> <?php echo Parametro::formato($total); ?></font></td>
                    <td></td>
                    <td style="text-align: right" colspan="1">
                        <font size='+1'> <?php echo Parametro::formato($totalSuma); ?></font></td>

            <!--                    <input class="form-control" value="<?php echo Parametro::formato($totalSuma, false); ?>" style="background-color:#F9FBFE ;" readonly="true" name="totalselec" id="totalselec">-->
                    <!--                    <div style="padding-top:3px; padding-bottom:3px;">
                                            
                                            <a href="<?php echo url_for("proceso/confirma?tipo=cuentapagar&token=" . $prover) ?>" class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#ajaxmodalCONFIRMA"> <li class="fa flaticon2-checkmark"></li>&nbsp;&nbsp;Pagos Seleccionados    </a>
                    
                                        </div>-->
                    </td>
                    </tfoot>
                <?php } ?>

            </table>

    </div>
</div>
</div>
</div>




<?php foreach ($operaciones as $reg) { ?>
    <?php $lista = $reg; ?>
    <div class="modal fade" id="ajaxmodal<?php echo $reg->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 750px">
            <div class="modal-content" style=" width: 750px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Detalle de Operación</h4>
                </div>
            </div>
        </div>
    </div>



<?php } ?>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<?php if ($operacionPago) { ?>
    <div id="ajaxmodalP" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Recibo <?php echo $operacionPago->getCodigo(); ?>   </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-9" style="font-weight:bold;  font-size: 15px;"> Impresion de Recibo</div>
                        <div class="col-lg-3">
                            <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $operacionPago->getId()) ?>" class="btn btn-block  btn-sm btn-dark " target = "_blank">
                                <i class="flaticon2-printer"></i>  Recibo <?php echo $operacionPago->getCodigo(); ?>
                            </a>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <script>
                        $(document).ready(function () {
                            $("#ajaxmodalP").modal();
                        });
    </script>
<?php } ?>



<?php
$partidaPen = PartidaQuery::create()
        ->filterByConfirmada(false)
        ->filterByTipo('PagoVentaCobrar')
        ->findOne();
?>
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




<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>

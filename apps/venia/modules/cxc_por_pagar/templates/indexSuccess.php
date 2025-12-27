<?php $modulo = $sf_params->get('module'); ?>

<script src='/assets/global/plugins/select2.min.js'></script>
<script src='/assets/global/plugins/jquery.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-hourglass-1 text-dark"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                CUENTA POR PAGAR <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Listado de pagos pendientes
                </small>
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
                <thead >
                    <tr class="active">
                        <th  align="center"><span class="kt-font-success">Código </span></th>
                        <th  align="center"><span class="kt-font-success"> Proveedor</span></th>
                        <th  align="center"><span class="kt-font-success"> Fecha</span></th>
                        <th  align="center"><span class="kt-font-success"> Crédito</span></th>
                        <th  align="center"><span class="kt-font-success"> Detalle</span></th>
                        <th  align="center"><span class="kt-font-success">Sub Total </span></th>
                        <th  align="center"><span class="kt-font-success"> Valor ISR </span></th>
                        <th  align="center"><span class="kt-font-success"> Valor Total </span></th>
                        <th  align="center"><span class="kt-font-success"> Valor Pagado</span></th>
                        <th  align="center"><span class="kt-font-success">Saldo </span></th>
                        <th  align="center"><span class="kt-font-success"> Acción </span></th>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?PHp $total = 0; ?>
                    <?php foreach ($registros as $deta) { ?>
                        <?php $total = $total + ($deta->getValorTotal() - $deta->getValorPagado()); ?>
                        <?php $estiloUno = ''; ?>
                        <?php $estiloDos = 'style="display:none;"'; ?>
                        <?php if ($deta->getSeleccionado()) { ?>
                            <?php $estiloDos = ''; ?>
                            <?php $estiloUno = 'style="display:none;"'; ?>
                        <?php } ?>
<?php //if ($deta->getOrdenProveedorId()) { ?>
                        <tr>
                            <td><?php echo $deta->getCodigo(); ?></td>
                            <td><?php echo $deta->getProveedor()->getNombre(); ?></td>
                            <td><?php echo $deta->getFecha('d/m/Y'); ?></td>
                            <td style="text-align: right"><?php echo $deta->getDias(); ?> Días</td>
                            <td><?php echo $deta->getDetalle(); ?></td>
                            <td style="text-align: right" ><?php echo Parametro::formato($deta->getValorSubTotal()); ?></td>
                            <td style="text-align: right" > <?php echo Parametro::formato($deta->getValorImpuesto()); ?></td>
                            <td style="text-align: right" ><?php echo Parametro::formato($deta->getValorTotal()); ?></td>                      
                            <td  style="text-align: right"><?php echo Parametro::formato($deta->getValorPagado()); ?></td>
                            <td  style="text-align: right">

                                <?php echo Parametro::formato($deta->getValorTotal() - $deta->getValorPagado()); ?>

                            </td>
                            <td style="text-align:center">     
                                <?php if ($deta->getOrdenProveedorId()) { ?>

                                    <a href="<?php echo url_for('orden_compra/muestraPaga?token=' . $deta->getOrdenProveedor()->getToken()) ?>" class="btn btn-sm btn-success btn-secondary" >  <i class="  flaticon2-correct"></i>Pagar</a>
                                <?php } ?>
                                <?php if ($deta->getGastoId()) { ?>

                                    <a href="<?php echo url_for('orden_gasto/muestraPaga?token=' . $deta->getGasto()->getToken()) ?>" class="btn btn-sm btn-success btn-secondary" >  <i class="  flaticon2-correct"></i>Pagar</a>
                                <?php } ?>

                            </td>


                            <td>
                                
                                       <?php if ( $deta->getGastoId() or ($deta->getOrdenProveedorId()) ) { ?>
                                <?php if ($prover) { ?>
                                    <div class="row">
                                        <div  id="btlista<?php echo $deta->getId(); ?>"  <?php echo $estiloUno ?> >
                                            <a id="activar<?php echo $deta->getId(); ?>" dat="<?php echo "0_" ?>" class="btn btn-outline  btn-xs grey "><img width="15px" src="/images/UnCheck.png"> </a>     
                                        </div> 
                                        <div  id="bNtactiva<?php echo $deta->getId(); ?>" <?php echo $estiloDos ?>>
                                            <a id="Nactivar<?php echo $deta->getId(); ?>" dat="<?php echo "0_" ?>" class="btn btn-outline btn-xs grey "><img width="15px" src="/images/Check.png"></a> 
                                        </div>
                                    </div>
                                <?php } ?>
                                   <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php  // } ?>

                </tbody>
                <?php if ($prover) { ?>
                <tfoot>
                <td></td>
                <td colspan="7" style="text-align: right"> <strong>Totales</strong></td>
                <td></td>
                <td  style="text-align: right"><font size='+2'> <?php echo Parametro::formato($total); ?></font></td>
                <td colspan="2">
                    <input class="form-control" value="<?php echo Parametro::formato($totalSuma, false); ?>" style="background-color:#F9FBFE ;" readonly="true" name="totalselec" id="totalselec">
                    <div style="padding-top:3px; padding-bottom:3px;">
                        
                        <a href="<?php echo url_for("proceso/confirma?tipo=cuentapagar&token=" . $prover) ?>" class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#ajaxmodalCONFIRMA"> <li class="fa flaticon2-checkmark"></li>&nbsp;&nbsp;Pagos Seleccionados    </a>

                    </div>
                    </td>
                </tfoot>
                <?php }  ?>
            </table>

    </div>
</div>




<?php foreach ($registros as $data) { ?>
    <?php $i = $data->getId(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#activar<?php echo $i ?>').click(function () {
                var id = <?php echo $i; ?>;
                var prove =<?php echo $prover; ?>;
                $.get('<?php echo url_for("cxc_por_pagar/activa") ?>', {id: id, prove: prove}, function (response) {
                    $('#totalselec').val(response);
                });
                $('#activar0').hide();
                $('#bNtactiva<?php echo $i ?>').slideToggle(250);
                $('#btactiva<?php echo $i ?>').hide();
                $('#bNtlista<?php echo $i ?>').slideToggle(250);
                $('#btlista<?php echo $i ?>').hide();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#Nactivar<?php echo $i ?>').click(function () {
                var id = <?php echo $i; ?>;
                var prove =<?php echo $prover; ?>;
                $.get('<?php echo url_for("cxc_por_pagar/desactiva") ?>', {id: id, prove: prove}, function (response) {
                    $('#totalselec').val(response);
                });


                $('#activar0').slideToggle(250);
                $('#btactiva<?php echo $i ?>').slideToggle(250);
                $('#bNtactiva<?php echo $i ?>').hide();
                $('#btlista<?php echo $i ?>').slideToggle(250);
                $('#bNtlista<?php echo $i ?>').hide();
            });
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



    <div class="modal fade"  id="ajaxmodalCONFIRMA" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Proceso Confirmación  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
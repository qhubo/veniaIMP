<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<?php        ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Proceso de Ventas Diarias
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for('reporte_venta/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>

        <div class="row"  style="padding-bottom:10px;">


            <label class="col-lg-1 control-label right "> Inicio </label>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-2">
                <?php echo $form['bodega'] ?> 
            </div>

            <div class="col-lg-2">
                <?php echo $form['estatus_op'] ?> 
            </div>

            <div class="col-lg-2">
                <button class="btn green btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
            </div>
            <div class="col-lg-1">
                <a target="_blank" href="<?php echo url_for('reporte_venta/reporteExcel') ?>" class="btn  btn-sm btn-warning" > <i class="flaticon2-printer"></i>Reporte </a>
            </div>
        </div>



        <?php echo '</form>'; ?>


        <div class="row">
            <div class="col-lg-6"> </div>
            <div class="col-lg-4" >  <span style="font-weight:bold; font-size: 16px;"> &nbsp;&nbsp;&nbsp;&nbsp;<?php   //echo Parametro::formato($total,false) ?></span> </div>
            <div class="col-lg-2">				
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>

        <table class="kt-datatable  table table-bordered  dataTable table-condensed flip-content" id="html_table" width="100%" >
            <thead class="flip-content">
                <tr class="active">
                    <th align="center" width="20px"> Código</th>
                    <th align="center" width="20px">Creación</th>
                    <th width="25px">Cliente</th>
                    <th  align="center"> Factura</th>
                    <th  align="center"> Estado</th>
                    <th  align="center"> Valor</th>    
<!--                                <th width="50px" >Ticket</th>-->
                    <th width="25px">Fel</th>
                    <th  align="center"> Observaciones</th>   
                    <th  align="center"> Recibo</th>   
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($operaciones as $lista) { ?>
                    <?php $total = $lista->getValorTotal() + $total; ?>
                    <?php $val = explode('-', $lista->getFaceFirma()) ?>
                    <?php $numero ='FACTURA'; // $val[0]; ?>
                    <?php $reenviar = false; ?>
                    <?php if ($lista->getFaceEstado() <> "") { ?>
                        <?php if ($lista->getFaceEstado() == "CONTIGENCIA") { ?>
                            <?php //$reenviar = true; ?>
                        <?php } ?>
                        <?php if ($lista->getFaceError() <> "") { ?>
                            <?php //$reenviar = true; ?>
                        <?php } ?>
                        <?php if ($numero == "") { ?>
                            <?php if (strtoupper(TRIM($lista->getEstatus())) != "ANULADO") { ?> 
                                <?php //$reenviar = true; ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>    
                    <?php if ($lista->getFaceEstado() == "") { ?>
                        <?php if (strtoupper(TRIM($lista->getEstatus())) != "ANULADO") { ?> 
                            <?php //$reenviar = true; ?>
                        <?php } ?>
                    <?php } ?>  

                    <tr>     
                        <td>
                            <a class="btn  btn-small btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                <?php echo $lista->getCodigo() ?>  
                            </a>
                            <?php echo substr($lista->getTienda(), 0, 5) ?>  
                        </td>
                        <td><?php echo $lista->getFecha('d/m/Y ') ?><br> <?php echo $lista->getUsuario() ?>  </td>
                        <td> <?php
                            if ($lista->getClienteId()) {
                                echo $lista->getCliente()->getCodigoCli();
                            }
                            ?>  </td>
                        <td><?php echo $lista->getNit() ?> <br> <?php echo $lista->getNombre() ?></td>

                        <td>  <?php echo $lista->getEstatus() ?> 
                            <?php if (!$lista->getAnulado()) { ?>
                                <a class="btn  btn-danger btn-sm btn-block  " style="padding-top: 1px !important; height:15px !important; font-size: 10px !important;"   href="<?php echo url_for('reporte_venta/anula?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodalC<?php echo $lista->getId() ?>">
                                    Anular
                                </a>
                            <?php } ?>
                            <?php if ($lista->getAnulado()) { ?>
                                <?php echo $lista->getObservaciones() ?>  <br> 
                                <strong> <?php echo $lista->getAnuloUsuario() ?>  </strong> <br>
                                <?php echo $lista->getFechaAnulo('d/m/Y H:i:s') ?>   <br>
                            <?php } ?>


                                
                          <?php  if ($TIPO_USUARIO=='ADMINISTRADORRRRRRR') { ?>
                                <a class="btn btn-sm  btn-block"   href="#" data-toggle="modal" data-target="#ajaxmo<?php echo $lista->getId() ?>">
                                      <?php if ($lista->getVendedorId()) { ?>
                                    <?php echo $lista->getVendedor()->getNombre(); ?>
                                     <?php } else {  ?> 
                                    .....
                                     <?php } ?>
                                </a>                        
                          <?php } else { ?>
                              <?php if ($lista->getVendedorId()) { ?>
                                    <?php echo $lista->getVendedor()->getNombre(); ?>
                                     <?php } ?> 
                          <?php } ?>
                        </td>


                        <td style="text-align:right">  <?php echo Parametro::formato($lista->getValorTotal()) ?>    </td>

                        <td>
                            <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $lista->getCodigo()) ?>" class="btn btn-block btn-sm btn-info " target = "_blank">
                                <?php if ($lista->getFaceEstado() == "FIRMADONOTA") { ?> <?php echo "NOTA "; ?> <?php } ?>   <?php echo $numero; ?>
                            </a>  
                            <?php if ($reenviar) { ?>
                                <a href="<?php echo url_for('reporte_venta/reenviar?id=' . $lista->getId()) ?>" class="btn btn-secondary btn-block  btn-dark btn-sm" > <i class="flaticon-refresh"></i>Reenviar</a>
                            <?php } ?>

                            <?php echo $lista->getFaceError(); ?>
                            <?php if ($lista->getFaceEstado() == "") { ?>
                                <?php if (strtoupper(TRIM($lista->getEstatus())) == "ANULADO") { ?> 
                                    <strong>ANULADO</strong>              
                                <?Php } ?>
                            <?php } ?>

                        </td>


                        <td>

                            <div id="resultado<?php echo $lista->getId() ?>" class="resultado<?php echo $lista->getId() ?>"><?Php echo $lista->getObservaciones(); ?></div>
                            <a class="btn btn-sm  btn-block  "   href="#"  data-toggle="modal" data-target="#ajaxmodalCE<?php echo $lista->getId() ?>">
                                ..    </a>                         


                        </td>
                        <td>  <?php if ($lista->getRecibo()) { ?> 
                                <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $lista->getRecibo()) ?>" class="btn btn-block btn-xs  " target = "_blank">
                                    <?php echo $lista->getRecibo(); ?>
                                </a>
                            <?php } ?>

                        </td>
                    </tr>



                <?php } ?>
            </tbody>

        </table>






    </div>
</div>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


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

    <div class="modal fade" id="ajaxmodalC<?php echo $lista->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Anular Operación  </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-6 kt-font-info">Confirma Anular Operación</div>
                        <div class="col-lg-2"><h3><?php echo $lista->getCodigoFactura(); ?></h3> </div>
                    </div>
                </div> 
                <?php $token = md5($lista->getCodigoFactura()); ?>
                <div class="modal-footer">
                    <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/anula?token=' . $token . '&id=' . $lista->getId()) ?>" >
                        <i class="fa fa-trash-o "></i> Confirmar</a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<form action="<?php echo url_for('reporte_venta/corrigeVendedor') ?>" method="get">

    <div class="modal fade" id="ajaxmo<?php echo $lista->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Vendedor  </h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="opera" name="opera" value="<?php echo $lista->getId(); ?>">
                    <div class="row">
                        <div class="col-lg-12 ">
                            <table style="width:100%">
                                <tr>
                                    <th>Documento</th>
                                    <td> <?php echo $lista->getCodigo() ?></td>
                                </tr>
                                <tr>
                                    <th>Vendedor Actual</th>
                                    <td>
                                        <?php if ($lista->getVendedorId()) { ?>
                                            <?php echo $lista->getVendedor()->getNombre(); ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cambiar de Vendedor</th>
                                    <td> 
                                        <select  class="form-control" name="vendedor" id="vendedor">

                                            <option  selected="selected"   >Seleccione</option>
                                            <?php foreach ($vendedores as $venta) { ?>
                                                <option <?php if ($venta->getId() == $lista->getVendedorId()) { ?> selected="selected" <?php } ?> value="<?php echo $venta->getId(); ?>" ><?php echo $venta->getNombre(); ?></option>

                                            <?php } ?>


                                        </select>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                <button class="btn btn-small btn-success" type="submit">
                    <i class="fa fa-check "></i> Actualizar
                  
                </button>
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <div class="modal fade" id="ajaxmodalCE<?php echo $lista->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Observaciones  </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 ">
                            <textarea name="observaciones<?php echo $lista->getId(); ?>"  id="observaciones<?php echo $lista->getId(); ?>"  class="form-control"><?php echo $lista->getObservaciones(); ?></textarea>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#observaciones<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#observaciones<?php echo $lista->getId(); ?>").val();
                //     alert (id);
                //      alert (val);
                $.get('<?php echo url_for("reporte_venta/comentario") ?>', {id: id, val: val}, function (response) {

                    $("#resultado<?php echo $lista->getId(); ?>").html(val);
                });
            });
        });
    </script>

<?php } ?>


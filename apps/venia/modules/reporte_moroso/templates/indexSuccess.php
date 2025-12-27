<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte Facturas Morosas
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">


        <form action="<?php echo url_for('reporte_moroso/index') ?>" method="GET">
            <div class="row" style="padding-bottom:5px;">
                <div class="col-lg-1"> </div>
                <div class="col-lg-1"> Seleccionar </div>
                <div class="col-lg-3">
                    <select  onchange="this.form.submit()" class="form-control" name="em" id="em">
                        <option value="9"  <?php if ($em == 9) { ?> selected="selected" <?php } ?> >Maximo 3  meses</option>
                        <option <?php if ($em == 6) { ?> selected="selected" <?php } ?> value="6" > Maximo 6 meses</option>
                        <option value="9"  <?php if ($em == 9) { ?> selected="selected" <?php } ?> >Maximo 9  meses</option>
                        <option value="9"  <?php if ($em == 12) { ?> selected="selected" <?php } ?> >Maximo 12  meses</option>
                    </select>
                </div>
            </div>
        </form>


        <div class="row">
            <div class="col-lg-10"></div>
            <div class="col-lg-2">				
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>
        
         <div class="row">
            <div class="col-md-12">

        <table class="kt-datatable  table table-bordered  dataTable table-condensed flip-content" id="html_table" width="100%" >
            <thead class="flip-content">
                <tr class="active">
                    <th align="center" > Código</th>
                    <th align="center" width="20px">Creación</th>
                    <th width="25px">Cliente</th>
                    <th  align="center"> Factura</th>
                    <th  align="center"> Estado</th>
                    <th  align="center"> Valor</th>  
                    <th  align="center"> Valor Pagado</th>  
                    <th width="25px">Fel</th>
                    <th  align="center"> Observaciones</th>   
                    <th  align="center"> Desbloquear</th>   
                    <th  align="center"> Recibo</th>   
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php $total2 = 0; ?>
                <?php foreach ($operaciones as $lista) { ?>
                    <?php $total = $lista->getValorTotal() + $total; ?>
                    <?php $total2 = $lista->getValorPagado() + $total2; ?>
                    <?php $val = explode('-', $lista->getFaceFirma()) ?>
                    <?php $numero = $val[0]; ?>
                    <tr>     
                        <td>
                            <a class="btn  btn-small btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                <?php echo $lista->getCodigo() ?>  
                            </a>
                            <?php echo substr($lista->getTienda(), 0, 5) ?>  
                        </td>
                        <td><?php echo $lista->getFecha('d/m/Y ') ?><br> <?php echo $lista->getUsuario() ?>  </td>
                        <td> 
                            <span style="display: block"> NIT <?php echo $lista->getCliente()->getNit(); ?></span>
                            
                            <?php
                            if ($lista->getClienteId()) {
                                echo $lista->getCliente()->getCodigoCli();
                            }
                            ?>  </td>
                        <td><?php echo $lista->getNit() ?> <br> <?php echo $lista->getNombre() ?></td>

                        <td>  <?php echo $lista->getEstatus() ?> 


                            <?php if ($lista->getVendedorId()) { ?>
                                <?php echo $lista->getVendedor()->getNombre(); ?>
                            <?php } ?>  </td>
                        </td>

                        <td style="text-align:right">  <?php echo Parametro::formato($lista->getValorTotal()) ?>    </td>
                        <td style="text-align:right">  <?php echo Parametro::formato($lista->getValorPagado()) ?>    </td>

                        <td>
                            <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $lista->getCodigo()) ?>" class="btn btn-block btn-small btn-info " target = "_blank">
                                <?php if ($lista->getFaceEstado() == "FIRMADONOTA") { ?> <?php echo "NOTA "; ?> <?php } ?>   <?php echo $numero; ?>
                            </a>  
                            <?php echo $lista->getFaceError(); ?>
                        </td>
                        <td>
                            <?Php echo $lista->getObservaciones(); ?>
                        </td>
                        <td>
                              <?php echo $lista->getObservaFacturar(); ?>
                            <?php if (!$lista->getPermiteFacturar()) { ?>
                                 <a class="btn btn-sm btn-warning  btn-block  "   href="#"  data-toggle="modal" data-target="#ajaxmodalCE<?php echo $lista->getId() ?>">
                                     Desbloquear </a>    
                            <?php } ?>
                            <?php if ($lista->getPermiteFacturar()) { ?>
                                 <a class="btn btn-sm btn-info  btn-block  "   href="#"  data-toggle="modal" data-target="#ajaxmodalCE<?php echo $lista->getId() ?>">
                                     <i class="flaticon-lock"> </i>BLOQUEAR </a>    
                            <?php } ?>           
                            
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
        
  
      <div class="row">
            <div class="col-md-8"></div>
       <div class="col-md-1" style="text-align:right">Totales</div>
       <div class="col-md-1" style="text-align:right"><?php echo Parametro::formato($total); ?> </div>
                   <div class="col-md-1" style="text-align:right"><?php echo Parametro::formato($total2); ?> </div>


            </div>





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
    <div class="modal fade" id="ajaxmodalCE<?php echo $reg->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Proceso  </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 "  style="font-weight: bold; font-size: 14px;">
                            Confirma para desbloquear factura de morosidad <?php echo $reg->getCodigo(); ?>
                        </div>

                    </div>
                </div> 

                <div class="modal-footer">
                           <a class="btn  btn btn-success " href="<?php echo url_for($modulo . '/desbloquear?id=' . $lista->getId()) ?>" >
                                    <i class="fa fa-check "></i> Confirmar</a> 

                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div>



<?php } ?>


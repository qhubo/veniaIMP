
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-more-v4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Listado Productos Para Entrega
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">




        <div class="portlet-body">
            <div class="table-scrollable">

                <table class="table table-bordered  dataTable table-condensed flip-content" >
                    <thead class="flip-content">
                        <tr class="active">
                            <th align="center" width="150px"> Código</th>
                            <th align="center" width="120px">Fecha</th>
                            <th align="center" width="20px">Usuario</th>
                            <th  align="center"> Nombre</th>
                            <th  align="center"> Nit</th>
                  
      
                            <th  align="center"> Valor</th>    
                                   
 <th width="120px" align="center"> Entregar</th>    
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($operaciones as $lista) { ?>
                            <?php $total = $lista->getValorTotal() + $total; ?>
                            <?php $detalleProducto = OperacionDetalleQuery::create()->filterByOperacionId($lista->getId())->count(); ?>    
                            <tr>     
                                <td>
                                    <?php if ($detalleProducto > 0) { ?>


                                        <a class="btn btn-sm btn-warning "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                            <?php echo $lista->getCodigo() ?>  
                                        </a>
                                    <?php } else { ?>

                                        <a class="btn btn-sm  btn-info "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                            <?php echo $lista->getCodigoFactura() ?>  
                                        </a>                                        
                                    <?php } ?>
                                    <br>
                                    <?php echo substr($lista->getTienda(),0,20) ?>  
                                </td>
                                <td><font size="-2"><?php echo $lista->getFecha('d/m/Y H:i') ?></font>  </td>
                                <td> <font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                                <td>  <font size="-1"><?php echo $lista->getNombre() ?></font>  </td>
                                <td>  <font size="-1"><?php echo $lista->getNit() ?></font>  </td>

                          
             
                                <td>  <font size="-1"><?php echo number_format($lista->getValorTotal(), 2) ?>  </font>  </td>
 
<td >
                    <a class="btn btn-sm btn-block  btn-success btn-outline  "  href="<?php echo url_for($modulo . '/entrega?id=' . $lista->getId()) ?>"  >
                        <i class="fa flaticon-signs"></i> Entregar </a>    
                </td>



                            </tr>



                        <?php } ?>
                    </tbody>

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

<?php } ?>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
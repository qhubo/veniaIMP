
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-more-v4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Ventas Pendientes de Pago
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
                            <th align="center" width="20px"> Código</th>
                            <th align="center" width="20px">Fecha</th>
                            <th align="center" width="20px">Usuario</th>
                            <th>Cliente</th>
                            <th  align="center"> Nombre</th>
                            <th  align="center"> Nit</th>
                            <th  align="center"> Observaciones</th>

                            <th  align="center"> Valor</th>    
                            <th  align="center"> Valor Pagado</th>                                    
                            <th  align="center"> Pagar</th>    
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


                                        <a class="btn btn-sm  btn-warning btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                            <?php echo $lista->getCodigo() ?>  
                                        </a>
                                    <?php } else { ?>

                                        <a class="btn  btn-small  btn-info btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                            <?php echo $lista->getCodigoFactura() ?>  
                                        </a>                                        
                                    <?php } ?>

                                    <font size="-2"> <?php echo substr($lista->getTienda(), 0, 5) ?> </font>  
                                </td>
                                <td><font size="-2"><?php echo $lista->getFecha('d/m/Y H:i') ?></font>  </td>
                                <td> <font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                              
                                                       <td> <font size="-1"><?php  if ($lista->getClienteId()) {  echo  $lista->getCliente()->getCodigoCli(); } ?></font>  </td>
                                <td>  <font size="-1"><?php echo $lista->getNombre() ?></font>  </td>
                                <td>  <font size="-1"><?php echo $lista->getNit() ?></font>  </td>

                                <td>  <font size="-1"><?php if ($lista->getCantidadTotalCaja()) {
                                    echo "<STRONG>CAJAS</STRONG> " . $lista->getCantidadTotalCaja() . "<br>";
                                } ?></font> 
                                    <font size="-1"><?php if ($lista->getPesoTotal()) {
                                    echo "<STRONG>PESO TOTAL </STRONG>" . $lista->getPesoTotal();
                                } ?></font> 
                                </td>


                                <td>  <font size="-1"><?php echo number_format($lista->getValorTotal(), 2) ?>  </font>  </td>
                                <td>  <font size="-1"><?php echo number_format($lista->getValorPagado(), 2) ?>  </font>  </td>

                                <td >
                                    <a class="btn btn-sm btn-block btn-success btn-outline  "  href="<?php echo url_for($modulo . '/caja?id=' . $lista->getId()) ?>"  >
                                        <i class="fa flaticon-signs"></i> Caja </a>    
                                </td>
                                <td>
                                    <div style="display: block">  <?php echo $lista->getObservaciones(); ?> </div>
    <?php if ($lista->getClienteId()) { ?>
                                    
                                        <a data-toggle="modal" href="#staticCONFIRMA<?php echo $lista->getId(); ?>" class="btn btn-sm btn-secondary btn-dark" > <i class="flaticon-bell"></i>Cuenta por cobrar</a>
    <?php } ?>
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


    <div id="staticCONFIRMA<?php echo $lista->getId(); ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso Cuentas por Cobrar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p> Confirma Enviar a Cuentas por Cobrar
                        <strong><?php echo $lista->getNombre(); ?></strong>
                        <span class="caption-subject font-green bold uppercase"> 
    <?php echo $lista->getCodigo() ?>
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                      <a class="btn  btn-warning " href="<?php echo url_for($modulo . '/confirmarCuenta?id='.$lista->getId()."&fel=NO") ?>" >
                                    <i class="flaticon2-lock "></i> Confirmar sin FEL </a> 
                    
                    <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmarCuenta?id=' . $lista->getId() . "&fel=SI") ?>" >
                        <i class="flaticon2-lock "></i> Confirmar </a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div>
<?php } ?>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<?php if ($operacion) { ?>
    <div id="ajaxmodalFactura" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                 <?php include_partial('soporte/avisos') ?>
                  <?php $val = explode('-', $operacion->getFaceFirma()) ?>
                                <?php $numero = $val[0]; ?>
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Factura <?php echo $operacion->getCodigo(); ?>   </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-lg-6" style="text-align:right; font-weight: bold;">
                            Factura
                        </div>
                        <div class="col-lg-2">
                              <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $operacion->getCodigo()) ?>" class="btn btn-block btn-xs btn-info " target = "_blank">
  <?php echo $numero; ?>
             </a>
                        </div>
                    </div>
                    
           
                         <?php if ($operacion->getFaceError() <> "") { ?>
                                                        <?php echo $operacion->getFaceError(); ?>
                                    <a href="<?php echo url_for('reporte_venta/reenviar?id=' . $operacion->getId()) ?>" class="btn btn-secondary btn-dark btn-sm" > <i class="flaticon-refresh"></i>Reenviar</a>
               
                         <?php  } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<?php $partidaPen = PartidaQuery::create()->filterByConfirmada(false)->filterById($id)->findOne(); ?>
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
    
<?php } ?>

<script>
        $(document).ready(function () {
            $("#ajaxmodalPartida").modal();
            $("#ajaxmodalFactura").modal();

        
        });
    </script>


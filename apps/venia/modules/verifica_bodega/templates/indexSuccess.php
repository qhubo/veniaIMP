<!--<meta http-equiv="refresh" content="30">-->
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Productos Solcitados en Bodega
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Ult. Actualización <?php echo date('d/m/Y H:i:s'); ?> 
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">

        <form action="<?php echo url_for($modulo . '/index?id=0') ?>" method="get">
            <div class="row" style="padding-top:2px;padding-bottom:5px;">
                <div class="col-lg-1"></div>
                <div class="col-lg-2">Seleccione pedido </div>
                <div class="col-lg-2">
                    <select  onchange="this.form.submit()" class="form-control" name="em" id="em">
                        <option  selected="selected"  value="99" >Todos los pedidos</option>
                        <?php foreach ($pedidos as $reg) { ?>
                            <option value="PE<?php echo $reg->getId(); ?>"  <?php if ($em == 'PE' . $reg->getId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo "PEDIDO" . $reg->getId(); ?>
                            </option>
                        <?php } ?>

                        <?php foreach ($cotizacio as $reg) { ?>
                            <option value="<?php echo $reg->getOrdenCotizacionId(); ?>"  <?php if ($em == $reg->getOrdenCotizacionId()) { ?> selected="selected" <?php } ?> >  
                                <?php echo $reg->getOrdenCotizacion()->getCodigo(); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <?php if ($muestraBoton) { ?>  
                    <div class="col-lg-5">
                    </div>
                    <div class="col-lg-2">
                        <?php if ($tipo==1) { ?>
                        <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token=' . $token) ?>" class="btn btn-sm btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
                        <?php } ?>
                        <?php if ($tipo==2) { ?>
                      
                 <a target="_blank" href="<?php echo url_for('producto_vendedor/reporte?id=' . $em) ?>" class="btn btn-sm btn-warning"  target = "_blank">
              <i class="flaticon2-print"></i>   Pedido     
                       </a>
  <?php } ?>

                    </div>
                <?php } ?>
            </div>     
        </form>
<?php $ruta ='ConfirmaPedi'; ?>
<?php if ($tipo==2) { ?>
<?php $ruta ='ConfirmaPediVendedor'; ?>        
<?php } ?>
        
        <form action="<?php echo url_for($modulo . '/'.$ruta.'?id=' . $em) ?>" method="post">
            <table  style="width: 100%" class=" <?php if (!$muestraBoton) { ?> table  <?php } ?> table-bordered " >
                <tr>
                    <th>Orden</th>
                    <th>Usuario</th>                    
                    <th>Codigo Producto</th>
                    <th>Producto </th>
                    <?php if ($muestraBoton) { ?>
                        <th>Cantidad Caja</th>
                        <th>Peso</th>
                    <?php } ?>
                    <th>Cantidad <br> Solicitada</th>
                    <?php if ($muestraBoton) { ?>
                        <th>Existencia</th>
                        <th></th>
                    <?php } ?>
                </tr>
                <?php if ($perdidoVendedor) { ?>
                    <?php foreach ($perdidoVendedor as $reg) { ?>
                        <tr style="background-color:#D7EBF5;">
                            <td><?php echo "PEDIDO" . $reg->getId(); ?></td>
                            <td><?php echo $reg->getVendedor()->getNombre(); ?></td>
                            <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                            <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                            <?php if ($muestraBoton) { ?>
                                <td>  </td>
                                <td> </td>
                            <?php } ?>
                            <td style="background-color:white !important; font-weight: bold; text-align: right; font-size:16px;">
                         
                                <?php echo $reg->getCantidad(); ?>
                        
                            </td>
                            <?php if ($muestraBoton) { ?>
                                <td></td>
                                <th>Despachar</th>
                            <?php } ?>
                        </tr>

                    <?php } ?>
                <?php } ?>


                <?php foreach ($detalles as $reg) { ?>
                    <?php if ($tipo == 1) { ?>
                        <tr style="background-color:#D7EBF5;">
                            <td><?php echo $reg->getOrdenCotizacion()->getCodigo(); ?></td>
                            <td><?php echo $reg->getOrdenCotizacion()->getUsuario(); ?></td>
                            <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                            <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                            <?php if ($muestraBoton) { ?>
                                <td>
                                    <input type="number" class="form-control" value="<?php echo $reg->getCantidadCaja() ?>"   name="can_caja<?php echo $reg->getId(); ?>" id="can_caja<?php echo $reg->getId(); ?>">
                                </td>
                                <td>
                                    <input class="form-control" value="<?php echo $reg->getPeso() ?>"   name="peso<?php echo $reg->getId(); ?>" id="peso<?php echo $reg->getId(); ?>">
                                </td>
                            <?php } ?>
                            <td style="background-color:white !important; font-weight: bold; text-align: right; font-size:16px;">
                            <?php if ($muestraBoton) { ?>
                                <a class="btn btn-block  btn-xs " data-toggle="modal" href="#staticE<?php echo $reg->getId() ?>">  
                          <?php echo $reg->getCantidad(); ?>
                              </a>
                            <?php } else { ?>
                          <?php echo $reg->getCantidad(); ?>
                                
                            <?php } ?>
                            </td>
                            <?php if ($muestraBoton) { ?>
                                <td></td>
                                <th>Despachar</th>
                            <?php } ?>
                        </tr>
                    <?php } ?>


                    <?php if ($tipo == 2) { ?>
                        <tr style="background-color:#D7EBF5;">
                            <td><?php echo "PE" . $reg->getOrdenVendedor()->getId(); ?></td>
                            <td><?php echo $reg->getOrdenVendedor()->getVendedor()->getNombre(); ?></td>
                            <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                            <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                            <?php if ($muestraBoton) { ?>
                                <td>
            <!--                                <input type="number" class="form-control" value="<?php //echo $reg->getCantidadCaja()  ?>"   name="can_caja<?php echo $reg->getId(); ?>" id="can_caja<?php echo $reg->getId(); ?>">-->
                                </td>
                                <td>
            <!--                                <input class="form-control" value="<?php //echo $reg->getPeso()  ?>"   name="peso<?php echo $reg->getId(); ?>" id="peso<?php echo $reg->getId(); ?>">-->
                                </td>
                            <?php } ?>
                            <td style="background-color:white !important; font-weight: bold; text-align: right; font-size:16px;">
                                    
                                      <?php if ($muestraBoton) { ?>
                                <a class="btn btn-block  btn-xs " data-toggle="modal" href="#staticC<?php echo $reg->getId() ?>">  
                          <?php echo $reg->getCantidad(); ?>
                              </a>
                            <?php } else { ?>
                          <?php echo $reg->getCantidad(); ?>
                                
                            <?php } ?>
                            
                            </td>
                            <?php if ($muestraBoton) { ?>
                                <td></td>
                                <th>Despachar</th>
                            <?php } ?>
                        </tr>
                    <?php } ?>



                    <?php if ($muestraBoton) { ?>
                        <?php $bodegas = ProductoExistenciaQuery::create()->filterByProductoId($reg->getProductoId())->filterByCantidad(0, criteria::GREATER_THAN)->find(); ?>
                        <?php foreach ($bodegas as $bode) { ?>
                            <?php $ubicaciones = ProductoUbicacionQuery::create()->filterByTiendaId($bode->getTiendaId())->filterByCantidad(0, criteria::GREATER_THAN)->filterByProductoId($reg->getProductoId())->find(); ?>
                            <?php $cano = 0; ?>
                            <?php foreach ($ubicaciones as $registr) { ?>
                                <?php $cano++; ?>
                                <tr>
                                    <td colspan="6" style="text-align:right;  font-size:14px; color:#0924A9 "><?php echo $bode->getTienda()->getNombre(); ?> </td>
                                    <td style="">&nbsp;&nbsp;&nbsp;<?php echo $registr->getUbicacion(); ?>&nbsp;&nbsp;&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $registr->getCantidad()-$registr->getTransito(); ?></td>
                                    <td><input class="form-control cantidad" value=""  type="number" max="<?php echo $registr->getCantidad()-$registr->getTransito(); ?>" min="0"  name="ubica<?php echo $registr->getId(); ?>" id="ubica<?php echo $registr->getId(); ?>"></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </table>

            <?php if ($muestraBoton) { ?>  
                <div class="row" style="padding-top:2px;padding-bottom:5px;">
                    <div class="col-lg-6" ></div>
                    <div class="col-lg-2" style="font-weight:bold;">
                        Total Caja
                        <input type="number" class="form-control" value="<?php echo $caja ?>"   name="total_caja" id="total_caja">
                    </div>
                    <div class="col-lg-2" style="font-weight:bold;"su>
                        Total Peso
                        <input type="number" class="form-control" value="<?php echo $peso ?>"   name="total_peso" id="total_peso">
                    </div>

                    <div class="col-lg-2" style="padding-top:10px;">
                        <button class="btn btn-block  btn-xs btn-dark dark"  type="submit">
                            <i class="flaticon2-check-mark"></i>CONFIRMAR PEDIDO
                        </button>    
                    </div> 
                </div>
            <?php } ?>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#total_caja").on('change', function () {
            var id = <?php echo $idp; ?>;
            var val = $("#total_caja").val();
            $.get('<?php echo url_for("verifica_bodega/tcaja") ?>', {id: id, val: val}, function (response) {
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#total_peso").on('change', function () {
            var id = <?php echo $idp; ?>;
            var val = $("#total_peso").val();
            $.get('<?php echo url_for("verifica_bodega/tpeso") ?>', {id: id, val: val}, function (response) {
            });
        });
    });
</script>

<?php foreach ($detalles as $lista) { ?>
      <form action="<?php echo url_for($modulo . '/modificarP') ?>" method="get">
            <input type="hidden" value="<?php echo $lista->getId(); ?>"  id="id" name="id">
       <div id="staticC<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Editar Ca</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de editar cantidad pedido vendedor
                                <table style="table">
                                    <tr>
                                        <td style="text-align: center; font-weight: bold; font-size:18px;">Cantidad Actual</td>
                                        <td style="text-align: right; font-weight: bold; font-size:18px;"> <?php echo $lista->getCantidad(); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nueva Cantidad</td>
                                        <td style="text-align: center; font-weight: bold; font-size:18px;"><input type="number" class="form-control" id="canti" name="canti" value="<?php echo $lista->getCantidad(); ?>" min="0" ></td>
                                    </tr>

                                </table>
                                 
                            </div>
                                      <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                              <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i> Aceptar  
                </button>
                            </div>
                        </div>
                    </div>
                </div> 
  </form>


        <form action="<?php echo url_for($modulo . '/modificar') ?>" method="get">
            <input type="hidden" value="<?php echo $lista->getId(); ?>"  id="id" name="id">
       <div id="staticE<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Editar Ca</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de editar pedido
                                <table style="table">
                                    <tr>
                                        <td style="text-align: center; font-weight: bold; font-size:18px;">Cantidad Actual</td>
                                        <td style="text-align: right; font-weight: bold; font-size:18px;"> <?php echo $lista->getCantidad(); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nueva Cantidad</td>
                                        <td style="text-align: center; font-weight: bold; font-size:18px;"><input type="number" class="form-control" id="canti" name="canti" value="<?php echo $lista->getCantidad(); ?>" min="0" ></td>
                                    </tr>

                                </table>
                                 
                            </div>
                                      <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                              <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i> Aceptar  
                </button>
                            </div>
                        </div>
                    </div>
                </div> 
  </form>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#can_caja<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#can_caja<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("verifica_bodega/caja") ?>', {id: id, val: val}, function (response) {

                    $("#total_caja").val(response);
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#peso<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#peso<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("verifica_bodega/peso") ?>', {id: id, val: val}, function (response) {
                    $("#total_peso").val(response);
                });
            });
        });
    </script>
    <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <li class="fa fa-cogs"></li>
                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmar existencia</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="font-size:15px;"> Esta seguro de confirmar existencia producto</td>
                                    <th style="font-size:15px;">Cantidad</th>
                                </tr>
                                <tr>
                                    <th style="font-size:15px;"><?php echo $lista->getProducto()->getCodigoSku(); ?>
                                        <?php echo $lista->getProducto()->getNombre(); ?>
                                    </th >
                                    <td style="font-size:15px;"><?php echo $lista->getCantidad(); ?></td>
                                </tr>
                            </table>

                        </div>
                        <div class="col-lg-2"></div>
                    </div>
                </div>
                <?php $token = md5($lista->getId()); ?>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    <a class="btn   btn-xs btn-info"  href="<?php echo url_for($modulo . '/confirma?token=' . $token . '&id=' . $lista->getId()) ?>" >
                        <i class="flaticon2-check-mark "></i> Confirmar</a> 
                </div>
            </div>
        </div>
    </div> 
<?php } ?>

<div id="staticCON" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <li class="fa fa-cogs"></li>
                <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmar existencia</span>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-2"></div>
                    <div class="col-lg-10">
                        <table class="table table-bordered">
                            <tr>
                                <td style="font-size:15px;"> Esta seguro de confirmar existencia del pedido completo</td>
                                <th style="font-size:15px;"></th>
                            </tr>
                            <tr>
                                <th style="font-size:15px;"><?php echo $codigo; ?>   </th>
                                <td style="font-size:15px;"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-2"></div>

                </div>

            </div>
            <?php $token = md5($em); ?>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                <a class="btn   btn-xs btn-info"  href="<?php echo url_for($modulo . '/confirmaPedi?token=' . $token . '&id=' . $em) ?>" >
                    <i class="flaticon2-check-mark "></i> Confirmar</a> 
            </div>
        </div>
    </div>
</div> 
    
        <script>
    const inputs = document.querySelectorAll('.cantidad');

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        const max = Number(input.getAttribute('max'));
        const min = Number(input.getAttribute('min'));
        let valor = Number(input.value);

        if (valor > max) {
          input.value = max; // Forzar el valor máximo
        } else if (valor < min) {
          input.value = min; // Evitar valores negativos
        }
      });
    });
  </script>
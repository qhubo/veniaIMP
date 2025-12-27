<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>

<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte de Corte de Caja
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php $modulo = $sf_params->get('module'); ?>
            <form action="<?php echo url_for($modulo . '/index') ?>" method="get">

                <select style="width:500px; background-color: #0924A9; color:#fff; font-size:14px; padding-top:5px; padding-bottom:5px;"  onchange="this.form.submit()" class="form-control"  name="bancover" id="bancover">

                    <?php foreach ($DATOS as $KEY => $VA) { ?>
                        <option <?php if ($bancover == $KEY) { ?> selected="selected"  <?php } ?>  value="<?php echo $KEY; ?>"><?php echo $VA; ?></option>
                    <?php } ?>
                </select>
            </form>


        </div>
    </div>
    <div class="kt-portlet__body">

        <?php echo $form->renderFormTag(url_for('reporte_caja/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <?php include_partial($modulo . '/encabezado', array('form' => $form, 'detalle' => $detalle)) ?>

        <?php echo "<form>"; ?>



        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab"> Resumen
                    <?php if (count($operaciones) > 0) { ?>
                        <span class="badge badge-info"> <?php echo count($operaciones) + count($operacionesCXC); ?>  </span> 
                    <?php } ?>

                </a>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-6"> 
              
                <?php
                include_partial($modulo . '/listado', array('operacionCXC' => $operacionCXC, 'operaciones' => $operaciones,
                    'operacionesCXC' => $operacionesCXC,
                    'bancover'=>$bancover,
                    'valorCobrar' => $valorCobrar,
                    'detalle' => $detalle))
                ?>
    
            </div>
            <div class="col-lg-6">
                <br>
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        <a class="btn green-jungle btn-block btn-outline"  target="_blank"  href="<?php echo url_for('reporte_caja/reporte') ?>" >
                            <i class="fa fa-print "></i>
                            IMPRIMIR
                        </a>
                    </div>
                </div>
                <br><br>
                <?php if (($bancover==3) or ($bancover==99)) { ?>
                <h3>MEDIOS DE PAGO FACTURAS DEL DIA </h3>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>No</td>
                            <td>Medio Pago </td>
                            <td>Valor </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $gratotal = 0; ?>
                        <?php $gratotalV = 0; ?>
                        <?php $can = 0; ?>
                        <?php foreach ($operacionPago as $regis) { ?>
                            <?php if (strtoupper($regis->getTipo()) == 'EFECTIVO') { ?>
                                <?php $gratotal = $gratotal + $regis->getValorTotal(); ?>
                            <?php } ?>
                            <?php $gratotalV = $gratotalV + $regis->getValorTotal(); ?>                        
                            <?php $can++; ?>
                            <tr>
                                <td><?php echo $regis->getCantidad(); ?></td>
                                <td class="uppercase"><?php echo $regis->getTipo(); ?></td>
                                <td align="right"><strong><?php echo number_format($regis->getValorTotal(), 2); ?></strong></td>
                            </tr>
                        <?php } ?>
                        <?php if ($valorCobrar) { ?>
                            <?php if ($valorCobrar->getSubValorTotal() > 0) { ?>
                                <?php $gratotalV = $gratotalV + $valorCobrar->getSubValorTotal(); ?>   
                                <tr style="background-color: #FFF8D6">
                                    <td><?php echo $valorCobrar->getCantidadTotal(); ?></td>
                                    <td class="uppercase">Cuentas Por Cobrar</td>
                                    <td align="right"><strong><?php echo number_format($valorCobrar->getSubValorTotal(), 2); ?></strong></td>

                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                    <tr class="active">
                        <td></td>
                        <th>GRAN TOTAL CAJA</th>
                        <th align="right" ><div align="right"><?php echo number_format($gratotalV, 2); ?></div></th>

                    </tr>
                </table>
                <div class="row">
                    <div class="col-lg-12"><br><br></div>
                </div>
                <?php } ?>

<?php if (($bancover==4) or ($bancover==99)) { ?>
                <h3> FACTURAS COBRADAS DE CUENTAS POR COBRAR </h3>

                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>Fecha </td>
                            <td>Tienda</td>
                            <td>Usuario</td>
                            <td> Documento </td>
                            <td>Valor </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php $can = 0; ?>
                        <?php foreach ($Recuperadas as $recuepera) { ?>
                            <?php $regi = $recuepera->getOperacion(); ?>
                            <?php $can++; ?>

                            <?php $total = $total + $recuepera->getValorTotal(); ?>
                            <tr>
                                <td align="center"><font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>
                                <td><font size="-2"><?php echo $regi->getTienda(); ?></font></td>
                                <td><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>
                                <td><font size="-2"><?php echo $regi->getCodigo(); ?></font></td>

                                <td align="right"><font size="-1"><strong><?php echo number_format($recuepera->getValorTotal(), 2); ?></strong></font></td>
                            </tr> 
                        <?php } ?>
                        <tr>
                            <td align="right" colspan="4" class="bold">Total</td>
                            <td align="right"><font size=""><strong><?php echo number_format($total, 2); ?></strong></font></td>
                        </tr>
                </table>
<?php } ?>
                <?php if (($bancover==5) or ($bancover==99)) { ?>
                <h3> PAGOS RECIBIDOS DEL DIA </h3>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>No</td>
                            <td>Medio Pago </td>
                            <td>Documento </td>
                            <td>Valor </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $gratotal = 0; ?>
                        <?php $gratotalV = 0; ?>
                        <?php $can = 0; ?>
                        <?php foreach ($operacionPago as $regis) { ?>
                            <?php if (strtoupper($regis->getTipo()) == 'EFECTIVO') { ?>
                                <?php $gratotal = $gratotal + $regis->getValorTotal(); ?>
                            <?php } ?>
                            <?php $gratotalV = $gratotalV + $regis->getValorTotal(); ?>                        
                            <?php $can++; ?>
                            <tr>
                                <td><?php echo $regis->getCantidad(); ?></td>
                                <td class="uppercase"><?php echo $regis->getTipo(); ?></td>
                                <td>Del Dia</td>
                                <td align="right"><strong><?php echo number_format($regis->getValorTotal(), 2); ?></strong></td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($operacionRecupera as $regis) { ?>

                            <?php $gratotalV = $gratotalV + $regis->getValorPagado(); ?>                        
                            <?php $can++; ?>
                            <tr>
                                <td><?php echo $regis->getTotalCantidad(); ?>  xxx</td>
                                <td class="uppercase"><?php echo $regis->getTipo(); ?> </td>
                                <td>Cuenta por Cobrar</td>
                                <td align="right"><strong><?php echo number_format($regis->getValorPagado(), 2); ?></strong></td>
                            </tr>
                        <?php } ?>               

                    </tbody>
                    <tr class="active">
                        <td></td>
                        <th colspan="2">GRAN TOTAL CAJA</th>
                        <th align="right" ><div align="right"><?php echo number_format($gratotalV, 2); ?></div></th>

                    </tr>
                </table>
                <?php } ?>
                                <?php if (($bancover==6) or ($bancover==99)) { ?>
                <h3>FACTURAS ANULADAS </h3>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>Fecha </td>
                            <td>Tienda</td>
                            <td>Usuario</td>
                            <td> Documento </td>
                            <td>Valor </td>
                        </tr>
                    </thead>
                    <?php foreach ($Anuladas as $regi) { ?>
                        <?php $can++; ?>
                        <tr>
                            <td align="center"><font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getTienda(); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getCodigo(); ?><br> <?php echo $regi->getObservaciones(); ?>
                                </font></td>
                            <td align="right"><font size="-1"><strong><?php echo number_format($regi->getValorTotal(), 2); ?></strong></font></td>
                        </tr> 
                    <?php } ?>
                </table>
  <?php } ?>

                             <?php if (($bancover==7) or ($bancover==99)) { ?>
                <h3>NOTA CREDITO FACTURAS ANULADAS </h3>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>Fecha </td>
                            <td>Tienda</td>
                            <td>Usuario</td>
                            <td> Documento </td>
                            <td>Valor </td>
                        </tr>
                    </thead>
                    <?php foreach ($Notas as $regi) { ?>
                        <?php $can++; ?>
                        <tr>
                            <td align="center"><font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getTienda(); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getCodigo(); ?><br> <?php echo $regi->getObservaciones(); ?>
                                </font></td>
                            <td align="right"><font size="-1"><strong><?php echo number_format($regi->getValorTotal(), 2); ?></strong></font></td>
                        </tr> 
                    <?php } ?>
                </table>

<?php } ?>
                    <?php if (($bancover==8) or ($bancover==99)) { ?>
                <h3>DEVOLUCIONES</h3>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>Fecha </td>
                            <td>Tienda</td>
                            <td>Usuario</td>
                            <td> Documento </td>
                            <td>Valor </td>
                        </tr>
                    </thead>
                    <?php foreach ($Devoluciones as $regi) { ?>
                        <?php $can++; ?>
                        <tr>
                            <td align="center"><font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getTienda(); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getUsuarioCreo(); ?></font></td>
                            <td><font size="-2"><?php echo $regi->getCodigo(); ?><br> <?php echo $regi->getConcepto(); ?>
                                </font></td>
                            <td align="right"><font size="-1"><strong><?php echo number_format($regi->getValor(), 2); ?></strong></font></td>
                        </tr> 
                    <?php } ?>
                </table>

<?php } ?>
            </div>
        </div>
    </div>
</div>









<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?test=' . $test), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">Estado de Resultados  
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-body">      
            <div class="row">
                <label class="col-lg-1 control-label right "> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right ">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>
       <label class="col-lg-1 control-label right ">Tienda </label>
                <div class="col-lg-1 <?php if ($form['tienda']->hasError()) echo "has-error" ?>">
                    <?php echo $form['tienda'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tienda']->renderError() ?>  
                    </span>
                </div>







                <div class="col-lg-1">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>

                <div class="col-lg-1"></div>
                     <div class="col-lg-2">
                                     <a target="_blank" href="<?php echo url_for('estado_resultado/reportePdf') ?>" class="btn  btn-sm btn-secondary btn-info btn-block" > <i class="flaticon2-printer"></i> Pdf </a>
                          </div>
                                  
                <!--                   <div class="col-lg-1">
                                     <a target="_blank" href="<?php echo url_for('libro_mayor/reporte') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
                          </div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9"><br></div>
        </div>
        <div class="table-scrollable">
            <table class="table  " >
                <?php if ($cuentas) { ?>
                    <tr style="background-color:#ebedf2">
                        <th  align="center"> Cuenta</th>
                        <th align="center" >Descripción </th>
                        <th  align="center" width="230px" > Saldo</th>
                        <th width="10px"></th>
                    </tr>
                    <?php $pinta =0; ?>
                    <?php $total = 0; ?>
                    <?php foreach ($cuentas as $cuenta) { ?>
                    <?php if ($pinta==0) { ?>
                        <?php if (substr($cuenta, 0, 1) == 7) { ?>
 <?php $pinta =1; ?>
                    <tr>
                                <td></td>
                                <td><strong>Total Gastos</strong></td>
                                <td></td>
                                <td  style="text-align:right"><?php echo Parametro::formato(($total6), true) ?></td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Resultado del Ejercicio</strong></td>
                                <td></td>
                                <td  style="text-align:right"><?php echo Parametro::formato($total4 + $total5 + $total6, true) ?></td> 
                            </tr>
                        <?php } ?>
                             <?php } ?>
                        <tr>
                            <?php $datosCuenta = $listaDatos[$cuenta]; ?>
                            <?php foreach ($datosCuenta as $dato) { ?>
                                <?php $total = $total + $dato['monto']; ?>
                                <td><?php if (strlen($cuenta) > 3) echo $cuenta ?></td>
                                <td><?php echo html_entity_decode($dato['detalle']) ?></td>
                                <td  style="text-align:right"><?php echo Parametro::formato(($dato['monto']), true) ?></td>
                                <td></td>
                            </tr>
                            <?php if ($cuenta == 5) { ?>
                                <tr>
                                    <td></td>
                                    <td><strong>Margen Bruto</strong></td>
                                    <td></td>
                                    <td  style="text-align:right"><?php echo Parametro::formato($total, true) ?></td> 
                                </tr>    
                                <tr>

                                    <td><strong>Gastos</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="text-align:right"></td> 
                                </tr>  
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                                
                                         <tr>
                                <td></td>
                                <td><strong>Total Otros gastos e ingresos</strong></td>
                                 <td></td>
                                <td  style="text-align:right"><?php echo Parametro::formato($total7, true) ?></td> 
                            </tr> 
                                         <tr>
                                <td></td>
                                <td><strong>Utilidad Neta</strong></td>
                                 <td></td>
                                <td  style="text-align:right"><?php echo Parametro::formato($total4 + $total5 + $total6+$total7, true) ?></td> 
                            </tr> 
                <?php } ?>
            </table>
        </div>


    </div>
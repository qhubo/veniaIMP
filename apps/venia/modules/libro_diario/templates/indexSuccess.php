<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Libro Diario
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
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
                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
                <div class="col-lg-1">
                     <a target="_blank" href="<?php echo url_for( 'libro_diario/reporte')  ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
          </div>
                       <div class="col-lg-1">
                     <a target="_blank" href="<?php echo url_for( 'libro_diario/reporte2')  ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon-more-1"></i>Datos </a>
          </div>
                <div class="col-lg-1">
                     <a target="_blank" href="<?php echo url_for( 'libro_diario/reportePdf')  ?>" class="btn  btn-sm btn-secondary btn-info btn-block" > <i class="flaticon2-printer"></i> Pdf </a>
          </div>
            </div>
            <div class="row">
                <div class="col-lg-9"><br></div>
            </div>
            <div class="table-scrollable">
                <table class="table  " >
    
                        <tr style="background-color:#ebedf2">
                            <th align="center"  width="80px">Partida</th>
                            <th align="center"   width="100px">Fecha</th>
                            <th  align="center"> Cuenta</th>
                            <th align="center" >Descripción </th>
                            <th  align="center" width="100px"> Debe</th>
                            <th  align="center" width="100px" > Haber</th>
                            <th  align="center"> </th>

                        </tr>
             
                        <?php $bandera = 0; ?>
                        <?php $total1 = 0; ?>
                        <?php $total2 = 0; ?> 
                        <?php $cantida=0; ?>
                        <?php foreach ($operaciones as $registro) { ?>

                            <?php if ($bandera <> $registro->getPartidaId())  { ?>
                                <?php if ($total1 > 0) { ?>

                                    <tr >
                                        <td style="text-align: center"  colspan="4"><strong>Totales</strong></td>
                                        <td  style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total1); ?></strong></td>
                                        <td style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total2); ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"> </td>
                                    </tr>
                                      <tr style="background-color:#ebedf2">
                            <th align="center"  width="80px">Partida</th>
                            <th align="center"   width="100px">Fecha</th>
                            <th  align="center"> Cuenta</th>
                            <th align="center" >Descripción </th>
                            <th  align="center" width="100px"> Debe</th>
                            <th  align="center" width="100px" > Haber</th>
                            <th  align="center" > </th>

                        </tr>
                                <?php } ?>                            
                            <?php } ?>
                            <tr>
                                <td><?php //echo $cantida. " --".count($operaciones); ?><?php echo $registro->getPartida()->getNoAsiento() ; ?></td>
                                <td  style="text-align: center"><?php echo $registro->getPartida()->getFechaContable('d/m/Y'); ?></td>
                                <td><?php echo $registro->getCuentaContable(); ?></td>
                                <td><?php echo $registro->getDetalle(); ?></td>
                                <td style="text-align: right"><?php echo Parametro::formato($registro->getDebe()); ?></td>
                                <td style="text-align: right"><?php echo Parametro::formato($registro->getHaber()); ?></td>
                                <td> <font size="-1"><?php echo $registro->getPartida()->getTipo(); ?>&nbsp;<?php //echo $registro->getPartida()->getCodigo(); ?></font></td>
                            </tr>
                            <?php if ($bandera <> $registro->getPartidaId()) { ?>
                                <?php $bandera = $registro->getPartidaId(); ?>
                                <?php $total1 = 0; ?>
                                <?php $total2 = 0; ?> 
                            <?php } ?>
                            <?php $total1 = $registro->getDebe() + $total1; ?>
                            <?php $total2 = $registro->getHaber() + $total2; ?> 
                        <?php } ?>
        <tr style="">
                                        <td style="text-align: center"  colspan="4"><strong>Totales</strong></td>
                                        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total1); ?></strong></td>
                                        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total2); ?></strong></td>
                                        <td></td>
                                    </tr>
               
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo '</form>'; ?>



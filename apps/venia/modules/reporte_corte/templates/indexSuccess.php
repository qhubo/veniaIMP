<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for('reporte_corte/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-checkmark kt-font-danger"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte de Cierre De Caja
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas <strong>del dia Calendario Trabajado </strong>y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="form-body">      
            <div class="row">

                <label class="col-lg-1 control-label right "> Usuario </label>
                <div class="col-lg-3 <?php if ($form['usuario']->hasError()) echo "has-error" ?>">
                    <?php echo $form['usuario'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['usuario']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right "> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>

            </div>

            <div class="row">

                <label class="col-lg-1 control-label right "> Bodega</label>
                <div class="col-lg-3">
                    <?php echo $form['bodega'] ?> 
                </div>
                <label class="col-lg-1 control-label right ">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>



                <div class="col-lg-1">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
<?php echo '</form>'; ?>


<div class="row">

    <div class="col-lg-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">

                    <table class="table table-bordered  dataTable table-condensed flip-content" id="sample_1">
                        <thead class="flip-content">
                                     <th  align="center"> Tienda</th>   
                                <th align="center" width="20px"> No</th>
                                <th align="center">Fecha Creación</th>
                                <th align="center" >Usuario</th>
                          
                                <th  align="center"> Turno Inicio</th>
                                <th  align="center"> Turno Fin</th>
                          <th align="center">Dia Trabajado</th>
                                   <th  align="center"> Valor Caja</th>
                                <th  align="center"> Valor Pos</th>
                          <th  align="center"> Faltante/Sobrante</th>
                                         <th  align="center"> Estatus</th>
                                             <th  align="center"> No Documentos</th>
                        

                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php foreach ($operaciones as $lista) { ?>
                                <?php $total = $lista->getValorTotal() + $total; ?>
                                <tr>     
                                       <td>  <font size="-1"><?php echo $lista->getBodega() ?>  </font>  </td>

                                    <td> <a class="btn  btn-warning "   href="<?php echo url_for('reporte_corte/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                        <?php echo $lista->getId(); ?>
                                        </a>                                        
                                    </td>
                                    <td><font size="-2"><?php echo $lista->getFechaCreo('d/m/Y H:i:s') ?></font>  </td>
                                    <td>  <font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                  
                                    <td  align="center"> <font size="-1"><?php echo $lista->getInicio('d/m/Y H:s') ?></font>  </td>
                                    <td  align="center"><font size="-1"><?php echo $lista->getFin('d/m/Y H:s') ?></font>  </td>
                                
                                                      <td align="right"> <?php echo $lista->getFechaCalendario('d/m/Y') ?>  </td>
                                            <td  align="right">  <font size="-1"><?php echo number_format($lista->getValorCaja(), 2) ?>  </font>  </td>
                                 
                                                      <td align="right">  <font size="-1"><?php echo number_format($lista->getValorTotal(), 2) ?></font>  </td>
                                     <td align="right">  <font size="-1"><?php echo number_format($lista->getValorCaja()-$lista->getValorTotal(), 2) ?></font>  </td>
                                    
                            
                                       <td  >  <font size="-1"><?php echo $lista->getEstatus() ?>  </font>  </td>
                               


    <td  align="right">
                                         <a class="btn  btn-brand "   href="<?php echo url_for('reporte_corte/detalle?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodalC<?php echo $lista->getId() ?>">
                                      <font size="-1"><?php echo $lista->getNoDocumentos() ?></font>
                                        </a>                                        
                                    </td>
                              




                                </tr>



                            <?php } ?>
                        </tbody>
                   
                    </table>

                </div>
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
    <div class="modal fade" id="ajaxmodalC<?php echo $reg->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
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

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
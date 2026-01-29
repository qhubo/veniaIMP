<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte de Pedidos Realizados
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for('orden_cotizacion/nueva') ?>" class="btn btn-block btn-small btn-success btn-secondary" >  <i class="flaticon2-plus"></i> Nuevo Pedido </a>
        </div>
    </div>


    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link"  href="<?php echo url_for('pedido_pendiente/index') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Pedidos en Proceso  </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content" >
            <?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=1'), array('class' => 'form-horizontal"')) ?>
            <?php echo $form->renderHiddenFields() ?>
            <div class="row"  style="padding-bottom:10px;">
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
                <div class="col-lg-3">
                    <?php echo $form['usuario'] ?> 
                </div>
                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
            <?php echo '</form>'; ?>
            <div class="row">
                <div class="col-lg-10">  </div>
                <div class="col-lg-2">				
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-checkable dataTable no-footer kt-datatable" xid="html_table" width="100%">
                <thead class="flip-content">
                    <tr class="active">
                        <th align="center" width="20px"> Código</th>
                        <th align="center" width="20px">Fecha</th>
                        <th  align="center"> Cliente</th>
                       
                        <th  align="center"> Estado</th>
                        <th  align="center"> Valor</th>    
                                        
                        <th width="25px">Reporte</th>
                     
                       <th align="center" width="20px">Usuario</th>
                        <th  align="center"> RUC</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($operaciones as $lista) { ?>
                        <?php $total = $lista->getValorTotal() + $total; ?>
                 
                        <tr>     
                            <td>
                                <?php echo $lista->getCodigo() ?>  
                            </td>
                            <td><font size="-2"><?php echo $lista->getFecha('d/m/Y H:i') ?></font>  </td>

                            <td>  <font size="-1"><?php echo $lista->getNombre() ?></font>  </td>
                
                            <td>  <font size="-1"><?php echo $lista->getEstatus() ?>  </font>  </td>
                            <td style="text-align:right">  <font size="-1"><?php echo Parametro::formato($lista->getValorTotal()) ?>  </font>  </td>

                            <td>
                                           <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token='.$lista->getToken()) ?>" class="btn btn-sm btn-block btn-warning" > 
      <i class="flaticon2-printer"></i>
                                        </a>
                                
                                                     <a target="_blank" href="<?php echo url_for('reporte_excel/pedido?id=' . $lista->getId()) ?>" class="btn btn-block  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte </a>
        
                            </td>
                      
                      

                              <td> <font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                                        <td>  <font size="-1"><?php echo $lista->getNit() ?></font>  </td>
                    </tr>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                <td  class="info" colspan="4"></td>
                <th  class="active" > Totales</th>
                <th class="active" style="text-align:right"><?php echo Parametro::formato($total); ?> </th>
                <td class="info">   </td>
                </tfoot>
            </table>
        </div>
    </div>
</div>
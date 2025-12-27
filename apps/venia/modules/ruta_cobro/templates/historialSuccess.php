<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-more-v4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Cuentas Por Cobrar
                <small>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">

        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
            <li class="nav-item">
                <a class="nav-link     " href="<?php echo url_for($modulo . '/index') ?>" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Asigna  Ruta
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link  active  " data-toggle="tab" href="<?php echo url_for($modulo . '/historial') ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                </a>
            </li>
        </ul>

        <?php echo $form->renderFormTag(url_for($modulo . '/historial?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">


            <div class="col-lg-1 control-label right "> Inicio </div>
            <div class="col-lg-3 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>



            <div class="col-lg-1 control-label right ">Fin  </div>
            <div class="col-lg-3 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>



            <div class="col-lg-2">
                <button class="btn btn-small btn-outline-success" type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
            </div>

                      <div class="col-lg-2">
                     <a target="_blank" href="<?php echo url_for( $modulo.'/reporteExcel')  ?>" class="btn  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
          </div>
        </div>

        <?php echo '</form>' ?>
        <div class="row">

            <div class="col-lg-12">   
                <BR> <BR>
            </div>
        </div>



            <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin " id="html_table" width="100%">
            <thead class="flip-content">
                <tr class="active">
                                        <th  align="center"> Fecha Cobro</th> 
                    <th  align="center">Codigo Cliente</th>
                    <th  align="center"> Cliente</th>
                    <th align="center" width="20px"> Código</th>
                    <th align="center" width="20px">Fecha </th>
                    <th  align="center"> Dirección</th>    
                    <th  align="center"> Valor Total</th>    

                    <th  align="center"> Valor Pagado</th>     
    
                    <th  align="center"> Ruta Cobro</th>  

                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($operaciones as $lista) { ?>
                    <tr>   
                                        <td><?Php echo $lista->getFechaCobro('d/m/Y'); ?></td>
                        <td>  <?php echo $lista->getCliente()->getCodigoCli(); ?></td>
                        <td>  <?php echo $lista->getCliente()->getNombre(); ?></td>
                        <td>
                            <?php if ($lista->getCodigo()) { ?>
                                <font size="-2"> <?php echo $lista->getCodigo() ?>   </font>
                            <?php } else { ?>
                                <?php echo $lista->getCodigoFactura() ?>  
                            <?php } ?>
                        </td>
                        <td><?php echo $lista->getFecha('d/m/Y') ?></td>
                        <td><?php echo $lista->getCliente()->getDireccion(); ?></td>
                        <td style="text-align:right">  <font size="-1"><?php echo number_format($lista->getValorTotal(), 2) ?>  </font>  </td>
                   
                        <td style="text-align:right">  <font size="-1"><?php echo number_format($lista->getValorPagado(), 2) ?>  </font>  </td>
                        <td><?Php echo $lista->getRutaCobro(); ?> </td>
        
                            
                    
                    </tr>
                <?php } ?>
            </tbody>
        </table>     


    </div>
</div>

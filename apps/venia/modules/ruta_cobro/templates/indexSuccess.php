

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
        
        
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">
            <div class="col-lg-2 control-label right "> Inicio </div>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1 control-label right ">Fin  </div>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row" style="padding-top:5px;">
            <div class="col-lg-2 control-label right "> Busca por Cliente </div>
            <div class="col-lg-5 <?php if ($form['busqueda']->hasError()) echo "has-error" ?>">
                <?php echo $form['busqueda'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['busqueda']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-small btn-outline-success" type="submit">   <i class="fa fa-search "></i> Buscar</button>
            </div>
        </div>
        <?php echo '</form>' ?>
        <div class="row">

            <div class="col-lg-12">   
                <BR> <BR>
            </div>
        </div>
           <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link   active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Asigna  Ruta
                        </a>
                    </li>
               
                    <li class="nav-item">
                        <a class="nav-link   " href="<?php echo url_for($modulo . '/historial') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
        <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin " id="html_table" width="100%">
            <thead class="flip-content">
                <tr class="active">
                    <th  align="center">Codigo Cliente</th>
                    <th  align="center"> Cliente</th>
                    <th align="center" width="20px"> Código</th>
                    <th align="center" width="20px">Fecha </th>
                    <th  align="center"> Dirección</th>    
                    <th  align="center"> Valor Total</th>    
                    <th  align="center"> Cheque Prefechado</th>     
                    <th  align="center"> Valor Pagado</th>     
                    <th  align="center"> Fecha Cobro</th>     
                    <th  align="center"> Ruta Cobro</th>  

                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($operaciones as $lista) { ?>
                    <tr>   
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
                        <td style="text-align:right">  <font size="-1"><?php echo number_format($lista->getValorPrefechado(), 2) ?>  </font>  </td>
                        <td style="text-align:right">  <font size="-1"><?php echo number_format($lista->getValorPagado(), 2) ?>  </font>  </td>
                        <td colspan="2" style="width:200px;">
                                                         <a     href="#"  data-toggle="modal" data-target="#ajaxmodalCE<?php echo $lista->getId() ?>">
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                     <div id="resultado<?php echo $lista->getId() ?>" class="resultado<?php echo $lista->getId() ?>"><?Php echo $lista->getRutaCobro(); ?></div>
                                    </td>
                                    <td>
                                     <div id="resultadofecha<?php echo $lista->getId() ?>" class="resultadofecha<?php echo $lista->getId() ?>"><?Php echo $lista->getFechaCobro('d/m/Y'); ?></div>
                                    </td>
                                </tr>
                            </table>

                                  </a> 
    
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<?php foreach ($operaciones as $reg) { ?>
    <?php $lista = $reg; ?>
    <div class="modal fade" id="ajaxmodalCE<?php echo $lista->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Detalle de ruta  </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-bottom:5px;">
                        <div class="col-lg-3">Fecha Cobro </div>
                        <div class="col-lg-6"><input class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="fecha<?php echo $lista->getId(); ?>" value="<?php echo $lista->getFechaCobro('d/m/Y'); ?>" id="fecha<?php echo $lista->getId(); ?>"> </div>
                    </div>
                    
<div class="row">   
    <div class="col-lg-3">Ruta Cobro </div>
                    
                    
                        <div class="col-lg-8 ">
                            <input   name="observaciones<?php echo $lista->getId(); ?>"  id="observaciones<?php echo $lista->getId(); ?>"  class="form-control" value="<?php echo $lista->getRutaCobro(); ?>">
                        </div>

                    </div>
                </div> 

                <div class="modal-footer">

                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#fecha<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#fecha<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("ruta_cobro/fecha") ?>', {id: id, val: val}, function (response) {
                   $("#resultadofecha<?php echo $lista->getId(); ?>").html(val);
                });
            });
        });
    </script>
        <script type="text/javascript">
        $(document).ready(function () {
            $("#observaciones<?php echo $lista->getId(); ?>").on('change', function () {
                var id = <?php echo $lista->getId(); ?>;
                var val = $("#observaciones<?php echo $lista->getId(); ?>").val();
                $.get('<?php echo url_for("ruta_cobro/comentario") ?>', {id: id, val: val}, function (response) {
                   $("#resultado<?php echo $lista->getId(); ?>").html(val);
                });
            });
        });
    </script>

<?php } ?>


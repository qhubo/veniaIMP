<?php $modulo = $sf_params->get('module'); ?>
<?php $pendientes = count($registros); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-hourglass-1 text-dark"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                DOCUMENTOS PENDIENTES CONTRASEÑAS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Listado para generación contraseñas
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">


        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pendientes > 0) { ?> active <?php } ?>" data-toggle="tab" href="#kt_portlet_base_demo_2_2_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>Pendientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pendientes == 0) { ?> active <?php } ?>" data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historico
                            </a>
                        </li>




                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">

                <div class="tab-content">

                    <div class="tab-pane  <?php if ($pendientes > 0) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_2_tab_content" role="tabpanel">
                        <?php include_partial($modulo . '/listado', array('modulo' => $modulo, 'registros' => $registros)) ?>   
                    </div>
                    <div class="tab-pane <?php if ($pendientes == 0) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                        <div class="row" style="padding-botom:15px;">
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
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><br><br></div>
                        </div>

                        <table class="table table-striped- table-bordered table-hover "  width="100%">
                            <thead >
                                <tr class="active">
                                    <th  align="center"><span class="kt-font-success">Codigo </span></th>
                                    <th  align="center"><span class="kt-font-success">Fecha </span></th>
                                    <th  align="center"><span class="kt-font-success"> Proveedor</span></th>
                                    <th  align="center"><span class="kt-font-success"> Dias Credito</span></th>
                                    <th  align="center"><span class="kt-font-success"> Fecha Pago</span></th>
                                    <th  align="center"><span class="kt-font-success">Valor </span></th>
                                    <th  align="center"><span class="kt-font-success"> Documentos </span></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?PHp $total = 0; ?>
                                <?php $can = 0; ?>
                                <?php foreach ($contrasenas as $deta) { ?>
                                    <?php $can++; ?>
                                    <tr>
                                        <td><?php echo $deta->getCodigo(); ?></td>
                                        <td><?php echo $deta->getFecha('d/m/Y'); ?></td>
                                        <td><?php echo $deta->getProveedor()->getNombre(); ?></td>
                                        <td style="text-align: right"><?php echo $deta->getDiasCredito(); ?> Días</td>
                                        <td><?php echo $deta->getFechaPago('d/m/Y'); ?></td>
                                        <td style="text-align: right" ><?php echo Parametro::formato($deta->getValor()); ?></td>
                                        <td  style="text-align: right" ><?php echo $deta->getDocumentos(); ?></td>
                                        <td>    <a href="<?php echo url_for($modulo . '/reporte?id='.$deta->getId()) ?>" class="btn btn-sm btn-dark" target="_blank" > <li class="fa fa-print"></li> Contraseña  </a></td>

                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                </div>      
            </div>
        </div>
    </div>
</div>


<div id="staticC" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <li class="fa fa-cogs"></li>
                <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmar Proceso</span>
            </div>
            <div class="modal-body">
                <p> Esta seguro confirma generación contraseñas
                    <span class="caption-subject font-green bold uppercase"> 
                        <?php //echo $lista->getUsuario() ?>
                    </span> ?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                <a class="btn  btn green " href="<?php echo url_for($modulo . '/confirmar') ?>" >
                    <i class="fa fa-trash-o "></i> Confirmar</a> 
            </div>
        </div>
    </div>
</div> 

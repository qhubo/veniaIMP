<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Nota de Crédito Factura
                <small>&nbsp;&nbsp;&nbsp; Ingresa una nuevo nota  y/o visualiza por un rango de fechas  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/nueva') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
            <li class="nav-item">
                <a class="nav-link     " href="<?php echo url_for($modulo . '/index') ?>" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Busqueda Factura
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

            <!--            <div class="col-lg-1">
                            <a class="btn btn-sm btn-outline-warning "   href="#<?php echo url_for('reporte/corteCaja') ?>"  target="_blank">
                                <li class="fa fa-print"></li> Reporte
                            </a>
                        </div>-->
        </div>

        <?php echo '</form>' ?>
        <div class="row">

            <div class="col-lg-12">   
                <BR> <BR>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-10"></div>
                    <div class="col-lg-2">				
                        <div class="kt-input-icon kt-input-icon--left">
                            <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                            <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                <span><i class="la la-search"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
<!--                        <table class="kt-datatable table-condensed flip-content" id="html_table" width="100%">-->
                <table class="kt-datatable  table table-bordered  xdataTable table-condensed flip-content" id="html_table" width="100%" >
                    <thead>
                        <tr class="info">
                            <th>Codigo </th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Valor </th>
                              <th>Consumido </th>
                            <th>Documento </th>
                            <th>Feel</th>
                            <th>Estatus</th>
                            <th>Usuario</th>
                        
                            <th>Concepto</th>
    <th>Accion</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($operaciones as $registro) { ?>
                            <?php $lista = OperacionQuery::create()->findOneByCodigo($registro->getDocumento()); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo url_for("nota_credito/vista?id=" . $registro->getId()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $registro->getId(); ?>">
                                        <?php echo $registro->getCodigo(); ?>
                                    </a>
                                </td>
                                <td><?php echo $registro->getFecha('d/m/Y'); ?></td>
                                <td><?php echo $registro->getNombre(); ?></td>
                                <td style="text-align: right; align-content: right">
                                    <div align="right" style="align-content:right;">
                                        <?php echo Parametro::formato($registro->getValorTotal(), true); ?>
                                    </div>
                                </td>
                                 <td style="text-align: right; align-content: right">
                                    <div align="right" style="align-content:right;">
                                        <?php echo Parametro::formato($registro->getValorConsumido(), true); ?>
                                    </div>
                                </td>
                                <td><?php echo $registro->getDocumento(); ?></td>
                                <td>


                                    <?php if ($lista) { ?>


                                        <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $lista->getCodigo()) ?>" class="btn btn-block btn-xs btn-info " target = "_blank">
                                            <?php if ($lista->getFaceEstado() == "FIRMADONOTA") { ?> <?php echo "NOTA "; ?> <?php } ?>
                                            <font size='-2'>   <?php echo $registro->getFaceFirma(); ?></font>
                                        </a>
                                        <?php if ($lista->getFaceError() <> "") { ?>
                                            <font color="red">    <?php echo $lista->getFaceError(); ?> </font>
                                            <a href="<?php echo url_for($modulo . '/reenviar?id=' . $lista->getId()) ?>" class="btn  btn-block btn-dark btn-sm" > <i class="flaticon-refresh"></i>Reenviar</a>

                                        <?php } ?>

                                    <?php } ?>


                                </td>
                                <td><?php echo $registro->getEstatus(); ?>
                                <?php echo $registro->getDocumentoCanje(); ?>
                                </td>
                                <td><?php echo $registro->getUsuario(); ?></td> 
                                                <td><?php echo $registro->getConcepto(); ?></td> 
                                <td>
                                         <?php if ($lista) { ?>
                                    <?php if ($lista->getFaceError() <> "") { ?>
                                        <a class="btn  btn-danger btn-sm  "   href="#"  data-toggle="modal" data-target="#static<?php echo $registro->getId() ?>">
                                            <i class="fa fa-trash"> </i> Anular
                                        </a>
                                    <?php } ?>
   <?php } ?>
                                </td>
                
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>      
        </div>      



        <?php foreach ($operaciones as $data) { ?>

            <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
                 role="dialog"  aria-hidden="true" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel6">Detalle Nota  <?php echo $data->getCodigo(); ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>


            <div id="static<?php echo $data->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <li class="fa fa-cogs"></li>
                            <span class="caption-subject bold font-yellow-casablanca uppercase"> Anular Nota</span>
                        </div>
                        <div class="modal-body">
                            <p> Esta seguro de eliminar Nota
                                <span class="caption-subject font-green bold uppercase"> 
                                    <?php echo $data->getCodigo() ?>
                                </span> ?
                            </p>
                        </div>
                        <?php $token = md5($data->getCodigo()); ?>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                            <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/eliminar?id=' . $data->getId()) ?>" >
                                <i class="fa fa-trash-o "></i> Confirmar</a> 
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

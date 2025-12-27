<?php $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa'); ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<?php $modulo = $sf_params->get('module'); ?>

<?php $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seledatos', null, 'carga')); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Carga de Activos <small> utiliza esta opción para la carga de activo mediante archivo plantilla excel </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-secondary btn-hover-brand" > <i class="flaticon-download-1"></i> Archivo Modelo Carga  </a>

        </div>
    </div>
    <div class="kt-portlet__body">

        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Carga
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial

                </a>
            </li>
        </ul>



        <div class="tab-content" style="padding-top:1px;" >



            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_2_3_tab_content" role="tabpanel">
                <div class="table-scrollable">
   <div class="row">
                        <div class="col-lg-1" style="text-align:right;"></div>
                        <div class="col-lg-2"><span class="caption-subject  kt-font-info uppercase">
                                <strong>  Código Vacio</strong></span></div>
                        <div class="col-lg-6"> Si el codigo es vacio lo genera automaticamente</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1" style="text-align:right;"></div>
                        <div class="col-lg-2"><span class="caption-subject  kt-font-info uppercase">
                                <strong>  Código  </strong></span></div>
                        <div class="col-lg-6"> Este debe ser unico por cada activo ingresado</div>
                    </div>


                    <div class="row">
                        <div class="col-lg-1" style="text-align:right;"></div>
                        <div class="col-lg-2"><span class="caption-subject  kt-font-info uppercase">
                                <strong>  Código  </strong></span></div>
                        <div class="col-lg-6"> Utilizando  el mismo codigo cuando se desea actualizar un activo</div>
                    </div>


                    <div class="row">
                        <div class="col-lg-1" style="text-align:right;"></div>
                        <div class="col-lg-2"><span class="caption-subject  kt-font-info uppercase">
                                <strong>  Código  </strong></span></div>
                        <div class="col-lg-6" style="background-color: #ffffdf"  > La linea sera resaltada con procede a una actualización</div>
                    </div>
                    <?php include_partial($modulo . '/carga', array('modulo' => $modulo)) ?>  
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_3_3_tab_content" role="tabpanel">

                <?php $modulo = $sf_params->get('module'); ?>
                <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
                <?php echo $form->renderHiddenFields() ?>
                <div class="row" style="padding-bottom:8px">

                    <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                        <?php echo $form['fechaInicio'] ?>           
                        <span class="help-block form-error"> 
                            <?php echo $form['fechaInicio']->renderError() ?>  
                        </span>
                    </div>




                    <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                        <?php echo $form['fechaFin'] ?>           
                        <span class="help-block form-error"> 
                            <?php echo $form['fechaFin']->renderError() ?>  
                        </span>
                    </div>





                    <div class="col-lg-2">
                        <button class="btn btn-outline-success" type="submit">
                            <i class="fa fa-search "></i>
                            <span>Buscar</span>
                        </button>
                    </div>



                </div>


                <?php echo "</form>"; ?>


                <table class="table table-bordered  dataTable table-condensed flip-content" >
                    <thead class="flip-content">
                        <tr class="active">
                            <th align="center" ><font size="-1"> CODIGO </font></th>
                            <th align="center" width="20px"><font size="-1">ACCOUNT</font></th>
                            <th align="center" ><font size="-1">DESCRIPTION</font></th>
                            <th align="center" ><font size="-1">ADQUISITION DATE</font></th>
                            <th align="center" ><font size="-1">LIFE YEARS</font></th>
                            <th align="center" ><font size="-1"> BOOK VALUE</font></th>
                            <th align="center" ><font size="-1">% </font></th>
                            <th align="center" ><font size="-1">Usuario</font></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $data) { ?>
                            <tr <?php if ($data->getFechaAdquision('Y-m-d') < date('Y-m-d')) { ?>  style="background-color: #ffffdf"  <?php } ?> >
                                <td><?php echo $data->getCodigo(); ?></td>
                                <td><?php echo $data->getCuentaContable(); ?></td>
                                <td><?php echo $data->getDetalle(); ?></td>
                                <td style="text-align:center"><?php echo $data->getFechaAdquision('d/m/Y'); ?></td>
                                <td style="text-align:right"><?php echo $data->getAnioUtil(); ?></td>
                                <td style="text-align:right"><?php echo Parametro::formato($data->getValorLibro(), true); ?></td>
                                <td style="text-align:right"><?php echo $data->getPorcentaje(); ?></td>
                                <td><?php echo $data->getUsuario(); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>



    </div>
</div>    


<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div id="staticC" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <li class="fa fa-cogs"></li>
                <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmar Ingresos</span>
            </div>
            <div class="modal-body">
                <p> Esta seguro confirma el listado
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



<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>



<!--   <script type="text/javascript">
       $(document).ready(function () {
           $("#cuentaid").on('change', function () {
               var id =<?php //echo $gasto->getId()   ?>;
               var val = $("#cuentaid").val();
               $.get('<?php //echo url_for("carga_gasto/cuenta")   ?>', {val: val, id: id}, function (response) {
                   var respuestali = response;
                     });
           });
       });
</script>
-->

<script src='/assets/global/plugins/jquery.min.js'></script>


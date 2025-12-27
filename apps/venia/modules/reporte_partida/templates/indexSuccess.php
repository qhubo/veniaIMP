<?php $modulo = $sf_params->get('module'); ?>
<?php $tab = 1; ?>
 <?php if (count($pendientes) > 0) { ?>
<?php $tab = 2; ?>
 <?php } ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte de Partidas Contables
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>

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
            </div>
            <div class="row">
                <div class="col-lg-9"><br></div>
            </div>
        </div>
        <?php echo '</form>'; ?>
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Listado
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Pendiente 
                    <?php if (count($pendientes) > 0) { ?>
                        <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded"><?php echo count($pendientes); ?></span>
                    <?php } ?>
                </a>
            </li>
        </ul>

        <div class="tab-content" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_2_3_tab_content" role="tabpanel">
                <div class="table-scrollable">
                    <?php include_partial('reporte_partida/lista', array('modulo'=>$modulo, 'operaciones' => $operaciones)) ?> 
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_3_3_tab_content" role="tabpanel">
                <div class="table-scrollable">
                    <?php include_partial('reporte_partida/pendiente', array('tiendas'=>$tiendas,'modulo'=>$modulo,'operaciones' => $pendientes)) ?> 
                </div>
            </div>

        </div>




    </div>
</div>


<?php foreach ($operaciones as $data) { ?>
    <div class="modal fade" xstyle="width:900px"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" xstyle="width:900px" role="document">
            <div class="modal-content" xstyle="width:750px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" xstyle="width:900px"  id="ajaxmodalMO<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" xstyle="width:900px" role="document">
            <div class="modal-content" xstyle="width:750px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<?php } ?>

<?php foreach ($pendientes as $data) { ?>
    <div class="modal fade" xstyle="width:900px"  id="ajaxmodalP<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" xstyle="width:900px" role="document">
            <div class="modal-content" xstyle="width:750px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>


    <div class="modal fade" xstyle="width:900px"  id="ajaxmodalCon<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" xstyle="width:900px" role="document">
            <div class="modal-content" xstyle="width:750px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Confirmar <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<?php } ?>






<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
<?php $modulo = $sf_params->get('module'); ?>
<?php $tab=1; ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-refresh-button kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                DEVOLUCIONES <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Filtra por rango de fechas   y/o ingresar un nuevo registro en <STRONG>NUEVO</STRONG>
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row" style="padding-bottom:30px">
  
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

    <div class="col-lg-2 <?php if ($form['usuario']->hasError()) echo "has-error" ?>">
                <?php echo $form['usuario'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['usuario']->renderError() ?>  
                </span>
            </div>
            
              <div class="col-lg-2 <?php if ($form['estatus_devolucion']->hasError()) echo "has-error" ?>">
                <?php echo $form['estatus_devolucion'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['estatus_devolucion']->renderError() ?>  
                </span>
            </div>

           

               <div class="col-lg-2">

                <button class="btn btn-sm btn-outline-success" type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
               </div>

             <div class="col-lg-1">
                     <a target="_blank" href="<?php echo url_for( $modulo.'/reporte')  ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
          </div>
        </div>
        <?php echo "</form>"; ?>

        
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historial
                </a>
            </li>
<!--            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Devoluciones
               
                </a>
            </li>-->
        </ul>

        
        
        <div class="tab-content" style="padding-top:20px;" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_2_3_tab_content" role="tabpanel">
                <div class="table-scrollable">
               
        <?php include_partial($modulo.'/listado', array('modulo'=>$modulo, 'registros' => $registros)) ?>  
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_3_3_tab_content" role="tabpanel">
                <div class="table-scrollable">
                        <?php include_partial($modulo.'/listadoDev', array('modulo'=>$modulo, 'devoluciones' => $devoluciones)) ?>  
                </div>
            </div>

        </div>

        




        <?php //if ($partidaPen) { ?>
        
        <?php if (1==2) { ?>
            <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
                <div class="modal-lg"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php include_partial('proceso/partidaCambia', array('partidaPen' => $partidaPen)) ?>  
                        </div>
                    </div>
                </div>
            </div>
            <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <?php foreach ($partidaPen->getListDetalle() as $cta) { ?>
                <script>
                    $(document).ready(function () {
                        $("#cuenta<?php echo $cta; ?>").select2({
                            dropdownParent: $("#ajaxmodalPartida")
                        });
                    });
                </script>
            <?php } ?>
            <script>
                $(document).ready(function () {
                    $("#ajaxmodalPartida").modal();
                });
            </script>
        <?php } ?>



    </div>
</div>









<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-sort-down kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                COTIZACIÓN <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                   &nbsp;&nbsp;  </small>
            </h3>
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>
   
        </div>
        <div class="kt-portlet__head-toolbar">
  
        </div>
    </div>
    <div class="kt-portlet__body">
            <?php include_partial($modulo . '/fichaVer', array('orden' => $orden)) ?>  

                <?php include_partial($modulo . '/fichalistaVer', array('orden' => $orden, 'lista' => $lista)) ?> 
<div class="row" >
    <div class="col-lg-6" style="background-size: contain; background-image: url(./assets/media//bg/300.jpg); padding-top: 3px;padding-bottom: 3px"></div>
    <div class="col-lg-3">                <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary btn-hover-brand">Cancelar</button>
</div>
   
    
     <div class="col-lg-3 " style="background-size: contain; background-image: url(./assets/media//bg/300.jpg);  padding-top: 3px;padding-bottom: 3px">
         <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token='.$orden->getToken()) ?>" class="btn btn-block btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
</div>
     </div>
    </div>
</div>

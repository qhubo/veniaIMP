<?php $tab = 1; ?>


<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-interface-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Nota Crédito Proveedor<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Información del documento&nbsp;&nbsp; </small>
            </h3>
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">




        <?php   include_partial($modulo . '/fichaVer', array('orden' => $orden)) ?>  

  

        
        
 <?php if ($orden->getPartidaNo()){ ?>
                      <div class="table-scrollable">
                          
                    <?php  include_partial('proceso/partida', array('id' => $orden->getPartidaNo())) ?>  
                 </div>
 <?php } ?>

        </div>
        
<!--        <div class="row">
            <div class="col-lg-8"> </div>
            <div class="col-lg-4">          <a target="_blank" href="<?php //echo url_for('reporte/gasto?token=' . $orden->getToken()) ?>" class="btn btn-block btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
            </div>
        </div>-->

    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
    </div>




    </div>


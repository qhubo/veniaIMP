
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-document  text-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Partida Contable  
            </h3> &nbsp;&nbsp;&nbsp; <?php echo $partida->getTipo(); ?> 
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-12">
 <?php include_partial('proceso/partida', array('id' => $partida->getId())) ?>  
            </div>    

        </div>
    </div>
</div>

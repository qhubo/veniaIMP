<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->

   <?php $condomi= sfContext::getInstance()->getUser()->getAttribute("nombrelinea", null, 'seguridad'); ?>
             <?php $porUno  =0; ?>   
 <?php $porDos  =0; ?>   
 <?php $porUno  =0; ?>  
 <?php $porPagar  =0; ?>  
 <?php $dia  =0; ?>  
 <?php $moroso  =0; ?>  


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php echo $condomi; ?> <small>..</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">

     
    </div>
</div>


<!--
<link href="./assets/global/css/components-md.css" rel="stylesheet" type="text/css" />
     -->
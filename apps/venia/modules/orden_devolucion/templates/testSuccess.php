<script src='/assets/global/plugins/jquery.min.js'></script>
<?php include_partial('soporte/labels') ?>  


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Devoluciones <small>..</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>

    <div class="kt-portlet__body">
        
        
                    <div class="row">
          <div class="col-lg-12">
                <h3>Devoluciones Por Vendedor</h3>
                   <?php include_partial( 'inicio/graficaVenta', array()) ?>  
    
            </div>
                    </div>
        <div class="row">
            <div class="col-lg-6">
                <h3>Histórico Devoluciones</h3>
                <?php include_partial('inicio/grafica', array()) ?>  

            </div>

            <div class="col-lg-6">
                <h3>Ultimas Devoluciones</h3>
                <?php include_partial('inicio/grafica2', array()) ?>  
            </div> 
        </div>

    </div>
</div>
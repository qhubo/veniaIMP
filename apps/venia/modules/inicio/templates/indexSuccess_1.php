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

        <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-purple-soft">
                                            <span data-counter="counterup" data-value="<?php //echo $viviendas; ?>"><?php //echo $viviendas; ?></span>
                                        </h3>
                                        <small></small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
<!--                                    <div class="progress">
                                        <span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">
                                            <span class="sr-only">56% change</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> change </div>
                                        <div class="status-number"> 57% </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>

            
            
            

            
            
            
            
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="<?php echo $dia; ?>"><?php echo $dia; ?></span>
                                        </h3>
                                        <small> al Dia</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-like"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: <?php echo $porUno ?>%;" class="progress-bar progress-bar-success red-haze">
                                            <span class="sr-only"><?php echo $porUno ?>% </span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">  </div>
                                        <div class="status-number"> <?php echo $porUno ?>% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-red-haze ">
                                            <span data-counter="counterup" data-value="<?php echo $moroso; ?>"><?php echo $moroso; ?></span>
                                        </h3>
                                                  <font color="#F36A5A">
                                        <small> Morosas</small>
                                        </font>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-basket"></i>
                                    </div>
                                </div>
                            
                                <div class="progress-info">
                                    <div class="progress">
                                             
                                        <span style="width: <?php echo $porDos ?>%;" class="progress-bar progress-bar-success blue">
                                            <span class="sr-only"><?php echo $porDos ?>% </span>
                                        </span>
                                                 
                                    </div>
                                    <div class="status">
                                        <div class="status-title">  </div>
                                        <div class="status-number"> <?php echo $porDos ?>% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
          
            
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-green-sharp">
                                            <span data-counter="counterup" data-value="<?php echo $porPagar; ?>">
                                            <?php echo number_format($porPagar,2); ?>
                                            </span>
                                            <small class="font-green-sharp">Q</small>
                                        </h3>
                                        <small>Cuenta por Pagar Proveedores</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-pie-chart"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
<!--                                    <div class="progress">
                                        <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">76% progress</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> progress </div>
                                        <div class="status-number"> 76% </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
        <div class="row">
            <div class="col-lg-6"><br></div>
            
        </div>
        
        <div class="row">
                  <div class="col-lg-6">
                      <h3>Historico de pagos y cobros</h3>
                   <?php //include_partial( 'inicio/grafica2', array('condomi' => $condomi)) ?>  
    
            </div> 
            <div class="col-lg-6">
                <h3>Pagos Recibidos Mes</h3>
                   <?php //include_partial( 'inicio/grafica', array('condomi' => $condomi)) ?>  
    
            </div>
           
            
            
        </div>
    </div>
</div>


<!--
<link href="./assets/global/css/components-md.css" rel="stylesheet" type="text/css" />
     -->
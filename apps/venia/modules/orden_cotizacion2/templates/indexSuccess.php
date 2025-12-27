<?php $modulo = $sf_params->get('module'); ?>
<?php $estiloUno = ''; ?>
<?php $estiloDos = 'style="display:none;"'; ?>
<?php $vivienda = 1; ?>
<?php $tab = 1; ?>
<!-- <meta http-equiv="refresh" content="30">-->
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-coins kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-warning">
                CREA VENTA <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Procede a grabar la información solicitada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>
       <a href="<?php echo url_for( 'bodega_confirmo/index') ?>" class="btn btn-secondary btn-success" > <i class="flaticon-list-3"></i> Listado </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <?php if (!$id) { ?>

            <div class="row">
                <div class="col-lg-2"></div>
               
            </div>
         
         <div class="row">
                       <div   class=" <?php if ($pendientes >1) { ?>   scroller  <?php } ?> col-lg-8 "  <?php if ($pendientes >1) { ?> style="padding-top:5PX; height:150px; overflow-y: scroll; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1" <?php } ?> >
        

 <?php include_partial($modulo . '/inicia', array('pantalla'=>0, 'modulo' => $modulo, 'pendientes'=>$pendientes )) ?>

                       </div> 
              <div class="col-lg-2">
                    <span class=" kt-font-brand"><h5> NUEVA OPERACIÓN</h5> </span>
                </div>

                <div class="col-lg-2">                     
                    <a href="<?php echo url_for($modulo . '/nueva') ?>" class="btn btn-block btn-small btn-success btn-secondary" >  <i class="flaticon2-plus"></i> Nuevo </a>
                    <br>&nbsp;
                </div>
            </div>
        
       
 <?php } ?>
        <?php if ($id) { ?>
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                <li class="nav-item">
                    <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>General
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($tab == 3) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>Personalización
                    </a>
                </li>
                <?php if ($pendientes >1) { ?>
                  <li class="nav-item">
                    <a class="nav-link <?php if ($tab == 4) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_4_tab_content" role="tab" aria-selected="false">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>Pendientes
                    </a>
                </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <div class="tab-content"  <?php if (!$id) { ?> disabled="disabled" style="background-color:#F9FBFE" <?php } ?>  >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                <div class="row">
                    <div class="col-lg-12" style=" padding: 5px">
                        <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                            <?php include_partial($modulo . '/cabecera', array('orden' => $orden, 'cliente' => $cliente, 'id' => $id, 'form'=>$form)) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
                <?php include_partial($modulo . '/campoUsuario', array()) ?>            
            </div>
              
            <div class="tab-pane <?php if ($tab == 4) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_4_tab_content" role="tabpanel">
                   <?php include_partial($modulo . '/inicia', array('pantalla'=>1, 'modulo' => $modulo, 'pendientes'=>$pendientes )) ?>
           </div>
                        </div>
<!--        <div class="row">
            <div class="col-lg-12">
        
                <hr>
            </div>
        </div>-->
        <div class="row">
            <div class="col-lg-5">
                 <?php if ($id) { ?>
                <div class="row">
                    <div class="col-lg-12"> 
                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link   <?php if ($tablista == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_4_tab_content" role="tab" aria-selected="false">
                                    Productos 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  <?php if ($tablista == 2) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_5_tab_content" role="tab" aria-selected="false">
                                    Servicios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link   <?php if ($tablista == 3) { ?> active <?php } ?>" data-toggle="tab" href="#kt_portlet_base_demo_2_6_tab_content" role="tab" aria-selected="false">
                                    Combos
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane  <?php if ($tablista == 1) { ?> active <?php } ?>  " id="kt_portlet_base_demo_2_4_tab_content" role="tabpanel">
<?php if ($orden) { ?>    
                        <?php if (($orden->getNit()<> "") && ($orden->getNombre()<> "")) { ?>

     <?php include_partial('busca/ordenCotiProducto', array()) ?>  
                    
<?php } else { ?>
                        <h3>Debe completar los datos de cliente</h3>   
                        <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!--<script src="/js/buscadores.js" type="text/javascript"></script>-->
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<?php } ?>
<?php } ?>
                    </div>
                    <div class="tab-pane   <?php if ($tablista == 2) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_5_tab_content" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-10">
                               <?php include_partial($modulo.'/servicio', array('servicios'=>$servicios)) ?>  
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane  <?php if ($tablista == 3) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_6_tab_content" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-10">
                                <?php include_partial($modulo.'/otro', array('forma'=>$forma, 'tablista'=>$tablista)) ?>  
                       
                            </div>
                        </div>
                    </div>

                </div>
                 <?php } ?>

            </div>
            <div class="col-lg-7">                
                <?php include_partial($modulo . '/lista', array( 'edit'=>$edit, 'id'=>$id,'listado'=>$listado)) ?>      
            </div>
        </div>
             <?php include_partial($modulo . '/total', array('listado'=>$listado, 'modulo'=>$modulo, 'orden' => $orden, 'cliente' => $cliente, 'id' => $id, 'form'=>$form)) ?>
              
    </div>
</div>

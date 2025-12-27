<?php $modulo = $sf_params->get('module'); ?>
<?php $estiloUno = ''; ?>
<?php $estiloDos = 'style="display:none;"'; ?>
<?php $vivienda = 1; ?>



<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-coins kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                ORDEN DE COMPRA 
                  <?php if ($orden) { ?>
                        <?php  if ($orden->getEstatus() =="Autorizado") {  ?>
                AUTORIZADA
                        <?php } ?>
                        <?php } ?>
                
                <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Procede a grabar la información solicitada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>
        </div>
    </div>
    <div class="kt-portlet__body">
    
        <?php if (!$id) { ?>
        
         <?php include_partial($modulo . '/inicia', array('modulo' => $modulo, 'pendientes'=>$pendientes )) ?>
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
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>Información Adicional
                    </a>
                </li>
            </ul>
        <?php } ?>
        <div class="tab-content"  <?php if (!$id) { ?> disabled="disabled" style="background-color:#F9FBFE" <?php } ?>  >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                <div class="row">
                    <div class="col-lg-11" style=" padding: 5px">
                        <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                            <?php include_partial($modulo . '/proveedor', array('proveedoresl'=>$proveedores, 'orden' => $orden, 'provedorId'=>$provedorId,  'proveedor' => $proveedor, 'id' => $id, 'form'=>$form)) ?>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <?php if ($orden) { ?>
                        <?php  if ($orden->getEstatus() =="Autorizado") {  ?>
                      
                        <?php } else { ?>
<!--                            <a class="btn btn-outline-success "   href="<?php echo url_for('busca/indexPro?id=1') ?>"  data-toggle="modal" data-target="#ajaxmodalv">
                                <li class="fa fa-search"></li> Proveedor
                            </a>-->
                        <?php } ?>
                         
                        <?php } ?>
                    </div> 
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
                <?php include_partial($modulo . '/campoUsuario', array('aler'=>$aler)) ?>            
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <br>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
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
<!--                            <li class="nav-item">
                                <a class="nav-link   <?php if ($tablista == 3) { ?> active <?php } ?>" data-toggle="tab" href="#kt_portlet_base_demo_2_6_tab_content" role="tab" aria-selected="false">
                                    Otros
                                </a>
                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane  <?php if ($tablista == 1) { ?> active <?php } ?>  " id="kt_portlet_base_demo_2_4_tab_content" role="tabpanel">
                        <?php  include_partial('busca/ordenProducto', array()) ?>  
                    </div>
                    <div class="tab-pane   <?php if ($tablista == 2) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_5_tab_content" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-10">
                               <?php include_partial($modulo.'/servicio', array('servicios'=>$servicios)) ?>  
                            </div>
                        </div>

                    </div>
<!--                    <div class="tab-pane  <?php if ($tablista == 3) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_6_tab_content" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-10">
                                <?php include_partial($modulo.'/otro', array('forma'=>$forma, 'tablista'=>$tablista)) ?>  
                       
                            </div>
                        </div>
                    </div>-->

                </div>
                 <?php } ?>

            </div>
            <div class="col-lg-9">                
                <?php include_partial($modulo . '/lista', array('id'=>$id,'listado'=>$listado)) ?>      
            </div>
        </div>
             <?php  include_partial($modulo . '/total', array('listado'=>$listado, 'modulo'=>$modulo, 'orden' => $orden, 'proveedor' => $proveedor, 'id' => $id, 'form'=>$form)) ?>
              
    </div>
</div>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#cproveeedor").on('change', function () {
   
            var id = $("#cproveeedor").val();
               $.get('<?php  echo url_for("orden_compra/propiUp") ?>', {id: id}, function (response) {
                var respuestali = response;
                var arr = respuestali.split('|');
                var nombre = arr[0];
                var nit = arr[1];
                var credito =arr[2];
                $("#consulta_nit").val(nit);
                $("#consulta_nombre").val(nombre);
                $("#consulta_credito").val(credito);
            });


        });
    });
</script>



<?php if ($id) { ?>
    <script ty pe="text/javascript">
        $(document).ready(function () {
            $("#consulta_serie").on('change', function () {
                var id =<?php echo $id ?>;
                var val = $("#consulta_serie").val();
                var tip=1;
           
                $.get('<?php echo url_for("orden_gasto/actua") ?>', {val: val, id: id,tip:tip}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
   <script ty pe="text/javascript">
        $(document).ready(function () {
            $("#consulta_no_documento").on('change', function () {
                var id =<?php echo $id ?>;
                var val = $("#consulta_no_documento").val();
                var tip=2;
        
                $.get('<?php echo url_for("orden_gasto/actua") ?>', {val: val, id: id,tip:tip}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
  
   <script ty pe="text/javascript">
        $(document).ready(function () {
            $("#consulta_proveedor").on('change', function () {
                var id =<?php echo $id ?>;
                var val = $("#consulta_proveedor").val();
                var tip=3;
     
                $.get('<?php echo url_for("orden_gasto/actua") ?>', {val: val, id: id,tip:tip}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
   <script ty pe="text/javascript">
        $(document).ready(function () {
            $("#consulta_observaciones").on('change', function () {
                var id =<?php echo $id ?>;
                var val = $("#consulta_observaciones").val();
                var tip=4;
              
                $.get('<?php echo url_for("orden_gasto/actua") ?>', {val: val, id: id,tip:tip}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
    <script ty pe="text/javascript">
        $(document).ready(function () {
            $("#consulta_dia_credito").on('change', function () {
                var id =<?php echo $id ?>;
                var val = $("#consulta_dia_credito").val();
                var tip=5;
              
                $.get('<?php echo url_for("orden_gasto/actua") ?>', {val: val, id: id,tip:tip}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
     <script ty pe="text/javascript">
        $(document).ready(function () {
            $("#consulta_fecha_documento").on('change', function () {
                var id =<?php echo $id ?>;
                var val = $("#consulta_fecha_documento").val();
                var tip=6;
     
                $.get('<?php echo url_for("orden_gasto/actua") ?>', {val: val, id: id,tip:tip}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
<?php } ?>
 
 
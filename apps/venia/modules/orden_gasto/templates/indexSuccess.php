<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
    <?php $estiloUno = ''; ?>
<?php $estiloDos = 'style="display:none;"'; ?>
<?php $vivienda = 1; ?>


<?php echo $form->renderFormTag(url_for($modulo . '/index?id=' . $id_detalle), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-interface-9 kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                INGRESO DE GASTOS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Procede a grabar la información solicitada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php if (!$id) { ?>

            <?php include_partial($modulo . '/inicia', array('modulo' => $modulo, 'pendientes' => $pendientes)) ?>
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
            </ul>
        <?php } ?>
        <div class="tab-content"  <?php if (!$id) { ?> disabled="disabled" style="background-color:#F9FBFE" <?php } ?>  >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                <div class="row">
                    <div class="col-lg-11" style=" padding: 5px">
                        <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                            <?php 
                            
                            include_partial($modulo . '/cabecera', array(
                                'detalles'=>$detalles,
                                'id_detalle'=>$id_detalle,
                                'agrega'=>$agrega,
                                'orden' => $orden, 'id' => $id, 'form' => $form))
                                    
                                    ?>
                        </div>
                    </div>
                    <div class="col-lg-1">

                    </div> 
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
                <?php include_partial($modulo . '/campoUsuario', array()) ?>            
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <br>
                <hr>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">                
                <?php 
                include_partial($modulo . '/linea', array(
                    'subtotal'=>$subtotal,
                    'iva'=>$iva,
                    'agrega'=>$agrega,
                    'id_detalle'=>$id_detalle,
                    'muestalinea'=>$muestalinea, 'modulo'=>$modulo, 'detalles'=>$detalles, 'orden'=>$orden, 'modulo' => $modulo, 'form' => $form)) 
                        
                        ?>

            </div>
        </div>
        <?php if ($orden) { ?>
            <div class="row"   style="background-color:#F9FBFE " >

                <div class="col-lg-2" >  <div style="text-align:right"> Observaciones</div> </div>
                <div class="col-lg-8 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                    <?php echo $form['observaciones'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['observaciones']->renderError() ?>  
                    </span>
                </div>
               
            </div> <?php } ?>       
        <?php if ($orden) { ?>
 <?php if ($orden->getValorTotal() >0) { ?>
        <?php include_partial($modulo . '/total', array('modulo'=>$modulo, 'orden' => $orden, 'proveedor' => $proveedor, 'id' => $id, 'form'=>$form)) ?>
        <?php } ?>
        <?php  } ?>
    </div>

</div>


<?php echo '</form>'; ?>
<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>



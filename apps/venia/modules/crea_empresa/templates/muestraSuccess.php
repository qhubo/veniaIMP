<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand"> EMPRESA
                <?php if ($registro) { ?>  Editar <?php echo $registro->getCodigo(); ?> <?php } else { ?>
                    Nuevo
                <?php } ?>
                <small>  &nbsp;&nbsp;&nbsp;&nbsp; Completa la información solicitada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a target="_blank" href="<?php echo url_for($modulo . '/respaldo') ?>" class="btn btn-sm btn-info btn-secondary" > <i class="flaticon2-download"></i> Respaldo </a>&nbsp;&nbsp;&nbsp;
      
            <?php if ($registro) { ?>
                <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a>
            <?php } ?>
            <a href="<?php echo url_for($modulo . '/index?lista=1') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <div class="kt-portlet__body">
              <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>General
                </a>
            </li>

<!--            <li class="nav-item">
                <a class="nav-link <?php if ($tab == 2) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_2_2_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Configuración
                </a>
            </li>-->

                <li class="nav-item">
                <a class="nav-link <?php if ($tab == 3) { ?> active <?php } ?>  " data-toggle="tab" href="#kt_portlet_base_demo_3_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Personalización
                </a>
            </li>
        </ul>
        
          <div class="tab-content">
              <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
      <?php include_partial($modulo.'/general', array('urlImagen'=>$urlImagen, 'form'=>$form,'id'=>$id,'modulo'=>$modulo)) ?>  
              </div>
          <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_2_tab_content" role="tabpanel">
     <?php include_partial($modulo.'/configura', array('urlImagen'=>$urlImagen, 'form'=>$form,'id'=>$id,'modulo'=>$modulo)) ?>  
  
          </div>
          <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
     <?php include_partial($modulo.'/personaliza', array('urlImagen'=>$urlImagen,  'form'=>$form,'id'=>$id,'modulo'=>$modulo)) ?>  
  
          </div>
        
          </div>
        
        <div class="row">
            <div class="col-lg-1"> <br></div>
        </div>
        <?php // include_partial($modulo.'/cliente', array('muestraEmpresa'=>false, 'muestraGas'=>false, 'id'=>$id, 'usuario' => $usuario, 'form' => $form)) ?>
        <div class="row">
            <div class="col-lg-8"> </div>

            <div class="col-lg-1 <?php if ($form['activo']->hasError()) echo "has-error" ?>">
          
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i>
                    <span> Aceptar  </span>
                </button>
            </div>
        </div>

    </div>
</div>
<?php echo '</form>'; ?>

 <script src="./assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
 <script>
                $(document).ready(function () {
                    $("#consulta_departamento").on('change', function () {
                        $("#consulta_municipio").empty();
                        $.getJSON('<?php echo url_for("soporte/dptoMunicipio") ?>?id=' + $("#consulta_departamento").val(), function (data) {
                            console.log(JSON.stringify(data));
                            $.each(data, function (k, v) {
                                
                                 if (k == "") {
$("#consulta_municipio").append("<option selected='selected'   value=\"" + k + "\">" + v + "</option>");
                            } else {
                                $("#consulta_municipio").append("<option value=\"" + k + "\">" + v + "</option>");
                            }
                                
                            }).removeAttr("disabled");
                        });
                    });
                });
            </script>


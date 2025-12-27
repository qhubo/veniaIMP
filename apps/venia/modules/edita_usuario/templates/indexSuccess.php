<?php $modulo = $sf_params->get('module'); ?>
<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-users-1 kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Listado de Usuarios  <small> Puedes crear un nuevo usuario acción NUEVO &nbsp;&nbsp;&nbsp;&nbsp;</small>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/muestra') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> NUEVO </a>

        </div>
    </div>
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Administradores
                        </a>
                    </li>
          
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_portlet_base_demo_2_2_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>Usuarios
                            </a>
                        </li>
             

                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">

            <div class="tab-content">
                <div class="tab-pane" id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
             <?php include_partial($modulo . '/lista', array( 'modulo' => $modulo, 'usuarioId'=>$usuarioId, 'usuarios' => $usuarios)) ?>
                </div>
                <div class="tab-pane  active " id="kt_portlet_base_demo_2_2_tab_content" role="tabpanel">
      <?php  include_partial($modulo . '/listaVen', array( 'modulo' => $modulo, 'usuarioId'=>$usuarioId, 'usuarios' => $vendedores)) ?>
       
                </div>

            </div>      


        </div>
    </div>
</div>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

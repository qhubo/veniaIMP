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
                CREA PEDIDO <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Procede a grabar la información solicitada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php if ($orden) { ?>  <font size="+2"> <strong> <?php echo $orden->getCodigo(); ?>  </strong> </font> <?php } ?>
<!--            <a href="<?php echo url_for('bodega_confirmo/index') ?>" class="btn btn-secondary btn-success" > <i class="flaticon-list-3"></i> Listado </a>-->

        </div>
    </div>
    <div class="kt-portlet__body">
        <?php if ($pendientes > 0) { ?>

            <div class="row">
                <div class="col-lg-2"></div>

            </div>

            <div class="row">
                <div   class=" col-lg-8 "  >
                    <table class="table bordered">
                        <tr>
                            <td style="text-align:right; font-weight: bold; font-size: 18px;">Pedidos en Proceso</td>
                            <td style="text-align: center; font-size: 18px;"><?php echo count($pendientes); ?> </td>
                            <td>
                                   <a href="<?php echo url_for('pedido_pendiente/index') ?>" class="btn btn-dark " > <i class="flaticon-list-3"></i> Listado </a>

                                
                            </td>
                        </tr>
                    </table>

                    <?php //include_partial($modulo . '/inicia', array('pantalla' => 0, 'modulo' => $modulo, 'pendientes' => $pendientes)) ?>

                </div> 
                <div class="col-lg-2">
                    <span class=" kt-font-brand"><h5> NUEVO PEDIDO</h5> </span>
                </div>

                <div class="col-lg-2">                     
                    <a href="<?php echo url_for($modulo . '/nueva') ?>" class="btn btn-block btn-small btn-success btn-secondary" >  <i class="flaticon2-plus"></i> Nuevo </a>
                  
                         <?php if ($id) { ?>
                            <a class="btn btn-block btn-outline-success "   href="<?php echo url_for('busca/indexCliente?id=1') ?>"  data-toggle="modal" data-target="#ajaxmodalv">
                                <li class="fa fa-search"></li> Cliente
                            </a>
                        <?php } ?>
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
                <?php if ($pendientes > 1) { ?>
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
                            <?php include_partial($modulo . '/cabecera', array('pendientes' => $pendientes, 'orden' => $orden, 'cliente' => $cliente, 'id' => $id, 'form' => $form)) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane <?php if ($tab == 3) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_3_tab_content" role="tabpanel">
                <?php include_partial($modulo . '/campoUsuario', array()) ?>            
            </div>

            <div class="tab-pane <?php if ($tab == 4) { ?> active <?php } ?> " id="kt_portlet_base_demo_3_4_tab_content" role="tabpanel">
                <?php include_partial($modulo . '/inicia', array('pantalla' => 1, 'modulo' => $modulo, 'pendientes' => $pendientes)) ?>
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
<!--                                <li class="nav-item">
                                    <a class="nav-link   <?php if ($tablista == 3) { ?> active <?php } ?>" data-toggle="tab" href="#kt_portlet_base_demo_2_6_tab_content" role="tab" aria-selected="false">
                                        Combos
                                    </a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane  <?php if ($tablista == 1) { ?> active <?php } ?>  " id="kt_portlet_base_demo_2_4_tab_content" role="tabpanel">


                            <?php if ($orden) { ?>    
                                <?php if (($orden->getNit() <> "") && ($orden->getNombre() <> "")) { ?>
                                    <?php include_partial('busca/ordenCotiProductoTodas', array()) ?>  
                                <?php } else { ?>
                                    <h3>Debe completar los datos de cliente</h3>   

                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="tab-pane   <?php if ($tablista == 2) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_5_tab_content" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-10">
                                    <?php include_partial($modulo . '/servicio', array('servicios' => $servicios)) ?>  
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane  <?php if ($tablista == 3) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_6_tab_content" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-10">
                                    <?php include_partial($modulo . '/otro', array('forma' => $forma, 'tablista' => $tablista)) ?>  

                                </div>
                            </div>
                        </div>

                    </div>
                <?php } ?>

            </div>
            <div class="col-lg-7">                
                <?php include_partial($modulo . '/lista', array('edit' => $edit, 'id' => $id, 'listado' => $listado)) ?>      
            </div>
        </div>
        <?php include_partial($modulo . '/total', array('listado' => $listado, 'modulo' => $modulo, 'orden' => $orden, 'cliente' => $cliente, 'id' => $id, 'form' => $form)) ?>

    </div>
</div>


<!-- SCRIPTS (sólo una vez en la página) -->
<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->

<!-- MODAL: estructura fija con un modal-body donde inyectaremos el HTML -->
<div class="modal fade" id="ajaxmodalPro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:750px">
    <div class="modal-content" style="width:750px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
        <h4 class="modal-title">Detalle</h4>
      </div>

      <!-- CONTENEDOR DINÁMICO -->
      <div class="modal-body" id="ajaxModalBody">
        <!-- Aquí se cargará la respuesta de la URL -->
      </div>

<!--      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>-->
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<!-- EJEMPLOS DE BOTONES (cada uno tiene su data-url) -->
<!--<button class="open-producto btn btn-primary" data-url="/venia_dev.php/ubicacion/vista?id=2">Abrir 123</button>
<button class="open-producto btn btn-success" data-url="/venia_dev.php/ubicacion/vista?id=4">Abrir 456</button>-->

<!-- HTML del modal y botones (igual que lo tienes) -->
<div class="modal fade" id="ajaxmodalPro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:750px">
    <div class="modal-content" style="width:750px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
        <h4 class="modal-title">Detalle</h4>
      </div>

      <!-- CONTENEDOR DINÁMICO -->
      <div class="modal-body" id="ajaxModalBody">
        <!-- Aquí se cargará la respuesta de la URL -->
      </div>

<!--      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>-->
    </div>
  </div>
</div>


<!-- Script: pega esto después de cargar jQuery y Bootstrap -->
<script>
(function($){
  var modal = $('#ajaxmodalPro');
  var modalBody = $('#ajaxModalBody');
  var lastTrigger = null;
  var currentXhr = null;

  // Guardar trigger cuando se abre con show.bs.modal (útil si usas data-toggle)
  modal.on('show.bs.modal', function (e) {
    lastTrigger = (e && e.relatedTarget) ? e.relatedTarget : document.activeElement;
  });

  // Manejo de cierre: quitar foco antes de que se ponga aria-hidden
  modal.on('hide.bs.modal', function () {
    try {
      var focused = modal.find(':focus');
      if (focused && focused.length) focused.blur();

      if (lastTrigger && $(lastTrigger).is(':visible')) {
        $(lastTrigger).focus();
      } else {
        $('body').focus();
      }
    } catch(e) {
      console.warn('Error moviendo foco al cerrar modal', e);
    }
  });

  // Limpia solo el body al ocultar
  modal.on('hidden.bs.modal', function () {
    if (modalBody && modalBody.length) modalBody.empty();
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
  });

  // Función que carga URL y muestra modal (con cache-bust y abort si hay petición en curso)
  function abrirModalUrl(url, trigger) {
    // abort previo
    if (currentXhr && currentXhr.readyState !== 4) {
      currentXhr.abort();
      currentXhr = null;
    }

    lastTrigger = trigger || document.activeElement;

    // Indicador de carga inmediato
    modalBody.html('<div class="text-center" style="padding:20px">Cargando…</div>');

    var urlNoCache = url + (url.indexOf('?') === -1 ? '?' : '&') + '_=' + Date.now();

    currentXhr = $.ajax({
      url: urlNoCache,
      method: 'GET',
      dataType: 'html',
      cache: false,
      timeout: 15000
    });

    currentXhr.done(function(html){
      modalBody.html(html);
      // mostrar modal (Bootstrap gestiona aria-hidden/backdrop)
      modal.modal('show');

      // intentar enfocar primer elemento dentro del modal
      setTimeout(function(){
        var focusable = modal.find('button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])')
                            .filter(':visible').first();
        if (focusable.length) focusable.focus();
      }, 50);
    });

    currentXhr.fail(function(jqXHR, textStatus){
      if (textStatus !== 'abort') {
        modalBody.html('<div class="text-danger">Error cargando contenido. Intenta nuevamente.</div>');
        modal.modal('show');
        console.error('Error al cargar modal:', textStatus, jqXHR.status);
      }
    });

    currentXhr.always(function(){ currentXhr = null; });
  }

  // Delegación: cualquier elemento con .open-producto data-url abrirá el modal
  $(document).on('click', '.open-producto', function(e){
    e.preventDefault();
    var url = $(this).data('url');
    if (!url) {
      console.warn('open-producto sin data-url');
      return;
    }

    // Previene doble-click rápido
    if ($(this).data('loading')) return;
    $(this).data('loading', true);
    setTimeout(() => $(this).removeData('loading'), 1000);

    abrirModalUrl(url, this);
  });

  // Exporta función global por si la llamas desde otro lugar
  window.abrirModalProducto = function(urlOrId){
    var url = urlOrId;
    // Si solo quieres pasar ID, transforma aquí:
    // url = '/venia_dev.php/ubicacion/vista?id=' + encodeURIComponent(urlOrId);
    abrirModalUrl(url, null);
  };

})(jQuery);
</script>


<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<div class="modal fade" id="ajaxmodalPro" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content" style=" width: 750px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Detalle de Producto</h4>
            </div>
        </div>
    </div>
</div>-->



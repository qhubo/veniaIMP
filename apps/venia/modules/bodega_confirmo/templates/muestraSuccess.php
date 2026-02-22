<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte de Pedidos Realizados
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

                               <a href="#"
   class="btn btn-block btn-small btn-success btn-secondary"
   data-toggle="modal"
   data-target="#modalSerie">
   <i class="flaticon2-plus"></i> Nuevo Pedido
</a>
            
        </div>
    </div>


    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link"  href="<?php echo url_for('pedido_pendiente/index') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Pedidos en Proceso  </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content" >
            <?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=1'), array('class' => 'form-horizontal"')) ?>
            <?php echo $form->renderHiddenFields() ?>
            <div class="row"  style="padding-bottom:10px;">
                <label class="col-lg-1 control-label right "> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right ">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-3">
                    <?php echo $form['usuario'] ?> 
                </div>
                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
            <?php echo '</form>'; ?>
            <div class="row">
                <div class="col-lg-10">  </div>
                <div class="col-lg-2">				
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-checkable dataTable no-footer kt-datatable" xid="html_table" width="100%">
                <thead class="flip-content">
                    <tr class="active">
                        <th align="center" width="20px"> Código</th>
                        <th align="center" width="20px">Fecha</th>
                        <th  align="center"> Cliente</th>
                       
                        <th  align="center"> Estado</th>
                        <th  align="center"> Valor</th>    
                                        
                        <th width="25px">Reporte</th>
                     
                       <th align="center" width="20px">Usuario</th>
                        <th  align="center"> RUC</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($operaciones as $lista) { ?>
                        <?php $total = $lista->getValorTotal() + $total; ?>
                 
                        <tr>     
                            <td>
                                <?php echo $lista->getCodigo() ?>  
                            </td>
                            <td><font size="-2"><?php echo $lista->getFecha('d/m/Y H:i') ?></font>  </td>

                            <td>  <font size="-1"><?php echo $lista->getNombre() ?></font>  </td>
                
                            <td>  <font size="-1"><?php echo $lista->getEstatus() ?>  </font>  </td>
                            <td style="text-align:right">  <font size="-1"><?php echo Parametro::formato($lista->getValorTotal()) ?>  </font>  </td>

                            <td>
                                           <a target="_blank" href="<?php echo url_for('reporte/ordenCotizacion?token='.$lista->getToken()) ?>" class="btn btn-sm btn-block btn-warning" > 
      <i class="flaticon2-printer"></i>
                                        </a>
                                
                                                     <a target="_blank" href="<?php echo url_for('reporte_excel/pedido?id=' . $lista->getId()) ?>" class="btn btn-block  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte </a>
        
                            </td>
                      
                      

                              <td> <font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                                        <td>  <font size="-1"><?php echo $lista->getNit() ?></font>  </td>
                    </tr>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                <td  class="info" colspan="4"></td>
                <th  class="active" > Totales</th>
                <th class="active" style="text-align:right"><?php echo Parametro::formato($total); ?> </th>
                <td class="info">   </td>
                </tfoot>
            </table>
        </div>
    </div>
</div>

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

<div id="modalSerie" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Seleccionar Tipo Serie Documento</h4>
      </div>
        <?php $idOp=0; ?>

        <input type="hidden" value="<?php  echo $idOp ?>" id="ope" name="ope" > 
<?php    $CAMPOuSUARIO = CampoUsuarioQuery::create()->findOneByNombre("SERIECOTI"); ?>
        <?php if ($CAMPOuSUARIO) { ?>
<?php          $lista=$CAMPOuSUARIO->getValores(); ?>
<?php          $lista = explode(",", $lista); ?>
     
      <div class="modal-body">
          <div class="row">
              <div class="col-lg-1"></div>
              <div class="col-lg-2" style="font-weight:bold; font-size: 14px">Tipo Serie</div>
             <div class="col-lg-3">  
                 <select id="tipoSerie" class="form-control">
            <option value="">-- Seleccione --</option>
            <?php foreach($lista as $de) { ?>
            <option value="<?php echo $de; ?>"> <?php echo $de; ?> </option>
            <?php } ?>

        </select>
             </div> 
          </div>
      </div>
        <?php } ?>

      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-success" id="btnContinuar">Continuar</button>
      </div>

    </div>
  </div>
</div>


<script>
document.getElementById("btnContinuar").addEventListener("click", function () {

    var tipo = document.getElementById("tipoSerie").value;
var ope=document.getElementById("ope").value;
    if (tipo === "") {
        alert("Seleccione un tipo de serie");
        return;
    }

    // redirigir enviando parámetro
    window.location.href =
        "<?php echo url_for( 'orden_cotizacion/nueva') ?>?tipo_serie=" + tipo+ "&id=" + ope;
});
</script>
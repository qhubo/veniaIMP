<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')   ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $muestrabusqueda = sfContext::getInstance()->getUser()->getAttribute('muestrabusqueda', null, 'busqueda'); ?>
<?php $linea = unserialize(sfContext::getInstance()->getUser()->getAttribute('carga', null, 'busqueda')); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-tag  kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                Ingresos de Inventarios <small>   puedes filtrar tu busqueda  <strong> Unicamente se actualizaran los productos afecto inventario </strong>    </small>
            </h3>
        </div>
        
                <div class="kt-portlet__head-toolbar">
                    <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-dark" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
                </div>
            
    </div>
    <div class="kt-portlet__body">

            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link   active  " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Actualiza Inventario
                        </a>
                    </li>
               
                    <li class="nav-item">
                        <a class="nav-link   " href="<?php echo url_for($modulo . '/historial') ?>" role="tab" aria-selected="false">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
      <div class="row" style="padding-top:5px">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right ">TIENDA  </label>
         <div class="col-lg-4 <?php if ($form['tienda']->hasError()) echo "has-error" ?>">
                <?php echo $form['tienda'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tienda']->renderError() ?>  
                </span>
            </div>
              <div class="col-lg-2"> </div>   
               <div class="col-lg-2">
                        <a href="<?php echo url_for("carga/index?tipo=existencia") ?>" class="btn btn-success btn-sm btn-block btn-hover-brand" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa fa-cloud-download"></li> Importar archivo   </a>
               </div>
        
        </div>
        
     
        <div class="row" style="padding-top:5px">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::tipo(); ?>  </label>
            <div class="col-lg-4 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
       
                <div class="col-lg-3">
                         <?php if ($muestrabusqueda) { ?>
                    <font color="#9eacb4" size="2px">   No Productos Total&nbsp;&nbsp;<strong> <?php echo $total ?> </strong> </font>
                <?php } ?>
                </div>
            
            
        </div>
     <div class="row" style="padding-top:5px">
            <div class="col-lg-1"> </div>        
            <label class="col-lg-1 control-label right "><?php echo TipoAparatoQuery::marca(); ?>  </label>
            <div class="col-lg-4 <?php if ($form['marca']->hasError()) echo "has-error" ?>">
                <?php echo $form['marca'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['marca']->renderError() ?>  
                </span>
            </div>

           
                <div class="col-lg-3">
                     <?php if ($muestrabusqueda) { ?>
                    <font color="#9eacb4" size="2px">   No Productos Busqueda&nbsp;&nbsp;<strong> <?php echo $totalB ?></strong> </font>
                 <?php } ?>            
                </div>
            <div class="col-lg-2">

                <button class="btn btn-warning btn-black btn-sm " type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
            </div>
         
        </div>
    
    </div>
</div>

<?php echo '</form>'; ?>
<?php include_partial('actualiza_inventario/detalle', array('pere'=>$pere, 'bodega'=>$bodega, 'modulo'=>$modulo,  'forma'=>$forma,  'muestrabusqueda' => $muestrabusqueda, 'bodegaId' => $bodegaId, 'linea' => $linea, 'productos' => $productos)) ?>


<?php foreach ($productos as $lis) { ?>
    <?php $id = $lis->getId(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#registro_numero_<?php echo $id ?>").on('change', function () {
                var id = $("#registro_numero_<?php echo $id ?>").val();
                var antes = $("#res_<?php echo $id ?>").val();
                var valor = $("#res_total").val();
                var estado = $("#estado").val();
                var resultado = parseInt(valor) - parseInt(antes) + parseInt(id);
                $("#res_total").val(resultado);
                $("#res_<?php echo $id ?>").val(id);
                var idv = <?php echo $id ?>;
                $.get('<?php echo url_for("actualiza_inventario/cantidad") ?>', {id: id, idv: idv}, function (response) {
                    $("#total_<?php echo $id ?>").html(response);
                });
                if (estado == 0) {
                    if (resultado > 0) {
                        $('#procesar').show();
                        $("#estado").val(1);
                    }
                }
                if (estado == 1) {
                    if (resultado == 0) {
                        $('#procesar').hide();
                        $("#estado").val(0);

                    }
                }


            });

        });
    </script>

    <script>
        function validate<?php echo $id ?>(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-8]|\9/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }
    </script>
<?php } ?>
<script>
    $(document).ready(function () {
        $("#consulta_tipo").on('change', function () {
            //    alert('cambio');
            $("#consulta_marca").empty();
            $("#consulta_producto_id").empty();
            $.getJSON('<?php echo url_for("soporte/tipoMarca") ?>?id=' + $("#consulta_tipo").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#consulta_marca").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
                   $.getJSON('<?php echo url_for("soporte/tipoMarcaModelo") ?>?id=' + $("#consulta_tipo").val(), function (data) {
                   $("#consulta_modelo").empty();
                $.each(data, function (k, v) {
                   $("#consulta_modelo").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
        });
    });
</script>



<script>
    $(document).ready(function () {
        $("#consulta_marca").on('change', function () {
            //    alert('cambio');
            $("#consulta_modelo").empty();
            $("#consulta_producto_id").empty();
            $.getJSON('<?php echo url_for("soporte/marcaModelo") ?>?id=' + $("#consulta_marca").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {
                    $("#consulta_modelo").append("<option value=\"" + k + "\">" + v + "</option>");
                }).removeAttr("disabled");
            });
       
        });
    });
</script>

<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px">
        <div class="modal-content" style=" width: 700px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
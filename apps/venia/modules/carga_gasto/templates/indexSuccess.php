<?php $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa'); ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<?php $modulo = $sf_params->get('module'); ?>
<?php     
$vboedgas = CuentaErpContableQuery::create()
                ->orderByCuentaContable('Asc')
                 ->where('length(CuentaErpContable.CuentaContable) >6 ')
                ->find();
        $listaCuenta[null] = '[Seleccione]';
        foreach ($vboedgas as $registro) {
            $listaCuenta[$registro->getCuentaContable()] = "[" . $registro->getCuentaContable() . "] " . $registro->getNombre();
        }
  ?>

<?php $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seledatos', null, 'carga')); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Ingreso de gastos varios <small> utiliza esta opción para la carga de ingresos mediante plantilla excel </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-secondary btn-hover-brand" > <i class="flaticon-download-1"></i> Archivo Modelo Carga  </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        
               <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link   active " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Ingreso
                        </a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link "  href="<?php echo url_for('reporte_gastoc/index') ?>" >
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                        </a>
                    </li>
                </ul>
        
        
          <form action="<?php echo url_for($modulo . '/index?id=0') ?>" method="post">
        <div class="row" style="padding-bottom:5px;">
   
        <div class="col-lg-1" >Tienda</div>  
            <div class="col-lg-4">
            <select   class="form-control"  name="tiendaver" id="tiendaver">
                <option value="">[Seleccione Tienda]</option>
                <?php foreach ($tiendas as $lista) { ?>
                <option <?php if ($gasto->getTiendaId() == $lista->getId()) { ?> selected="selected"  <?php } ?>  value="<?php echo $lista->getId(); ?>"><?php echo $lista->getNombre(); ?></option>
                <?php } ?>
            </select>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-1 ">Fecha</div>  
            <div class="col-lg-2 ">
                <input class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="re_fecha" value="<?php echo $gasto->getFecha('d/m/Y'); ?>" id="re_fecha">           
            </div>
            <div class="col-lg-1 ">Monto</div>  
            <div class="col-lg-2 ">
                <input class="form-control"  disabled="" <?php if ($gasto->getValor() >0) { ?>  value="<?php echo $gasto->getValor(); ?>" <?php } ?>  placeholder="0" onkeypress="validate(event)"  type="text" name="re_valor" id="re_valor">
            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-2">   
                <a href="<?php echo url_for("carga/index?tipo=cargagasto") ?>" class="btn btn-dark" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa flaticon-upload"></li> Importar archivo   </a>
            </div>
        </div>
        <div class="row"  style="padding-top:5px;">
            <div class="col-lg-1 ">Concepto</div>  
            <div class="col-lg-5">
                <textarea rows="2" cols="30" class="form-control noEditorMce" name="re_observacion" id="re_observacion" spellcheck="false"><?php echo $gasto->getConcepto(); ?></textarea>
            </div>
        </div>
            <div class="row" style="padding-bottom:5px;">
   

        <div class="col-lg-9"></div>
                     <?php if ($valores) { ?>
        <div class="col-lg-1">
              <a href="<?php echo url_for($modulo.'/limpia') ?>" class="btn btn-sm btn-block  btn-secondary btn-danger" > <i class="flaticon2-trash"></i>  </a>
  </div>
                     <?php } ?>
        
        </div>
        <div class="row"  style="padding-top:10px;">

            <table class="table table-bordered  dataTable table-condensed flip-content" >
                <thead class="flip-content">
                    <tr class="active">
                        <th align="center" width="20px"><font size="-1"> SERIE FACTURA</font></th>
                      <th align="center" width="20px"><font size="-1">FECHA</font></th>
                        <th align="center" ><font size="-1">DESCRIPCION</font></th>
                        <th align="center" ><font size="-1">CODIGO PROVEEDOR</font></th>
                        <th align="center" ><font size="-1">PROVEEDOR</font></th>
                        <th align="center" ><font size="-1">CUENTA</font></th>
                        <th align="center" ><font size="-1">NOMBRE CUENTA</font></th>
                        <th align="center" ><font size="-1"> VALOR</font></th>
                        <th align="center" ><font size="-1"> IVA</font></th>
                        <th align="center" ><font size="-1">ISR RETENIDO</font></th>
                        <th align="center" ><font size="-1"> IVA RETENIDO</font></th>
                         <th align="center" ><font size="-1"> APLICA IVA</font></th>
                        <th align="center" ><font size="-1">RETIENE ISR</font></th>
                        <th align="center" ><font size="-1"> EXENTO ISR</font></th>
                         <th align="center" ><font size="-1"> IDP</font></th>
                    </tr>
                </thead>
                <?php if ($valores) { ?>
                    <tbody>
                        <?php foreach ($valores as $registro) { ?>
                            <tr <?php if (!$registro['VALIDO']) { ?> style="background-color: #F8ED82" <?php } ?>>
                                <td><font size="-1"><?php echo $registro['SERIE']; ?><BR>
                                  <?php echo $registro['FACTURA']; ?></font></td>
                                <td><font size="-1"><?php echo $registro['FECHA']; ?></font></td>
                                <td><font size="-1"><?php echo $registro['DESCRIPCION']; ?></font></td>
                                <td><font size="-1"><?php echo $registro['CODIGO_PROVEEDOR']; ?></font></td>
                                <td><font size="-1"><?php echo $registro['PROVEEDOR']; ?></font></td>
                                <td><font size="-1"><?php echo $registro['CUENTA']; ?></font></td>
                                <td><font size="-1"><?php echo $registro['NOMBRE_CUENTA']; ?></font></td>
                                <td  style="text-align: right"><font size="-1"><?php echo Parametro::formato($registro['VALOR'],false); ?></font></td>
               <td  style="text-align: right"><font size="-1"><?php echo Parametro::formato($registro['IVA'],false); ?></font></td>
                                <td  style="text-align: right"><font size="-1"><?php echo Parametro::formato($registro['VALOR_ISR'],false); ?></font></td>
                                    <td  style="text-align: right"><font size="-1"><?php echo Parametro::formato($registro['VALOR_RETIENE_IVA'],false); ?></font></td>
                                    <td  style="text-align: center"><font size="-1"><?php  if ($registro['APLICA_IVA']) { ?> <li class="fa fa-check"></li> <?php } ?></font></td>
              <td style="text-align: center"><font size="-1"><?php  if ($registro['RETIENE_ISR']) { ?> <li class="fa fa-check"></li> <?php } ?></font></td>
                       
            <td style="text-align: center"><font size="-1"><?php  if ($registro['EXENTO_ISR']) { ?> <li class="fa fa-check"></li> <?php } ?></font></td>
                                         <td><font size="-1"><?php echo $registro['IDP']; ?></font></td>                         
</tr>
                        <?php } ?>
                    </tbody>
          <?php } ?>

            </table>
        </div>
             <?php if ($valores) { ?>
        <div class="row">
            <div class="col-lg-4"></div>
            
             <div class="col-lg-1">Cuenta</div>
             <div class="col-lg-4">
               <select   class="form-control mi-selector"  name="cuentaid" id="cuentaid">
                <option value="">[Seleccione Cuenta]</option>
                <?php foreach ($listaCuenta as $value=>$key) { ?>
                <option <?php if ($gasto->getCuenta() == $value) { ?> selected="selected"  <?php } ?>  value="<?php echo $value; ?>"><?php echo $key; ?></option>
                <?php } ?>
            </select>
             </div>
            <div class="col-lg-2">
                <button class="btn-block btn-success btn " type="submit">
                    <i class="fa fa-save "></i>
                    Confirmar
                </button>
<!--                 <a class="btn btn-block  btn-xs btn-info" data-toggle="modal" href="#staticC">Confirmar </a>-->
            </div>
        </div>
                  <?php } ?>
          </form>

    </div>
</div>    


<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

         <div id="staticC" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmar Ingresos</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro confirma el listado
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php //echo $lista->getUsuario() ?>
                                    </span> ?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn green " href="<?php echo url_for($modulo . '/confirmar') ?>" >
                                    <i class="fa fa-trash-o "></i> Confirmar</a> 
                            </div>
                        </div>
                    </div>
                </div> 


<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
-->

<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
        $(document).ready(function () {
            $("#tiendaver").on('change', function () {
                var id =<?php echo $gasto->getId() ?>;
                var val = $("#tiendaver").val();
                $.get('<?php echo url_for("carga_gasto/tienda") ?>', {val: val, id: id}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
    
    
 
 <script type="text/javascript">
        $(document).ready(function () {
            $("#re_fecha").on('change', function () {
                var id =<?php echo $gasto->getId() ?>;
                var val = $("#re_fecha").val();
                $.get('<?php echo url_for("carga_gasto/fecha") ?>', {val: val, id: id}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

  <script type="text/javascript">
        $(document).ready(function () {
            $("#re_valor").on('change', function () {
                var id =<?php echo $gasto->getId() ?>;
                var val = $("#re_valor").val();
                $.get('<?php echo url_for("carga_gasto/valor") ?>', {val: val, id: id}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

   <script type="text/javascript">
        $(document).ready(function () {
            $("#re_observacion").on('change', function () {
                var id =<?php echo $gasto->getId() ?>;
                var val = $("#re_observacion").val();
                $.get('<?php echo url_for("carga_gasto/observacion") ?>', {val: val, id: id}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
 
   <script type="text/javascript">
        $(document).ready(function () {
            $("#cuentaid").on('change', function () {
                var id =<?php echo $gasto->getId() ?>;
                var val = $("#cuentaid").val();
                $.get('<?php echo url_for("carga_gasto/cuenta") ?>', {val: val, id: id}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
 <?php  if (!$partidaPen) { ?>
 <script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
 <?php } ?>
<script src='/assets/global/plugins/jquery.min.js'></script>


<?php  if ($partidaPen) { ?>
    <div id="ajaxmodalPartida" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Partida <?php echo $partidaPen->getTipo(); ?>  <?php echo $partidaPen->getCodigo(); ?>  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
             
                    <?php include_partial('proceso/partidaCambia', array('partidaPen' => $partidaPen)) ?>  
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <?php foreach ($partidaPen->getListDetalle() as $cta) { ?>
        <script>
                        $(document).ready(function () {
                            $("#cuenta<?php echo $cta; ?>").select2({
                                dropdownParent: $("#ajaxmodalPartida")
                            });
                        });
        </script>
    <?php } ?>
    <script>
        $(document).ready(function () {
            $("#ajaxmodalPartida").modal();
        });
    </script>
<?php } ?>



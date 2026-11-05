<?php
$modulo = $sf_params->get('module');
$usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
$usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
$TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
?>
<style>
.kardex-modos{display:flex;gap:6px;width:100%}
.kardex-modo{flex:1;padding:8px 10px;border:1px solid #d8dce3;background:#f5f6f8;color:#606775;border-radius:5px;font-size:12px;font-weight:600;cursor:pointer;transition:all .15s}
.kardex-modo i{margin-right:5px}
.kardex-modo:hover{background:#e9edf3}
.kardex-modo.activo-parcial{background:#e8f2ff;color:#1765b3;border:2px solid #3084d6;padding:7px 9px}
.kardex-modo.activo-exacto{background:#e8f7ef;color:#177b48;border:2px solid #26a269;padding:7px 9px}
.kardex-modo:focus{outline:2px solid #8da8ce;outline-offset:2px}
.kardex-ayuda{font-size:11px;color:#737d8c;margin-top:5px;min-height:16px}
@media(max-width:576px){.kardex-modos{flex-wrap:wrap}.kardex-modo{min-width:120px}}
</style>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon"><i class="flaticon-list-2 kt-font-warning"></i></span>
            <h3 class="kt-portlet__head-title kt-font-info">REPORTE KARDEX PRODUCTO
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="actions">
                <a class="btn btn grey-cascade btn-block" target="_blank" href="<?php echo url_for($modulo.'/reporte') ?>">
                    <i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;<i class="fa fa-print"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo.'/index'),array('class'=>'form-horizontal')) ?>
        <?php echo $form->renderHiddenFields() ?>

        <div class="row" style="padding-top:5px;padding-bottom:10px">
            <label class="col-lg-1 control-label right">Nombre</label>
            <div class="col-lg-4 <?php if($form['nombrebuscar']->hasError()) echo 'has-error'; ?>">
                <?php echo $form['nombrebuscar'] ?>
                <span class="help-block form-error"><?php echo $form['nombrebuscar']->renderError() ?></span>
            </div>
            <label class="col-lg-1 control-label right">Búsqueda</label>
            <div class="col-lg-4 <?php if($form['modoBusqueda']->hasError()) echo 'has-error'; ?>">
                <div class="kardex-modos" role="group" aria-label="Tipo de búsqueda">
                    <button type="button" class="kardex-modo" data-modo="PARCIAL" aria-pressed="false"><i class="fa fa-search"></i> Contiene (%)</button>
                    <button type="button" class="kardex-modo" data-modo="EXACTO" aria-pressed="false"><i class="fa fa-check-circle"></i> Exacto (=)</button>
                </div>
                <div id="ayudaModoBusqueda" class="kardex-ayuda"></div>
                <div style="display:none"><?php echo $form['modoBusqueda']->render(array('id'=>'consulta_modoBusqueda')) ?></div>
                <span class="help-block form-error"><?php echo $form['modoBusqueda']->renderError() ?></span>
            </div>
        </div>

        <div class="row" style="padding-top:5px">
            <label class="col-lg-1 control-label right"><span class="font-blue bold Bold">Fecha Inicio</span></label>
            <div class="col-lg-2 <?php if($form['fechaInicio']->hasError()) echo 'has-error'; ?>">
                <?php echo $form['fechaInicio'] ?>
                <span class="help-block form-error"><?php echo $form['fechaInicio']->renderError() ?></span>
            </div>
            <label class="col-lg-1 control-label right"><span class="font-blue bold Bold">Fecha Fin</span></label>
            <div class="col-lg-2 <?php if($form['fechaFin']->hasError()) echo 'has-error'; ?>">
                <?php echo $form['fechaFin'] ?>
                <span class="help-block form-error"><?php echo $form['fechaFin']->renderError() ?></span>
            </div>
            <label class="col-lg-1 control-label right">Bodega</label>
            <div class="col-lg-4 <?php if($form['bodega']->hasError()) echo 'has-error'; ?>">
                <?php echo $form['bodega'] ?>
                <span class="help-block form-error"><?php echo $form['bodega']->renderError() ?></span>
            </div>
        </div>

        <div class="row" style="padding-top:5px;padding-bottom:10px">
            <label class="col-lg-1 control-label right">Motivo</label>
            <div class="col-lg-2 <?php if($form['motivo']->hasError()) echo 'has-error'; ?>">
                <?php echo $form['motivo'] ?>
                <span class="help-block form-error"><?php echo $form['motivo']->renderError() ?></span>
            </div>
            <label class="col-lg-1 control-label right">Tipo</label>
            <div class="col-lg-2 <?php if($form['tipo']->hasError()) echo 'has-error'; ?>">
                <?php echo $form['tipo'] ?>
                <span class="help-block form-error"><?php echo $form['tipo']->renderError() ?></span>
            </div>
            <div class="col-lg-2"><?php echo $form['transito'] ?></div>
            <div class="col-lg-2">
                <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-search"></i> Consultar</button>
            </div>
            <div class="col-lg-1">
                <?php if($usuarioId==1){ ?>
                    <a class="btn btn-sm btn-dark" target="_blank" href="<?php echo url_for($modulo.'/ajusta?id='.$productoId) ?>">..</a>
                <?php } ?>
            </div>
        </div>
        </form>

        <div class="table-scrollable">
            <table class="table table-bordered dataTable table-condensed flip-content">
                <thead class="flip-content">
                    <tr class="info">
                        <th align="center">Código</th>
                        <th align="center">Operación</th>
                        <th align="center">Referencia</th>
                        <th align="center">Descripción</th>
                        <th align="center">Fecha</th>
                        <th align="center">Bodega</th>
                        <th align="center">Motivo</th>
                        <th align="center">Producto</th>
                        <th align="center">Inicial</th>
                        <th align="center">Tipo</th>
                        <th align="center">Entrada</th>
                        <th align="center">Salida</th>
                        <th align="center">Final</th>
                        <th align="center">Venta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($movimiento as $reg){ ?>
                        <tr <?php if($reg->getMotivo()=='Reinicio Inventario'){ ?>style="background-color:#FF1590"<?php } ?>>
                            <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                            <td><?php echo $reg->getTipoDocumento(); ?></td>
                            <td><?php echo $reg->getDocumento(); ?></td>
                            <td><?php echo $reg->getNombreDocumento(); ?></td>
                            <td><?php echo $reg->getFecha('d/m/Y H:i'); ?></td>
                            <td><?php echo $reg->getTienda(); ?></td>
                            <td><?php echo $reg->getMotivo(); ?></td>
                            <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                            <td align="right"><?php echo $reg->getInicio(); ?></td>
                            <td><?php echo $reg->getTipo(); ?></td>
                            <td align="right"><?php if(in_array($reg->getTipo(),array('INGRESO','TRANSITO INGRESO','TRASLADO INGRESO'))) echo $reg->getCantidad(); ?></td>
                            <td align="right"><?php if(!in_array($reg->getTipo(),array('INGRESO','TRANSITO INGRESO','TRASLADO INGRESO'))) echo $reg->getCantidad(); ?></td>
                            <td align="right"><?php echo $reg->getFin(); ?></td>
                            <td align="right">
                                <?php if($TIPO_USUARIO=='ADMINISTRADOR'){ ?>
                                    <a class="btn btn-small btn-block" href="<?php echo url_for('reporte_kardex/costo?id='.$reg->getId()) ?>" data-toggle="modal" data-target="#ajaxmodal<?php echo $reg->getId() ?>">
                                        <?php echo Parametro::formato($reg->getVenta()); ?>
                                    </a>
                                <?php }else{ echo Parametro::formato($reg->getVenta()); } ?>
                                <?php if($usuarioId=='1'){ ?>
                                    <a style="height:15px!important;font-size:10px!important" class="btn btn-sm btn-danger" data-toggle="modal" href="#static<?php echo $reg->getId() ?>"></a>
                                    <?php echo $reg->getId(); ?>
                                <?php } ?>
                            </td>
                        </tr>

                        <div id="static<?php echo $reg->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmación Kadex</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Esta seguro de eliminar Linea Kardex
                                            <span class="caption-subject font-green bold uppercase"><?php echo $reg->getIdentificador() ?></span> ?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-danger" href="<?php echo url_for($modulo.'/elimina?id='.$reg->getId()) ?>"><i class="fa fa-trash-o"></i> Confirmar</a>
                                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="/assets/global/plugins/jquery.min.js"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<?php foreach($movimiento as $reg){ ?>
    <?php $lista = $reg; ?>
    <div class="modal fade" id="ajaxmodal<?php echo $reg->getId() ?>" tabindex="-1" data-toggle="modal" data-target="#responsivemodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:750px">
            <div class="modal-content" style="width:750px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="ti-close"></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel6">Detalle de Operación</h4>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
$(document).ready(function(){
    function actualizarModoBusqueda(modo){
        if(modo!=='EXACTO') modo='PARCIAL';
        $('#consulta_modoBusqueda').val(modo);
        $('.kardex-modo').removeClass('activo-parcial activo-exacto').attr('aria-pressed','false');
        if(modo==='EXACTO'){
            $('.kardex-modo[data-modo="EXACTO"]').addClass('activo-exacto').attr('aria-pressed','true');
            $('#ayudaModoBusqueda').html('<i class="fa fa-check-circle"></i> Coincidencia exacta del código o nombre.');
        }else{
            $('.kardex-modo[data-modo="PARCIAL"]').addClass('activo-parcial').attr('aria-pressed','true');
            $('#ayudaModoBusqueda').html('<i class="fa fa-info-circle"></i> Busca productos que contengan el texto.');
        }
    }
    $('.kardex-modo').on('click',function(){actualizarModoBusqueda($(this).attr('data-modo'));});
    actualizarModoBusqueda($('#consulta_modoBusqueda').val());
});
</script>
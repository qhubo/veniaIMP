<script src='/assets/global/plugins/jquery.min.js'></script>
<style>
    .table-responsive-scroll {
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
}

.table-responsive-scroll table {
    min-width: 1400px; /* ajusta según columnas */
    white-space: nowrap;
}

</style>
<?php $modulo = $sf_params->get('module'); ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Consulta Ventas
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for('consulta_venta/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row"  style="padding-bottom:3px;">
            <label class="col-lg-2 control-label right " style="font-weight:bold; text-align: right;"> Fecha Inicio </label>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <label class="col-lg-1 control-label right " style="font-weight:bold; text-align: right;"> Fecha Fin </label>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
            <label class="col-lg-1 control-label right " style="font-weight:bold; text-align: right;"> Tienda </label>   
            <div class="col-lg-2"> <?php echo $form['bodega'] ?></div>  
        </div>


        <div class="row"  style="padding-bottom:3px;">

            <label class="col-lg-2 control-label right " style="font-weight:bold; text-align: right;"> Estatus </label>
            <div class="col-lg-2">
                <?php echo $form['estatus_op'] ?> 
            </div>
            <label class="col-lg-1 control-label right " style="font-weight:bold; text-align: right;"> Vendedor </label>
            <div class="col-lg-2">
                <?php echo $form['vendedor'] ?> 
            </div>
            <label class="col-lg-1 control-label right " style="font-weight:bold; text-align: right;"> Usuario </label>
            <div class="col-lg-2">
                <?php echo $form['usuario'] ?> 
            </div>

        </div>


        <div class="row" style="padding-bottom:3px;">
            <div class="col-lg-2 control-label right " style="font-weight:bold; text-align: right;"> Factura </div>
            <div class="col-lg-2 <?php if ($form['busqueda']->hasError()) echo "has-error" ?>">
                <?php echo $form['busqueda'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['busqueda']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1 control-label right " style="font-weight:bold; text-align: right;">Cliente  </div>
            <div class="col-lg-2 <?php if ($form['cliente']->hasError()) echo "has-error" ?>">
                <?php echo $form['cliente'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['cliente']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-1">
                <button class="btn  btn-info btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
            </div>
            <div class="col-lg-1">
                <a target="_blank" href="<?php echo url_for('consulta_venta/reporteExcel') ?>" class="btn  btn-sm btn-warning" > <i class="flaticon2-printer"></i>Reporte </a>
            </div>
        </div>



        <?php echo '</form>'; ?>
        <div class="table-responsive-scroll">
        <table class="table table-bordered  dataTable table-condensed flip-content" >
            <thead class="flip-content">
                <tr class="active">
                    <th align="center" width="20px"> Código</th>
                    <th align="center" width="20px"> Tienda</th>
                    <th align="center" width="20px">Fecha</th>
                    <th align="center" width="20px">Usuario</th>
                    <th width="25px">Cliente</th>
                    <th  align="center"> Nombre</th>
                    <th  align="center"> RUC</th>
                    <th  align="center"> Estado</th>
                    <th  align="center"> Valor</th>    
                    <th width="25px">CUFE</th>
                    <th align="center" width="20px">Vendedor</th>
                    <th  align="center"> Observaciones /Guia</th>   
                    

                    <th  align="center"> Valor Pagado</th>      
                    <th>Ult Recibo</th>
                    <th>Ult Fecha Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($operaciones as $lista) { ?>
                    <?php $id = $lista->getId(); ?>
                    <?php $val = explode('-', $lista->getFaceFirma()) ?>
                    <?php $numero ="Fact"; // $val[0]; ?>
                    <tr>
                        <td>
                            <a class="btn btn-warning btn-sm btn-block" href="<?php echo url_for('reporte_venta/muestra?id=' . $id) ?>" data-toggle="modal" data-target="#ajaxmodal<?php echo $id ?>">  <?php echo $lista->getCodigoFactura() ?> </a>
                        </td>
                        <td> <?php echo substr($lista->getTienda(), 0, 20) ?>  </td>
                        <td><?php echo $lista->getFecha('d/m/Y H:i') ?></td>
                        <td> <font size="-1"><?php echo $lista->getUsuario() ?></font>  </td>
                        <td><?php
                            if ($lista->getClienteId()) {
                                echo $lista->getCliente()->getCodigoCli();
                            }
                            ?></td>
                        <td><?php echo $lista->getNombre() ?></td>
                        <td><?php echo $lista->getNit() ?></td>
                        <td><?php echo $lista->getEstatus() ?></td>
                        <td style="text-algn:right"><?php echo Parametro::formato($lista->getValorTotal()) ?> </td>
                        <td>
                            <?php echo substr($lista->getFaceFirma(),0,20) ?>
                                                          
                                                            </td>
                        <td><?php
                            if ($lista->getVendedorId()) {
                                echo $lista->getVendedor()->getNombre();
                            }
                            ?></td>
                        <td><?php echo $lista->getObservaciones() ?>  </td>
                        <td  style="text-align:right"><?php echo Parametro::formato($lista->getValorPagado()) ?>   </td>
                        <td>  <?php if ($lista->getRecibo()) { ?> 
                                <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $lista->getRecibo()) ?>" class="btn btn-block btn-xs  " target = "_blank">
                                    <?php echo $lista->getRecibo(); ?>
                                </a>
                            <?php } ?>

                        </td>
                        <td><?php echo $lista->getFechaRecibo() ?>  </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
   </div>
    </div>
</div>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<?php foreach ($operaciones as $reg) { ?>
    <?php $lista = $reg; ?>



    <div class="modal fade" id="ajaxmodal<?php echo $reg->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 750px">
            <div class="modal-content" style=" width: 750px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Detalle de Operación</h4>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
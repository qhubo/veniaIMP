<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<?php        ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Reporte de NOTAS
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for('reprote_nota/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>

        <div class="row"  style="padding-bottom:10px;">


            <label class="col-lg-1 control-label right "> Inicio </label>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-2">
                <?php echo $form['bodega'] ?> 
            </div>

       

            <div class="col-lg-2">
                <button class="btn green btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
            </div>
<!--            <div class="col-lg-1">
                <a target="_blank" href="<?php echo url_for('reprote_nota/reporteExcel') ?>" class="btn  btn-sm btn-warning" > <i class="flaticon2-printer"></i>Reporte </a>
            </div>-->
        </div>
        <?php echo '</form>'; ?>

        <div class="row">
            <div class="col-lg-10"></div>
            <div class="col-lg-2">				
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>

        <table class="kt-datatable  table table-bordered  dataTable table-condensed flip-content" id="html_table" width="100%" >
            <thead class="flip-content">
                <tr class="active">
                    <th align="center" width="20px"> Código</th>
                    <th align="center" width="20px">Creación</th>
                    <th width="25px">Cliente</th>
                     <th>Nombre</th>
                    <th  align="center"> Observaciones</th>
                    <th  align="center"> Vendedor</th>

                    <th  align="center"> Valor</th>    
                    <th width="30px">Fel</th>
                    <th  align="center"> Observaciones</th>   
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($operaciones as $lista) { ?>
                    <?php $total = $lista->getValorTotal() + $total; ?>
                    <?php $val = explode('-', $lista->getFaceFirma()) ?>
                    <?php $numero = $val[0]; ?>
                    <tr>     
                        <td>
                            <a class="btn  btn-small btn-block "   href="<?php echo url_for('reporte_venta/muestra?id=' . $lista->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId() ?>">
                                <?php echo $lista->getCodigo() ?>  
                            </a>
                            <?php echo substr($lista->getTienda(), 0, 5) ?>  
                        </td>
                        <td><?php echo $lista->getFecha('d/m/Y ') ?><br> <?php echo $lista->getUsuario() ?>  </td>
                        <td> <?php
                            if ($lista->getClienteId()) {
                                echo $lista->getCliente()->getCodigoCli();
                            }
                            ?>  </td>
                        <td><?php echo $lista->getNit() ?> <br> <?php echo $lista->getNombre() ?></td>

                        <td>
                           
                                <?php echo $lista->getObservaciones() ?>  <br> 
                                <strong> <?php echo $lista->getAnuloUsuario() ?>  </strong> <br>
                                <?php echo $lista->getFechaAnulo('d/m/Y H:i:s') ?>   <br>
                            
                        </td>
                        <td>  <?php if ($lista->getVendedorId()) {  echo $lista->getVendedor()->getNombre(); } ?></td>

                        <td style="text-align:right">  <?php echo Parametro::formato($lista->getValorTotal()) ?>    </td>

                        <td>
                            <a target="_blank" href="<?php echo url_for('pdf/factura?tok=' . $lista->getCodigo()) ?>" class="btn btn-block btn-small btn-warning " target = "_blank">
                          <?php echo "NOTA "; ?>   <?php echo $numero; ?>
                            </a>  
                        

                        </td>


                     
                   
                    </tr>



                <?php } ?>
            </tbody>

        </table>






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


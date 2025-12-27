<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-clipboard kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success"> Estado Cuenta Proveedor
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y  proveedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar"></div>
    </div>
    <div class="kt-portlet__body">

        <div class="form-body">     
            <div class="row">
                
                <div class="col-lg-9"> 
            
            <div class="row">              
                <label class="col-lg-1 control-label right " style="text-align:right"> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right " style="text-align:right">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>

                  <div class="col-lg-4 <?php if ($form['proveedor']->hasError()) echo "has-error" ?>">
                    <?php echo $form['proveedor'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['proveedor']->renderError() ?>  
                    </span>
                </div>

                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
                    </div>
                <div class="col-lg-3  kt-callout--success"> 
     
			
				
					<div class="kt-callout__content">
						<h3 class="kt-callout__title">Saldo Actual
					
					
						<a href="#" class="btn btn-custom btn-bold btn-upper   btn-success"><?php  echo Parametro::formato($saldo) ?></a>
					</h3>
                                            <?php if ($proveedor) { ?>
                                            <?php echo $proveedor->getNombre(); ?> 
                                            <?php } ?>
                                        </div>
				
	
                    

                </div>

            </div>
        </div>

    </div>

<?php echo '</form>'; ?>


<div class="row">

    <div class="col-lg-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">

                    <table class="table table-bordered  dataTable table-condensed flip-content" >
                        <thead class="flip-content">
                            <tr class="active">
                                <th align="center" >Fecha</th>
                                <th align="center" >Proveedor</th>
                                <th align="center" > Tipo</th>
                                <th align="center" >Codigo</th>
                                <th  align="center"> Observaciones</th>
                                <th  align="center">Valor Total</th>
                                <th  align="center"> Valor Pagado</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total1 = 0; ?>
                               <?php $total2 = 0; ?>
                            <?php foreach ($operaciones as $lista) { ?>
                            <?php $total1=$lista->getValorTotal()+$total1; ?>
                            <?php $total2=$total2+$lista->getValorPagado() ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $lista->getFecha('d/m/Y'); ?> </td>
                                    <td><?php echo $lista->getProveedor()->getNombre(); ?> </td>
                                    <td><?php echo $lista->getTipo(); ?> </td>
                                    <td style="text-align:center; align-content: center">
                                     <?php if ( $lista->getOrdenProveedorId()) { ?>   
                                    
                                         <a href="<?php echo url_for("orden_compra/vista?token=" . $lista->getOrdenProveedor()->getToken()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId(); ?>">  <?php echo $lista->getCodigo(); ?>    </a>
                                     <?php } elseif($lista->getGastoId()) { ?>
                                              <a href="<?php echo url_for("orden_gasto/vista?token=" . $lista->getGasto()->getToken()) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId(); ?>">  <?php echo $lista->getCodigo(); ?>    </a>
                       
                                     <?php } else {  ?>
                                           <?php echo $lista->getCodigo(); ?>   
                                     <?php  } ?>
                                    </td>
                                    <td><?php echo $lista->getObservaciones(); ?> </td>
                                    <td style="align:right" ><div style="text-align:right"> <?php echo Parametro::formato($lista->getValorTotal()); ?></div> </td>
                                    <td  style="align:right"><div style="text-align:right"><?php echo Parametro::formato($lista->getValorPagado()); ?></div> </td>
                                    <!-- comment -->
                                </tr>
                            <?Php } ?>
                        </tbody>
                        <tr>
                            <td colspan="5" style="text-align:center"><h3> Totales</h3> </td>
                            <td style="align:right" ><div style="text-align:right"><h3> <?php echo Parametro::formato($total1); ?></h3> </div> </td>
                                    <td  style="align:right"><div style="text-align:right"><h3><?php echo Parametro::formato($total2); ?></h3></div> </td>
                        
                        </tr>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>

</div>


<?php foreach ($operaciones as $data) { ?>
<?php //if ( $data->getOrdenProveedorId()) { ?>
    <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle  <?php echo $data->getCodigo(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php // } ?>

<?php } ?>


<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
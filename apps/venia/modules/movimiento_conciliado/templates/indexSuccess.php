<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo.'/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<?php $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-3 kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success"> Movimientos de Banco Conciliados
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y  banco&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar"></div>
    </div>
    <div class="kt-portlet__body">


        <div class="form-body">     
            <div class="row">

                <div class="col-lg-8"> 

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

                        <div class="col-lg-4 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
                            <?php echo $form['banco'] ?>           
                            <span class="help-block form-error"> 
                                <?php echo $form['banco']->renderError() ?>  
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
                <div class="col-lg-4  kt-callout--success"> 



                    <div class="kt-callout__content"  style="padding-top:10px; padding-left:20px; padding-bottom: 10px" >
                   Saldo Actual     <?php if ($banco) { ?>
                            <?php echo $banco->getNombre(); ?>&nbsp; 
                        <?php } ?>
                            <a href="#" style="padding-left:20px; padding-right:20px;" class="btn btn-custom btn-bold btn-upper   btn-success"><?php echo Parametro::formato($saldo) ?></a>
                  
                     
                    </div>




                </div>

            </div>
        </div>

    </div>

    <?php echo '</form>'; ?>
-<div class="row">
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

    <div class="row">

        <div class="col-lg-12">
                    <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
<!--      <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin " id="html_table" width="100%">-->
                <thead>
                    <tr class="active">

                        <th  align="center"><span class="kt-font-success"> Fecha</span>        </th>
                        <th  align="center"><span class="kt-font-success"> Tipo</span>  </th>
                        <th  align="center"><span class="kt-font-success"> Tienda </span></th>
                        <th  align="center"><span class="kt-font-success"> Banco </span></th>
                        <th  align="center"><span class="kt-font-success"> Observaciones </span></th>                   
                        <th  align="center"><span class="kt-font-success"> Valor</span></th>
                        <th  align="center"><span class="kt-font-success">Usuario </span></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $Vtotal = 0; ?>
                    <?php foreach ($operaciones as $data) { ?>
                                 <?php $Vtotal = $Vtotal + $data->getValor(); ?>

                        <tr>
                            <td style="text-align: center"><?php echo $data->getFechaConfirmoBanco('d/m/Y'); ?> </td>
                            <td>  <?php echo $data->getTipo(); ?> <strong> <?php echo $data->getTipoMovimiento();   ?> </strong>  </td> 
                            <td><?php echo $data->getTienda(); ?> </td>
                            <td><?php echo $data->getBancoRelatedByBancoId()->getNombre(); ?> </td>

                            <td><?php echo $data->getObservaciones(); ?> </td>
                            <td style="text-align: right" ><?php echo Parametro::formato($data->getValor(), true); ?> </td>
                            <td><?php echo $data->getUsuario(); ?> </td>
                            <td>
                                  <a class="btn btn-block  btn-xs btn-danger" data-toggle="modal" href="#static<?php echo $data->getId() ?>"><i class="flaticon-cancel"></i>   </a>
               
                            </td>
                        </tr>        
<?php } ?>
                </tbody>

            </table>
        </div>
    </div>

</div>
<?php foreach ($operaciones as $lista) { ?>
       <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Revertir Conciliación</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de revertir este movimiento
                                    <span class="caption-subject font-green bold uppercase"> 
                                   <?php echo $lista->getTipo(); ?>  <?php echo $lista->getObservaciones(); ?> <?php echo Parametro::formato($lista->getValor(), true); ?>
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = sha1($lista->getId()); ?>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn green " href="<?php echo url_for($modulo . '/revertir?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                    <i class="fa fa-trash-o "></i> Confirmar</a> 
                            </div>
                        </div>
                    </div>
                </div>

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
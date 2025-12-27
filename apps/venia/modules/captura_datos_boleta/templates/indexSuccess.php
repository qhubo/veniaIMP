<style>
    .titulo {
        font-size: 15px !important;
        /*        font-family: "Lucida Console", "Courier New", monospace !important;*/
    }
</style>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-interface-2 text-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                CAPTURA DE  DATOS DEPOSITO  BOLETA<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-left" role="tablist">
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 1) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_1_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Ingresar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  <?php if ($tab == 2) { ?> active <?php } ?> " data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Historico
                </a>
            </li>
        </ul>
        <div class="tab-content" >
            <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_1_tab_content" role="tabpanel">

                <div class="row">
                    <div class="col-lg-6" style="padding-top:10px;">
                        <?php include_partial($modulo . '/datos', array('id' => $id, 'modulo' => $modulo, 'form' => $form)) ?>           
                    </div>
                    <div class="col-lg-6">
                        <?php if (count($datosConfirmados)>0) { ?>
                        <div class="row">
                           
                            <div class="col-lg-1"><li class="fa fa-list"></li> </div>
                            <div class="col-lg-8"> <h4>Solicitud Confirmadas</h4> </div>
                                
                        </div>
                            <?php include_partial($modulo . '/listaConfirmado', array('id' => $id, 'modulo' => $modulo, 'datosConfirmados' => $datosConfirmados)) ?>           
                        <?php  } ?>
                    </div>

                </div>

            </div> 
            <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
            
                <?php $modulo = $sf_params->get('module'); ?>
        <?php echo $forma->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $forma->renderHiddenFields() ?>
        <div class="row" style="padding-bottom:30px">
  
            <div class="col-lg-2 <?php if ($forma['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $forma['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $forma['fechaInicio']->renderError() ?>  
                </span>
            </div>



    
            <div class="col-lg-2 <?php if ($forma['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $forma['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $forma['fechaFin']->renderError() ?>  
                </span>
            </div>



           

            <div class="col-lg-2">
                <button class="btn btn-outline-success" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
            </div>

            
        </div>
        <?php echo "</form>"; ?>
                
                
                
                <table class="table" >
                    <tr style="background-color:#ebedf2">
                        <th align="center"  width="100px">Codigo</th>
                        <th align="center" >Banco</th>
                        <th  align="center"> Tienda</th>         
                        <th  align="center">Vendedor </th>
                        <th  align="center">Boleta </th>
                        <th  align="center">Fecha Deposito </th>
                        <th  align="center">Estado </th>
                        <th  align="center">Total </th>
                        <th  align="center">Cliente </th>
                        <th></th>
                    </tr>
                    <?php foreach ($registros as $regi) { ?> 
                        <tr>
                            <td><?php echo $regi->getCodigo(); ?></td>
                            <td><?php echo $regi->getBanco(); ?></td>
                            <td><?php echo $regi->getTienda(); ?></td>
                            <td><?php echo $regi->getVendedor(); ?></td>
                            <td><?php echo $regi->getBoleta(); ?></td>
                            <td><?php echo $regi->getFechaDeposito('d/m/Y'); ?></td>
                            <td><?php echo $regi->getEstatus(); ?></td>
                            <td style="text-align:right" ><?php echo Parametro::formato($regi->getTotal(), true); ?></td>
                            <td><?php echo $regi->getCliente(); ?></td>
                            
                            <td>   
                            <?php if ($regi->getEstatus() == "Nuevo") { ?>
                                <a class="btn  btn-sm btn-danger" data-toggle="modal" href="#static<?php echo $regi->getId() ?>"><i class="flaticon-delete"></i>     </a>
                            <?php } ?>
                                 <?php if ($regi->getEstatus() == "Autorizado") { ?>
                                        <a target="_blank" href="<?php echo url_for($modulo.'/reporte?id=' . $regi->getId()) ?>" class="btn btn-outline btn-block  btn-sm " > <i class="flaticon2-printer"></i><?php echo $regi->getBoleta(); ?> </a>
  <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </div>
        </div>

    </div>
</div>






<?php foreach ($registros as $lista) { ?> 
    <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <li class="fa fa-cogs"></li>
                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Eliminar Usuario</span>
                </div>
                <div class="modal-body">
                    <p> Esta seguro de eliminar Solicitud Deposito
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $lista->getCodigo() ?>
                        </span> ?
                    </p>
                </div>
                <?php $token = sha1($lista->getId()); ?>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    <a class="btn  btn green " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
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

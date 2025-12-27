
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<?php $modulo = $sf_params->get('module'); ?>
<form action="<?php echo url_for($modulo . '/index') ?>" method="get">
    <div class="kt-portlet kt-portlet--responsive-mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="flaticon2-zig-zag-line-sign kt-font-warning"></i>
                </span>
                <h3 class="kt-portlet__head-title kt-font-info">
                    MOVIMIENTOS DE BANCOS  PENDIENTES DE CONFIRMAR <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Listado de los movimientos pendientes de confirmar
                    </small>
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <select  onchange="this.form.submit()" class="form-control"  name="bancover" id="bancover">
                    <option value="0">[    Todos los bancos   ]</option>
                    <?php foreach ($bancos as $lista) { ?>
                        <option <?php if ($bancover == $lista->getId()) { ?> selected="selected"  <?php } ?>  value="<?php echo $lista->getId(); ?>"><?php echo $lista->getNombre(); ?></option>
                    <?php } ?>
                </select>


            </div>
        </div>

        <div class="kt-portlet__body">

            <div class='row' style="padding-bottom:6px;">
                
                <div class="col-lg-3"></div>
                
                <div class="col-lg-2">
                    <font size="-2">Inicio</font>

                    <input onchange="this.form.submit()" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="fechaINI" value="<?php echo $fechaINI; ?>" id="fechaINI">
                </div>
                <div class="col-lg-2">
                    <font size="-2">Fin</font>
                <input onchange="this.form.submit()" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="fechaFIN" value="<?php echo $fechaFIN; ?>" id="fechaFIN">
                </div>
                
                <div class="col-lg-2">
                         <font size="-2">Tipo</font>
                    <select  onchange="this.form.submit()" class="form-control"  name="movi" id="movi">
                    <?php foreach ($movimientos  as $key=>$data) { ?>
                        <option <?php if ($movi == $key) { ?> selected="selected"  <?php } ?>   value="<?php echo $key; ?>"><?php echo $data; ?></option>
                    <?php } ?>
                </select>
                </div>
                
                <div class="col-lg-2 " style="text-align:right">  
                    <?php if ($bancover) { ?>
                        <a href="<?php echo url_for("concilia_banco/index?ver=1&bancover=" . $bancover."&movi=".$movi) ?>" class="btn btn-blue btn-block" > <i class="flaticon-graph kt-font-warning"></i> Conciliación  </a>
                    <?php } ?>

                </div>            
            </div>
<!--            <div class="row">
                                <div class="col-lg-10">  </div>
                                <div class="col-lg-2">				
                                    <div class="kt-input-icon kt-input-icon--left">
                                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                            <span><i class="la la-search"></i></span>
                                        </span>
                                    </div>
                                </div>
                            </div>-->

            <table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">

<!-- <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
                    -->
                <thead>
                    <tr class="active">

                        <th  align="center"><span class="kt-font-success"> Fecha</span>        </th>
                        <th  align="center"><span class="kt-font-success"> Tipo</span>  </th>
                        <th  align="center"><span class="kt-font-success"> Tienda </span></th>
                        <th  align="center"><span class="kt-font-success"> Banco </span></th>
                        <th  align="center"><span class="kt-font-success"> Observaciones </span></th>                   
                        <th  align="center"><span class="kt-font-success"> Valor</span></th>
                        <th  align="center"><span class="kt-font-success"> Documento</span></th>
                        <th></th>
                        <th  align="center"><span class="kt-font-success">Usuario </span></th>

                    </tr>
                </thead>
                <tbody>
                    <?php $Vtotal = 0; ?>
                    <?php foreach ($registros as $data) { ?>
                        <?php $estiloUno = ''; ?>
                        <?php $estiloDos = 'style="display:none;"'; ?>
                        <?php if ($data->getRevisado()) { ?>
                            <?php $estiloDos = ''; ?>
                            <?php $estiloUno = 'style="display:none;"'; ?>
                        <?php } ?>
                        <?php $Vtotal = $Vtotal + $data->getValor(); ?>

                        <tr>
                            <td style="text-align: center"><?php echo $data->getFechaDocumento('d/m/Y'); ?> </td>
                            <td>  <?php echo $data->getTipo(); ?> <strong> <?php echo $data->getTipoMovimiento();
                    
                        ?> </strong>  </td> 
                            <td><?php echo $data->getTienda(); ?> </td>
                            <td><?php echo $data->getBancoRelatedByBancoId()->getNombre(); ?> </td>

                            <td> <?php echo $data->getDetalleBanco(); ?>  
                            
                            </td>
                            <td style="text-align: right" ><?php echo Parametro::formato($data->getValor(), true); ?> </td>
                            <td style="text-align: right">
                           <?php echo $data->getNumero(); ?> 
                            </td>
                     
                            <td>
                                <div class="row">
                                    <div  id="btlista<?php echo $data->getId(); ?>"  <?php echo $estiloUno ?> >
                                        <a id="activar<?php echo $data->getId(); ?>" dat="<?php echo "0_" ?>" class="btn btn-outline  btn-xs grey "><img width="15px" src="/images/UnCheck.png"> </a>     
                                    </div> 
                                    <div  id="bNtactiva<?php echo $data->getId(); ?>" <?php echo $estiloDos ?>>
                                        <a id="Nactivar<?php echo $data->getId(); ?>" dat="<?php echo "0_" ?>" class="btn btn-outline btn-xs grey "><img width="15px" src="/images/Check.png"></a> 
                                    </div>
                                </div>
                            </td>
                                   <td><?php echo $data->getUsuario(); ?> </td>
                        </tr>        
<?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right"><strong>Valor Total</strong></td>
                        <td colspan="2">
                            <input class="form-control" value="<?php echo Parametro::formato($Vtotal, false); ?>" style="background-color:#F9FBFE ;" readonly="true" name="totalVal" id="totalVal">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right"><strong>Total Seleccionado</strong></td>
                        <td colspan="2">

                            <input class="form-control" value="<?php echo Parametro::formato($total, false); ?>" style="background-color:#F9FBFE ;" readonly="true" name="totalselec" id="totalselec">
                        </td>
                        <td>

                        </td>
                    </tr>
    <!--         <tr>
                        <td colspan="5" style="text-align: right"><strong>Total Pendiente</strong></td>
                        <td colspan="2">
                            <input class="form-control" value="<?php echo Parametro::formato($Vtotal - $total, false); ?>" style="background-color:#F9FBFE ;" readonly="true" name="totalPendi" id="totalPendi">
                        </td>
                    </tr>-->
<?php if ($banco) { ?>
                        <tr>
                            <td colspan="5" style="text-align: right"><strong>Confirma los registros seleccionados</strong></td>
                            <td colspan="2" style="text-align:center; align-content: center">
                                <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-dark" > <i class="flaticon-lock"></i> Confirmar </a>

                            </td>
                        </tr> 
<?php } ?>

                </tfoot>
            </table>
        </div>


    </div>
</form>


<?php if ($banco) { ?>
    <div id="staticCONFIRMA" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Conciliación  Bancaria </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>  
                        <strong>Banco  <?php echo $banco->getNombre(); ?> </strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            confirma los movimientos seleccionados
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn  btn-success " href="<?php echo url_for($modulo . '/confirmar') . '?id=' . $banco->getId() . "&token=" . sha1($banco->getCodigo())."&movi=".$movi ?>" >
                        <i class="flaticon2-lock "></i> Confirmar <?php echo $movi; ?></a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div>

<?php } ?>


<!--<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
                
<div class="modal fade" id="ajaxmodalVista" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
        <div class="modal-dialog" role="document">
     <div class="modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Conciliación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
<div class="modal-body">
    
</div>
        </div>
    </div>
</div>-->


<?php foreach ($registros as $data) { ?>
    <?php $i = $data->getId(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#activar<?php echo $i ?>').click(function () {
                var id = <?php echo $i; ?>;
                var banco =<?php echo $bancover; ?>;
                var movi ='<?php echo $movi; ?>';
                $.get('<?php echo url_for("concilia_banco/activa") ?>', {id: id, banco: banco,movi:movi}, function (response) {
                    $('#totalselec').val(response);
                });
                $('#activar0').hide();
                $('#bNtactiva<?php echo $i ?>').slideToggle(250);
                $('#btactiva<?php echo $i ?>').hide();
                $('#bNtlista<?php echo $i ?>').slideToggle(250);
                $('#btlista<?php echo $i ?>').hide();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#Nactivar<?php echo $i ?>').click(function () {
                var id = <?php echo $i; ?>;
                var banco =<?php echo $bancover; ?>;
                var movi ='<?php echo $movi; ?>';
       
                $.get('<?php echo url_for("concilia_banco/desactiva") ?>', {id: id, banco: banco,movi:movi}, function (response) {
                    $('#totalselec').val(response);
                });
    

                $('#activar0').slideToggle(250);
                $('#btactiva<?php echo $i ?>').slideToggle(250);
                $('#bNtactiva<?php echo $i ?>').hide();
                $('#btlista<?php echo $i ?>').slideToggle(250);
                $('#bNtlista<?php echo $i ?>').hide();
            });
        });
    </script>

<?php } ?>



<?php if ($banco) { ?>
    <?php if ($ver) { ?>
    <div id="ajaxmodalConcilia" class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false"  style="padding-top:20px;  padding-left:450px">
            <div class="modal-lg"  role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel6">Conciliación  Bancaria  </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


        <?php  include_partial('concilia_banco/vista', array('banco' => $banco)) ?>  
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $("#ajaxmodalConcilia").modal();
            });
        </script>
    <?php } ?>    
<?php } ?>
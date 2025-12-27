<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Cuentas Contables <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Listado de cuentas </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn-sm btn-info" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
        </div>
    </div>




    <div class="kt-portlet__body">

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
        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
               <thead>
                <tr class="active">

                  
                    <th  width="50px" align="center"><span class="kt-font-info"> Tipo</span></th>
                    <th     align="center"><span class="kt-font-info"> Grupo</span></th>
                    <th  width="450px"   align="center"><span class="kt-font-info"> Cuenta</span></th>
                    <th>Editar</th>
  <th  width="50px"   align="center"><span class="kt-font-info"> #</span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cuentas as $registro) { ?>
                    <?php $lista = $registro; ?>
                    <tr>
                     
                        <td><?Php echo $registro->getTipoDetalle() ?></td>
                        <td><?Php echo $registro->getGrupo() ?>
                          </td>
                        <td>
                            <?php echo $registro->getCuentaContable(); ?>
                                     <div class="total_<?php echo $registro->getId(); ?>" id="total_<?php echo $registro->getId(); ?>" ></div>
                 
                        </td>

                        <td>
                                        <a class=" btn btn-xs btn-info"  href="<?php echo url_for($modulo . '/editar?id=' . $registro->getId()) ?>" ><i class="fa fa-pencil"></i> Editar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
                      
                        </td>
                           <td><?Php echo $registro->getId() ?></td>
                    </tr>


                <?php } ?>
            </tbody>

        </table>



    </div>
        
    </div>

<script src='/assets/global/plugins/jquery.min.js'></script>
<?php foreach ($cuentas as $reg) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#cuenta<?php echo $reg->getId(); ?>").on('change', function () {

                var valor = $("#cuenta<?php echo $reg->getId(); ?>").val();
                var id = <?php echo $reg->getId(); ?>;
                $.get('<?php echo url_for("cuenta_default/actuaCuenta") ?>', {id: id, valor: valor}, function (response) {
                    $("#total_<?php echo $reg->getId(); ?>").html(response);
                });

            });
        });
    </script>
<?php } ?>
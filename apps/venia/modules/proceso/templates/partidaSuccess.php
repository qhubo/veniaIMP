
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-document  text-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Partida Contable  
            </h3> &nbsp;&nbsp;&nbsp; <?php echo $partida->getTipo(); ?> 
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped- table-bordered table-hover no-footer dtr-inlin " width="100%">
                    <tr class="active">
                        <td></td>
<!--                        <td><strong>Cuenta Contable</strong></td>
                        <td><strong>Detalle</strong></td>-->
                        <td></td> 
                        <td></td> 
                    </tr>
                    <?Php $total1 = 0; ?>
                    <?Php $total2 = 0; ?>
                    <?php foreach ($partidaDeta as $reg) { ?>
                        <?php $total1 = $reg->getDebe() + $total1; ?>
                        <?php $total2 = $reg->getHaber() + $total2; ?>
                        <?php $listaCuentas = $cuentasUno; ?>
                        <?php if ($reg->getHaber()) { ?>
                            <?php $listaCuentas = $cuentasDos; ?>
                        <?php } ?>
                        <tr>
                            <td>

                                <select class="form-control" name="cuenta<?php echo $reg->getId() ?>" id="cuenta<?php echo $reg->getId() ?>">
                                    <?php foreach ($listaCuentas as $dat) { ?>
                                        <option 
                                        <?php if ($dat->getCuentaContable() == $reg->getCuentaContable()) { ?>
                                                selected="selected"
                                            <?php } ?>
                                            value="<?php echo $dat->getCuentaContable(); ?>"><?php echo $dat->getCuentaContable(); ?> - <?php echo $dat->getNombre(); ?></option>
                                        <?php } ?>
                                </select>
                            </td>
    <!--                            <td><?php echo $reg->getCuentaContable() ?></td>
                            <td><?php echo $reg->getDetalle() ?></td>-->
                            <td style="text-align: right" ><?php echo Parametro::formato($reg->getDebe()) ?></td>
                            <td style="text-align: right"><?php echo Parametro::formato($reg->getHaber()); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="1" style="text-align: right" >Totales&nbsp;&nbsp;</td>
                        <td style="text-align: right" ><font size="+1"> <?php echo Parametro::formato($total1) ?></font></td>
                        <td style="text-align: right"><font size="+1"><?php echo Parametro::formato($total2); ?></font></td>
                    </tr>
                </table>
            </div>    

        </div>
    </div>
</div>
<script src='/assets/global/plugins/jquery.min.js'></script>
 <?php foreach ($partidaDeta as $reg) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#cuenta<?php echo $reg->getId(); ?>").on('change', function () {

              var valor = $("#cuenta<?php echo $reg->getId(); ?>").val();
               var  id = <?php echo $reg->getId(); ?>;
                $.get('<?php echo url_for("proceso/actuaCuenta") ?>', {id: id, valor: valor}, function (response) {
                    $("#total_<?php echo $reg->getId(); ?>").html(response);
                });
    
            });
        });
    </script>
<?php } ?>

<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<?Php $partida = $partidaPen; ?>
<?php $id = $partida->getId(); ?>
<?Php $partidaDeta = PartidaDetalleQuery::create()->filterByPartidaId($id)->find(); ?>
<?php $listaCuentas = CuentaErpContableQuery::create()->filterByCampo('Cuenta')->where("CuentaErpContable.CuentaContable not like '%00'")->find();  //->filterByTipo(1) ?>
<?php //$cuentasDos = CuentaErpContableQuery::create()->find(); //->filterByTipo(2)  ?>




<div class="row">
    <div class="col-lg-12">
        <?php $link = "$_SERVER[REQUEST_URI]"; ?>
        <?php $link = str_replace('index.php', "", $link); ?>
        <?php $link = str_replace('venia_dev.php', "", $link); ?>
        <?php $link = str_replace('//', "", $link); ?>
        <?Php sfContext::getInstance()->getUser()->setAttribute("ruta", $link, 'seguridad'); ?>
        <?php include_partial('soporte/avisos') ?>   
        <h3><?php echo $partida->getVenta(); ?></h3>

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
                <?php // $listaCuentas = $cuentasUno; ?>
                <?php // if ($reg->getHaber()) { ?>
                    <?php // $listaCuentas = $cuentasDos; ?>
                <?php // } ?>
                <tr  <?php if (trim($reg->getCuentaContable())=="") { ?> style="background-color:#FFCC00 !important" <?php } ?> >
                    <td width="300px"  style="width:100% !important; <?php if (trim($reg->getCuentaContable())=="") { ?> background-color:#FFCC00 !important <?php } ?>"  >

                        <select width="100%" class="mi-selector form-control" name="cuenta<?php echo $reg->getId() ?>" id="cuenta<?php echo $reg->getId() ?>">
                            <?php foreach ($listaCuentas as $dat) { ?>
                                <option 
                                <?php if (trim($dat->getCuentaContable()) == trim($reg->getCuentaContable())) { ?>
                                        selected="selected"
                                    <?php } ?>
                                    value="<?php echo $dat->getCuentaContable(); ?>"><?php echo $dat->getCuentaContable(); ?> - <?php echo $dat->getNombre(); ?></option>
                                <?php } ?>
                                
   <?php if (trim($reg->getCuentaContable())=="") { ?>
                                <option value=""   selected="selected"> [Seleccione Cuenta ]   </option>
                                <?php } ?>
                             
                        </select>
                        <?php if (trim($reg->getCuentaContable())=="") { ?>
                        <br> 
                        
                        <?php echo $reg->getGrupo(); ?>-<?php echo $reg->getAdicional(); ?>
                        <?php } else { ?>
                        <br>
                      <?php echo $reg->getDetalle(); ?>
                        <?php } ?>
                     
                    </td>
    <!--                            <td><?php echo $reg->getCuentaContable() ?></td>
                    <td><?php echo $reg->getDetalle() ?></td>-->
                         <td style="text-align: right" ><?php echo Parametro::formato($reg->getDebe(),false) ?></td>
             
                    <td style="text-align: right"><?php echo Parametro::formato($reg->getHaber(),false); ?></td>
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


<div class="modal-footer">
    <a class="btn  btn-warning " href="<?php echo url_for('proceso/confirmaPartida?id=' . $partida->getId()) ?>" >
        <i class="flaticon2-cube-1 "></i> Confirmar 
    
<?php if ($partidaPen->getMedioPagoId()) { ?>    
<?php echo " ".$partidaPen->getMedioPago()->getNombre(); ?> 
<?php } ?>
        
        <?php if ($partidaPen->getTiendaId()) { ?>    
<?php echo " ".$partidaPen->getTienda()->getNombre(); ?> 
<?php } ?>
    </a> 
    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

</div>

<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php foreach ($partidaDeta as $reg) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#cuenta<?php echo $reg->getId(); ?>").on('change', function () {

                var valor = $("#cuenta<?php echo $reg->getId(); ?>").val();
                var id = <?php echo $reg->getId(); ?>;
                $.get('<?php echo url_for("proceso/actuaCuenta") ?>', {id: id, valor: valor}, function (response) {
                    $("#total_<?php echo $reg->getId(); ?>").html(response);
                });

            });
        });
    </script>
<?php } ?>

 
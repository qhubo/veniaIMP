
   <?php if (($bancover==1) or ($bancover==99)) { ?>
                <h3>FACTURAS DEL DIA</h3>
                <table class="table table-hover table-bordered table-striped">
    <thead>
        <tr class="info">
            <td>Fecha </td>
            <td>Tienda</td>
            <td>Usuario</td>
            <td> Documento </td>
            <td>Estatus </td>
            <td>Valor </td>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php  $can=0; ?>
        <?php foreach ($operaciones as $regi) { ?>
   <?php  $can++; ?>
          
       <?php $total = $total + $regi->getValorTotal(); ?>
            <tr>
                <td align="center"><font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>
                <td><font size="-2"><?php echo $regi->getTienda(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getCodigo(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getEstatus(); ?></font></td>
                <td align="right"><font size="-1"><strong><?php echo number_format($regi->getValorTotal(), 2); ?></strong></font></td>

            </tr>                       
        <?php } ?>
                <?php foreach ($operacionesCXC as $regi) { ?>
  <?php $total = $total + $regi->getValorTotal(); ?>
            <tr style="background-color: #FFF8D6">
                <td align="center"><font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>
                <td><font size="-2"><?php echo $regi->getTienda(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getCodigo(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getEstatus(); ?></font></td>
                <td align="right"><font size="-1"><strong><?php echo number_format($regi->getValorTotal(), 2); ?></strong></font></td>

            </tr>                     
        <?php } ?>
            
        <tr>
            <td align="right" colspan="5" class="bold">Total</td>
            <td align="right"><font size=""><strong><?php echo number_format($total, 2); ?></strong></font></td>

        </tr>

    </tbody>
</table>
        <?php } ?>
            
           <?php if (($bancover==2) or ($bancover==99)) { ?>
      <h3>VENTAS DEL  DIA</h3>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr class="info">
            <td>Codigo</td>
            <td>Producto</td>
            <td>Cantidad</td>
            <td>Valor </td>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($detalle as $regi) { ?>
            <?php $total = $total + $regi->getTotalValor(); ?>
            <tr>
                <td><font size="-2"><?php echo $regi->getCodigo(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getDetalle(); ?></font></td>
                <td align="right"><font size="-1"><strong><?php echo number_format($regi->getTotalCantidad(), 0); ?></strong></font></td>

                <td align="right"><font size="-1"><strong><?php echo number_format($regi->getTotalValor(), 2); ?></strong></font></td>

            </tr>
        <?php } ?>
        <tr>
            <td align="right" colspan="3" class="bold">Total</td>
            <td align="right"><font size=""><strong><?php echo number_format($total, 2); ?></strong></font></td>

        </tr>
    </tbody>

</table>
           <?php } ?>
<script src='/assets/global/plugins/jquery.min.js'></script>

<!--<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_monto_efectivo").on('change', function () {
            var val = parseFloat($("#consulta_monto_efectivo").val());
            var grantotal =parseFloat($("#totalefe").val());
            var granddepo= parseFloat( $("#granddepo").val());
            var total = parseFloat(granddepo+val);
            $("#exacto").hide();
            if (total == grantotal) {
                 $("#exacto").show();
            }
            
            
           
        $.get('<?php echo url_for("proceso_corte/valores") ?>', {grantotal: grantotal, total: total}, function (response) {
                $("#mensa").html(response);
            });
            
        });
    });
</script>-->


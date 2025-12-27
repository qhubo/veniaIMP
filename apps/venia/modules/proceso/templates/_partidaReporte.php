<?php $partida = PartidaQuery::create()->findOneById($id); ?>
<?php $partidaDeta = PartidaDetalleQuery::create()->filterByPartidaId($id)->find(); ?>


<br><br>
<table width="750px" cellpadding="5px" >


    <?Php $total1 = 0; ?>
    <?Php $total2 = 0; ?>
    <?php foreach ($partidaDeta as $reg) { ?>
        <?php $total1 = $reg->getDebe() + $total1; ?>
        <?php $total2 = $reg->getHaber() + $total2; ?>
        <tr>
              <td  width="30px" >&nbsp; </td>
            <td width="150px" ><?php echo $reg->getCuentaContable() ?></td>
            <td width="390px"><?php echo $reg->getDetalle() ?></td>
            <td  width="50px" style="text-align: right" ><?php echo Parametro::formato($reg->getDebe(), false) ?></td>
            <td  width="50px" style="text-align: right"><?php echo Parametro::formato($reg->getHaber(), false); ?></td>
        </tr>
    <?php } ?>

</table>





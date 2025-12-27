<table class="table table-bordered  ">

    <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Tienda</span></th>
        <td>        <h5><?php echo $orden->getTienda() ?></h5>  </td>
        <th align="center" width="80px"><span class="kt-font-success"></span></th>
        <td>     </td>
    </tr> 

    <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Observaciones </span></th>
        <td>        <?php echo $orden->getObservaciones() ?>  </td>
        <th align="center" width="80px"><span class="kt-font-success">Usuario </span></th>
        <td>    <?php echo $orden->getUsuario(); ?> </td>
    </tr>
</table>

<table class="table table-bordered  xdataTable table-condensed flip-content">
    <thead class="flip-content">
        <tr class="active">
            <th align="center"><span class="kt-font-success"><font size="-1"> Fecha </font> </span></th>
            <th align="center"><span class="kt-font-success"><font size="-1">Documento</font> </span></th>

            <th align="center"><span class="kt-font-success"><font size="-1">Cuenta</font></span></th>
            <th align="center"><span class="kt-font-success"><font size="-1">Concepto</font></span></th>      

            <th align="center"><span class="kt-font-success"><font size="-1">Valor</font></span></th>
            <th align="center"><span class="kt-font-success"><font size="-1">Iva</font></span></th>
            <th align="center"><span class="kt-font-success"><font size="-1">Retenido</font></span></th>
            <th align="center"><span class="kt-font-success"><font size="-1">Iva Retenido</font></span></th>
        </tr>
    </thead>
    <tbody>
        <?php $total1=0; ?>
        <?php $total2=0; ?>
        <?php $total3=0; ?> 
         <?php $total4=0; ?>
        <?php foreach ($lista as $orden) { ?>
           <?php $total1=$total1+$orden->getValor(); ?>
        <?php $total2=$total2+$orden->getIva(); ?>
        <?php $total3=$total3+$orden->getValorIsr(); ?> 
         <?php $total4= $total4+$orden->getValorRetieneIva(); ?>
            <tr>
                <td><font size="-1"> <?php echo $orden->getFecha() ?></font></td>
                <td><font size="-1"> <?php echo $orden->getSerie() ?> <?php echo $orden->getFactura() ?></font></td>
                <td><font size="-1">  <?php echo $orden->getCuenta() ?> </font></td>
                <td><font size="-1"> 
                    <?php echo $orden->getDescripcion() ?> 
                    <br>
                    <?php echo $orden->getProveedor() ?> 
</font>
                </td>

                <td style="text-align: right"><font size="-1"> <?php echo number_format($orden->getValor(), 2); ?></font> </td>
                <td style="text-align: right"><font size="-1"> <?php echo number_format($orden->getIva(), 2); ?></font> </td>
                <td style="text-align: right"><font size="-1"> <?php echo number_format($orden->getValorIsr(), 2); ?></font> </td>
                <td style="text-align: right"><font size="-1"> <?php echo number_format($orden->getValorRetieneIva(), 2); ?> </font></td>

            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"></td>
            <td colspan="2"><strong>Totales</strong></td>
             <td style="text-align: right"><font size="-1"> <?php echo number_format($total1, 2); ?></font> </td>
                <td style="text-align: right"><font size="-1"> <?php echo number_format($total2, 2); ?></font> </td>
                <td style="text-align: right"><font size="-1"> <?php echo number_format($total3, 2); ?></font> </td>
                <td style="text-align: right"><font size="-1"> <?php echo number_format($total4, 2); ?> </font></td>

        </tr>
    </tfoot>

</table>



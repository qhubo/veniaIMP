<table class="table table-bordered">
    <thead>
        <tr>
            <th><span class="kt-font-bold kt-font-success">Codigo</span></th>
            <th  ><span class="kt-font-bold kt-font-success">Detalle</span></th>
            <th align="center"><span class="kt-font-bold kt-font-success">Cantidad</span></th>
            <th  align="center" colspan="2" ><span align="center" class="kt-font-bold kt-font-success">Valor Total</span></th>

        </tr>
    </thead>
    <tbody>
        <?php $totalC = 0; ?>
        <?php foreach ($detalle as $reg) { ?>
            <?php $totalC = $reg->getValorTotal() + $totalC; ?>
            <tr>
                <td><?php echo $reg->getCodigo(); ?></td>
                <td><?php echo $reg->getDetalle(); ?>

                </td>
                <td align="right"><?php echo number_format($reg->getValorUnitario(), 2); ?></td>
                <td align="right"><?php echo $reg->getCantidad(); ?></td>
                <td align="right"><?php echo number_format($reg->getValorTotal(), 2); ?></td>

            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" align="right"> <strong>TOTAL</strong></td>
            <td align="right"><?php echo number_format($totalC, 2); ?></td>

        </tr>
    </tfoot>
</table>


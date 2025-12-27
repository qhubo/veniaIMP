

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">Detalle de la Cierre  <?php echo $operacion->getId() ?> 
                <small></small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <?php echo $operacion->getFechaCalendario('d/m/Y'); ?>
        </div>
    </div>
    <div class="kt-portlet__body">

        <h4>FACTURAS REGISTRADAS</h4>         
  <table class="table table-hover table-bordered table-striped">
    <thead>
        <tr class="info">
            <td>Fecha </td>
     
            <td> Documento </td>
            <td>Factura </td>
            <td>Valor </td>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($operaciones as $regi) { ?>
            <?php $total = $total + $regi->getValorTotal(); ?>
            <tr>
                <td align="center"> <font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>
  
                <td><font size="-2"><?php echo $regi->getCodigoFactura(); ?></font></td>
                <td><font size="-2"><?php echo $regi->getFaceRerenciaSat(); ?></font></td>
                <td align="right"><font size="-1"><?php echo number_format($regi->getValorTotal(), 2); ?></font></td>

            </tr>                       
        <?php } ?>
        <tr>
            <td align="right" colspan="3" class="bold">Total</td>
            <td align="right"><font size=""><strong><?php echo number_format($total, 2); ?></strong></font></td>

        </tr>

    </tbody>
</table>
  

      
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn dark btn-dark">Cancelar</button>

        </div>
    </div>
</div>
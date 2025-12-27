<!DOCTYPE html>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            max-height: 80px;
        }
        .header .info {
            text-align: right;
        }
        .header .info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
        }
           .info .label{font-weight:bold}
    </style>


    <!-- Encabezado -->
  <table class="info" style="width:740px;" role="presentation">
      <tr>
          <td style="width:120px;"></td>
           <td style="width:440px;">
        <strong><?php echo $NOMBRE_EMPRESA; ?></strong><br>
        <?php echo $DIRECCION; ?>  <br>      Tel: <?php echo $TELEFONO; ?> <br>

           </td>
           <td style="width:180px;">
              <strong>PEDIDO</strong><br>
        Fecha: <span><?php echo $operacion->getFecha('d/m/Y'); ?></span><br>
         Nº: <span style="font-weight:bold; font-size: 40px;" ><?php echo $operacion->getId(); ?></span><br>
    
      </td>
  </tr>
    </table>
    
        <div class="clear"></div>

    <table class="info"  style="width:740px;" role="presentation">
      <tr>
        <td class="label">Código de vendedor:</td>
        <td>    <?php echo $operacion->getVendedor()->getCodigo(); ?></td>
          <td class="label"></td>
        <td><?php //echo $CODIGO_CLIENTE; ?></td>

      </tr>
      <tr>
        <td class="label">Vendedor:</td>
        <td colspan="3"><?php echo $operacion->getVendedor()->getNombre(); ?></td>
      </tr>
      <tr>
        <td class="label">Observaciones:</td>
        <td colspan="3"><?php echo $operacion->getObservaciones(); ?></td>
      </tr>
    
    </table>

    <br>
    
    

    <!-- Detalle de productos -->
    <table style="width:740px;">
        <thead>
            <tr>
                <th style="height:20px; font-weight: bold;width:100px">Código </th>
                <th  style="height:20px; font-weight: bold;width:385px">Nombre</th>
                <th  style="height:20px; font-weight: bold;width:80px">Cantidad</th>
                <th  style="height:20px; font-weight: bold;width:100px"> Unitario</th>
                <th  style="height:20px; font-weight: bold;width:100px">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach($detalle as $regi) { ?>
            <?php $valor =$regi->getValorUnitario() * $regi->getCantidad(); ?>
            <?php $total = $valor+$total; ?>
            <tr>
                <td style="height:20px; width:100px"><?php echo $regi->getProducto()->getCodigoSku(); ?></td>
                <td style="width:370px"><?php echo $regi->getProducto()->getNombre(); ?></td>
                <td style="width:80px;text-align:right;"><?php echo $regi->getCantidad(); ?></td>
                <td style="width:90px;text-align:right;"><?php echo Parametro::formato($regi->getValorUnitario()); ?></td>
                <td style="width:100px;text-align:right;"><?php echo Parametro::formato($regi->getValorUnitario() * $regi->getCantidad()); ?></td>
            </tr>
            <?php } ?>
         
        </tbody>
    </table>

    <p class="total">Total Pedido: <?php echo Parametro::formato($total); ?></p>



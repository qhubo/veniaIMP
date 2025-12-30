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
              <strong>ACTUALIZA INVENTARIO</strong><br>
        Fecha: <span><?php echo $operacion->getFechaDocumento('d/m/Y'); ?></span><br>
         Nº: <span style="font-weight:bold; font-size: 40px;" ><?php echo $operacion->getId(); ?></span><br>
    
      </td>
  </tr>
  
        <tr>
          <td style="width:100px;"></td>
          <td style="width:520px;"  colspan="2">
                 <STRONG>Tienda</STRONG>
               
                                  <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $operacion->getTienda()->getNombre(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
               <STRONG>Documento</STRONG>
               
                   <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $operacion->getNumeroDocumento(); ?></span>
                     <STRONG>&nbsp;&nbsp;&nbsp;&nbsp;No Orden</STRONG>
               
                   <span>&nbsp;&nbsp;<?php echo $operacion->getNumeroOrden(); ?></span>
           </td>
       
  </tr>
    </table>
    
        <div class="clear"></div>


    <br>
    <table style="width:743px;">
        <tr>
     <th style=" font-weight: bold; font-size: 34px; height:30px; font-weight: bold;width:735px; text-align: center;">
    <?php echo $operacion->getObservaciones(); ?>
             </th>
        </tr>
    </table>
    <!-- Detalle de productos -->
   <table style="width:740px;">
        <thead>
            <tr>
                <th style="font-size:25px;height:15px; font-weight: bold;width:115px; text-align: center;">Código </th>
                <th  style="font-size:25px;height:20px; font-weight: bold;width:390px;text-align: center;">Nombre</th>
                <th  style="font-size:25px;height:20px; font-weight: bold;width:55px;text-align: center;">Cantidad</th>
                <th  style="font-size:25px;height:20px; font-weight: bold;width:50px;text-align: center;">Costo</th>
<!--                <th  style="font-size:25px;height:20px; font-weight: bold;width:80px;text-align: center;">Ubicacion</th>-->
                <th  style=" font-size:25px; height:20px; font-weight: bold;width:125px;text-align: center;">Costo Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach($detalle as $regi) { ?>
            <?php $total = $total+($regi->getCantidad()*$regi->getProducto()->getCostoProveedor()); ?>
    
   
            <tr>
                <td style="height:15px; font-size:27px; width:120px"><?php echo $regi->getProducto()->getCodigoSku(); ?></td>
                <td style="width:350px; font-size:27px;width:390px "><?php echo $regi->getProducto()->getNombre(); ?></td>
                <td style="width:55px;text-align:right;font-size:27px; width:50px"><?php echo $regi->getCantidad(); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="width:50px;text-align:right;font-size:27px; "><?php echo  Parametro::formato($regi->getProducto()->getCostoProveedor(),false); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<!--                <td style="width:90px;text-align:right;font-size:27px; "><?php //echo $regi->getTienda()->getCodigo(); ?>&nbsp;<?php echo $regi->getUbicacion(); ?></td>-->
                <td style="width:125px;text-align:right;font-size:27px; "><?php echo Parametro::formato(($regi->getCantidad()*$regi->getProducto()->getCostoProveedor()),false); ?></td>

            </tr>
            <?php } ?>
            <tr>
                <td colspan="6"  style="width:530px;font-weight:bold; font-size: 48px; text-align: right;"> TOTAL </td>
                <td style="width:180px;text-align:right; font-size: 48px; text-align: right;"><?php echo Parametro::formato ($total); ?></td>

            </tr>
         
        </tbody>
    </table>






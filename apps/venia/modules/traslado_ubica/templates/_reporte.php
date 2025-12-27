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
  <table class="info" style="width:740px; background-color: whitesmoke" role="presentation">
      <tr style="height:100px;">
          <td style="width:120px;"></td>
           <td style="width:440px;">
        <strong><?php echo $NOMBRE_EMPRESA; ?></strong><br>
        <?php echo $DIRECCION; ?>  <br>      Tel: <?php echo $TELEFONO; ?> <br>

           </td>
           <td style="width:180px;height:40px">
              <strong>TRASLADO UBICACION</strong><br>
        Fecha: <span><?php echo $operacion->getFecha('d/m/Y'); ?></span><br>
         Nº: <span style="font-weight:bold; font-size: 40px;" ><?php echo $operacion->getCodigo(); ?></span><br>
    
      </td>
  </tr>
  
            <tr style="height:100px;">
          <td style="width:100px;height:40px"></td>
           <td style="width:440px;">
                 <STRONG>Tienda</STRONG>
               
                                  <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $operacion->getTienda()->getNombre(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>

           </td>
           <td style="width:180px;">

      </td>
  </tr>
    </table>
    
        <div class="clear"></div>


    <br>
    <table style="width:740px;">
        <tr>
     <th style=" font-weight: bold; font-size: 34px; height:30px; font-weight: bold;width:730px; text-align: center;">
    <?php echo $operacion->getObservaciones(); ?>
             </th>
        </tr>
    </table>
    <!-- Detalle de productos -->
    <table style="width:740px;">
        <thead>
            <tr>
                <th style="font-size:25px;height:15px; font-weight: bold;width:115px; text-align: center;">Código </th>
                <th  style="font-size:25px;height:20px; font-weight: bold;width:340px;text-align: center;">Nombre</th>
                <th  style="font-size:25px;height:20px; font-weight: bold;width:55px;text-align: center;">Cantidad</th>
                <th  style="font-size:25px;height:20px; font-weight: bold;width:100px;text-align: center;">Ubicacion Original</th>
                <th  style="font-size:25px;height:20px; font-weight: bold;width:120px;text-align: center;">Nueva Ubicacion</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach($detalle as $regi) { ?>
      
   
            <tr>
                <td style="height:15px; font-size:27px; width:115px"><?php echo $regi->getProducto()->getCodigoSku(); ?></td>
                <td style="width:340px; font-size:27px; "><?php echo $regi->getProducto()->getNombre(); ?></td>
                <td style="width:55px;text-align:right;font-size:27px; width:70px"><?php echo $regi->getCantidad(); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="width:50px;font-size:27px; width: 100px; "><?php echo  $regi->getUbicacionOriginal(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="width:55px;font-size:27px; width:105px"><?php echo substr($regi->getTienda()->getNombre(),0,10); ?><br>
                    <?php echo $regi->getNuevaUbicacion(); ?>
                </td>
           
            </tr>
            <?php } ?>
       
         
        </tbody>
    </table>





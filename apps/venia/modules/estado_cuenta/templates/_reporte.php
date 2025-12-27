
  <style>
    /* Estilos mínimos compatibles con TCPDF */
    body{font-family:helvetica, Arial, sans-serif; font-size:12px; color:#000;}
    .container{width:100%;padding:8px}
    .header{width:100%;margin-bottom:8px}
    .header .left{float:left;width:60%}
    .header .right{float:right;width:38%;text-align:right}
    .clear{clear:both}

    table{width:100%;border-collapse:collapse}
    .info td{padding:4px 6px}
    .info .label{font-weight:bold}
    .box{border:1px solid #000;padding:6px}

    .detalle th, .detalle td{border:1px solid #000;padding:6px;text-align:left}
    .detalle th{background:#e9e9e9}

    .firmas td{padding-top:24px;text-align:center}
  </style>
  <table class="info" style="width:750px;" role="presentation">
      <tr>
          <td style="width:120px;"></td>
           <td style="width:450px;">
        <strong><?php echo $NOMBRE_EMPRESA; ?></strong><br>
        <?php echo $DIRECCION; ?>  <br>      Tel: <?php echo $TELEFONO; ?> <br>
        <span style="font-weigth:bold; font-size: 54px;"> <?php echo $clienteQ->getNombre(); ?> </span>
           </td>
           <td style="width:500px;">
              <strong>Estado de cuenta </strong><br>
        Fecha: <span><?php //echo $operacionPago->getFechaCreo('d/m/Y'); ?></span><br>
        Codigo Cliente: <br> <span style="font-weight:bold; font-size: 40px;" ><?php echo $clienteQ->getCodigo(); ?></span><br>
    
      </td>
  </tr>
    </table>

    <div class="clear"></div>


    <br>
    
    

    <!-- DETALLE: tabla principal -->
    <table class="detail" style="width: 720px;" role="table" aria-label="Detalle de movimientos">
      <thead>
        <tr>
          <th style="width:120px; font-weight: bold;">Documento</th>
          <th style="width:110px;font-weight: bold;">Fecha</th>
          <th style="text-align: right;width:80px;font-weight: bold;" class="text-right">Cargo</th>
          <th style="text-align: right;width:80px;font-weight: bold;" class="text-right">Abono</th>
          <th style="text-align: right;width:80px;font-weight: bold;" class="text-right">Saldo</th>
          <th style="width:380px;font-weight: bold;">Descripción</th>
        </tr>
      </thead>

      <tbody>
        <!--
          Reemplaza estas filas de ejemplo por tus datos.
          Asegúrate de formatear números con dos decimales y fechas en el formato deseado.
        -->
        <?php $total1 =0; ?>
        <?php $total2 =0; ?>
        <?php $total3 =0; ?>

        <?php foreach($detalle as $data) { ?>
        <?php $total1 =$total1+$data['cargo']; ?>
        <?php $total2 =$total2+$data['abono']; ?>
        <?php $total3 =$total3+$data['saldo']; ?>

        <tr>
          <td style="width:120px;"><?php echo $data['codigo']; ?></td>
          <td   style="width:110px; text-align: center;" class="text-center"><?php echo $data['fecha']; ?></td>
          <td style="width:80px; text-align: right;"  class="text-right"><?php echo Parametro::formato($data['cargo'], false); ?></td>
          <td style="width:80px; text-align: right;"  class="text-right"><?php echo Parametro::formato($data['abono'], false); ?></td>
          <td style="width:80px; text-align: right;"  class="text-right"><?php echo Parametro::formato($data['saldo'], false); ?></td>
          <td style="width:300px; font-size: 24px;" ><?php echo $data['descripcion']; ?></td>
        </tr>
        <?php } ?>

       

        <!-- Añade más filas según necesites -->
      </tbody>

      <tfoot>
        <tr class="totales">
          <td colspan="2">Totales</td>
        <td style="width:80px; text-align: right;"  class="text-right"><?php echo Parametro::formato($total1, false); ?></td>
          <td style="width:80px; text-align: right;"  class="text-right"><?php echo Parametro::formato($total2, false); ?></td>
          <td style="width:80px; text-align: right;"  class="text-right"><?php echo Parametro::formato($total3, false); ?></td>
          <td></td>
        </tr>
      </tfoot>
    </table>

    <div class="footer">
      <div>Observaciones: ........................................................................................................</div>
      <div style="margin-top:8px;">Firma: ____________________________________________</div>
    </div>
  </div>

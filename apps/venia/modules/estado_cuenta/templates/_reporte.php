
  <style>
    /* Estilos mÃ­nimos compatibles con TCPDF */
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
 <style>
    .borde { border: 0.2px solid #1f1f1e; }
</style>

<!-- ================= TITULO ================= -->
<table width="100%">
    <tr>
        <td style="text-align:center;">
            <span style="font-weight:bold; font-size:28px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ESTADO DE CUENTA
            </span>
        </td>
    </tr>
</table>

<br>

<!-- ================= HEADER ================= -->
<table width="100%">
    <tr>
        <td width="60%">
            <span style="font-size:27px; font-weight:bold;">
                <?php echo $NOMBRE_EMPRESA; ?>
            </span><br>

            <span style="font-size:28px;;">
            Calle principal, France Field, Lote 10, Manzana 23, Bodega Golden Apple Auto Parts,
            <br>&nbsp;&nbsp;&nbsp;&nbsp;Zona Libre de Colón, Panamá
            </span><br>

            <span style="font-size:28px;;">
                Tel: <?php echo $TELEFONO; ?>
            </span>
        </td>

        <td width="40%" style="text-align:right;">
            <span style="font-size:29px; font-weight:bold;">Fecha:</span>
            <span style="font-size:28px;"><?php echo date('d/m/Y'); ?></span><br>

            <span style="font-size:29px; font-weight:bold;">Código Cliente:</span><br>

            <span style="font-size:27px;">
                <?php echo $clienteQ->getCodigo(); ?>
            </span>
        </td>
    </tr>
</table>

<br>

<!-- ================= CLIENTE ================= -->
<table width="100%">
    <tr>
        <td style="font-size:33px; padding:8px;">
            <strong>Cliente:</strong> 
            <?php echo $clienteQ->getNombre(); ?>
        </td>
    </tr>
</table>

<br>

<!-- ================= SALDO ================= -->
<table width="100%">
    <tr>
        <td width="70%" style="font-size:29px; padding:8px;">

        </td>

        <td class="borde" width="30%"  style="height: 35px; font-size:35px; text-align:right; padding:8px;">
            <strong>SALDO ACTUAL</strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;
            <strong><?php echo Parametro::formato($SALDO, true); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</table>

<br>

    <br>
    
    

    <!-- DETALLE: tabla principal -->
    <table class="detail" style="width: 720px;" role="table" aria-label="Detalle de movimientos">
      <thead>
        <tr>
          <th style="width:100px; font-weight: bold;">Documento</th>
          <th style="width:90px;font-weight: bold;">Fecha</th>
          <th style="text-align: right;width:80px;font-weight: bold;" class="text-right">Cargo</th>
          <th style="text-align: right;width:80px;font-weight: bold;" class="text-right">Abono</th>
          <th style="text-align: right;width:80px;font-weight: bold;" class="text-right">Saldo</th>
          <th style="width:380px;font-weight: bold;">Descripción</th>
        </tr>
      </thead>

      <tbody>
        <!--
          Reemplaza estas filas de ejemplo por tus datos.
          AsegÃºrate de formatear nÃºmeros con dos decimales y fechas en el formato deseado.
        -->
        <?php $total1 =0; ?>
        <?php $total2 =0; ?>
        <?php $total3 =0; ?>
<?php $saldoU =0; ?>
        <?php foreach($detalle as $data) { ?>
        <?php $total1 =$total1+$data['cargo']; ?>
        <?php $total2 =$total2 +  $data['abono']; ?>

<?php $saldoU =$data['saldo']; ?>
        <tr>
          <td style="width:100px;font-size: 27px;"><?php echo $data['codigo']; ?></td>
          <td   style="width:90px; text-align: center;font-size: 27px;" class="text-center"><?php echo $data['fecha']; ?></td>
          <td style="width:80px; text-align: right;font-size: 27px;"  class="text-right"><?php echo Parametro::formato($data['cargo'], false); ?></td>
          <td style="width:80px; text-align: right;font-size: 27px;"  class="text-right"><?php echo Parametro::formato($data['abono'], false); ?></td>
          <td style="width:80px; text-align: right;font-size: 27px;"  class="text-right"><?php echo $saldov=  Parametro::formato($data['saldo'], false); ?></td>
          <td style="width:280px; font-size: 26px;" ><?php echo html_entity_decode($data['descripcion']); ?></td>
        </tr>
        <?php } ?>

       

        <!-- AÃ±ade mÃ¡s filas segÃºn necesites -->
      </tbody>

      <tfoot>
          <tr class="totales" style="background-color:whitesmoke">
            <td colspan="2" style="font-weight:bold;" >Totales</td>
        <td style="width:80px; text-align: right; font-weight:bold;"  class="text-right"><?php echo Parametro::formato($total1, false); ?></td>
          <td style="width:80px; text-align: right; font-weight:bold;"  class="text-right"><?php echo Parametro::formato($total2, false); ?></td>
          <td style="width:80px; text-align: right; font-weight:bold;"  class="text-right"><?php  echo Parametro::formato($saldoU, false); ?></td>
          <td></td>
        </tr>
      </tfoot>
    </table>

    <div class="footer">
      <div>&nbsp;&nbsp;&nbsp;Observaciones: ........................................................................................................</div>
      <div style="margin-top:8px;">&nbsp;&nbsp;&nbsp;Firma: ____________________________________________</div>
    </div>

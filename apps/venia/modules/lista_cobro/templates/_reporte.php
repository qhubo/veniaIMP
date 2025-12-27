
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
          <td style="width:100px;"></td>
           <td style="width:450px;">
        <strong><?php echo $NOMBRE_EMPRESA; ?></strong><br>
        <?php echo $DIRECCION; ?>  <br>      Tel: <?php echo $TELEFONO; ?> <br>
        <?php echo $operacionPago->getOperacion()->getTienda()->getNombre(); ?>
           </td>
           <td style="width:500px;">
              <strong>RECIBO DE PAGO</strong><br>
        Fecha: <span><?php echo $operacionPago->getFechaCreo('d/m/Y'); ?></span><br>
        Recibo Nº: <span style="font-weight:bold; font-size: 40px;" ><?php echo $operacionPago->getCodigo(); ?></span><br>
    
      </td>
  </tr>
    </table>

    <div class="clear"></div>

    <table class="info" role="presentation">
      <tr>
        <td class="label">Código de cliente:</td>
        <td><?php echo $CODIGO_CLIENTE; ?></td>
        <td class="label">Código de vendedor:</td>
        <td>    <?php echo $operacionPago->getOperacion()->getUsuario(); ?></td>
      </tr>
      <tr>
        <td class="label">Vendedor:</td>
        <td colspan="3"><?php  if ($operacionPago->getOperacion()->getVendedorId()) { echo $operacionPago->getOperacion()->getVendedor()->getNombre();  } ?></td>
      </tr>
      <tr>
        <td class="label">Recibimos de:</td>
        <td colspan="3"><?php echo $operacionPago->getOperacion()->getNombre(); ?></td>
      </tr>
      <tr>
        <td class="label">Número de factura:</td>
        <td><?php echo $operacionPago->getOperacion()->getCodigo(); ?></td>
        <td class="label">Fecha factura:</td>
        <td><?php echo $operacionPago->getOperacion()->getFecha('d/m/Y'); ?></td>
      </tr>
    </table>

    <br>

    <table class="detalle" role="table">
      <thead>
        <tr>
           <td style="height: 20px; width:200px; font-weight: bold; " class="label">Medio de pago</td>
          <td style="width:300px; font-weight: bold;" class="label">Banco / Documento</td>
        <td  style="width:220px; font-weight: bold;"class="label">Valor</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width:200px; height: 25px;" > <?php echo $operacionPago->getTipo(); ?></td>
          <td style="width:300px;"> <?php if ($operacionPago->getBancoId()) { ?><?php echo $operacionPago->getBanco()->getNombre(); ?> <?php } ?> <?php echo $operacionPago->getDocumento(); ?> </td>
          <td style="width:220px;"> <?php echo Parametro::formato($operacionPago->getValor(),2); ?></td>
        </tr>
        <?php if ($operacionPago->getComision()) { ?>
           <tr>
          <td style="width:200px; height: 25px;" > </td>
          <td style="width:300px; font-weight: bold;" class="label"> Comisión </td>
          <td style="width:220px;"> <?php echo Parametro::formato($operacionPago->getComision(),2); ?></td>
        </tr>
        <?php } ?>
        
      </tbody>
    </table>

    <br>

    <table class="info" role="presentation">
      <tr>
        <td class="label">TOTAL RECIBO:</td>
        <td><?php echo Parametro::formato($operacionPago->getValor()+$operacionPago->getComision(),2); ?></td>
      </tr><!-- comment -->
        <tr>
        <td class="label">Cantidad en Letras:</td>
        <td><?php echo $TOTAL_LETRAS; ?></td>
      </tr>
    </table>

    <br>

    <table class="firmas" style="width:720px;" role="presentation">
      <tr>
        <td width="50%" class="box">
          Firma del receptor<br><br>
          ____________________________
        </td>
        <td width="50%" class="box">
          Firma del cliente<br><br>
          ____________________________
        </td>
      </tr>
    </table>
    <br>
    <table style="width:700px;">
        <tr>
            <td style="font-size:24px; text-align: center">ESTE ES EL ÚNICO DOCUMENTO LEGAR QUE LE RECONOCEMOS COMO COMPROBANTE DE PAGO TOTAL O PARCIAL SI FUERA EFECTUADO CON CHEQUE ESTARA CONDICIONADO A PRIMERA PRESENTACION DE LO CONTRARIO QUEDARA ANULADO</td>
        </tr>
    </table>

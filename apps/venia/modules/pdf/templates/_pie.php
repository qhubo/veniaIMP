<?php $tamanoLogo = $wlogo*3; ?>
    <?php $wlogo = $wlogo + 110; ?>

<?php $max = 255; ?>
<?php $maxPx = 550; ?>
<?php if ($pos == 1) { ?>
    <?php $uno = $wlogo . 'px'; ?>
    <?php $dos = '2px'; ?>
    <?php $tres = '2px'; ?>
<?php } ?>
<?php if ($pos == 2) { ?>
    <?php $uno = '2px'; ?>
    <?php $dos = $wlogo . 'px'; ?>
    <?php $tres = '2px'; ?>
<?php } ?>
<?php if ($pos == 3) { ?>
    <?php $uno = '2px'; ?>
    <?php $dos = '2px'; ?>
    <?php $tres = $wlogo . 'px'; ?>
<?php } ?>
<?php $pix = ($ancho * $maxPx) / 255; ?>
<?php $pix = $pix - 5 - 2 - 2; ?>
<?php $mitadPi = (int) $pix / 2; ?>
<?php $mitadPi = (int) $mitadPi; ?>
<?php $mitadPi = $mitadPi . "px"; ?>
<?php $maximo = $mitadPi + $mitadPi + 4 + $wlogo ?>
<?php $maximoCompleto = $mitadPi + $mitadPi + 4 + $wlogo; ?>
<?php $sT="font-size:".$Titulo_no."px; "; ?>
<?php $sT .="color:".$Titulo_Color.";"; ?>
<?php if ($Titulo_Bold) { ?>
<?php $sT .="font-weight: bold;"; ?>
<?php } ?>
<?php $sL="font-size:".$linea_no."px; "; ?>
<?php $sL .="color:".$linea_Color.";"; ?>
<?php if ($linea_Bold) { ?>
<?php $sL .="font-weight: bold;"; ?>
<?php } ?>
<br>
<br>

<?php $boder='border: 0.2px solid '.$colorBorder.';'; ?>
<?php $boderBottom='border-bottom: 0.2px solid '.$colorBorder.';'; ?>
<?php $boderR='border-right: 0.2px solid '.$colorBorder.';'; ?>
<?php $boderL='border-left: 0.2px solid '.$colorBorder.';'; ?>
<?php $boderT='border-top: 0.2px solid '.$colorBorder.';'; ?>
<?php if ($valoresDefault['Certificacion']['anulaNumeroAutorizacion']<> "") { ?>
<table cellspacing="0" cellpadding="0" >
    <tr>
        <td></td>
        <td style="<?php echo $boderL; ?> <?php echo $boderR; ?> <?php echo $boderT; ?> text-align:right; <?php echo $sL; ?>"><span style="font-size: 24px; font-weight: bold">Factura Documento Origen &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    </tr>
      <tr>
          <td></td>
          <td style="<?php echo $boderL; ?> <?php echo $boderR; ?> text-align:right;<?php echo $sL; ?>">
              <span style=""><strong>Autorización</strong></span> 
              <?php echo $valoresDefault['Certificacion']['anulaNumeroAutorizacion'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <br>
      <span style=""><strong>Serie:</strong></span>
              <?php echo $valoresDefault['CertificacionF']['anulaSerie'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
   
    <tr>
        <td></td>
          <td  style="<?php echo $boderL; ?> <?php echo $boderR; ?> <?php echo $boderBottom; ?> text-align:right;<?php echo $sL; ?>">
              <span style=""><strong> Número de DTE:</strong> </span>
 <?php echo $valoresDefault['CertificacionF']['anulaNumero'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
</table>
<br>
<?php } ?>

<table cellspacing="0" cellpadding="0" >
<!--    <tr>
        <td></td>
        <td style="<?php echo $boderL; ?> <?php echo $boderR; ?> <?php echo $boderT; ?> text-align:right; <?php echo $sL; ?>"><span style=""> Sujeto a Pagos Trimestrales ISR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    </tr>-->
      <tr>
                  <td></td>
          <td style="<?php echo $boderL; ?> <?php echo $boderR; ?><?php echo $boderT; ?> text-align:right;<?php echo $sL; ?>"><span style=""><strong>Certificador</strong> <?php echo $valoresDefault['Certificacion']['NombreCertificador'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    </tr>
    <tr>
                <td></td>
          <td  style="<?php echo $boderL; ?> <?php echo $boderR; ?> <?php echo $boderBottom; ?> text-align:right;<?php echo $sL; ?>"><span style="">NIT: <?php echo $valoresDefault['Certificacion']['NITCertificador'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    </tr>
</table>












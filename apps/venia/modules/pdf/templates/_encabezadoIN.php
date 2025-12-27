
<?php $tamanoLogo = $wlogo * 2; ?>
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
<?php $sT = "font-size:" . $Titulo_no . "px; "; ?>
<?php $sT .= "color:" . $Titulo_Color . ";"; ?>
<?php if ($Titulo_Bold) { ?>
    <?php $sT .= "font-weight: bold;"; ?>
<?php } ?>
<?php $sL = "font-size:" . $linea_no . "px; "; ?>
<?php $sL .= "color:" . $linea_Color . ";"; ?>
<?php if ($linea_Bold) { ?>
    <?php $sL .= "font-weight: bold;"; ?>
<?php } ?>
<?php $imprimeTIpo = true; ?>
<?php if (($UNA_LINEA) && ($PosicionLogo == "SUPERIOR-CENTRO")) { ?>
    <?php $imprimeTIpo = false; ?>
<?php } ?>
<?php if ($imprimeTIpo) { ?>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td style="text-align:center;">
                <span style="font-weight: bold; font-size:24px;background-color:#FFF; "><?php echo $valoresDefault['GENERALES']['Tipo']; ?></span>
            </td>
        </tr>
    </table>
<?php } ?>
<?php if (!$UNA_LINEA) { ?>

    <?php $maximo = $maximo . "px"; ?>
    <table cellspacing="0" cellpadding="0" width="740px;">
        <tr>
         
            <td width="300px;"><span style="<?php echo $sT; ?>"><?php echo $valoresDefault['EMISOR']['NombreComercial']; ?> </span>
                <br><span style="<?php echo $sT; ?>"><?php echo $valoresDefault['EMISOR']['NombreEmisor']; ?></span>
                <br><span style="<?php echo $sT; ?>">Nit Emisor: </span> <?php if ($ancho < 146) { ?><br><?php } ?><span style="<?php echo $sL; ?>"> <?php echo $valoresDefault['EMISOR']['NITEmisor']; ?></span>
                <br><span style="<?php echo $sL; ?>"><?php echo trim($valoresDefault['EMISOR']['DireccionEmisor']['Direccion']['Direccion']); ?></span>
            </td>
            <td width="<?php echo $dos; ?>">&nbsp;</td>
            <td width="<?php echo $mitadPi; ?>" style="text-align: left"><span style="<?php echo $sT; ?>">Serie:</span> <span style="<?php echo $sL; ?>"><?php echo $valoresDefault['CertificacionF']['Serie']; ?></span>
                             
                <br><span style="<?php echo $sT; ?>">Número de DTE:</span> <span style="<?php echo $sL; ?>"><?php echo $valoresDefault['CertificacionF']['Numero']; ?></span>
                 <br><span style="<?php echo $sT; ?>">Autorización</span>&nbsp;&nbsp;<span style="<?php echo $sL; ?>"><?php echo $valoresDefault['Certificacion']['NumeroAutorizacion']; ?></span>

<!--                <br><span style="<?php echo $sT; ?>">&nbsp;&nbsp;Número Acceso:</span> <span style="<?php echo $sL; ?>"><?php //echo $valoresDefault['CertificacionF']['Numero']; ?></span>
    -->
            </td>
            <td width="<?php echo $tres; ?>">&nbsp;</td>
        </tr>

    </table>
    <?php if ($tamanoLogo == 120) { ?>
<!--        <br>-->
    <?php } ?>
    <?php if ($tamanoLogo == 180) { ?>
<!--        <br><br><br><br>-->
    <?php } ?>

<?php } ?>
<?php if ($UNA_LINEA) { ?>
    <?php if ($tamanoPapel == 'A5V') { ?>
        <?php $maximo = $maximo - 600; ?>

    <?php } else if ($tamanoPapel == 'A3') { ?>
        <?php $maximo = $maximo - 10; ?>

    <?php } else { ?>
        <?php $maximo = $maximo - 30; ?>
    <?php } ?>  
    <table cellspacing="0" cellpadding="0" width="<?php echo $maximo . "px"; ?>">
        <tr>
            <td style="text-align: center" width="<?php echo $maximo . "px"; ?>">
                <?php if ($PosicionLogo == "SUPERIOR-CENTRO") { ?>
                    <img src="<?php echo $urlImage; ?>" width="<?php echo $tamanoLogo; ?>px">
                <?php } ?>
                <br>
                <table cellspacing="0" cellpadding="0">
                    <!--    <tr>
        <td style="text-align:center;">
            <span style="font-weight: bold; font-size:9px;background-color:#FFF; "><?php echo $valoresDefault['GENERALES']['Tipo']; ?></span></td>
    </tr>-->
                </table> <br><span style="<?php echo $sT; ?>"> <?php echo $valoresDefault['EMISOR']['NombreComercial']; ?> </span>
                <br><span style="<?php echo $sT; ?>"> <?php echo $valoresDefault['EMISOR']['NombreEmisor']; ?> </span>
                <br><span style="<?php echo $sT; ?>">NIT Emisor</span> <span style="<?php echo $sL; ?>"> <?php echo $valoresDefault['EMISOR']['NITEmisor']; ?></span>
                <br><span style="<?php echo $sL; ?>"><?php echo $valoresDefault['EMISOR']['DireccionEmisor']['Direccion']['Direccion']; ?></span>
            </td>

        </tr>

        <tr>

            <td style="text-align: center" width="<?php echo $maximo . "px"; ?>">

                <span style="<?php echo $sT; ?>">Autorización:</span>
                <br><span style="<?php echo $sL; ?>"><?php echo $valoresDefault['Certificacion']['NumeroAutorizacion']; ?></span>
                <br><span style="<?php echo $sT; ?>">Serie:</span><span style="<?php echo $sL; ?>"> <?php echo $valoresDefault['CertificacionF']['Serie']; ?></span>
                <br><span style="<?php echo $sT; ?>">Número de DTE:</span> <span style="<?php echo $sL; ?>"><?php echo $valoresDefault['CertificacionF']['Numero']; ?></span>

            </td>

        </tr>

    </table><?php $sT = "font-size:" . ($Titulo_no + 1) . "px; "; ?>
    <?php $sT .= "color:" . $Titulo_Color . ";"; ?>
    <?php if ($Titulo_Bold) { ?>
        <?php $sT .= "font-weight: bold;"; ?>
    <?php } ?>
    <?php $sL = "font-size:" . ($linea_no + 1) . "px; "; ?>
    <?php $sL .= "color:" . $linea_Color . ";"; ?>
    <?php if ($linea_Bold) { ?>
        <?php $sL .= "font-weight: bold;"; ?>
    <?php } ?>
   
    <hr style="  border-top: 1px dashed red;">
    <table cellspacing="0" cellpadding="0" width="<?php echo $maximo . "px"; ?>">
    
        <tr>
            <td style="text-align: center" width="<?php echo $maximo . "px"; ?>">
                <span style="<?php echo $sT; ?>">&nbsp;&nbsp;Nombre: </span> <?php if ($ancho < 146) { ?><br><?php } ?><span style="<?php echo $sL; ?>"> <?php echo $valoresDefault['RECEPTOR']['NombreReceptor']; ?></span>


                <br><span style="<?php echo $sT; ?>">&nbsp;&nbsp;Nit: </span><span style="<?php echo $sL; ?>">&nbsp;&nbsp;<?php echo $valoresDefault['RECEPTOR']['IDReceptor']; ?></span>
                <br><span style="<?php echo $sT; ?>">&nbsp;&nbsp;Fecha: </span><span style="<?php echo $sL; ?>">&nbsp;&nbsp;<?php echo $valoresDefault['GENERALES']['FechaHoraEmision'] ?></span>&nbsp;&nbsp; <span style="<?php echo $sT; ?>">&nbsp;&nbsp;&nbsp;&nbsp;Fecha Certificación: </span><span style="<?php echo $sL; ?>">&nbsp;&nbsp;<?php echo $valoresDefault['GENERALES']['FechaHoraCertifica'] ?></span>&nbsp;&nbsp;
            </td>
        </tr>
   
    </table>
  
<?php } ?>
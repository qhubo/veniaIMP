<?php include_partial('proceso/estilo') ?> 
<?php $espacios = '&nbsp;&nbsp;'; ?>
<?php if (!$UNA_LINEA) { ?>
    <?php $sT = "font-size:" . ($Titulo_no + 1) . "px; "; ?>
    <?php $sT .= "color:" . $Titulo_Color . ";"; ?>
    <?php if ($Titulo_Bold) { ?>
        <?php $sT .= "font-weight: bold;"; ?>
    <?php } ?>
    <?php $sL = "font-size:" . ($linea_no + 1) . "px; "; ?>
    <?php $sL .= "color:" . $linea_Color . ";"; ?>
    <?php if ($linea_Bold) { ?>
        <?php $sL .= "font-weight: bold;"; ?>
    <?php } ?>
 
    <?php $espacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
<table cellpadding="0" width="100%">
        <tr>
            <td>
                <span style="<?php echo $sT; ?>;  text-align: right;">Nombre&nbsp;&nbsp;&nbsp;</span>
                <span style="border: 1px solid red;<?php echo $sL; ?>; text-left: left;"><?php echo $valoresDefault['RECEPTOR']['NombreReceptor']; ?> <?php echo $espacios; ?><?php echo $espacios; ?></span>
                <span style="<?php echo $sT; ?>; text-align: right; ">&nbsp;&nbsp;&nbsp;</span>
                <span style="<?php echo $sL; ?>; text-align: left;"></span>
                <span style="<?php echo $sT; ?>; text-align: right; "></span>
                <span style="<?php echo $sL; ?>; text-align: left;"></span>
            </td>
        </tr>
        <tr>
            <td>
                <span style="<?php echo $sT; ?>; text-align: right; ">Nit&nbsp;&nbsp;&nbsp;</span>
                <span style="<?php echo $sL; ?>; text-align: left;"><?php echo $valoresDefault['RECEPTOR']['IDReceptor']; ?><?php echo $espacios; ?><?php echo $espacios; ?></span>
                <span style="<?php echo $sT; ?>; text-align: right; ">&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;</span>
                <span style="<?php echo $sL; ?>; text-align: left;"><?php echo $valoresDefault['GENERALES']['FechaFactura'] ?></span>
                <span style="<?php echo $sT; ?>; text-align: right; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Certificación&nbsp;&nbsp;&nbsp;</span>
                <span style="<?php echo $sL; ?>; text-align: left;"><?php echo $valoresDefault['GENERALES']['FechaHoraCertifica'] ?></span>
            </td>
              </tr>
    </table>
<table cellpadding="3" width="100%">
          <tr>
              <td style="width: 7px;" ></td>
              <td  class="arriba   izqui" style="height: 20px;  width:70px; font-size:22px; font-weight: bold;  ">Vendedor&nbsp;&nbsp;&nbsp;</td>
                <td class="arriba   "  style="width:140px; font-size:22px; ; text-left: left;"> <?php echo $valoresDefault['VENDEDOR']; ?> </td>
                <td class="arriba   "  style="width:70px; font-size:22px;font-weight: bold;; text-align: right; ">Tipo de Pago</td>
                <td class="arriba  "  style="width:100px; font-size:22px; ; text-align: left;"> <?php echo $valoresDefault['TIPO_PAGO']; ?></td>
                <td class="arriba   " style="width:70px;  font-size:22px; font-weight: bold;text-align: right; ">TRANSPORTE</td>
                <td class="arriba  dere "  style="width:137px;  font-size:22px; text-align: left;"><?php echo $valoresDefault['TRANSPORTE']; ?></td>
        </tr>
           <tr>
           <td style="width:7px;" ></td>
              <td class=" abajo  izqui" style="  width:75px; font-size:22px; font-weight: bold;  ">COD&nbsp;CLIENTE&nbsp;</td>
              <td class=" abajo  "  style="width:140px; font-size:22px; ; text-left: left;"> <?php echo html_entity_decode($valoresDefault['CODIGO_CLIENTE']); ?></td>
                <td  colspan="3" class=" abajo dere "  style="width:372px; font-size:18px; text-align:justify; ">
                    A: SE SERVIRÁN UDS. PAGAR POR ESTA ÚNICA FACTURA CAMBIARIA GIRADA LIBRE DE PROTESTO A LA ORDEN O ENDOSO DE
    IMPORTADORA INFINITY, SOCIEDAD ANÓNIMA. EL VALOR TOTAL POR EL QUE ESTA EXTENDIDA O POR EL ULTIMO SALDO INSOLUTO QUE APAREZCA</td>
        </tr>

</table>


    <?php } ?>

<?php $boder = 'border: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderBottom = 'border-bottom: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderR = 'border-right: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderL = 'border-left: 0.2px solid ' . $colorBorder . ';'; ?>
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
<!--<br />
<br />-->



<table cellpadding="3" width="100%">
    <tr>
        <th width="7px" ></th>
        <th  <?php if ($setear) { ?> width="65px" <?php } ?> style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?> text-align: center; <?php echo $boder; ?>"><strong> Cantidad</strong></th>
        <th <?php if ($setear) { ?> width="330px" <?php } ?> style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>text-align: center; <?php echo $boder; ?>"><strong>Descripción</strong></th>
        <th <?php if ($setear) { ?> width="80px" <?php } ?> style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>text-align: center; <?php echo $boder; ?>"><strong>Precio</strong></th>
<!--        <th <?php if ($setear) { ?> width="80px" <?php } ?> style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>text-align: center; <?php echo $boder; ?>"><strong>Descuento</strong></th>-->
        <!--    <th>Descuento</th>-->
        <th <?php if ($setear) { ?> width="112px" <?php } ?> style="<?php echo $sT; ?>; <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>text-align: center; <?php echo $boder; ?>"><strong>Total</strong></th>
    </tr>
    <?php $total = 0; ?>
    <?php foreach ($valoresDefault['lineas'] as $Linea) { ?>
        <?php $total = $total + $Linea['Precio']; ?>
        <tr>
           <th width="7px" ></th>
            <td style="<?php echo $sL; ?>;<?php if ($fondoDetalle <> "#ffffff") { ?>background-color:<?php echo $fondoDetalle; ?> ;<?php } ?>text-align: center; <?php //echo $boderBottom; ?> <?php echo $boderL; ?>"><?php echo $Linea['Cantidad']; ?></td>
            <td xwidth="<?php echo $ancho / 1.5; ?>" style="<?php echo $sL; ?>;<?php if ($fondoDetalle <> "#ffffff") { ?>background-color:<?php echo $fondoDetalle; ?> ;<?php } ?>padding: 15px;<?php //echo $boderBottom; ?><?php echo $boderL; ?>"><?php echo $Linea['Descripcion']; ?></td>
            <td style="<?php echo $sL; ?>;<?php if ($fondoDetalle <> "#ffffff") { ?>background-color:<?php echo $fondoDetalle; ?> ;<?php } ?>text-align: right;<?php //echo $boderBottom; ?><?php echo $boderL; ?>"><?php echo Usuario::formato($Linea['PrecioUnitario'], '') ?><?php echo $espacios; ?></td>
<!--            <td style="<?php echo $sL; ?>;<?php if ($fondoDetalle <> "#ffffff") { ?>background-color:<?php echo $fondoDetalle; ?> ;<?php } ?>text-align: right;<?php //echo $boderBottom; ?><?php echo $boderL; ?>"><?php echo Usuario::formato($Linea['Descuento'], '') ?><?php echo $espacios; ?></td>-->
            <td style="<?php echo $sL; ?>;<?php if ($fondoDetalle <> "#ffffff") { ?>background-color:<?php echo $fondoDetalle; ?> ;<?php } ?>text-align: right;<?php //echo $boderBottom; ?><?php echo $boderL; ?><?php echo $boderR; ?>"><?php echo Usuario::formato($Linea['Precio'], '') ?><?php echo $espacios; ?></td>
        </tr>
    <?php } ?>
    <tr>
       <th width="7px" ></th>
        <th colspan="3" style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>;text-align: right; <?php echo $boder; ?>"><strong> Total Documento&nbsp;&nbsp;&nbsp;</strong></th>
        <th style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>;text-align: center; <?php echo $boder; ?>"><strong><?php echo Usuario::formato($total, '') ?></strong></th>
    </tr>
      <tr>
    <th width="7px" ></th>
       <th width="300px;" colspan="2" style="font-size:25px;<?php //echo $sT; ?>;text-align: right; <?php echo $boder; ?>"> Total Iva&nbsp;&nbsp;&nbsp;<?php echo Usuario::formato($valoresDefault['IVA'], '') ?></th>
        <th width="285px;" colspan="2"  style="font-size:25px;<?php //echo $sT; ?>;text-align: center; <?php echo $boder; ?>">&nbsp;&nbsp;&nbsp;<?php if ($valoresDefault['IMPUESTO_HOTEL'] >0) { ?> Total Turismo Hospedaje  &nbsp;&nbsp;&nbsp;<?php echo Usuario::formato($valoresDefault['IMPUESTO_HOTEL'], '') ?> <?php } ?> </th>
    </tr>
    <tr>
       <th width="7px" ></th>
        <th colspan="3" style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>;text-align: right; <?php echo $boder; ?>"><strong>SUJETO A PAGOS TRIMESTRALES <?php //echo  $valoresDefault['GENERALES']['LEYENDA']; ?>&nbsp;&nbsp;&nbsp;</strong></th>

        <th style="<?php echo $sT; ?>;  <?php if ($fondoEncabezado <> "#ffffff") { ?> background-color:<?php echo  $fondoEncabezado; ?>;<?php } ?>;text-align: center; <?php echo $boder; ?>"><strong><?php echo $valoresDefault['GENERALES']['CodigoMoneda']; ?></strong></th>
    </tr>
</table>


<table  style="width:100%;">
     <tr>
            <th width="7px" ></th>
         <td   class=" abajo "  style="width:100%; font-size:18px; text-align:justify; ">
<br>&nbsp;&nbsp;&nbsp;SE COBRARÁ Q. 100 POR CHEQUE RECHAZADO
<br>&nbsp;&nbsp;&nbsp;NOTA: SI ESTA FACTURA NO SE CANCELA EN DÍAS DESDE SU EMISIÓN DEVENGARA INTERESES DEL 3 % ANUAL. ESTA
<br>&nbsp;&nbsp;&nbsp;FACTURA NO SE RECONOCERÁ CANCELADA SIN EL CORRESPONDIENTE RECIBO DE CAJA.</td>
        </tr>
</table>

<table style="width:100%">
    <tr>
        <th width="50px" ></th>
        <td  style="width:80px; font-size:24px;font-weight: bold;"></td>
        <td style="width:90px; font-size:25px; "><?php //echo $valoresDefault['CLIENTE']; ?></td>
        <td  style="width:20px; font-size:24px;"></td>
        <td  style="width:70px; font-size:24px;font-weight: bold;"></td>
        <td style="width:100px; font-size:25px; "><?php //echo $valoresDefault['VENDEDOR']; ?></td>
         <td style="width:100px; font-size:26px;font-weight: bold;">Referencia</td>
        <td style="width:200px; font-size:28px; "><?php echo $valoresDefault['REFERENCIA']; ?></td>
    </tr>
<!--    <tr>
        <th width="50px" ></th>
        <td style="width:80px; font-size:24px;font-weight: bold;">Referencia</td>
        <td style="width:200px; font-size:25px; "><?php echo $valoresDefault['REFERENCIA']; ?></td>
        <td  style="width:50px; font-size:24px;"></td>
        <td  style="width:100px; font-size:24px;"></td>
        <td style="width:200px; font-size:23px; font-weight: bold;"></td>
    </tr>    -->
</table>

<table  style="width:100%;">
     <tr>
         <td    style="height:15px; width:100%; font-size:24px; font-weight: bold; text-align:center; ">
NO SE ACEPTA DEVOLUCIONES DESPUÉS DE 8 DÍAS EMITIDA LA FACTURA</td>
        </tr>
             <tr>
         <td    style="height:15px; width:100%; font-size:24px; font-weight: bold; text-align:center; ">
UNICO COMPROBANTE DE PAGO "RECIBO DE CAJA"</td>
        </tr>
</table>
<br><br>

<table  style="width:100%;">
    <tr>
           <th width="7px" ></th>
        <td  class="arriba" style=" text-align: center; height:25px; width:172px; font-size: 20px;"> FIRMA Y SELLO DE LIBRADOR</td>
        <td style=" width:20px;" ></td>
        <td class="arriba" style=" text-align: center; height:25px; width:172px;font-size: 20px;"> FIRMA Y SELLO DE<br> COMPRADOR(ACEPTANTE)</td>
        <td style=" width:20px;" ></td> 
        <td class="arriba" style=" text-align: center; height:25px; width:172px;font-size: 20px;">FECHA DE ACEPTACIÓN</td>
    </tr>
</table>




<table  style="width:100%;">
    <tr>
        <td style="text-align: center; font-size: 28px;" ><?php echo $valoresDefault['OBSERVACIONES']; ?></td>
    </tr>
</table>

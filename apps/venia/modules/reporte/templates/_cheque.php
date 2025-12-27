<?php $espacioline="28px"; ?>
<?php $espaciouno="130px"; ?>
<?php $espaciodo2="40px"; ?>

<br>
<table width="750px" cellpadding="0px" >
    <tbody>
          <tr>
            <td height="<?php echo $espacioline; ?>" width="50px" >&nbsp; </td>
            <td  height="<?php echo $espacioline; ?>" style="text-align: right" width="400px" > <?php echo $cheque->getNumero(); ?></td>
            <td  height="<?php echo $espacioline; ?>" style="text-align: right"  width="190px"></td>
        </tr> 
        <tr>
            <td colspan="3" height="<?php echo $espacioline; ?>" width="600px" ></td>
        </tr>
        
        <tr>
            <td height="<?php echo $espacioline; ?>" width="50px" >&nbsp; </td>
            <td height="<?php echo $espacioline; ?>" width="480px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guatemala , <?php echo $cheque->getFechaCheque('d/m/Y'); ?> </td>
            <td height="<?php echo $espacioline; ?>" width="190px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  str_replace("Q", "",Parametro::formato($cheque->getValor())); ?></td>
        </tr>
        <tr>
            <td  width="50px" >&nbsp; </td>
            <td  height="<?php echo $espacioline; ?>" width="500px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $cheque->getBeneficiario(); ?></td>
            <td  width="190px"></td>
        </tr>
        <tr>
            <td  width="50px" >&nbsp; </td>
            <td  height="<?php echo $espacioline; ?>" width="600px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; <?php echo $valorLetras; ?></td>
            <td  width="90px"></td>
        </tr>
    </tbody>
</table>

<table width="750px" cellpadding="1px" >
      <tr>
          <td colspan="3" height="<?php echo $espaciouno; ?>" width="600px" ><br></td>
        </tr>
        <tr>
            <td  width="100px" >&nbsp; </td>
            <td  width="500px" >&nbsp;&nbsp;&nbsp;Nombre: <?php echo $cheque->getBeneficiario(); ?></td>
            <td  width="140px">&nbsp; </td>
        </tr>
          <tr>
            <td  width="100px" >&nbsp; </td>
            <td  width="500px" >&nbsp;&nbsp;&nbsp;Detalle:  <?php echo $cheque->getMotivo(); ?></td>
            <td  width="140px">&nbsp;  <?php echo $cheque->getNumero(); ?>  </td>
        </tr>
              <tr>
            <td  width="50px" >&nbsp; </td>
            <td  height="<?php echo $espaciodo2; ?>" width="600px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<br></td>
            <td  width="90px"></td>
        </tr>
            
</table>
<?php if ($partida) { ?>
<?php include_partial('reporte/partidaReporte', array('id' => $partida)) ?>  
<?php } ?>
<?php if ($cheque->getOrdenDevolucionId()) { ?>
<br>
<hr style=" border-top: 1px dotted  ;">
<table width="750px" cellpadding="1px" >
        <tr>
            <td  width="100px" >&nbsp; </td>
            <td  width="500px" >&nbsp;&nbsp;&nbsp;<strong> Motivo de Devolución: </strong> <?php echo $cheque->getOrdenDevolucion()->getDetalleMotivo(); ?></td>
            <td  width="140px">&nbsp; </td>
        </tr>
        <tr>
            <td colspan="3"  width="750px" style="text-align:center" ><?php echo html_entity_decode($cheque->getOrdenDevolucion()->getDetalleCompleto()); ?></td>
           
        </tr>
</table>
<?php $b = "0.2px solid #263663"; ?>
<?php $detalle= SolicitudDevDetalleQuery::create()
        ->filterBySolicitudDevolucionId($cheque->getOrdenDevolucion()->getSolicitudDevolucionId())
        ->find(); ?>

 <table cellspacing="0" cellpadding="3"   width="580px">
                <tr>
                    <td class="titulo" width="120px" style="text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>">Código de Parte</td>
                    <td class="titulo" width="340px" style="text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>">Descripción</td>
                    <td class="titulo" width="100px" style="text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>">Stock</td>
                    <td  class="titulo" width="120px" style="border-right:<?php echo $b; ?>;text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>">Tipo</td>
                </tr>
                <?php $can = 0; ?>
                <?php foreach ($detalle as $lista) { ?>
                    <?php $can++; ?>
                    <tr>

                        <td style="text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>"><?php echo $lista->getHollander(); ?></td>
                        <td style="text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>"><?php echo $lista->getDescripcion(); ?></td>
                        <td style="text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>"><?php echo $lista->getStock(); ?></td>

                        <td style="border-right:<?php echo $b; ?>;text-align: center; align-content: right;border-left:<?php echo $b; ?>; border-top:<?php echo $b; ?>"><?php echo $lista->getTipoRespuesto(); ?></td>
                    </tr> 
                <?php } ?>
                <tr>

                    <td  colspan="4" style="text-align: center; align-content: right; border-top:<?php echo $b; ?>"></td>

                </tr> 
            </table>
<?php } ?>
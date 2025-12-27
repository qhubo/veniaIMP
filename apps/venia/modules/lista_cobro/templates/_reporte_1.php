<style>

    .titulon {

        font-weight: bold;
        font-size: 38px;
        display: block;
    }
    .dere {
        border-right-color:black;  
        border-right-style: solid;
    }
    .izqui {
        border-left-color:black;  
        border-left-style: solid;
    }
    .arriba {
        border-top-color:black;  
        border-top-style: solid;
    }
    .abajo {
        border-bottom-color:black;  
        border-bottom-style: solid;
    }
</style>

<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>
        <td  width="150px"> <img width="140px" alt="Logo" src="/uploads/images/<?php echo $logo; ?>"></td>
        <td width="590px" style="border: 0.2px solid #5E80B4;">
            <table cellspacing="1" cellpadding="3"   width="590px">
                <tr>
                    <td colspan="2"  width="390px" style=" font-size: 52px; font-weight: bold;" >RECIBO DE PAGO</td>
                        <td  width="75px"  class="titulon">Recibo </td>
                    <td  width="125px" style=" font-size: 38px; font-weight: bold;" >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $operacionPago->getCodigo(); ?> </td>
   
                </tr>
                
                  <tr>
                    <td  width="90px" class="titulon" >Cliente</td>
                    <td  width="300px"><?php echo $operacionPago->getOperacion()->getNombre(); ?>                    </td>
                 <td  width="75px"  class="titulon">Fecha </td>
                    <td  width="125px"  >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $operacionPago->getFechaDocumento('d/m/Y'); ?> </td>
   
                  </tr>
                        <tr >
                    <td style="height:15px;" width="90px" class="titulon" ></td>
                    <td  width="255px"><?php echo $operacionPago->getTipo(); ?>   
                        <?php echo $operacionPago->getBanco(); ?> 
                        <?php echo $operacionPago->getDocumento(); ?>                    </td>
                 <td  width="80px"  class=" izqui arriba abajo titulon">&nbsp;&nbsp;Valor </td>
                 <td  width="150px" class="arriba abajo dere"  style="font-size: 43px;" >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Parametro::formato($operacionPago->getValor()); ?> </td>
   
                  </tr>
                    <tr>
                        <td style="height:22px;"  width="90px" class="titulon" >Concepto</td>
                        <td  colspan="3" style="height:15px;">
                            
                            <?php if ($operacionPago->getOperacion()->getPagado()) { ?>
                       Pago  Factura <?php echo $operacionPago->getOperacion()->getCodigo(); ?>
                            <?php } ?>
                             <?php if (!$operacionPago->getOperacion()->getPagado()) { ?>
                       Abono Pago  Factura Saldo Pendiente <?php echo ($operacionPago->getOperacion()->getValorTotal() -$operacionPago->getOperacion()->getValorPagado()); ?>
                            <?php } ?>
                       
                        </td>
                  </tr>
                  <tr>
                      <td colspan="4"><br><br></td>
                  </tr>

                  <tr>
                        <td style="height:22px;" class="titulon"  >Recibi</td>
                        <td colspan="2" class="abajo"></td>
                        <td></td>
                  </tr>
                  <tr>
                      <td colspan="4"><br></td>
                  </tr>
                  
            </table>
        </td>
    </tr>
</table>
<br>

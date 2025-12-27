<?php $total1=0; ?>
<?php $total2=0; ?>
<?php $total3=0; ?>
<?php $total4=0; ?>
<?php $conta=0; ?>
<br>
<br>
<?php foreach($bancos as $banco) { ?>
<?php $conta++; ?>

<?php $seleccionV = sfContext::getInstance()->getUser()->getAttribute('selecBa' . $banco->getId(), '', 'seguridad');; ?>
<?php $valor = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), '', 'seguridad'); ?>
<?php $ValorBanco = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'conciliado'); ?>
<?php $retorna =   sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'diferencia'); ?>
<?php $valor = $banco->getHsaldoBanco($dia); ?>
<?php $ValorBanco = $banco->getHsaldoConciliado($dia); ?>
<?php $retorna = $banco->getHDiferencia($dia); ?>
    <?php if ($seleccionV==1) { ?>
<?php $total1=0; ?>
<?php $total2=0; ?>
<?php $total3=0; ?>
<?php $total4=0; ?>
<table width="740px">
    <tr>
        <td colspan="3" width="380px"></td>
        <td colspan="2" width="240px"><?php echo $banco->getCuentaContable(); ?></td>   
        <td width="120px"><?php echo Parametro::formato( $tasa,true); ?></td> 
    </tr>
    <tr>
        <td colspan="740px" colspan="6">
            <br>
            
        </td>
        
    </tr>
    
    <tr>
        <th  style="text-align: center" width="60px"><strong>Date</strong></th>
        <th  style="text-align: center" width="200px"><strong>Description</strong></th>   
        <th  style="text-align: center; border-width: 1px;padding: 1px;	border-style: inset;border-color: gray; border-left-width: 1px;padding: 1px; border-left-style: inset;border-left-color: gray; "  width="120px" ><strong>Bank</strong></th>
        <th  style="text-align: center;  border-width: 1px;padding: 1px;	border-style: inset;border-color: gray;" width="120px"><strong>Book</strong></th>   
        <th  style="text-align: center;  border-width: 1px;padding: 1px;	border-style: inset;border-color: gray;" width="120px"><strong>Bank</strong></th>   
        <th  style="text-align: center;  border-width: 1px;padding: 1px; border-style: inset;border-color: gray; border-right-width: 1px;padding: 1px; border-right-style: inset;border-right-color: gray;" width="120px"><strong>Book</strong></th>   

    </tr>
    <?php $total1 = $total1+ $valor; ?>
    <?php $total2 = $total2+ $banco->getHSaldoLibros($dia); ?>
    <?php $total3 = $total3+ ($valor / $tasa); ?>
    <?php $total4 = $total4+ ($banco->getHSaldoLibros($dia) / $tasa); ?>
    <tr>
        <td></td>
        <td  style="text-align: left; padding-left: 10px">Beginning Balance</td>
        <td   style="text-align: right; padding-right: 5px; border-left-width: 1px;padding: 1px; border-left-style: inset;border-left-color: gray;"><?php echo Parametro::formato($valor,true); ?> </td>
        <td   style="text-align: right; padding-right: 5px"><?php echo Parametro::formato($banco->getHSaldoLibros($dia),true); ?> </td>
        <td   style="text-align: right; padding-right: 5px"><strong>$</strong> <?php echo Parametro::formato($valor  / $tasa,false); ?> </td>
        <td   style="text-align: right; padding-right: 5px;border-right-width: 1px;padding: 1px; border-right-style: inset;border-right-color: gray; "><strong>$</strong> <?php echo Parametro::formato($banco->getHSaldoLibros($dia)/$tasa, false); ?> &nbsp;&nbsp;</td>
    </tr>

     <tr>
        <td colspan="2">    <img height="50px" alt="Logo" src="/uploads/images/<?php echo $imagen; ?>"></td>
        <td   style="text-align: right; padding-right: 5px;  border-left-width: 1px;padding: 1px; border-left-style: inset;border-left-color: gray;"><br><br> </td>
        <td colspan="2">
          
            
        </td>
        <td   style="text-align: right; padding-right: 5px;border-right-width: 1px;padding: 1px; border-right-style: inset;border-right-color: gray;  "><br><br></td>
    </tr>
        <?php $total1 = $total1+ $banco->getHNotasChequesCircula($dia); ?>
   <tr>
        <td style="text-align: center;">(-)</td>
        <td  style="text-align: left; padding-left: 10px">Outstanding Checks</td>
        <td   style="text-align: right; padding-right: 5px;border-left-width: 1px;padding: 1px; border-left-style: inset;border-left-color: gray;"> <?php echo Parametro::formato(abs($banco->getHNotasChequesCircula($dia)), true); ?></td>
        <td   style="text-align: right; padding-right: 5px; ;"> </td>
      
        <td   style="text-align: right; padding-right: 5px"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right-width: 1px;padding: 1px; border-right-style: inset;border-right-color: gray;"> &nbsp;&nbsp;</td>
    </tr>
     <?php $total1 = $total1+ $banco->getHDepositoTransito($dia); ?>
   <tr>
        <td style="text-align: center;">(+)</td>
        <td  style="text-align: left; padding-left: 10px">Outstanding Deposits</td>
       <td   style="text-align: right; padding-right: 5px;border-left-width: 1px;padding: 1px; border-left-style: inset;border-left-color: gray;"> <?php echo Parametro::formato(abs($banco->getHDepositoTransito($dia)), true); ?> </td>
        <td   style="text-align: right; padding-right: 5px; "></td>
        
        <td   style="text-align: right; padding-right: 5px"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right-width: 1px;padding: 1px; border-right-style: inset;border-right-color: gray; "> &nbsp;&nbsp;</td>
    </tr>
    <?php $total1 = $total1+ $banco->getHNotasCreditoTransito($dia); ?>
   <tr>
        <td style="text-align: center;">(-)</td>
        <td  style="text-align: left; padding-left: 10px">Outstanding Debit Notes</td>
        <td   style="text-align: right; padding-right: 5px; border-left-width: 1px;padding: 1px; border-left-style: inset;border-left-color: gray;"> <?php echo Parametro::formato(abs($banco->getHNotasCreditoTransito($dia)), true); ?></td>
        <td   style="text-align: right; padding-right: 5px; "> </td>
 
        <td   style="text-align: right; padding-right: 5px"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right-width: 1px;padding: 1px; border-right-style: inset;border-right-color: gray; "> &nbsp;&nbsp;</td>
    </tr>
       <tr>
        <td style="text-align: center; "></td>
        <td  style="text-align: left; padding-left: 10px;"><br></td>
        <td   style="text-align: right; padding-right: 5px;  border-left-width: 1px;padding: 1px; border-left-style: inset;border-left-color: gray; "> </td>
        <td   style="text-align: right; padding-right: 5px;;"> </td>
        <td   style="text-align: right; padding-right: 5px; ;"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right-width: 1px;padding: 1px; border-right-style: inset;border-right-color: gray; "> &nbsp;&nbsp;</td>
    </tr>
    
      <tr>
        <td style="text-align: center; "></td>
        <td  style="text-align: left; padding-left: 10px;"><br></td>
        <td   style="text-align: right; padding-right: 5px;border-style: inset;border-color: gray;   ; "><?php echo Parametro::formato($total1,true); ?> </td>
        <td   style="text-align: right; padding-right: 5px;border-style: inset;border-color: gray;;"><?php echo Parametro::formato($total2,true); ?> </td>
        <td   style="text-align: right; padding-right: 5px;border-style: inset;border-color: gray; ;"><?php echo Parametro::formato($total3,true); ?> </td>
        <td   style="text-align: right; padding-right: 5px; border-style: inset;border-color: gray;  "> <?php echo Parametro::formato($total4,true); ?>&nbsp;&nbsp;</td>
    </tr>
 
             <tr>
        <td style="text-align: center; "></td>
        <td  style="text-align: left; padding-left: 10px;"><br></td>
        <td   style="text-align: right; padding-right: 5px;border-style: inset;border-color: gray;   ; "> </td>
        <td   style="text-align: right; padding-right: 5px;border-style: inset;border-color: gray;;"> </td>
        <td   style="text-align: right; padding-right: 5px;border-style: inset;border-color: gray; ;"> </td>
        <td   style="text-align: right; padding-right: 5px; border-style: inset;border-color: gray;  "> </td>
    </tr>
    
</table>
<br>
<br>
<br>
<br>

<?php if ($conta ==3) { ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php  } ?>


<?php } ?>
<?php } ?>







<?php foreach($bancos as $banco) { ?>

<?php $seleccionV = sfContext::getInstance()->getUser()->getAttribute('selecBa' . $banco->getId(), '', 'seguridad');; ?>
<?php $valor = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), '', 'seguridad'); ?>
<?php $ValorBanco = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'conciliado'); ?>
<?php $retorna = 0; //   sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'diferencia'); ?>
<?php if ($seleccionV==1) { ?>

<table width="740px">
    <tr>
        <td colspan="3" width="380px"></td>
        <td colspan="2" width="240px"><?php echo $banco->getCuentaContable(); ?></td>   
        <td width="120px"><?php echo Parametro::formato( $tasa,true); ?></td> 
    </tr>
    <tr>
        <td colspan="740px" colspan="6"><br></td>
        
    </tr>
    
    <tr>
        <th  style="text-align: center" width="60px">Date</th>
        <th  style="text-align: center" width="200px">Description</th>   
        <th  style="text-align: center; border-top:0px ; border-left:0px ; "  width="120px" >Bank</th>
        <th  style="text-align: center; border-top:0px ;" width="120px">Book</th>   
        <th  style="text-align: center; border-top:0px ;" width="120px">Bank</th>   
        <th  style="text-align: center; border-top:0px ; border-right:1px ;" width="120px">Book</th>   

    </tr>
    <tr>
        <td></td>
        <td  style="text-align: left; padding-left: 10px">Beginning Balance</td>
        <td   style="text-align: right; padding-right: 5px; border-left:0px ;"><?php echo Parametro::formato($valor); ?> </td>
        <td   style="text-align: right; padding-right: 5px"><?php echo Parametro::formato($banco->getSaldoLibros()); ?> </td>
        <td   style="text-align: right; padding-right: 5px"><?php echo Parametro::formato($valor*$tasa); ?> </td>
        <td   style="text-align: right; padding-right: 5px; border-right:1px "><?php echo Parametro::formato($banco->getSaldoLibros()*7); ?> </td>
    </tr>
     <tr>
        <td colspan="2"></td>
        <td   style="text-align: right; padding-right: 5px; border-left:0px ;"><br><br> </td>
        <td colspan="2"></td>
        <td   style="text-align: right; padding-right: 5px; border-right:0px "><br><br></td>
    </tr>
   <tr>
        <td style="text-align: center;">(-)</td>
        <td  style="text-align: left; padding-left: 10px">Outstanding Checks</td>
        <td   style="text-align: right; padding-right: 5px;border-left:0px;"> </td>
        <td   style="text-align: right; padding-right: 5px; ;"><?php echo Parametro::formato(abs($banco->getNotasChequesCircula()), false); ?> </td>
      
        <td   style="text-align: right; padding-right: 5px"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right:0px;"> </td>
    </tr>
   <tr>
        <td style="text-align: center;">(+)</td>
        <td  style="text-align: left; padding-left: 10px">Outstanding Deposits</td>
       <td   style="text-align: right; padding-right: 5px;border-left:0px;"> </td>
        <td   style="text-align: right; padding-right: 5px; "> <?php echo Parametro::formato(abs($banco->getDepositoTransito()), false); ?></td>
        
        <td   style="text-align: right; padding-right: 5px"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right:1px "> </td>
    </tr>
   <tr>
        <td style="text-align: center;">(-)</td>
        <td  style="text-align: left; padding-left: 10px">Outstanding Debit Notes</td>
        <td   style="text-align: right; padding-right: 5px;border-left:0px ;"> </td>
        <td   style="text-align: right; padding-right: 5px; "> <?php echo Parametro::formato(abs($banco->getNotasDebitoTransito()), false); ?></td>
 
        <td   style="text-align: right; padding-right: 5px"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right:0px "> </td>
    </tr>
       <tr>
        <td style="text-align: center; "></td>
        <td  style="text-align: left; padding-left: 10px;"><br></td>
        <td   style="text-align: right; padding-right: 5px; border-left:0px ;border-bottom: 0px "> </td>
        <td   style="text-align: right; padding-right: 5px;border-bottom: 0px;"> </td>
        <td   style="text-align: right; padding-right: 5px;border-bottom: 0px ;"> </td>
        <td   style="text-align: right; padding-right: 5px; border-right:0px ;border-bottom: 0px "> </td>
    </tr>
    
</table>
<br>
<br>
<br>
<br>
<?php } ?>
<?php } ?>


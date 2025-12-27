<?php $nombreInicial = $operaciones[0]->getPartidaAgrupa()->getDetalle(); ?>
<?php $CANTI = 0; ?> 
<?php $NOfolio = (int) sfContext::getInstance()->getUser()->getAttribute("folio", null, 'seguridad'); ?>
<?php //$NOfolio =1;  ?>
<table class="table  " width="740px" >
    <tr>
        <td  colspan="5" style="text-align: center" width="637px"> <strong> </strong></td>
        <td   style="text-align: left"><font size="+1" width="103px" > <strong>Folio <?php echo $NOfolio; ?> </strong></font></td>
        
    </tr>    
    <tr>
        <td  colspan="5" style="text-align: center" width="637px"> <strong></strong></td>
        <td   style="text-align: right"> </td>
        <?php $CANTI++; ?>    
    </tr> 
    <tr>
        <td  colspan="5" style="text-align: center" width="637px"> <strong>Libro Diario del <?php echo $inicio;  ?> al <?php echo $fin; ?> </strong></td>
        <td   style="text-align: right"></td>
        <?php $CANTI++; ?>    
    </tr> 
    <tr>
        <td  colspan="6" style="text-align: right"><br></td>
        <?php $CANTI++; ?>    
    </tr>    

    <tr>
        <td  colspan="6" width="740px"  style="background-color:#ebedf2; text-align: left"><font > <strong><?php echo $nombreInicial ?></strong></font> </td>
        <?php $CANTI++; ?>          
    </tr>

    <tr style="background-color:#ebedf2">
        <th align="center" style="font-weight: bold;"  width="82px"><strong> Partida</strong></th>
        <th align="center"   width="82px"><strong>Fecha</strong></th>
        <th  align="center" width="60px"><strong> Cuenta</strong></th>
        <th align="center" width="310px" ><strong>Descripción </strong></th>
        <th  align="center" width="103px"> <strong>Debe </strong></th>
        <th  align="center" width="103px" ><strong> Haber </strong></th>
        <?php $CANTI++; ?> 
    </tr>

    <?php $bandera = 0; ?>
    <?php $total1 = 0; ?>
    <?php $total2 = 0; ?> 
    <?php $cantida = 0; ?>
    <?php $nombrePartida = ''; ?>

    <?php foreach ($operaciones as $registro) { ?>

        <?php if ($CANTI == 62) { ?>
            <?php $CANTI = 0; ?> 
            <?php $NOfolio++; ?> 
                <tr>
        <td  colspan="5" style="text-align: center" width="637px"> <strong> </strong></td>
        <td   style="text-align: left"><font size="+1" width="103px" > <strong>Folio <?php echo $NOfolio; ?> </strong></font></td>
        
    </tr>    
    <tr>
        <td  colspan="5" style="text-align: center" width="637px"> <strong> </strong></td>
        <td   style="text-align: right"> </td>
        <?php $CANTI++; ?>    
    </tr> 
    <tr>
        <td  colspan="5" style="text-align: center" width="637px"> <strong>Libro Diario del <?php echo $inicio;  ?> al <?php echo $fin; ?></strong></td>
        <td   style="text-align: right"></td>
        <?php $CANTI++; ?>    
    </tr> 
    <tr>
        <td  colspan="6" width="740px" style="text-align: right"><br></td>
        <?php $CANTI++; ?>    
    </tr>    

    <tr>
        <td  colspan="6" width="740px"  style="background-color:#ebedf2; text-align: left"><font > <strong><?php echo $nombreInicial ?></strong></font> </td>
        <?php $CANTI++; ?>          
    </tr>
             <tr style="background-color:#ebedf2">
                         <th align="center" style="font-weight: bold;"  width="82px"><strong> Partida</strong></th>
        <th align="center"   width="82px"><strong>Fecha</strong></th>
        <th  align="center" width="60px"><strong> Cuenta</strong></th>
        <th align="center" width="310px" ><strong>Descripción </strong></th>
        <th  align="center" width="103px"> <strong>Debe </strong></th>
        <th  align="center" width="103px" ><strong> Haber </strong></th>
                    <?php $CANTI++; ?>  
                </tr>
        <?php } ?>


        <?php if ($bandera <> $registro->getPartidaAgrupaId()) { ?>
            <?php $nombreInicial = $registro->getPartidaAgrupa()->getDetalle(); ?>
            <?php if ($total1 > 0) { ?>

                <tr>
                    <td style="text-align: left"  colspan="3"><strong>  <?php //echo $nombrePartida; ?></strong></td>
                    <td style="text-align: right"  colspan="1"><strong>Sumas Iguales   <font size="+1">  <?php //echo $nombrePartida;  ?></font> </strong></td>
                    <td  style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total1); ?></strong></td>
                    <td style="background-color:#ebedf2; text-align: right"><strong><?php echo Parametro::formato($total2); ?></strong></td>
                    <?php $CANTI++; ?>  
                </tr>

                <tr>
                    <td colspan="6">&nbsp;&nbsp; </td>
                    <?php $CANTI++; ?>   
                </tr>

                <tr>
                    <td  colspan="6" style="background-color:#ebedf2; text-align: left"><font > <strong><?php echo $nombreInicial ?></strong></font> </td>
                    <?php $CANTI++; ?>
                </tr>

                <tr style="background-color:#ebedf2">
                         <th align="center" style="font-weight: bold;"  width="82px"><strong> Partida</strong></th>
        <th align="center"   width="82px"><strong>Fecha</strong></th>
        <th  align="center" width="60px"><strong> Cuenta</strong></th>
        <th align="center" width="310px" ><strong>Descripción </strong></th>
        <th  align="center" width="103px"> <strong>Debe </strong></th>
        <th  align="center" width="103px" ><strong> Haber </strong></th>
                    <?php $CANTI++; ?>  
                </tr>
            <?php } ?>                            
        <?php } ?>


        <tr>
            <td  width="82px"><?php echo str_replace("0000", "000", $registro->getPartidaAgrupa()->getCodigo()); ?></td>
            <td  width="82px" style="text-align: center"><?php echo $registro->getPartidaAgrupa()->getFechaContable('d/m/Y'); ?></td>
            <td width="60px"><?php echo $registro->getCuentaContable(); ?></td>
            <td width="310px" align="left" style="text-align:left"  ><font size="-1"> <?php echo substr($registro->getDetalle(), 0, 55); ?></font></td>
            <td width="103px" style="text-align: right" ><?php echo Parametro::formato($registro->getDebe()); ?></td>
            <td width="103px" style="text-align: right" ><?php echo Parametro::formato($registro->getHaber()); ?></td>
            <?php $CANTI++; ?>  
        </tr>

        <?php if ($bandera <> $registro->getPartidaAgrupaId()) { ?>
            <?php $bandera = $registro->getPartidaAgrupaId(); ?>
            <?php $nombrePartida = $registro->getPartidaAgrupa()->getDetalle(); ?>
            <?php $total1 = 0; ?>
            <?php $total2 = 0; ?> 
        <?php } ?>
        <?php $total1 = $registro->getDebe() + $total1; ?>
        <?php $total2 = $registro->getHaber() + $total2; ?> 
    <?php } ?>
    <tr>
        <td></td>
        <td style="text-align: left"  colspan="2"><strong>  <?php //echo $nombrePartida; ?> </strong></td>
        <td style="text-align: right"  colspan="1"><strong>Sumas Iguales  <font size="+1">  <?php //echo $nombrePartida;  ?></font> </strong></td>
        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total1); ?> </strong></td>
        <td style="text-align: right; background-color:#ebedf2"><strong><?php echo Parametro::formato($total2); ?></strong></td>
    </tr>

</table>
<?php
$campoUsuario = ValorUsuarioQuery::create()
        ->filterByTipoDocumento($tipoDocumento)
        ->filterByNoDocumento($idDoc)
        ->find();
?>

<table >

    <?php foreach ($campoUsuario as $campo) { ?>
        <tr >
            <th  align="left" width="30px" style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center"> </th>
            <th  align="left" width="285px"  style="font-size:30px; ;border-top: 0.2px solid #5E80B4;text-align: left"><strong><?php echo $campo->getNombreCampo(); ?></strong> </th>
            <th  align="left" width="350px"  style="font-size:30px;border-right: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: left"><?php echo $campo->getValor(); ?> </th>
        </tr>
    <?php } ?>
        
           <tr >
            <th  align="center" width="30px" style="font-size:30px; border-top: 0.2px solid #5E80B4; text-align: center">&nbsp; </th>
            <th  align="center" width="285px"  style="font-size:30px; ;border-top: 0.2px solid #5E80B4;text-align: left"><strong>&nbsp;</strong> </th>
            <th  align="center" width="350px"  style="font-size:30px;;border-top: 0.2px solid #5E80B4; text-align: left">&nbsp; </th>
        </tr>
</table>
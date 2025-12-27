<?php $colorBorder ="#5E80B4;"; ?>
<?php $boder = 'border: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderBottom = 'border-bottom: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderTOp = 'border-top: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderR = 'border-right: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderL = 'border-left: 0.2px solid ' . $colorBorder . ';'; ?>
<!--Resumen-->
<?php //echo count($operaciones); ?>  
<br>
<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>
        <td  width="150px"> 
            <img width="140px" alt="Logo" src="/uploads/images/<?php echo $logo;   ?>">

        </td>
        <td width="10px"></td> 
        <td width="580px" style="border: 0.2px solid #5E80B4;">
            <table cellspacing="1" cellpadding="3"   width="590px">
                <tr>
                    <td style="font-size:35px;color:#063173; font-weight: bold">Fecha Inicio</td>
                    <td style="font-size:35px;color:#063173"><?php echo $valores['fechaInicio']." ".$valores['inicio'];  ?> </td>
                    <td style="font-size:35px;color:#063173; font-weight: bold">Fecha Fin</td>
                    <td style="font-size:35px;color:#063173"><?php echo $valores['fechaFin']." ".$valores['fin']; ?></td>         
                </tr>
                <tr>
                    <td style="font-size:35px;color:#063173; font-weight: bold">Tienda</td>
                    <td style="font-size:35px;color:#063173"><?php echo $bodega; ?></td>
                    <td  style="font-size:35px;color:#063173; font-weight: bold" >Usuario</td>
                    <td style="font-size:35px;color:#063173"><?php echo $valores['usuario']; ?></td>         
                </tr>
            </table>    
        </td>
    </tr>
</table>

<br>
<table cellspacing="0" cellpadding="0"   width="745px">
    <tr>
        <td  width="450px">             
            <?php include_partial('reporte_caja/listadoReporte', array('operacionCXC'=>$operacionCXC, 'operaciones' => $operaciones, 'detalle' => $detalle)) ?> 
        </td>
        <td  width="10px"> </td>

        <td  width="290px">
            <br>
            <br>
            <br>
  <br>
            <br>
            <table cellpadding='1'>
                <thead>
                    <tr class="info">
                        <td  style="width:30px; font-size:32px;color:#063173; font-weight: bold;<?php echo $boder; ?>">No</td>
                        <td style="width:130px;font-size:32px;color:#063173; font-weight: bold;<?php echo $boder; ?>">Medio Pago </td>
                        <td style="width:80px; font-size:32px;color:#063173; font-weight: bold;<?php echo $boder; ?>">Valor </td>
                    </tr>
                </thead>
                <tbody>
                    <?php $gratotal = 0; ?>
                    <?php $gratotalV = 0; ?>
                    <?php $can = 0; ?>
                    <?php foreach ($operacionPago as $regis) { ?>
                        <?php if (strtoupper($regis->getTipo()) == 'EFECTIVO') { ?>
                            <?php $gratotal = $gratotal + $regis->getValorTotal(); ?>
                        <?php } ?>
                        <?php $gratotalV = $gratotalV + $regis->getValorTotal(); ?>                        
                        <?php $can++; ?>
                        <tr>
                            <td style="font-size:32px;<?php echo $boderL; ?>"><?php echo $regis->getCantidad(); ?></td>
                            <td style="font-size:32px;<?php echo ""; ?>"><?php echo $regis->getTipo(); ?></td>
                            <td  style="font-size:32px;<?php echo $boderR; ?>" align="right"><strong><?php echo number_format($regis->getValorTotal(), 2); ?></strong></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tr class="active">
                    <th style="font-size:34px;font-weight: bold ;<?php echo $boderTOp; ?>" colspan="3">GRAN TOTAL CAJA</th>
                </tr>
                <tr class="active">
                    <th style="font-size:35px; font-weight: bold" colspan="3" align="right" ><div align="right"><?php echo number_format($gratotalV, 2); ?></div></th>
                </tr>

            </table>
        </td>
    </tr>
</table>












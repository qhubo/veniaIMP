<?php $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad'); ?>
<?php
$sqlexp = "select vendedor, sum(valor)  as Valor, count(id) as Cantidad from orden_devolucion";
$sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''"
        . " and  created_at  >='" . $fechaInicio . "' and  created_at <='" . $fechaFin . "'  group by vendedor;";
if ($medio_pago) { 
$sqlexp = "select vendedor, sum(valor)  as Valor, count(id) as Cantidad from orden_devolucion";
$sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''  and  pago_medio = '".$medio_pago."' "
        . " and  created_at  >='" . $fechaInicio . "' and  created_at <='" . $fechaFin . "'  group by vendedor;";
    
    }


$con = Propel::getConnection();
$stmt = $con->prepare($sqlexp);
$resource = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $result['Valor'] = 45;
//    $result['mes'] =2;
?>

<div class="row">
    <table class="table" >
        <?php if ($medio_pago) {  ?>
        <tr style="background-color:#ebedf2">
            <td colspan="3" " style="font-weight: bold;text-align: center "><?php echo $medio_pago; ?></td>
        </tr>  
        <?php } ?>
        <tr style="background-color:#ebedf2">
        <th align="center" style="font-weight: bold;"  ><strong> Vendedor</strong></th>
        <th align="center" style="font-weight: bold;"  width="30px"><strong> Cantidad</strong></th>
        <th align="center" style="font-weight: bold;"  width="50px"><strong> Total</strong></th>
        </tr>
        <?php $totalCa =0; ?>
        <?php $totalVa =0; ?>
        <?php  foreach ($result as $data) {?>
        <?php $totalCa =$data['Cantidad']+$totalCa; ?>
        <?php $totalVa =$data['Valor']+$totalVa; ?>

        <tr>
            <td><?php  echo $data['vendedor'] ; ?></td>
            <td  style="text-align: right"><?php  echo  $data['Cantidad'] ; ?></td>
            <td style="text-align: right" ><?php  echo Parametro::formato($data['Valor'],true) ; ?></td>
        </tr>
        <?php } ?>
        <tr style="background-color:#ebedf2">
                    <th align="center" style="font-weight: bold;"  ><strong> Totales <?php echo $medio_pago; ?></strong></th>
        <th align="center" style="font-weight: bold;"  width="30px"><strong> <?php echo $totalCa; ?></strong></th>
        <th align="center" style="font-weight: bold;"  width="50px"><strong> <?php echo Parametro::formato($totalVa); ?></strong></th>
        </tr>
        
    </table>
</div>
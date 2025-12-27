 <?php $no = 0 ?>
<!-- $registros->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $registros->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");-->
<?php  $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad'); ?>
<?php 
  $sqlexp = "select detalle_motivo, sum(valor)  as Valor, count(id)  as Cantidad from orden_devolucion";
      $sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''  "
              . " and  created_at  >='".$fechaInicio."' and  created_at <='".$fechaFin."'  group by detalle_motivo;"; 
      if ($vendedor) {
            $sqlexp = "select detalle_motivo, sum(valor)  as Valor , count(id)  as Cantidad from orden_devolucion";
      $sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''  and vendedor ='".$vendedor." ' "
              . " and  created_at  >='".$fechaInicio."' and  created_at <='".$fechaFin."'  group by detalle_motivo;"; 
          
      }  
      
      
      $con = Propel::getConnection();
            $stmt = $con->prepare($sqlexp);
            $resource = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>




<div class="row"  style="margin-top: 100px;">
    <table class="table" >
        <?php if ($vendedor) {  ?>
        <tr style="background-color:#ebedf2">
            <td colspan="3" " style="font-weight: bold;text-align: center "><?php echo $vendedor; ?></td>
        </tr>  
        <?php } ?>
        <tr style="background-color:#ebedf2">
        <th align="center" style="font-weight: bold;"  ><strong> Motivo</strong></th>
        <th align="center" style="font-weight: bold;"  width="30px"><strong> Cantidad</strong></th>
        <th align="center" style="font-weight: bold;"  width="50px"><strong> Total</strong></th>
        </tr>
        <?php $totalCa =0; ?>
        <?php $totalVa =0; ?>
        <?php  foreach ($result as $data) {?>
        <?php $totalCa =$data['Cantidad']+$totalCa; ?>
        <?php $totalVa =$data['Valor']+$totalVa; ?>
        <?php $motivo=  $data['detalle_motivo']; ?>
<?php if (!$data['detalle_motivo']) {  $motivo='SIN MOTIVO'; } ?> 
        <tr>
            <td><?php  echo $motivo ; ?></td>
            <td  style="text-align: right"><?php  echo  $data['Cantidad'] ; ?></td>
            <td style="text-align: right" ><?php  echo Parametro::formato($data['Valor'],true) ; ?></td>
        </tr>
        <?php } ?>
        <tr style="background-color:#ebedf2">
                    <th align="center" style="font-weight: bold;"  ><strong> Totales <?php echo $vendedor; ?></strong></th>
        <th align="center" style="font-weight: bold;"  width="30px"><strong> <?php echo $totalCa; ?></strong></th>
        <th align="center" style="font-weight: bold;"  width="50px"><strong> <?php echo Parametro::formato($totalVa); ?></strong></th>
        </tr>
        
    </table>
</div>
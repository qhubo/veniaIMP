<?php $colorBorder = "#5E80B4;"; ?>
<?php $boder = 'border: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderBottom = 'border-bottom: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderTOp = 'border-top: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderR = 'border-right: 0.2px solid ' . $colorBorder . ';'; ?>
<?php $boderL = 'border-left: 0.2px solid ' . $colorBorder . ';'; ?>
<?Php $tipoDocumento = "Cliente"; ?>
<?php include_partial('soporte/valorCampoReporte', array('tipoDocumento' => $tipoDocumento, 'idDoc' => $orden->getId())) ?>


<h3>Visitas Realizadas</h3>


<br>
<table cellpadding='1'>
    <thead>
        <tr class="info">
            <td style="width:150px; font-size:32px;color:#063173; font-weight: bold;<?php echo $boder; ?>"> Fecha</td>
            <td style="width:390px;font-size:32px;color:#063173; font-weight: bold;<?php echo $boder; ?>"> Detalle </td>
            <td style="width:150px; font-size:32px;color:#063173; font-weight: bold;<?php echo $boder; ?>"> Estatus </td>
        </tr>
    </thead>
    <tbody>
        <?php $agendas = AgendaQuery::create()
            ->filterByClienteId($orden->getId())
            ->find(); ?>
        <?php foreach ($agendas as $agenda) : ?>
            <tr>
                <td style="width:150px; font-size:28px;color:#000000;<?php echo $boder; ?>;text-align:center"><?php echo $agenda->getFecha('d/m/Y') ?></td>
                <td style="width:390px;font-size:28px;color:#000000; <?php echo $boder; ?>"><?php echo 'Cita en horario de ' . $agenda->getHoraInicio() . ' a ' . $agenda->getHoraFin() ?></td>
                <td style="width:150px; font-size:28px;color:#000000; <?php echo $boder; ?>"><?php echo $agenda->getEstatusSobreFecha() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<h3>Historial Médico</h3>


<br>
<table cellpadding='1'>
    <thead>
        <tr class="info">
            <td style="width:150px; font-size:32px;color:#063173;font-weight: bold;<?php echo $boder; ?>"> Fecha</td>
            <td style="width:390px;font-size:32px;color:#063173;font-weight: bold;<?php echo $boder; ?>"> Detalle </td>
            <td style="width:150px; font-size:32px;color:#063173;font-weight: bold;<?php echo $boder; ?>"> Frecuencia </td>
        </tr>
    </thead>
    <tbody>
        <?php $recetarioDetalle = RecetarioDetalleQuery::create()
            ->useRecetarioQuery()
            ->filterByClienteId($orden->getId())
            ->endUse()
            ->find(); ?>
        <?php foreach ($recetarioDetalle as $recetaDet) : ?>
            <?php $receta = $recetaDet->getRecetario() ?>
            <tr>
                <td style="width:150px; font-size:28px;color:#000000;<?php echo $boder; ?>;text-align:center"><?php echo $receta->getFecha('d/m/Y') ?></td>
                <td style="width:390px;font-size:28px;color:#000000;<?php echo $boder; ?>"><?php echo $recetaDet->getDetalle() ?></td>
                <td style="width:150px; font-size:28px;color:#000000;<?php echo $boder; ?>"><?php echo $recetaDet->getFrecuencia() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
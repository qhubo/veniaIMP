<?php $RecetaDetalle = RecetarioDetalleQuery::create()
    ->filterByRecetarioId($id)
    ->find();

$Receta = RecetarioQuery::create()->findOneById($id);
$Cliente = $Receta->getCliente(); ?>


<h1 style="text-align:center">Receta Médica</h1>

<table style="width:100%; border-collapse: collapse; margin: 10px 0;">
    <tr>
        <th style="border: 1px solid #000; padding: 8px;"><b>Paciente</b></th>
        <td style="border: 1px solid #000; padding: 8px;"><?php echo $Cliente->getNombre() ?> '</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px;"><b>Dirección</b></th>
        <td style="border: 1px solid #000; padding: 8px;"><?php echo trim($Cliente->getDireccionCompleta()) ?> </td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px;"><b>Teléfono</b></th>
        <td style="border: 1px solid #000; padding: 8px;"><?php echo trim($Cliente->getTelefono()) ?></td>
    </tr>
</table>
<br />
<h3>Medicamentos Recetados:</h3>

<table style="width:100%; border-collapse: collapse;">
    <tr>
        <th style="border: 1px solid #000; padding: 8px;"><b>Medicamento/Servicio</b></th>
        <th style="border: 1px solid #000; padding: 8px;"><b>Dosis</b></th>
        <th style="border: 1px solid #000; padding: 8px;"><b>Frecuencia</b></th>
        <th style="border: 1px solid #000; padding: 8px;"><b>Observaciones</b></th>
    </tr>
    <?php foreach ($RecetaDetalle as $detalle) : ?>
        <tr>
            <td style="border: 1px solid #000; padding: 8px;"><?php echo ($detalle->getTipoDetalle() == 'Producto' ? $detalle->getProducto()->getNombre() : $detalle->getServicio()) ?></td>
            <td style="border: 1px solid #000; padding: 8px;"><?php echo $detalle->getDosis() ?></td>
            <td style="border: 1px solid #000; padding: 8px;"><?php if (trim($detalle->getFrecuencia()) <> "cada") { echo  $detalle->getFrecuencia(); } ?></td>
            <td style="border: 1px solid #000; padding: 8px;"><?php echo $detalle->getObservaciones() ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br />
<?php if ($Receta->getObservaciones()) : ?>
    <h3>Observaciones adicionales:</h3>
    <h5><?php echo trim($Receta->getObservaciones()) ?> </h5>
<?php endif; ?>
<h3>Instrucciones:</h3>
<ul>
    <li>Tomar los medicamentos con las comidas.</li>
    <li>Descansar adecuadamente.</li>
    <li>Seguir tomando los medicamentos según lo recetado.</li>
</ul>

<p style="text-align:right"><em>Firma: __________________________</em></p>
<p style="text-align:right">Fecha: <?php echo $Receta->getFecha() ?></p>
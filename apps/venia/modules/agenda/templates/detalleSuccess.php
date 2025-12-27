<div class="table-responsive">
    <table class="table">
             <tr>
            <th>Doctor </th>
            <td><?php echo $Agenda->getNombreDoctor() ?></td>
        </tr>
        <tr>
            <th>Cliente</th>
            <td><?php echo $Agenda->getCliente()->getNombre() ?></td>
        </tr>
        <tr>
            <th>Telefono</th>
            <td><?php echo $Agenda->getCliente()->getTelefono() ?></td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td><?php echo $Agenda->getCliente()->getDireccion() ?></td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td><?php echo $Agenda->getFecha() ?></td>
        </tr>
        <tr>
            <th>Hora de Inicio</th>
            <td><?php echo $Agenda->getHoraInicio() ?></td>
        </tr>
        <tr>
            <th>Hora Fin</th>
            <td><?php echo $Agenda->getHoraFin() ?></td>
        </tr>
        <tr>
            <th>Estatus</th>
            <td><b><?php echo $Agenda->getEstatus() ?></b></td>
        </tr>
         <tr>
            <th>No Sesión</th>
            <td><b><?php echo $Agenda->getNoSesion() ?></b></td>
        </tr>

        <tr>
            <th>Observaciones</th>
            <td><?php echo $Agenda->getObservaciones() ?></td>
        </tr>
    </table>
    <?php if ($Agenda->getEstatus() != "Confirmado") : ?>
        <a type="submit" class="btn btn-success btn-dark" href="<?php echo url_for('agenda/cambioEstatus') . "?id=" . $Agenda->getId() . "&estatus=Confirmado" ?>">Confirmar Cita</a>
    <?php endif; ?>
    <?php if ($Agenda->getEstatus() == "Confirmado") : ?>
        <a type="submit" class="btn btn-success btn-dark" href="<?php echo url_for('agenda/cambioEstatus') . "?id=" . $Agenda->getId() . "&estatus=Pendiente" ?>">Abrir Cita</a>
    <?php endif; ?>
    <a type="submit" class="btn btn-warning btn-dark" href="<?php echo url_for('agenda/eliminar') . "?id=" . $Agenda->getId() . "&estatus=Pendiente" ?>">Eliminar Cita</a>
</div>
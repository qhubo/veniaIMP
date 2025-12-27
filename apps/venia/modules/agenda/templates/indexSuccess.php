<script src='./js/fullcalendar/index.global.js'></script>
<script src='./js/fullcalendar/es.global.js'></script>
<script>
    function convertirFormatoHora(horaOriginal) {
        const partes = horaOriginal.split(":");
        let hora = parseInt(partes[0], 10);
        const minutos = partes[1];
        let ampm = "AM";

        if (hora >= 12) {
            if (hora > 12) {
                hora -= 12;
            }
            ampm = "PM";
        }

        if (hora === 0) {
            hora = 12;
        }

        const horaFormateada = `${hora}:${minutos} ${ampm}`;
        return horaFormateada;
    }

    function convert12To24(time12h) {
        // Extracting hours, minutes, and AM/PM indicator
        const [time, period] = time12h.split(' ');
        const [hours, minutes] = time.split(':');

        // Converting hours to 24-hour format
        let hours24;
        if (period.toLowerCase() === 'am') {
            hours24 = hours === '12' ? '00' : hours.padStart(2, '0');
        } else {
            hours24 = hours === '12' ? '12' : String(Number(hours) + 12);
        }

        // Formatting minutes
        const minutes24 = minutes.padStart(2, '0');

        // Combining hours and minutes in 24-hour format
        const time24h = `${hours24}:${minutes24}`;

        return time24h;
    }

    function concatenarFecha(fechaHoraInicial) {

        // Dividir la fecha y la hora
        var partes = fechaHoraInicial.split(" ");
        var fecha = partes[0];
        var hora = convert12To24(partes[1] + " " + partes[2]);

        // Formato de hora de 12 horas a 24 horas
        var fechaHora24 = new Date(fecha + " " + hora);
        var hora24 = fechaHora24.toLocaleTimeString("en-US", {
            hour12: false
        });

        // Formato final
        var fechaHoraFinal = fecha + "T" + hora24;
        return fechaHoraFinal;
    }
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($error) : ?>
            jQuery('#kt_modal_cita').modal('show');
        <?php endif; ?>
        const citas_bd = JSON.parse('<?php echo html_entity_decode($registros) ?>');
        let citas = [];
        for (let i = 0; i < citas_bd.length; i++) {
            citas.push({
                title: citas_bd[i]['Cliente.Nombre'] + " | " + citas_bd[i]['Agenda.NoSesion'],
                start: concatenarFecha(citas_bd[i]['Agenda.Fecha'] + " " + citas_bd[i]['Agenda.HoraInicio']),
                end: concatenarFecha(citas_bd[i]['Agenda.Fecha'] + " " + citas_bd[i]['Agenda.HoraFin']),
                backgroundColor: citas_bd[i]['Agenda.Estatus'] == "Pendiente" ? "grey" : '',
                extendedProps: {
                    status: 'done'
                },
            })
        }
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            selectable: true, // Habilita la selección de fechas

            // Controlador de eventos para la selección
            eventClick: function(info) {
                const start = info.event.start;
                const title = info.event.title;
                const ano = start.getFullYear();
                const mes = start.getMonth() + 1;
                const dia = start.getDate();
                const hora = start.getHours();
                const minutos = start.getMinutes() == '0' ? '00' : start.getMinutes();
                const fecha_completa = `${ano}-${mes}-${dia}T${hora}:${minutos}`;

                // Formatea los nuevos parámetros utilizando encodeURIComponent()
                var parametro1Formateado = encodeURIComponent(fecha_completa);
                var parametro2Formateado = encodeURIComponent(title);

                // Crea la nueva URL con los parámetros formateados
                var nuevaURL = "<?php echo url_for('agenda/detalle') ?>?" +
                    "fecha=" + parametro1Formateado + "&" +
                    "cliente=" + parametro2Formateado;
                $.get(nuevaURL, function(html) {
                    $("#modal_body_detalle").html(html)
                    $("#kt_modal_detalle").modal('show');
                })

                // Redirige a la nueva URL
                // window.location.href = nuevaURL;
            },
            dateClick: function(info) {
                const date_full = info.dateStr.toString();
                const date_split = date_full.split("T");
                const date = date_split[0];
                const parts = date.split("-");
                const dateCorrect = `${parts[2]}/${parts[1]}/${parts[0]}`;
                const time = date_split[1];
                const timeCorrect = convertirFormatoHora(time)
                $('#nueva_cita_hora_inicio').timepicker('setTime', timeCorrect);
                //Hora Final
                var horaOriginal = new Date(date_full);
                horaOriginal.setMinutes(horaOriginal.getMinutes() + 30);
                var horaResultado = horaOriginal.toTimeString();
                const timeCorrectEnd = convertirFormatoHora(horaResultado)
                $('#nueva_cita_hora_fin').timepicker('setTime', timeCorrectEnd);
                //Fecha
                $('#nueva_cita_fecha').datepicker('update', dateCorrect);
                jQuery('#kt_modal_cita').modal('show');
            },
            initialView: 'timeGridWeek',
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5, 6],

                startTime: '07:00',
                endTime: '18:00',
            },
            locale: 'es',
            slotMinTime: '05:00:00', // Hora de inicio
            slotMaxTime: '20:00:00', // Hora de finalización
            customButtons: {
                nuevaCita: {
                    text: 'Nueva Cita',
                    click: function() {
                        jQuery('#kt_modal_cita').modal('show');
                    }
                }
            },
            headerToolbar: {
                left: 'prev,next today nuevaCita',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            events: citas
        });
        calendar.render();
    });
</script>
<div id='calendar'></div>
<div class="modal fade" id="kt_modal_cita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo $form->renderFormTag(url_for('agenda/index'), array('class' => 'form')) ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Nueva Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-1">Doctor</div>
                    <div class="form-group col-md-6">

                        <?php echo $form['usuario'] ?>
                        <span>
                            <?php echo $form['usuario']->renderError() ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <?php echo $form['cliente']->renderLabel() ?>
                        <?php echo $form['cliente'] ?>
                        <span>
                            <?php echo $form['cliente']->renderError() ?>
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <?php echo $form['fecha']->renderLabel() ?>
                        <?php echo $form['fecha'] ?>
                        <span>
                            <?php echo $form['fecha']->renderError() ?>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <?php echo $form['hora_inicio']->renderLabel() ?>
                        <?php echo $form['hora_inicio'] ?>
                        <span>
                            <?php echo $form['hora_inicio']->renderError() ?>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <?php echo $form['hora_fin']->renderLabel() ?>
                        <?php echo $form['hora_fin'] ?>
                        <span>
                            <?php echo $form['hora_fin']->renderError() ?>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                      <?php echo $form['sesion']->renderLabel() ?>
                        <?php echo $form['sesion'] ?>
                        <span>
                            <?php echo $form['sesion']->renderError() ?>
                        </span>
                    </div>
                  
                    
                    <div class="form-group col-md-12">
                        <?php echo $form['observaciones']->renderLabel() ?>
                        <?php echo $form['observaciones'] ?>
                        <span>
                            <?php echo $form['observaciones']->renderError() ?>
                        </span>
                    </div>
                </div>
                <?php echo $form->renderHiddenFields() ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-dark">Guardar</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary btn-dark">Cancelar</button>
            </div>
            <?php echo "</form>" ?>
        </div>
    </div>
</div>
<div class="modal fade" id="kt_modal_detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalle de Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="modal_body_detalle">


            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary btn-dark">Cancelar</button>
            </div>
            <?php echo "</form>" ?>
        </div>
    </div>
</div>
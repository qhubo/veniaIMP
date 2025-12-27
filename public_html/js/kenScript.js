function kenSelect() {
    $('.select2').each(function () {
        $(this).select2();
    });
}
function kenFile() {
    $('input[type=file]').each(function () {
        $(this).dropify();
    });
}
function kenBadgeFilter() {
    var contador = 1;
    jQuery('#filtros').each(function () {
        var inputs = jQuery(this).find('input');
        inputs.each(function () {
            switch (jQuery(this).attr('type')) {
                case 'text':
                    if (jQuery(this).val() != '') {
                        contador++;
                    }
                    break;
                case 'checkbox':
                    if (jQuery(this).attr('checked')) {
                        contador++;
                    }
                    break;
            }
        });
        var inputs = jQuery(this).find('select');
        inputs.each(function () {
            if (jQuery(this).val() != '') {
                contador++;
            }
        });
    });
    if (contador > 0) {
        contador = contador - 1;
        jQuery('.vel_badge_filter').text(contador);
        if (contador > 0) {
            jQuery('.vel_badge_filter').removeClass('badge-info');
            jQuery('.vel_badge_filter').addClass('badge-warning');
            jQuery('.vel_badge_filter').parent().attr('class', 'vel_filtros_generator btn btn-success');
        }
    }

}
function kenBotBoxFiltro() {
    var contadorInputs = 0;
    jQuery('#filtros').each(function () {
        var inputs = jQuery(this).find('input');
        inputs.each(function () {
            contadorInputs++;
        });
        var inputs = jQuery(this).find('select');
        inputs.each(function () {
            if (jQuery(this).val() != '') {
                contadorInputs++;
            }
        });
    });
    jQuery('#filtros').hide();
    if (contadorInputs == 0) {
        jQuery('.vel_filtros_generator').hide();
    }
    jQuery('.vel_filtros_generator').on('click', function () {
        bootbox.dialog({
            message: jQuery('#filtros').html(),
            onEscape: function () {

            },
        });
    });
    jQuery('.contenido_filtro').each(function () {
        jQuery(this).find('label').each(function () {
            jQuery(this).css('float', '');
        });
    });
}
function kenTags() {
    $(".tags").each(function () {
        $(this).tagsinput();
    });
}
function kenTime() {
    $('.datepicker').datepicker({
    });
    $('.timepicker').timepicker({
    });
}
function kenColor(){
    $('.colorpicker').colorpicker({});
}
function kenText(){
    $('textarea').wysihtml5({});
}
function kenNotify(titulo, mensaje, tema) {
    var settings = {
        theme: tema,
        horizontalEdge: 'top',
        verticalEdge: 'right',
        heading: titulo
    };
    $.notific8('zindex', 11500);
    $.notific8(mensaje, settings);
}
function kenWidthContainer(){
    $('.container').each(function(){
        if($(this).width() >= 940){
            $(this).width($(this).width() * 1.1);
        }
    });
}
$(document).ready(function () {
    kenSelect();
    kenFile();
    kenTags();
    kenTime();
    kenColor();
    kenText();
//    kenNotify();
    kenBadgeFilter();
    kenBotBoxFiltro();
    kenWidthContainer();
});
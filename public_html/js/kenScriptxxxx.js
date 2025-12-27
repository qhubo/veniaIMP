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
function kenText1(){
    $('textarea.Editor').wysihtml5({});
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
function kenText(){
    tinymce.init({
        selector: "textarea.EditorMce",
        theme: "modern",
        paste_data_images: true,
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        file_picker_callback: function(callback, value, meta) {
          if (meta.filetype == 'image') {
            $('#upload').trigger('click');
            $('#upload').on('change', function() {
              var file = this.files[0];
              var reader = new FileReader();
              reader.onload = function(e) {
                callback(e.target.result, {
                  alt: ''
                });
              };
              reader.readAsDataURL(file);
            });
          }
        },
        templates: [{
          title: 'Test template 1',
          content: 'Test 1'
        }, {
          title: 'Test template 2',
          content: 'Test 2'
        }]
      });
}
$(document).ready(function () {
    kenSelect();
    kenFile();
    kenTags();
    kenTime();
    kenColor();
    //kenText1();
     kenText();
//    kenNotify();
    kenBadgeFilter();
    kenBotBoxFiltro();
    kenWidthContainer();
});
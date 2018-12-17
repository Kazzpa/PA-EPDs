(function ($) {
    //declaracion plugin
    $.fn.validacion = function (options) {
        options = $.extend({},$.fn.validacion.defaultOptions, options);
        this.each(function () {
            $(this).focus(function () {
                $(this).css('background-color', options.fondo);
            });
            $(this).blur(function () {
                if ($(this).val() == '') {
                    $(this).css('background-color', options.vacio);
                } else {
                    $(this).css('background-color', options.lleno);
                }
            });
        });
    }
    $.fn.validacion.defaultOptions = {
        fondo : 'blue',
        vacio : 'black',
        lleno : 'brown'
    }
})(jQuery);

$(document).ready(function () {
    $('input').validacion({fondo : 'yellow',vacio : 'red'});
});
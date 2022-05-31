(function($) {

if (settings.isActive) {
        $('<div></div>')
                .attr('id', 'greg-plugin-container')
                .append(`<p>${settings.content}</p>`)
                .css({
                'background-color': settings.bgColor,
                'color': settings.textColor,
                })
                .appendTo('body');

        (settings.position === "bottom") ? $('#greg-plugin-container').css('bottom', '0') : $('#greg-plugin-container').css('top', '0');
}




})(jQuery);
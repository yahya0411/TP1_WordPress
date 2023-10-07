(function($) {

    // USE STRICT
    "use strict";

    var wbgColorPicker = [
        '#wtn_ticker_label_bg_color',
        '#wtn_ticker_label_font_color',
        '#wtn_ticker_content_bg_color',
        '#wtn_ticker_content_font_color',
        '#wtn_ticker_content_border_color'
    ];

    $.each(wbgColorPicker, function(index, value) {
        $(value).wpColorPicker();
    });

    $('.wtn-closebtn').on('click', function() {
        this.parentElement.style.display = 'none';
    });

})(jQuery);
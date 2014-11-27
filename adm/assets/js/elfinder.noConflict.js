(function($){
    $(function(){
        if($.fn.button.noConflict) {
            $.fn.btn = $.fn.button.noConflict();
        }
    });
})(jQuery);
(function($){
    $(function(){
        $("ul.nav li.active").closest(".nav.none").prev('a').trigger('click');
    });
})(jQuery);
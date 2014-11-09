(function($){
    $(function(){
        $("ul.nav li.active").closest(".nav.none").prev('a').trigger('click');

        $('.main').on('resize', function(){
            console.log('dd');
            $(window).trigger('resize');
        });
    });




})(jQuery);
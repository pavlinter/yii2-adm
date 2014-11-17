(function($){
    $(function(){
        //$("ul.nav li.active").closest(".nav.none").prev('a').trigger('click');
        $(".adm-nav li ul a[href*='" + admId + "/" + admController + "']").filter(':first').closest('.nav.none').prev('a').trigger('click');
        $('.nav-tabs').each(function(){
            var $th = $(this);
            if (!$th.find('li.active').length){
                $th.find('a:first').trigger('click');
            }
        });

    });
})(jQuery);
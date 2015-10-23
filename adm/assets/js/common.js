(function($){
    $('[data-toggle="tooltip"]').tooltip()

    setTimeout(function(){
        $(".adm-nav > .nav .nav").each(function(){
            var $this = $(this);
            var $li = $this.find("li.active:first");
            if($li.length){
                //sub li
                $li = $li.parent().parent();
                var $a = $li.children("a");
                if($a.length && !$a.is(".is-inited")){
                    $a.addClass("is-inited").trigger("click");
                    $li.addClass("active");
                }
            }
        });

        $(".adm-nav > .nav > li.active > a").not(".is-inited").each(function(){
            var $this = $(this);
            $this.addClass("is-inited").trigger("click");
        });
    }, 1000);

    $('.nav-tabs').each(function(){
        var $th = $(this);
        if (!$th.find('li.active').length){
            $th.find('a:first').trigger('click');
        }
    });

    //copy lang
    $langsPanel = $(".adm-langs-panel");
    if(!$langsPanel.is(".disable-copy")){

        $langsPanel.find(".panel-heading .nav li").each(function(){
            $(this).prepend('<a href="javascript:void(0);" class="adm-copy-lang" title="Copy Content" data-toggle="tooltip" data-placement="right"><i class="fa fa-copy"></i></a>');
        });

        $langsPanel.find(".panel-heading .nav li.active").find(".adm-copy-lang").addClass("active");

        $('.panel-heading .nav a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $(".adm-copy-lang").removeClass("active");
            $(this).closest("li").find(".adm-copy-lang").addClass("active");
        });

        $(document).on("click", ".adm-copy-lang", function(e){
            var $el = $(this);
            var tabId = $el.closest("li").find("[data-toggle='tab']").attr("href");
            var $tab = $(tabId);
            var data = [];
            $tab.find(":input").each(function(i){
                data[i] = $(this).val();
            });
            $langsPanel.find(".tab-pane").not($tab).each(function(){
                $(this).find(":input").each(function(i){
                    if(data[i] !== undefined){
                        var $el = $(this);
                        $el.val(data[i]);
                        if($el.is("textarea")){
                            var $cke = $el.next("[id^='cke_']");
                            var cke_id = $el.attr("id");
                            if($cke.length){
                                CKEDITOR.instances[cke_id].setData(data[i]);
                            }
                        }
                        if($el.data('select2')){
                            $el.trigger('change');
                        }
                        if($el.data('checkboxX')){
                            $el.checkboxX('refresh');
                        }
                    }
                });
            });
            return false;
        });
    }
})(jQuery);
<?php

namespace pavlinter\adm\widgets;

use Yii;

class GridView extends \kartik\grid\GridView
{
    public function init()
    {
        parent:: init();

        if (Yii::$app->getUrlManager() instanceof \pavlinter\urlmanager\UrlManager) {
            Yii::$app->getView()->registerJs('
            $("#' . $this->id .'").on("beforeFilter", function(e){
                var $form = $(".gridview-filter-form",this);
                var url = $form.attr("action").replace(/\/$/, "");
                $(":input", $form).each(function(i,e){
                    var inp = $(this);
                    var name = inp.attr("name");
                    if (name != "_pjax"){
                        if(!i){
                            var pos = url.indexOf(encodeURIComponent(name));
                            if (pos !== -1){
                                url = url.substring(0,pos - 1);
                            }
                        }
                        url += "/" + name + "/" + inp.val();
                    }

                });
                $form.attr("action",url);
                $form.empty();
            });
        ');
        }





    }
}
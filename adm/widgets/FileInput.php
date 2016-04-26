<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.1.2
 */

namespace pavlinter\adm\widgets;


use mihaildev\elfinder\InputFile;
use pavlinter\adm\Adm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class FileInput
 */
class FileInput extends InputWidget
{
    /**
     * @var $form \yii\widgets\ActiveForm
     */
    public $form;

    public $fileManager = [];

    public $enablePreview = true;

    public $basePath = '@web';

    public function init()
    {
        $id = $this->getId();
        $buttonId = 'fm-btn-' . $id;
        $this->fileManager = ArrayHelper::merge([
            'controller'    => Adm::getInstance()->id.'/elfinder',
            'filter'        => 'image', // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template'      => '<div class="input-group fm-input-cont"><span class="input-group-addon">{button}</span>{input}</div>',
            'options'       => ['class' => 'form-control'],
            'buttonTag'     => 'a',
            'buttonName'    => '',
            'buttonOptions' => [
                'class' => 'glyphicon glyphicon-folder-open filemanager-btn',
                'href'  => 'javascript:void(0);',
                'id'    => $buttonId,
                'data' => [
                    'placement' => 'top',
                ],
            ],
            'multiple'      => true
        ], $this->fileManager);

        if ($this->enablePreview) {
            $basePath = Yii::getAlias($this->basePath);
            $this->getView()->registerJs('
            $("#' . $buttonId . '").tooltip({
                html: true,
                title: function(){
                    var v = $(this).closest(".fm-input-cont").find("#' . Html::getInputId($this->model, $this->attribute) . '").val();
                    var $img = $("<img src=\"' . $basePath . '" + v + "\" class=\"hide file-input-img\">");
                    var $loading = $("<span class=\"file-input-loading fa fa-spinner rotating\"></span>");
                    $img.on("load", function(){
                        $img.removeClass("hide");
                        $loading.hide();
                    })
                    return $("<div class=\"file-input-cont\"><div>").append($loading).append($img);
                },
            });
        ');
        }


        parent:: init();
    }
    public function run()
    {
        return $this->form->field($this->model, $this->attribute)->widget(InputFile::className(), $this->fileManager);
    }


}
<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.5
 */

namespace pavlinter\adm\widgets;


use mihaildev\elfinder\InputFile;
use pavlinter\adm\Adm;
use Yii;
use yii\helpers\ArrayHelper;
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

    public function init()
    {
        $this->fileManager = ArrayHelper::merge([
            'controller'    => Adm::getInstance()->id.'/elfinder',
            'filter'        => 'image', // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template'      => '<div class="input-group"><span class="input-group-addon">{button}</span>{input}</div>',
            'options'       => ['class' => 'form-control'],
            'buttonTag'     => 'a',
            'buttonName'    => '',
            'buttonOptions' => [
                'class' => 'glyphicon glyphicon-folder-open filemanager-btn',
                'href'  => 'javascript:void(0);'
            ],
            'multiple'      => true
        ], $this->fileManager);

        parent:: init();
    }
    public function run()
    {
        return $this->form->field($this->model, $this->attribute)->widget(InputFile::className(), $this->fileManager);
    }


}
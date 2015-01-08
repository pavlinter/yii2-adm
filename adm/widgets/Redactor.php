<?php

namespace pavlinter\adm\widgets;

use mihaildev\elfinder\ElFinder;
use pavlinter\adm\Adm;
use Yii;
use yii\widgets\InputWidget;

/**
 * Class Redactor
 */
class Redactor extends InputWidget
{
    /**
     * @var $form \yii\widgets\ActiveForm
     */
    public $form;

    public function init()
    {
        parent:: init();
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        return $this->form->field($this->model, $this->attribute)->widget(CKEditor::className(), [
            'initOnEvent' => 'focus',
            'options' => [
                'class' => 'form-control form-redactor',
            ],
            'editorOptions' => ElFinder::ckeditorOptions(Adm::getInstance()->id.'/elfinder',[/* Some CKEditor Options */]),
        ]);
    }
}
<?php

namespace pavlinter\adm\widgets;

use mihaildev\elfinder\ElFinder;
use pavlinter\adm\Adm;
use Yii;
use mihaildev\ckeditor\CKEditor;
use yii\widgets\InputWidget;

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

    public function run()
    {
        return $this->form->field($this->model, $this->attribute)->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions(Adm::getInstance()->id.'/elfinder',[/* Some CKEditor Options */]),
        ]);
    }
}
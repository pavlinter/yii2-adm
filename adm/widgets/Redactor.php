<?php

namespace pavlinter\adm\widgets;


use dosamigos\ckeditor\CKEditor;
use Yii;
use yii\widgets\InputWidget;

class Redactor extends InputWidget
{
    public $form;

    public function init()
    {
        parent:: init();
    }

    public function run()
    {
        parent:: init();
        return $this->form->field($this->model, $this->attribute)->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]);
    }
}
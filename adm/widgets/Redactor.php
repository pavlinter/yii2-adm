<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.4
 */

namespace pavlinter\adm\widgets;

use mihaildev\elfinder\ElFinder;
use pavlinter\adm\Adm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
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

    public $removeFirstTag = false;

    public $clientOptions = [];

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
        $ckeditorOptions = [];
        if ($this->removeFirstTag) {
            $ckeditorOptions['enterMode'] = new JsExpression('CKEDITOR.ENTER_BR');
        }
        $ckeditorOptions = ArrayHelper::merge($ckeditorOptions, $this->clientOptions);

        $options = ArrayHelper::merge([
            'initOnEvent' => 'focus',
            'options' => [
                'class' => 'form-control form-redactor',
            ],
        ], $this->options);
        $options['editorOptions'] = ElFinder::ckeditorOptions(Adm::getInstance()->id.'/elfinder', $ckeditorOptions);

        return $this->form->field($this->model, $this->attribute)->widget(CKEditor::className(), $options);
    }
}
<?php

namespace pavlinter\adm\widgets;


use mihaildev\elfinder\InputFile;
use pavlinter\adm\Adm;
use Yii;

class FileInput extends InputFile
{
    public $form;

    public $buttonTag = 'span';
    public $buttonName = '';
    public $buttonOptions = ['class' => 'fa fa-folder-open'];

    public $options = ['class' => 'form-control'];

    public $template = '<div class="input-group">{input}<span class="input-group-addon">{button}</span></div>';

    public $controller;

    public $multiple;

    public function init()
    {
        if ($this->controller === null) {
            $this->controller = Adm::getInstance()->id.'/elfinder';
        }

        parent:: init();
    }
}
<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.10
 */

namespace pavlinter\adm\widgets;

use mihaildev\elfinder\ElFinder;
use pavlinter\adm\Adm;
use Yii;

/**
 * Class FileManager
 */
class FileManager extends ElFinder{

    public $language;

    public $filter;

    public $callbackFunction;

    public $containerOptions = [];
    public $frameOptions = [
        'style' => 'height: 500px;width: 100%;border: 0;',
    ];

    public $controller ;

    public function init()
    {
        if ($this->controller === null) {
            $this->controller = Adm::getInstance()->id.'/elfinder';
        }
        parent::init();
    }
}
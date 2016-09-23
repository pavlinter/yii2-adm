<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.2
 */

namespace pavlinter\adm\widgets;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * Class GridView
 */
class GridView extends \kartik\grid\GridView
{
    public $export = false;

    public $nestable = false;

    public $nestableClass = 'pavlinter\adm\widgets\GridNestable';

    public function init()
    {

        parent::init();
        if ($this->nestable === true || is_array($this->nestable)) {
            echo $this->nestableGrid();
        }
    }

    /**
     * @return mixed
     */
    public function nestableGrid()
    {
        if (!is_array($this->nestable)) {
            $this->nestable = [];
        }
        $nestable = ArrayHelper::merge([
            'class' => $this->nestableClass,
            'grid' => $this,
        ], $this->nestable);
        return forward_static_call([$nestable['class'], 'widget'], $nestable);
    }
}
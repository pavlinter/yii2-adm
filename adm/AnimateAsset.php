<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.2
 */

namespace pavlinter\adm;

/**
 * Class AnimateAsset
 */
class AnimateAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/animate.css';

    public $css = [
        'animate.min.css',
    ];
}
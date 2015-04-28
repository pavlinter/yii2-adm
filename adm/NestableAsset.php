<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.3
 */

namespace pavlinter\adm;

/**
 * Class NestableAsset
 */
class NestableAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@admRoot/assets';
    public $css = [
        'js/nestable/nestable.css',
    ];
    public $js = [
        'js/nestable/jquery.nestable.js',
    ];
    public $depends = [
        'pavlinter\adm\AdmAsset'
    ];
}
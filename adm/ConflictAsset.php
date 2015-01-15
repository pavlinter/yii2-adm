<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\adm;

/**
 * Class ConflictAsset
 */
class ConflictAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@admRoot/assets';
    public $css = [];
    public $js = [
        'js/elfinder.noConflict.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
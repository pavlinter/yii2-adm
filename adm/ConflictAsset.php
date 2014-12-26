<?php
/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-adm
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
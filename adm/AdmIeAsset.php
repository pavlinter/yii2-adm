<?php
/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-adm
 */

namespace pavlinter\adm;

/**
 * Class AdmIeAsset
 */
class AdmIeAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@admRoot/assets';

    public $jsOptions = ['condition' => 'lte IE9'];

    public $js = [
        "js/ie/respond.min.js",
        "js/ie/html5.js",
        "js/ie/fix.js",
    ];
}
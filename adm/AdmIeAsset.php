<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.6
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
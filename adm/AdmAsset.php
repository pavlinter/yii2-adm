<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.0
 */

namespace pavlinter\adm;
use kartik\icons\Icon;
use Yii;

/**
 * Class AdmAsset
 */
class AdmAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@admRoot/assets';

    public $css = [
        'css/app.css',
    ];
    public $js = [
        'js/app.js',
        'js/common.js',
    ];
    public $depends = [
        'pavlinter\adm\AnimateAsset',
        'pavlinter\adm\AdmIeAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init()
    {
        parent::init();
        Icon::map(Yii::$app->getView(), Icon::FA);
        Icon::map(Yii::$app->getView(), Icon::EL);
        Icon::map(Yii::$app->getView(), Icon::TYP);
        Icon::map(Yii::$app->getView(), Icon::WHHG);
        Icon::map(Yii::$app->getView(), Icon::JUI);
        Icon::map(Yii::$app->getView(), Icon::UNI);
        Icon::map(Yii::$app->getView(), Icon::SI);
        Icon::map(Yii::$app->getView(), Icon::OCT);
        Icon::map(Yii::$app->getView(), Icon::FI);
    }
}
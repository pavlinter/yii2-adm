<?php
/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-adm
 */

namespace pavlinter\adm;

class AdmAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@admAsset';
    public $css = [
        'css/animate.css',
        'css/font-awesome.min.css',
        'css/font.css',
        'css/plugin.css',
        'css/app.css',
        'css/style.css',
    ];
    public $js = [
        'js/charts/sparkline/jquery.sparkline.min.js',
        'js/app.js',
        'js/app.plugin.js',
        'js/app.data.js',
        'js/slimscroll/jquery.slimscroll.min.js',
        'js/charts/sparkline/jquery.sparkline.min.js',
        'js/charts/easypiechart/jquery.easy-pie-chart.js',
        'js/charts/morris/raphael-min.js',
        'js/charts/morris/morris.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
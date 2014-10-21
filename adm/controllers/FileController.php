<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-adm
 */

namespace pavlinter\adm\controllers;

use pavlinter\adm\filters\AccessControl;
use Yii;
use yii\web\Controller;

class FileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['AdmRoot'],
                    ],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}

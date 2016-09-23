<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.2
 */

namespace pavlinter\adm\controllers;

use pavlinter\adm\Adm;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package pavlinter\adm\controllers
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \pavlinter\adm\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        return $this->redirect(['user/update']);
    }
    /**
     * @inheritdoc
     */
    public function actionLogin()
    {
        $adm = Adm::getInstance();
        $model = $adm->manager->createLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return Adm::redirect(['index']);
        } else {
            if ($adm->user->isGuest) {
                $this->layout = 'base';
                Html::addCssClass($adm->params['html.bodyOptions'], 'body-login');
            } else {
                $this->layout = 'main';
            }

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * @inheritdoc
     */
    public function actionLogout()
    {
        Adm::getInstance()->user->logout(false);
        return Adm::redirect(['login']);
    }
}

<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\adm\controllers;

use pavlinter\adm\Adm;
use Yii;
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
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['files'],
                        'allow' => true,
                        'roles' => ['AdmRoot'],
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
        //return $this->render('index');
    }
    /**
     * @inheritdoc
     */
    public function actionLogin()
    {
        if (!Adm::getInstance()->user->isGuest) {
            return $this->redirect(['index']);
        }
        $this->layout = 'base';
        $model = Adm::getInstance()->manager->createLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (($redirect = Yii::$app->request->post('redirect'))) {
                return $this->redirect($redirect);
            }
            return $this->redirect(['index']);
        } else {
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
        Adm::getInstance()->user->logout();
        return $this->redirect(['login']);
    }
}

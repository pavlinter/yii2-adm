<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.7
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
    }
    /**
     * @inheritdoc
     */
    public function actionLogin()
    {
        $adm = Adm::getInstance();
        if (!$adm->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = $adm->manager->createLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return Adm::redirect(['index']);
        } else {

            $this->layout = 'base';
            if (isset($adm->params['html.bodyOptions']['class'])) {
                $adm->params['html.bodyOptions']['class'] .= ' body-login';
            } else {
                $adm->params['html.bodyOptions']['class'] = 'body-login';
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
